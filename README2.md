# 🏛️ ChamberConnect DRC — Portail de Création de Chambre

## 🎯 Objectif

Mettre à jour le projet _ChamberConnect DRC_ existant pour ajouter un **Portail utilisateur** dédié à la **demande de création d’une chambre de commerce**.  
Ce portail permettra à un utilisateur connecté de soumettre une demande complète, qui sera ensuite **vérifiée et validée par un administrateur (SuperAdmin)**.

Le projet utilise déjà le modèle `Chamber`.  
Aucune nouvelle table n’est à créer : la logique doit simplement permettre d’enregistrer les nouvelles chambres avec `verified = false` jusqu’à validation.

---

## 🧭 Structure fonctionnelle

### Menu principal

-   **Label :** `Portail`
-   **Icône :** `building-2`
-   **Visibilité :** seulement pour les utilisateurs connectés (`role = user`)
-   **Action :** redirige vers le formulaire de demande de création d’une chambre

---

## 🧱 Étapes du processus utilisateur

### 1️⃣ Accès au portail

L’utilisateur connecté clique sur **Portail → Nouvelle demande** pour ouvrir le formulaire.

### 2️⃣ Formulaire multi-étapes

Le formulaire est fluide, clair et progressif (type wizard).  
Chaque étape est validée avant de passer à la suivante.

---

## 📋 Étape 1 — Informations générales

Champs à inclure :

| Champ                                    | Type               | Description                                             |
| ---------------------------------------- | ------------------ | ------------------------------------------------------- |
| Nom complet de la chambre                | Texte              | Ex : Chambre de Commerce et d’Industrie du Haut-Katanga |
| Sigle (abréviation)                      | Texte court        | Ex : CCIHK                                              |
| Province / Ville du siège social         | Liste déroulante   | Sélection parmi les provinces et communes               |
| Adresse complète                         | Texte              | Rue, quartier, commune, ville                           |
| Téléphone de contact                     | Numéro             | Format : +243 XXX XXX XXX                               |
| Adresse e-mail officielle                | Email              | Ex : contact@ccihk.org                                  |
| Site web (facultatif)                    | URL                | Ex : www.ccihk.org                                      |
| Objet social principal                   | Zone de texte      | Description claire du but de la chambre                 |
| Date de création                         | Date               | JJ/MM/AAAA                                              |
| Numéro d’identification nationale (NINA) | Texte ou numérique | Champ libre                                             |

> 🔸 Ces informations alimentent directement le modèle `Chamber` existant :
>
> -   `name`, `location`, `address`, `email`, `phone`, `website`, `description`
> -   `verified` sera automatiquement défini sur `false`
> -   `state_number` et `certification_date` seront remplis uniquement lors de la validation

---

## 📂 Étape 2 — Téléversement des documents

L’utilisateur doit pouvoir importer les fichiers justificatifs suivants :

| Document                                    | Format accepté     | Description                                                           |
| ------------------------------------------- | ------------------ | --------------------------------------------------------------------- |
| Statuts signés                              | PDF/DOCX           | Document officiel indiquant l’objet, les organes, les règles internes |
| Règlement intérieur                         | PDF/DOCX           | Complément des statuts                                                |
| Procès-verbal de l’Assemblée constitutive   | PDF                | Mentionne l’élection du bureau                                        |
| Liste des membres fondateurs                | PDF/Excel          | Noms, fonctions, coordonnées, signatures                              |
| Plan d’action ou programme d’activités      | PDF                | Prévisions sur 1 à 3 ans                                              |
| Copie des pièces d’identité des fondateurs  | PDF (multi-upload) | Carte d’identité ou passeport                                         |
| Lettre de demande de personnalité juridique | PDF/DOCX           | Lettre adressée au Ministre de la Justice                             |

📁 Les fichiers doivent être enregistrés dans un répertoire structuré :
storage/app/public/chambers/{slug}/

Une validation doit s’assurer que :

-   tous les fichiers requis sont fournis,
-   les formats sont valides,
-   la taille maximale est respectée.

---

## 📤 Étape 3 — Validation et soumission

Une fois les informations et fichiers complétés :

-   L’utilisateur visualise un **récapitulatif**.
-   Il clique sur **Soumettre ma demande**.
-   Un message de confirmation s’affiche :
    > “Votre demande a été soumise avec succès. Vous recevrez un e-mail dès qu’elle sera examinée.”

Les champs sont enregistrés dans la table `chambers` avec :

-   `verified = false`
-   `state_number = null`
-   `certification_date = null`
-   `certification_notes = null`

---

## 🧠 Workflow d’approbation (SuperAdmin)

### Espace d’administration

Un tableau de bord doit permettre à l’administrateur de visualiser toutes les chambres en attente de validation (`verified = false`).

Colonnes recommandées :

-   Nom de la chambre
-   Province / Ville
-   Demandeur
-   Date de soumission
-   Statut (En attente, Validée, Refusée)
-   Actions (Valider / Refuser)

---

### Actions possibles

#### ✅ Validation :

-   Mettre à jour la chambre :
    -   `verified = true`
    -   `state_number` = format automatique : `CHMBR-YYYY-XXXX`
    -   `certification_date` = date actuelle
-   Attribuer au demandeur le rôle `chamber_manager`
-   Envoyer un **e-mail de confirmation** avec le numéro d’enregistrement

#### ❌ Refus :

-   Garder `verified = false`
-   Ajouter une note dans `certification_notes`
-   Envoyer un **e-mail de refus** au demandeur

---

## ✉️ Notifications e-mail

### 1. Validation

**Sujet :** “Validation de votre chambre sur ChamberConnect DRC”  
**Corps :**

> Votre chambre [Nom] a été validée.  
> Numéro officiel : [state_number]  
> Vous disposez désormais des droits de gestionnaire.

### 2. Refus

**Sujet :** “Refus de votre demande de création de chambre”  
**Corps :**

> Votre demande de création n’a pas été approuvée.  
> Motif : [certification_notes]

---

## 🎨 Spécifications design

-   Respect strict du **design ChamberConnect existant**
-   Framework : **Laravel + TailwindCSS**
-   Style des boutons :
    -   Couleur primaire : `#E71D36`
    -   Coins arrondis, ombrage doux
-   Barre de progression horizontale pour indiquer les étapes
-   Boutons : `Suivant`, `Précédent`, `Soumettre`
-   Mise en page fluide (max-width : 700px)
-   Composants cohérents avec le reste du site (`rounded-xl`, `border-neutral-200`, `shadow-sm`)

---

## 📊 Résumé du comportement attendu

| Rôle                                     | Action                                                                     |
| ---------------------------------------- | -------------------------------------------------------------------------- |
| **Utilisateur (user)**                   | Accède au menu Portail, remplit le formulaire et soumet la demande         |
| **SuperAdmin**                           | Examine les demandes, valide ou rejette, envoie les e-mails correspondants |
| **Utilisateur validé (chamber_manager)** | Obtient automatiquement les droits de gestion de la chambre validée        |

---

## ✅ Résultat attendu

-   Expérience fluide et intuitive pour l’utilisateur
-   Workflow complet de soumission et validation
-   Respect total du design existant
-   Aucun impact sur le modèle ou les chambres déjà existantes
-   Notifications automatiques lors des validations ou refus
