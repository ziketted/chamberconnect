# PRD: Profil Utilisateur & Dashboard

## Objectif
Permettre aux utilisateurs de gérer leur profil et consulter leurs statistiques et activités.

## Fonctionnalités Principales

### 1. Dashboard Utilisateur
- **Route**: `/dashboard`
- **Layout**: Grid responsive

#### Card Profil Complet
**Header**: Gradient bleu

**Photo de Profil**:
- Source: `profile_photo_path` ou `avatar`
- Fallback: Initiales avec gradient bleu
- Bordure blanche + badge "online" vert
- Effets hover: zoom + élévation

**Informations**:
- Nom (avec tooltip si long)
- Email
- Entreprise (si disponible)

**Statistiques Interactives**:
1. **Chambres rejointes** (X):
   - Card avec gradient bleu
   - Lien vers `/my-chambers`
   - Icône `building-2`
   - Hover: scale + shadow

2. **Événements participés** (Y):
   - Card avec gradient vert
   - Lien vers `/my-bookings`
   - Icône `calendar-check`
   - Hover: scale + shadow

**~~Bouton Action~~** (supprimé): "Modifier mon profil"

#### Card Mes Chambres (supprimée)
- Redirection: Intégrée dans statistiques
- Lien "Voir toutes les chambres" dans la card statistiques

#### Événements à Venir
- Liste des prochains événements réservés
- Actions contextuelles
- Lien vers détails

#### Activité Récente
- Posts récents
- Interactions

### 2. Profil Utilisateur
- **Route**: `/profile`
- **Sections**:
  - Informations personnelles
  - Photo de profil
  - Entreprise
  - Mot de passe
  - Paramètres

#### Upload Photo de Profil
**Workflow**:
1. Utilisateur clique sur zone photo
2. Sélectionne fichier (input file)
3. Preview instantané
4. Clic "Enregistrer"
5. Upload AJAX vers `/profile/photo`
6. Backend sauvegarde dans `profile_photo_path` ET `avatar`
7. Response retourne `photo_url` avec timestamp
8. Frontend met à jour:
   - Photo dans formulaire
   - Photo dans header
   - Photo dans dashboard
9. Toast de succès

**Problèmes Résolus**:
- ✅ Photo s'affiche correctement partout
- ✅ Photo header cohérente avec profil
- ✅ Cache navigateur contourné (timestamp)
- ✅ Mise à jour simultanée des 2 champs

### 3. Header Utilisateur

#### Dropdown Profil
**Bouton**:
- Photo (ou initiales)
- Nom
- Entreprise (si disponible)
- Chevron (rotation au hover)

**Menu**:
- Dashboard
- Profil
- Paramètres
- Déconnexion

**Unification**:
- ✅ Toutes icônes en gris uniforme
- Design glassmorphism
- Animations fluides

## Design

### Card Profil Dashboard

**Structure**:
```
┌─────────────────────────────────┐
│ ▓▓▓ Gradient Header ▓▓▓         │
├─────────────────────────────────┤
│     🔵 Photo                    │
│     Jean Dupont                 │
│     jean@example.com            │
│     Entreprise XYZ              │
├─────────────────────────────────┤
│ ┌──────────┐  ┌──────────┐     │
│ │ Chambres │  │ Événements│    │
│ │    5     │  │    12     │    │
│ └──────────┘  └──────────┘     │
└─────────────────────────────────┘
```

**Animations**:
- `slideInDown`: Header
- `fadeIn`: Contenu
- `shimmer`: Loading state
- Hover: scale, rotate, glow

### Profil Page

**Photo Section**:
- Zone upload avec border-dashed
- Preview circulaire
- Bouton "Enregistrer" avec spinner
- Messages success/error

**Forms**:
- Inputs Tailwind
- Validation inline
- Dark mode support

## Règles Métier

### Photo de Profil
- **Formats acceptés**: JPG, PNG, GIF, WebP
- **Taille max**: 2MB
- **Stockage**: `storage/app/public/profile-photos/`
- **Champs DB**: 
  - `profile_photo_path`: Nouveau champ principal
  - `avatar`: Champ legacy (pour compatibilité)
- **Affichage prioritaire**: `profile_photo_path` > `avatar` > initiales

### Statistiques
- **Chambres**: Count des relations `user->chambers` avec `status = 'approved'`
- **Événements**: Count des relations `user->events` 

### Cohérence Visuelle
- Photo doit être identique:
  - Header dropdown
  - Dashboard card
  - Page profil
  - Sidebar (my-chambers)

## API

### POST `/profile/photo`
**Request**: `multipart/form-data`
```
photo: File
```

**Response**:
```json
{
  "success": true,
  "photo_url": "/storage/profile-photos/user123.jpg?t=1638360000"
}
```

**Controller**: `ProfileController@updatePhoto`
- Sauvegarde fichier
- Met à jour `profile_photo_path`
- Met à jour `avatar` (fallback)
- Retourne URL avec timestamp

## Tests Prioritaires

### Tests Fonctionnels
1. ✅ Upload photo de profil
2. ✅ Mise à jour informations personnelles
3. ✅ Changement mot de passe
4. ✅ Statistiques correctes (chambres, événements)
5. ✅ Liens statistiques fonctionnent
6. ✅ Photo cohérente partout

### Tests UI
1. ✅ Preview photo avant upload
2. ✅ Loading spinner pendant upload
3. ✅ Toast notifications
4. ✅ Photo mise à jour instantanément (header + dashboard)
5. ✅ Icônes dropdown uniformes (gris)
6. ✅ Animations fluides
7. ✅ Dark mode

### Tests d'Intégration
1. ✅ Upload → DB → Affichage
2. ✅ Cache navigateur contourné
3. ✅ Fallback initiales si pas de photo
4. ✅ Responsive design
5. ✅ Gestion erreurs upload

