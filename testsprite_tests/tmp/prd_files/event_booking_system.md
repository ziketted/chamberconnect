# PRD: Système de Réservation d'Événements

## Objectif
Permettre aux utilisateurs de réserver, confirmer et annuler leur participation aux événements des chambres de commerce.

## Fonctionnalités Principales

### 1. Consultation des Événements
- **Page**: `/events`
- **Description**: Liste paginée de tous les événements à venir
- **Éléments affichés**:
  - Image de couverture ou pattern par défaut
  - Titre de l'événement
  - Date et heure
  - Lieu (ville, pays) ou "En ligne"
  - Nombre de participants / places disponibles
  - Statut (Ouvert, Complet, Confirmé)
  - Bouton "Voir détails"

### 2. Modal de Détails d'Événement
- **Déclencheur**: Clic sur "Voir détails"
- **Chargement**: AJAX vers `/api/events/{event}/details`
- **Contenu affiché**:
  - Image de couverture complète
  - Badges de statut (Vérifiée, Complet, Confirmé/Réservé)
  - Informations détaillées dans des cards colorées:
    - 🔵 Date (formatée)
    - 🟣 Heure
    - 🟢 Lieu / Mode
    - 🟠 Participants (X/Y inscrits)
  - Description complète
  - Adresse complète (si présentiel)
  - Prix (si applicable)
  - Boutons d'action contextuels

### 3. Actions de Réservation

#### 3.1 Réserver une Place
- **Condition**: Utilisateur connecté, événement pas complet, pas déjà réservé
- **Route**: `POST /events/{event}/book`
- **Comportement**:
  - Vérifie les places disponibles
  - Crée une réservation avec `status = 'reserved'`
  - Affiche message de succès
  - Met à jour l'UI instantanément

#### 3.2 Confirmer Participation
- **Condition**: Réservation existante avec `status = 'reserved'`
- **Route**: `PATCH /events/{event}/confirm`
- **Comportement**:
  - Change le status à `'confirmed'`
  - Affiche message de confirmation
  - Pour événements online: affiche le bouton "Rejoindre en ligne"

#### 3.3 Rejoindre en Ligne
- **Condition**: Événement online + réservation confirmée + lien disponible
- **Comportement**: Ouvre le `lien_live` dans un nouvel onglet

#### 3.4 Annuler Réservation
- **Condition**: Réservation existante
- **Restriction**: **Impossible si status = 'confirmed'**
- **Route**: `DELETE /events/{event}/cancel`
- **Comportement**:
  - Modal de confirmation
  - Si status = 'reserved': supprime la réservation
  - Si status = 'confirmed': bouton désactivé avec message "Annulation impossible"

### 4. Page Mes Réservations
- **Route**: `/my-bookings`
- **Sections**:
  - **Événements à venir**: avec actions (Confirmer, Rejoindre, Annuler)
  - **Événements passés**: liste paginée (10 par page)

## Règles Métier

### Gestion des Places
- `max_participants`: Nombre maximum de places
- `participants_count`: Nombre actuel de participants
- `available_spots = max_participants - participants_count`
- Si `available_spots <= 0`: status = 'full', bouton "Complet" désactivé

### États de Réservation
1. **Non réservé**: Bouton "Réserver une place"
2. **Reserved**: Boutons "Confirmer" + "Annuler"
3. **Confirmed**: 
   - Bouton "Rejoindre en ligne" (si online + lien)
   - Bouton "Annulation impossible" (désactivé)

### Restrictions d'Annulation
- ✅ Annulation autorisée: `booking_status === 'reserved'`
- ❌ Annulation interdite: `booking_status === 'confirmed'`
- Raison: Engagement confirmé auprès de l'organisateur

## UI/UX

### Design
- **Couleurs primaires**: Bleu (#2563eb, #1e40af)
- **Cards colorées**: Gradient backgrounds
- **Animations**: fadeIn (200ms), slideUp (300ms)
- **Modal**: Backdrop blur + shadow-2xl
- **Boutons**:
  - Réserver: Gradient bleu
  - Confirmer: Gradient bleu clair
  - Rejoindre: Gradient vert
  - Annuler: Bordure orange/rouge
  - Désactivé: Gris avec cursor-not-allowed

### Responsive
- Desktop: Modal max-w-3xl, 2 colonnes pour infos
- Tablet: Adaptatif
- Mobile: 1 colonne, boutons empilés

### Dark Mode
- Tous les éléments supportent le dark mode
- Couleurs ajustées automatiquement

## API

### GET `/api/events/{event}/details`
**Response**:
```json
{
  "success": true,
  "event": {
    "id": 1,
    "title": "Swiss Business Day",
    "description": "...",
    "date": "2025-12-01",
    "time": "01:01:00",
    "mode": "online|offline",
    "city": "TYUIO",
    "country": "Congo",
    "address": "31 Boulevard du 30 juin",
    "lien_live": "https://...",
    "max_participants": 100,
    "participants_count": 45,
    "available_spots": 55,
    "status": "open|full",
    "cover_image_path": "...",
    "type": "forum|networking|...",
    "is_booked": true,
    "booking_status": "reserved|confirmed",
    "is_authenticated": true,
    "chamber": {
      "name": "CCSC",
      "verified": true
    }
  }
}
```

## Tests Prioritaires

### Tests Fonctionnels
1. ✅ Réservation réussie (places disponibles)
2. ✅ Réservation échouée (événement complet)
3. ✅ Confirmation de réservation
4. ✅ Annulation d'une réservation 'reserved'
5. ❌ Tentative d'annulation d'une réservation 'confirmed' (doit échouer)
6. ✅ Modal AJAX charge correctement les détails
7. ✅ Affichage contextuel des boutons selon le statut
8. ✅ Pagination des événements passés

### Tests UI
1. ✅ Modal s'ouvre avec animation
2. ✅ Cards colorées affichent les bonnes informations
3. ✅ Boutons désactivés ont le bon style
4. ✅ Dark mode fonctionne correctement
5. ✅ Responsive sur mobile/tablet/desktop

### Tests d'Intégration
1. ✅ Backend → Frontend: données correctes
2. ✅ AJAX: gestion des erreurs réseau
3. ✅ Notifications toast après actions
4. ✅ Mise à jour en temps réel des places disponibles

