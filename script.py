import pandas as pd
import os
import json





"""data = pd.read_csv("data/annotations_metadata.csv", sep=",")

#print(data)
liste_label=[]

liste_ms = []

for fichier in os.listdir('data/sampled_train'):
    x= os.path.splitext(fichier)[0]
    if x in data.file_id.values  :
        with open(fichier, "r", encoding="utf-8") as f:
                contenu = f.read()
                liste_ms.append(contenu)
        liste_label.append(1)



print(liste_label)
print(liste_ms)
"""

data = pd.read_csv("data/annotations_metadata.csv")  
with open("stop_words_english.json", "r", encoding="utf-8") as f:
    list_stopword = json.load(f)

liste_ms = []
liste_label = []


for fichier in os.listdir("data/sampled_train"):
    if fichier.endswith(".txt"):
        #print(os.path.splitext(fichier)[0])

        if os.path.splitext(fichier)[0] in data['file_id'].values:
            label = data.loc[data['file_id'] == os.path.splitext(fichier)[0], 'label'].values[0]
            liste_label.append(label)

            # Lire le contenu du fichier et l'ajouter à liste_ms
            chemin_fichier = os.path.join("data/sampled_train", fichier)
            with open(chemin_fichier, "r", encoding="utf-8") as f:

                contenu = f.read()
                liste_ms.append(contenu)

# Vérification
print(f"Nombre de documents : {len(liste_ms)}")
print(f"Nombre de labels : {len(liste_label)}")

print(liste_ms[-1])
print(liste_label[-1])

idf = {}

for e in liste_ms:
    mots = set(e.split())
    liste_mots = []
    for mot in mots:
        mot = mot.lower()
        
        if mot not in liste_mots:
            if mot in idf:
                idf[mot]+=1
            else:
                idf[mot] = 1
            liste_mots.append(mot)

#print(idf)
print(len(idf))

for mot in idf:
    idf[mot] = idf[mot] / len(liste_ms)

ScoreMap={}
for mot in idf:
    mot = mot.lower()
    ScoreMap[mot] = 0

#print(ScoreMap)
for i in range(len(liste_ms)):
    mots = set(liste_ms[i].split())
    for mot in mots:
        mot = mot.lower()
        tf = 1/len(mots)
        tf_idf  = tf * idf[mot]
        if liste_label[i] =="hate":
             ScoreMap[mot] -= tf_idf
        else:
             ScoreMap[mot] += tf_idf

#print(ScoreMap)
#Stop words


#print(list_stopword)

for e in ScoreMap:
    for i in list_stopword:
        if e==i:
            ScoreMap[e]=0

#print(ScoreMap)
nom_fichier = 'ScoreMap.json'
try:
    # 'w' signifie écriture (write). 'encoding="utf-8"' assure la compatibilité des caractères.
    with open(nom_fichier, 'w', encoding='utf-8') as fichier:
        # json.dump() prend le dictionnaire et l'objet fichier en entrée.
        # indent=4 rend le fichier facile à lire (mise en forme)
        json.dump(ScoreMap, fichier, indent=4)
    print("fichierenregister")
except Exception as e:
    print("Err")

print(ScoreMap['able'])
print(ScoreMap['you'])

res=0
for e in liste_ms[2].split():
    e = e.lower()
    #print("mot : "+e+"      score : " + str(ScoreMap[e]))
    #print(res)
    res+= ScoreMap[e]
#print(ScoreMap['she'])
#print(liste_ms[2])
#print(res)  


#Enlever les MAJUSCULES

"""
print(len(idf))
print(idf['the'])
print(idf['world'])
print(idf['you'])
print(idf['father'])
"""
