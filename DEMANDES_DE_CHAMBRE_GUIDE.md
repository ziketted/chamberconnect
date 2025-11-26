# 📬 GUIDE COMPLET: Gestion des Demandes de Création de Chambre

## 🎯 Vue d'ensemble

Le SuperAdmin peut maintenant **examiner les demandes de création de chambre en détail**, consulter tous les documents attachés, et prendre une décision : **Approuver**, **Certifier avec numéro**, ou **Rejeter**.

---

## 📋 Workflow complet

### Étape 1: Un utilisateur soumet une demande
```
Utilisateur normal → /portal/chamber/create
↓
Upload 7 documents requis
↓
Soumission de la demande
```

### Étape 2: SuperAdmin voit la demande au dashboard
```
SuperAdmin → http://127.0.0.1:8000/super-admin/dashboard
↓
Section "Demandes récentes en attente" (affiche les 5 dernières)
↓
Clic sur "Examiner"
```

### Étape 3: SuperAdmin examine les détails complets
```
Page `/super-admin/chambers/{chamber}/request`
↓
Voir toutes les informations:
  - Infos générales (sigle, NINA, type, date création)
  - Description complète
  - Demandeur (nom, email)
  - Tous les 7 documents attachés (avec téléchargement)
```

### Étape 4: SuperAdmin prend une décision
```
3 boutons d'action:
  ✅ APPROUVER        → Marquer comme vérifiée (pas de numéro)
  🏆 CERTIFIER        → Attribuer un numéro d'état + date + badge
  ❌ REJETER          → Refuser avec raison
```

---

## 📄 Documents attendus

Le formulaire de demande exige **7 documents obligatoires**:

| # | Document | Format | Taille max |
|---|----------|--------|-----------|
| 1 | **Statuts signés** | PDF, DOC, DOCX | 10 MB |
| 2 | **Règlement intérieur** | PDF, DOC, DOCX | 10 MB |
| 3 | **PV Assemblée constitutive** | PDF | 10 MB |
| 4 | **Liste des membres fondateurs** | PDF, XLSX, XLS | 10 MB |
| 5 | **Plan d'action** | PDF | 10 MB |
| 6 | **Pièces d'identité** | PDF | 20 MB |
| 7 | **Lettre de demande** | PDF, DOC, DOCX | 10 MB |

### Stockage des documents
```
Location: storage/app/public/chambers/{slug}/documents/
Pattern:  {document_type}_{timestamp}.{extension}

Exemple:
storage/app/public/chambers/chamber-commerce-123/documents/
  ├── statuts_1700234567.pdf
  ├── reglement_interieur_1700234568.pdf
  ├── pv_assemblee_1700234569.pdf
  └── ... (4 autres fichiers)
```

---

## 🖥️ Page de détails d'une demande

### Sections affichées:

#### 1. En-tête
```
Nom de la chambre
Badge: "En attente de certification"
```

#### 2. Informations de la demande
```
2 colonnes avec:
- Sigle/Acronyme
- Numéro NINA
- Type de chambre (nationale ou bilatérale)
- Date de soumission

- Date de création de la chambre
- Localisation
- Email
- Téléphone
```

#### 3. Description complète
```
Affiche la description complète (texte libre)
```

#### 4. Informations demandeur
```
Avatar + Nom + Email de la personne qui a soumis
```

#### 5. Documents attachés (avec téléchargement)
```
Grille 2 colonnes montrant:
- Icône PDF
- Nom du document
- Chemin du fichier
- Bouton "Télécharger"

Tous les 7 documents avec les labels français
```

#### 6. Actions SuperAdmin
```
3 boutons grands:
  ✅ Approuver
  🏆 Certifier & Numéro
  ❌ Rejeter
```

---

## 🔧 Les 3 actions possibles

### Action 1: ✅ Approuver

**Quand l'utiliser:**
- Les documents sont corrects mais la chambre n'est pas encore prête pour un numéro officiel
- Vous voulez valider temporairement

**Résultat:**
```
Chamber.verified = true
Pas de numéro d'état attribué
Pas de date de certification
```

**Modal:**
```
"Êtes-vous sûr de vouloir approuver cette demande?"
"La chambre sera vérifiée mais ne recevra pas encore de numéro d'état."
→ Bouton "Approuver"
```

### Action 2: 🏆 Certifier & Attribuer Numéro

**Quand l'utiliser:**
- Les documents sont complets et approuvés
- La chambre est officielle
- Vous attribuez un **numéro d'état unique**

**Résultat:**
```
Chamber.verified = true
Chamber.state_number = "{votre_numéro}"
Chamber.certification_date = date_selected
Chamber.certification_notes → Ajoute les notes
```

**Modal avec formulaire:**
```
1. Numéro d'état * (requis)
   Exemple: CC-2024-001

2. Date de certification * (requis)
   Sélecteur de date

3. Notes (optionnel)
   Zone de texte

→ Bouton "Certifier"
```

**Exemple de numéro:**
```
Format recommandé:
CC-YYYY-NNN

CC = Chambre Commerce (ou autre sigle)
YYYY = Année
NNN = Numéro séquentiel

Exemples:
CC-2024-001
CC-2024-002
CNDC-2024-105
```

### Action 3: ❌ Rejeter

**Quand l'utiliser:**
- Les documents sont manquants ou incomplets
- Les informations ne sont pas correctes
- La demande ne répond pas aux critères

**Résultat:**
```
Chamber.status = 'rejected'
Chamber.rejection_reason = "{votre_raison}"
```

**Modal avec formulaire:**
```
Raison du rejet * (requis)
Zone de texte avec placeholder:
"Expliquez pourquoi cette demande est rejetée..."

Exemple:
"Numéro NINA invalide. Veuillez vérifier avec l'administration."
"Documents manquants: lettre de demande signée."

→ Bouton "Rejeter"
```

---

## 📊 Dashboard SuperAdmin - Section "Demandes récentes"

### Affichage sur le dashboard:

```
Section: 📬 Demandes récentes en attente
Affiche les 5 dernières demandes non vérifiées

Pour chaque demande:
┌─────────────────────────────────────┬──────────┐
│ Nom de la chambre                   │ Examiner │
│ Demandé le JJ/MM/YYYY à HH:mm      │          │
└─────────────────────────────────────┴──────────┘
```

### Lien "Voir toutes"
```
Redirige vers: /super-admin/chambers?filter_status=pending
Affiche toute la liste avec pagination
```

---

## 🔗 Routes et endpoints

### Routes SuperAdmin pour les demandes:

```
GET  /super-admin/dashboard
     → Voir les demandes récentes

GET  /super-admin/chambers
     → Lister toutes les chambres
     → Filtrer par: pending, verified, certified

GET  /super-admin/chambers/{chamber}/request
     → Voir les détails complets d'une demande
     → Télécharger les documents

POST /super-admin/chambers/{chamber}/approve
     → Approuver une demande

POST /super-admin/chambers/{chamber}/certify
     → Certifier et attribuer un numéro

POST /super-admin/chambers/{chamber}/reject
     → Rejeter une demande
```

---

## 📝 Format des données stockées

### Demandes (modèle Chamber)

```json
{
  "id": 1,
  "name": "Chambre de Commerce",
  "slug": "chambre-de-commerce",
  "type": "national",
  "location": "Kinshasa",
  "address": "123 Avenue Principal",
  "email": "info@chambre.cd",
  "phone": "+243999888777",
  "description": "Une chambre dynamique...",
  "verified": false,
  "state_number": null,
  "certification_date": null,
  "certification_notes": {
    "documents": {
      "statuts": "chambers/chambre-de-commerce/documents/statuts_1700234567.pdf",
      "reglement_interieur": "chambers/chambre-de-commerce/documents/reglement_interieur_1700234568.pdf",
      "pv_assemblee": "chambers/chambre-de-commerce/documents/pv_assemblee_1700234569.pdf",
      "liste_membres": "chambers/chambre-de-commerce/documents/liste_membres_1700234570.xlsx",
      "plan_action": "chambers/chambre-de-commerce/documents/plan_action_1700234571.pdf",
      "pieces_identite": "chambers/chambre-de-commerce/documents/pieces_identite_1700234572.pdf",
      "lettre_demande": "chambers/chambre-de-commerce/documents/lettre_demande_1700234573.pdf"
    },
    "sigle": "CC",
    "creation_date": "2024-01-15",
    "nina_number": "NINA12345678",
    "submitted_at": "2024-11-17T10:30:00",
    "submitted_by": 5
  }
}
```

---

## 🔒 Sécurité

- ✅ Seul les SuperAdmin (`is_admin = 1`) peuvent accéder
- ✅ Les documents sont stockés dans `storage/public`
- ✅ Validation côté serveur pour tous les inputs
- ✅ Les fichiers téléchargés sont validés (type + taille)

---

## 💡 Cas d'usage

### Scénario 1: Approuvation rapide
```
1. SuperAdmin va à /super-admin/dashboard
2. Voit "Demandes récentes en attente"
3. Clique "Examiner"
4. Vérifie rapidement (documents OK?)
5. Clique "Approuver"
6. ✅ Demande marquée comme vérifiée
```

### Scénario 2: Certification complète
```
1. SuperAdmin examine la demande détails
2. Télécharge et vérifie les 7 documents
3. Tout est correct → Clique "Certifier & Numéro"
4. Entre numéro: "CC-2024-001"
5. Entre date: "17/11/2024"
6. Ajoute notes: "Chambre conforme, tous documents OK"
7. Clique "Certifier"
8. ✅ Chambre certifiée avec numéro officiel!
```

### Scénario 3: Rejet
```
1. SuperAdmin examine la demande
2. Le numéro NINA est invalide
3. Clique "Rejeter"
4. Entre raison: "Numéro NINA invalide. Vérifier avec l'administration."
5. Clique "Rejeter"
6. ❌ Demande rejetée avec raison
```

---

## ✨ Nouvelles fonctionnalités

| Feature | Statut | Détails |
|---------|--------|---------|
| Voir détails demande | ✅ | Page `/super-admin/chambers/{id}/request` |
| Télécharger documents | ✅ | 7 documents avec boutons de téléchargement |
| Dashboard widget | ✅ | 5 demandes récentes affichées |
| Approuver demande | ✅ | Mark as `verified = true` |
| Certifier + Numéro | ✅ | Attribuer `state_number` + date |
| Rejeter demande | ✅ | Ajouter `rejection_reason` |
| Filtrer par statut | ✅ | pending, verified, certified |

---

## 📞 Questions fréquentes

**Q: Où télécharger les documents?**
A: Sur la page de détails (`/super-admin/chambers/{id}/request`), section "Documents attachés", bouton "Télécharger" pour chaque document.

**Q: Que se passe-t-il après approbation?**
A: La chambre est marquée comme `verified = true` et apparaît dans la liste des chambres vérifiées.

**Q: Que se passe-t-il après certification?**
A: La chambre reçoit un **numéro d'état unique** (badge officiel) et une date de certification. Elle apparaît dans "Chambres certifiées".

**Q: Puis-je modifier un numéro après certification?**
A: Actuellement non. Si erreur, vous devez rejeter et créer une nouvelle demande.

**Q: Les demandeurs sont-ils notifiés?**
A: À implémenter - envoi d'email quand approved/certified/rejected.

---

## 🚀 Accès

### Pour voir une demande:
```
SuperAdmin → http://127.0.0.1:8000/super-admin/chambers/{chamber_id}/request
```

### Pour lister toutes les demandes:
```
SuperAdmin → http://127.0.0.1:8000/super-admin/chambers?filter_status=pending
```

### Pour approuver/certifier/rejeter:
```
Via les boutons d'action sur la page de détails
```

---

**Créé le:** 17/11/2025
**Statut:** ✅ Complet
**Prêt pour:** Production


