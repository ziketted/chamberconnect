# PRD: Gestion des Chambres de Commerce

## Objectif
Permettre aux utilisateurs de découvrir, consulter et rejoindre les chambres de commerce bilatérales et nationales.

## Types de Chambres

### 1. Chambres Bilatérales
- Entre deux pays (ex: Suisse - RDC)
- Affichent le taux de change (1 CHF = X CDF)
- Informations de l'ambassade (téléphone, site web, adresse)

### 2. Chambres Nationales
- Pour un seul pays
- Focus sur le commerce local

## Fonctionnalités Principales

### 1. Liste des Chambres
- **Route**: `/chambers`
- **Éléments affichés**:
  - Image de couverture (ou pattern par défaut)
  - Logo de la chambre
  - Nom
  - Type (Bilatérale/Nationale)
  - Localisation
  - Nombre de membres
  - Badge "Membre" (si déjà membre)
  - Bouton "Adhérer" (si non membre)
- **Filtres**:
  - Recherche par nom
  - Type (bilatérale/nationale)
  - Statut membre

### 2. Détail d'une Chambre
- **Route**: `/chamber/{slug}`
- **Structure avec Tabs**:
  - 🏠 **Overview**
  - 📅 **Events**
  - 👥 **Members**
  - 🤝 **Partners**

#### Tab Overview
**À propos de la chambre**:
- Description complète
- ~~Badges de certification~~ (supprimés pour épurer)

**Événements à venir** (2 derniers):
- Card avec image, titre, date, lieu
- Lien "Voir tous"

**Partenaires** (carousel):
- Logos des partenaires
- Navigation dots

#### Tab Events
- Liste complète des événements
- Uniquement événements à venir (pas de passés)
- Actions: Réserver, Voir détails, Annuler
- Logique d'annulation respectée

#### Tab Members
- Liste des membres approuvés
- Photo, nom, entreprise
- Recherche par nom

#### Tab Partners
- Grille des partenaires
- Logos, noms, sites web

### 3. Adhésion à une Chambre
- **Bouton**: "Rejoindre" (si non membre)
- **Route**: `POST /chambers/{slug}/join`
- **Workflow**:
  1. Utilisateur clique "Rejoindre"
  2. Demande créée avec `status = 'pending'`
  3. Badge "En attente" affiché
  4. Admin/Manager valide
  5. Status → 'approved'
  6. Badge "Membre" affiché

### 4. Mes Chambres
- **Route**: `/my-chambers`
- **Layout**: Sidebar (profil) + Grid (chambres)
- **Statistiques**:
  - Total chambres
  - Chambres vérifiées
  - Total membres
- **Filtres**:
  - Recherche
  - Statut (pending/approved)
- **Actions**:
  - Consulter
  - Quitter (bouton rouge visible)

## Informations Spécifiques

### Banner
- Image de couverture
- Logo overlay
- Nom de la chambre
- Localisation + nombre de membres
- Type (badge)
- Pays (si bilatérale)
- Bouton "Rejoindre"/"En attente"/"Membre"

### Taux de Change (Bilatérales)
- **Position**: Coin supérieur droit des tabs
- **Format**: "1 CHF = 2,750.45 CDF"
- **Style**: Badge bleu avec bordure (comme "Agréée")
- **Service**: `ExchangeRateService`
- **API**: exchangerate-api.com
- **Cache**: 6 heures
- **Pays supportés**: 23 pays

### Contact & Adresse
**Affichage**:
- 📧 Email
- ☎️ Téléphone
- 📍 Adresse
- 🌐 Site web
- 🗺️ Bouton "Itinéraire"

~~**Badges** (supprimés): Vérifiée, Agréée~~

### Informations Complémentaires
**Ordre** (du haut vers le bas):
1. Type (Bilatérale/Nationale)
2. Pays (si bilatérale)
3. Téléphone ambassade (si bilatérale)
4. Site web ambassade (si bilatérale)
5. **Adresse** (en dernier)

**Gestion du texte long**:
- `overflow-hidden` sur conteneur
- `break-all` pour URLs et téléphones
- `flex-shrink-0` sur icônes
- Empêche tout débordement

## Design

### Palette de Couleurs
- Primaire: Bleu (#2563eb, #1e40af)
- Succès: Vert
- Attente: Jaune
- Danger: Rouge

### Cards & Sections
- `rounded-xl` avec `shadow-sm`
- Bordures `border-neutral-200 dark:border-gray-700`
- Backgrounds avec gradients subtils
- Hover effects

### Dark Mode
- Full support
- Couleurs adaptées automatiquement
- Contrastes optimisés

## Règles Métier

### Statuts Membre
- `null`: Non membre → Bouton "Rejoindre"
- `pending`: En attente → Badge "En attente" (jaune)
- `approved`: Membre → Badge "Membre" (vert)

### Chambres Suspendues
- Affichage limité
- Actions désactivées
- Message d'information

### Validation Admin
- Super Admin: Toutes chambres
- Chamber Admin/Manager: Sa chambre uniquement
- Notifications envoyées

## API

### GET `/chamber/{slug}`
**Response** inclut:
- Détails de la chambre
- Partenaires
- Événements à venir
- Membres approuvés
- Status membre de l'utilisateur
- Taux de change (si bilatérale)

## Tests Prioritaires

### Tests Fonctionnels
1. ✅ Consultation d'une chambre bilatérale
2. ✅ Consultation d'une chambre nationale
3. ✅ Adhésion à une chambre
4. ✅ Navigation entre tabs
5. ✅ Affichage du taux de change
6. ✅ Quitter une chambre
7. ✅ Filtres et recherche

### Tests UI
1. ✅ Taux de change affiché correctement
2. ✅ Adresse en dernier dans Infos complémentaires
3. ✅ Pas de débordement texte (URLs longues)
4. ✅ Bouton "Quitter" visible (rouge)
5. ✅ Dark mode cohérent
6. ✅ Image de couverture ou pattern par défaut
7. ✅ Responsive design

### Tests d'Intégration
1. ✅ Service de taux de change fonctionne
2. ✅ Cache de taux de change (6h)
3. ✅ Gestion des erreurs API
4. ✅ Validation des membres par admin




