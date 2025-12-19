import os
import json
import pandas as pd
import numpy as np
from gensim.models import Word2Vec
from sklearn.linear_model import LogisticRegression
import pickle
import re
#SVM 
from sklearn.svm import SVC
#RF
from sklearn.ensemble import RandomForestClassifier



BASE_DIR = os.path.dirname(os.path.abspath(__file__))
TRAIN_DIR = os.path.join(BASE_DIR, "data", "sampled_train")
CSV_PATH = os.path.join(BASE_DIR, "data", "annotations_metadata.csv")
STOPWORDS_PATH = os.path.join(BASE_DIR, "stop_words_english.json")
MODEL_DIR = os.path.join(BASE_DIR, "model")
os.makedirs(MODEL_DIR, exist_ok=True)

#Noteoyage
def clean_text(text):
    text = text.lower()
    text = re.sub(r"[^a-zàâçéèêëîïôûùüÿñæœ\s]", "", text)
    return text.strip()

#stop-word
with open(STOPWORDS_PATH, "r", encoding="utf-8") as f:
    STOP_WORDS = set(json.load(f))

NEGATIONS = {"not", "never", "no"}
STOP_WORDS = STOP_WORDS - NEGATIONS


def tokenize(text):
    words = clean_text(text).split()
    words = [w for w in words if w not in STOP_WORDS]
    return words


df = pd.read_csv(CSV_PATH)

texts = []
labels = []

for _, row in df.iterrows():
    file_id = str(row["file_id"]).strip()
    label = 1 if str(row["label"]).strip().lower() == "hate" else 0
    file_path = os.path.join(TRAIN_DIR, f"{file_id}.txt")
    if not os.path.exists(file_path):
        continue
    with open(file_path, "r", encoding="utf-8") as f:
        text = f.read()
    texts.append(text)
    labels.append(label)

print(f"{len(texts)} messages chargés")


sentences = [tokenize(t) for t in texts]


VECTOR_SIZE = 200
w2v = Word2Vec(
    sentences,
    vector_size=VECTOR_SIZE,
    window=5,
    min_count=2,
    workers=4,
    sg=1  
)

'''
clf = SVC(
    kernel="linear",        
    class_weight="balanced",  
    probability=True)

clf.fit(X, y)
'''


def sentence_vector(sentence):
    words = tokenize(sentence)
    vectors = [w2v.wv[w] for w in words if w in w2v.wv]
    if len(vectors) == 0:
        return np.zeros(VECTOR_SIZE)
    return np.mean(vectors, axis=0)

X = np.array([sentence_vector(t) for t in texts])
y = np.array(labels)


clf = LogisticRegression(max_iter=1000, class_weight="balanced")
clf.fit(X, y)
#pickle.dump(clf, open(os.path.join(MODEL_DIR, "svm_classifier.model"), "wb"))


pickle.dump(w2v, open(os.path.join(MODEL_DIR, "w2v.model"), "wb"))
pickle.dump(clf, open(os.path.join(MODEL_DIR, "classifier.model"), "wb"))

print(" Modèle creer")



