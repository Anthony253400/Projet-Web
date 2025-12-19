import uvicorn
from fastapi import FastAPI
from pydantic import BaseModel
import pickle
import numpy as np
import re
import torch
from transformers import BertTokenizer, BertForSequenceClassification
import os

#W2V
with open("model_W2V/w2v.model", "rb") as f:
    w2v = pickle.load(f)

with open("model_W2V/classifier.model", "rb") as f:
    clf = pickle.load(f)

VECTOR_SIZE = w2v.vector_size
STOP_WORDS = set()
NEGATIONS = {"not", "never", "no"}

def clean_text(text: str):
    text = text.lower()
    text = re.sub(r"[^a-zàâçéèêëîïôûùüÿñæœ\s]", "", text)
    text = re.sub(r"\s+", " ", text)
    return text.strip()

def tokenize(text: str):
    words = clean_text(text).split()
    return [w for w in words if w not in STOP_WORDS or w in NEGATIONS]

def sentence_vector(text: str):
    words = tokenize(text)
    vectors = [w2v.wv[w] for w in words if w in w2v.wv]
    if not vectors:
        return np.zeros(VECTOR_SIZE)
    return np.mean(vectors, axis=0)



#bert
bert_model = BertForSequenceClassification.from_pretrained("model_bert")
bert_tokenizer = BertTokenizer.from_pretrained("model_bert")
bert_model.eval()



#Fastapi
app = FastAPI(title="Detection de message haineux")

class Message(BaseModel):
    text: str


@app.post("/analyze")
def analyze_word2vec(msg: Message):
    vec = sentence_vector(msg.text).reshape(1, -1)
    pred = clf.predict(vec)[0]
    prob = clf.predict_proba(vec)[0][1]
    return {"hate": bool(pred), "confidence": float(prob)}


@app.post("/predict")
def analyze_bert(msg: Message):
    inputs = bert_tokenizer(
        msg.text,
        return_tensors="pt",
        truncation=True,
        padding=True,
        max_length=128
    )

    with torch.no_grad():
        outputs = bert_model(**inputs)
        probs = torch.softmax(outputs.logits, dim=1)
        pred = torch.argmax(probs).item()

    label = "hate" if pred == 1 else "noHate"
    confidence = probs[0][pred].item()

    return {"label": label, "confidence": confidence}




if __name__ == "__main__":
    uvicorn.run(app, host="127.0.0.1", port=8000)
