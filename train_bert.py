import pandas as pd
import os
import json
from transformers import BertTokenizer ,BertForSequenceClassification, Trainer, TrainingArguments
import torch
from torch.utils.data import random_split


data = pd.read_csv("data/annotations_metadata.csv")  
with open("stop_words_english.json", "r", encoding="utf-8") as f:
    list_stopword = json.load(f)

liste_ms = []
liste_label = []


for fichier in os.listdir("data/sampled_train"):
    if fichier.endswith(".txt"):
        if os.path.splitext(fichier)[0] in data['file_id'].values:
            label = data.loc[data['file_id'] == os.path.splitext(fichier)[0], 'label'].values[0]
            liste_label.append(label)

            # Lire le contenu du fichier et l'ajouter à liste_ms
            chemin_fichier = os.path.join("data/sampled_train", fichier)
            with open(chemin_fichier, "r", encoding="utf-8") as f:

                contenu = f.read()
                liste_ms.append(contenu)

"""
print(f"Nombre de documents : {len(liste_ms)}")
print(f"Nombre de labels : {len(liste_label)}")
print(liste_ms[0])
print(liste_label[0])
"""

for i in range(len(liste_label)):
    if liste_label[i] == "noHate":
        liste_label[i]= 0
    else:
        liste_label[i]=1

tokenizer = BertTokenizer.from_pretrained("bert-base-uncased")

# Tokenizer tous les messages
encodings = tokenizer(liste_ms, truncation=True, padding=True, max_length=128)

# Dataset PyTorch
class HateDataset(torch.utils.data.Dataset):
    def __init__(self, encodings, labels):
        self.encodings = encodings
        self.labels = labels

    def __len__(self):
        return len(self.labels)

    def __getitem__(self, idx):
        item = {key: torch.tensor(val[idx]) for key, val in self.encodings.items()}
        item['labels'] = torch.tensor(self.labels[idx])
        return item

dataset = HateDataset(encodings, liste_label)


train_size = int(0.8 * len(dataset))
val_size = len(dataset) - train_size

train_dataset, val_dataset = random_split(dataset, [train_size, val_size])

print(val_dataset)

model = BertForSequenceClassification.from_pretrained("bert-base-uncased", num_labels=2)

training_args = TrainingArguments(
    output_dir="./results",
    num_train_epochs=2,
    per_device_train_batch_size=16,
    per_device_eval_batch_size=16,
    logging_dir='./logs',
)

trainer = Trainer(
    model=model,
    args=training_args,
    train_dataset=train_dataset,
    eval_dataset=val_dataset,
)

trainer.train()
model.save_pretrained("hate_model")
tokenizer.save_pretrained("hate_model")
