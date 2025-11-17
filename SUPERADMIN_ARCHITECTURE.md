# SuperAdmin Module - Architecture & Implementation Plan

## 1. ARCHITECTURE GLOBALE

### Hiérarchie des rôles
```
is_admin = 0  →  Utilisateur normal (ROLE_USER)
is_admin = 1  →  Super Admin (ROLE_SUPER_ADMIN) 
is_admin = 2  →  Gestionnaire de Chambre (ROLE_CHAMBER_MANAGER)
```

### Structure de dossiers (existante + améliorée)
```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   │   ├── SuperAdminController.php (existant, à améliorer)
│   │   │   ├── SuperAdminChamberController.php (NOUVEAU)
│   │   │   ├── SuperAdminUserController.php (NOUVEAU)
│   │   │   └── SuperAdminNotificationController.php (NOUVEAU)
│   ├── Requests/
│   │   └── Admin/
│   │       ├── CertifyChamberRequest.php (NOUVEAU)
│   │       └── PromoteUserRequest.php (NOUVEAU)
│   └── Policies/
│       ├── ChamberPolicy.php (à améliorer)
│       └── UserPolicy.php (NOUVEAU)
├── Services/
│   └── Admin/
│       ├── ChamberManagementService.php (NOUVEAU)
│       ├── UserManagementService.php (NOUVEAU)
│       └── NotificationService.php (NOUVEAU)
└── Mail/
    ├── ChamberCertifiedMail.php (NOUVEAU)
    ├── ManagerPromotedMail.php (NOUVEAU)
    └── BulkNotificationMail.php (NOUVEAU)

resources/views/
└── admin/
    └── super-admin/
        ├── dashboard.blade.php (existant, à améliorer)
        ├── chambers/
        │   ├── index.blade.php (NOUVEAU - liste)
        │   ├── show.blade.php (NOUVEAU - détails)
        │   └── certify-modal.blade.php (NOUVEAU)
        ├── managers/
        │   ├── index.blade.php (NOUVEAU)
        │   ├── promote-modal.blade.php (NOUVEAU)
        │   └── demote-modal.blade.php (NOUVEAU)
        └── notifications/
            ├── index.blade.php (NOUVEAU)
            └── create-modal.blade.php (NOUVEAU)
```

---

## 2. PLAN DÉTAILLÉ DES PAGES UI (Charte UI/UX)

### 2.1 Dashboard Amélioré
**Route:** `/admin/dashboard`

**Composants:**
- Header avec titre "Tableau de bord"
- 6 KPI Cards (Total, Agréées, En attente, Utilisateurs, Gestionnaires, Utilisateurs normaux)
- Alert "Demandes en attente" (si > 0)
- 4 Quick Actions Buttons
- Section Statistiques (Graphiques - optional pour Phase 2)
- Section "Activité récente"

**Design:** Respecte l'existant - cards avec icônes, couleurs #073066, #fcb357, #b81010

---

### 2.2 Gestion des Chambres
**Route:** `/admin/chambers`

**Composants:**
- Header avec filtres (Agréées/En attente/Certifiées)
- Barre de recherche + Tri (Nom, Date, Statut)
- Table avec colonnes:
  - Logo + Nom
  - Location
  - Gestionnaire (avatar + nom)
  - Membres
  - Statut (badge: Agréée/En attente/Certifiée)
  - Actions (voir, certifier, modifier, supprimer)
- Pagination (15 par page)

**Modal Certifier:**
- Input: Numéro d'état (state_number)
- Date de certification
- Notes optionnelles
- Boutons: Annuler / Certifier

---

### 2.3 Gestion des Gestionnaires
**Route:** `/admin/managers`

**Composants:**
- Header + "Ajouter un gestionnaire"
- Table:
  - Avatar + Nom
  - Email
  - Chambres gérées
  - Statut actif/inactif
  - Actions (voir profil, retirer rôle)
- Pagination

**Modal Promouvoir:**
- Liste des utilisateurs normaux
- Autocomplete searchable
- Bouttons: Annuler / Promouvoir

---

### 2.4 Notifications en Masse
**Route:** `/admin/notifications`

**Composants:**
- Onglets: Nouveau message / Historique
- Tab "Nouveau":
  - Type de destinataire (Toutes chambres / Une chambre / Gestionnaires)
  - Dropdown pour sélectionner chambres (si applicable)
  - Sujet (email)
  - Message (textarea rich text - optional)
  - Boutons: Aperçu / Envoyer
- Tab "Historique":
  - Table: Date, Type, Destinataires, Statut

---

### 2.5 Demandes Créations en Attente
**Route:** `/admin/chambers/pending-requests`

**Composants:**
- Header + Compteur
- Table:
  - Logo + Nom chambre
  - Demandeur (avatar + nom + email)
  - Date de demande
  - Détails brefs (type, localisation)
  - Actions (Voir détails, Approuver, Rejeter)
- Pagination

**Modal Détails/Approbation:**
- Infos complètes de la chambre
- Informations demandeur
- Input: Numéro d'état (optionnel)
- Buttons: Rejeter / Approuver

---

## 3. LOGIQUE MÉTIER (SuperAdmin)

### 3.1 Privilèges SuperAdmin
✅ Créer gestionnaire (promouvoir utilisateur)
✅ Valider demande création chambre + attribuer numéro d'état + badge officiel
✅ Certifier une chambre
✅ Décertifier une chambre
✅ Supprimer chambre
✅ Supprimer gestionnaire
✅ Envoyer notifications en masse
✅ Voir toutes les chambres / utilisateurs
✅ Analytics/Dashboard

### 3.2 Workflow Certification Chambre
1. Super Admin va sur `/admin/chambers`
2. Clique "Certifier" sur une chambre
3. Modal s'ouvre:
   - Input: Numéro d'état (unique, requis)
   - Date certification (auto-rempli = today)
   - Notes (optionnel)
4. Sur "Certifier":
   - Validation backend
   - Update Chamber: state_number, certification_date, verified=true
   - Email au gestionnaire: "ChamberCertifiedMail"
   - Notification success affichée

### 3.3 Workflow Promotion Manager
1. Super Admin va sur `/admin/managers`
2. Clique "Ajouter gestionnaire"
3. Modal: Autocomplete utilisateurs (only ROLE_USER)
4. Sélectionne + "Promouvoir"
5. Backend:
   - Valide que user.is_admin === 0
   - Update user: is_admin = 2
   - Email: "ManagerPromotedMail"
   - Notification success

### 3.4 Workflow Approbation Demande Création
1. Super Admin va sur `/admin/chambers/pending-requests`
2. Voit chambres non-vérifiées (verified=false)
3. Clique "Approuver"
4. Modal:
   - Infos chambre complètes
   - Input: Numéro d'état
   - Input: Sélectionner gestionnaire existant OU promouvoir nouveau user
5. Sur "Approuver":
   - Update chamber: verified=true, state_number, certification_date
   - Si nouveau user: créer manager
   - Attach manager à chamber
   - Email manager: "ChamberApprovedMail"
   - Email créateur: "ChamberApprovedMail"

### 3.5 Système Notifications
- **Type 1:** Notification interne (DB)
- **Type 2:** Email
- **Type 3:** Bulk (email + notification)

Email trigger events:
- Chamber created (user → "request received")
- Chamber approved (user + manager → "approved")
- Chamber rejected (user → "rejected")
- Chamber certified (manager → "certified")
- Manager promoted (user → "promoted")

---

## 4. POLITIQUE D'ACCÈS (Policies)

### SuperAdminPolicy (NOUVEAU)
```php
public function viewAdmin() → is_admin === 1
public function manageChambers() → is_admin === 1
public function manageUsers() → is_admin === 1
public function sendBulkNotifications() → is_admin === 1
public function certifyChamber() → is_admin === 1
public function promoteUser() → is_admin === 1
public function deleteChamber() → is_admin === 1
```

### Middleware 'admin'
```php
// Vérifie user.is_admin === 1
→ Redirect /dashboard si échoue
```

---

## 5. COMPOSANTS RÉUTILISABLES (Vue Blade)

### Components à créer:
```
resources/views/components/admin/
├── kpi-card.blade.php
├── action-button.blade.php
├── table-header.blade.php
├── modal-certify.blade.php
├── modal-promote.blade.php
├── status-badge.blade.php
├── user-avatar.blade.php
└── empty-state.blade.php
```

---

## 6. MÉTRIQUES / KPI À AFFICHER

```
Dashboard:
- Total chambres
- Chambres agréées / certifiées
- Chambres en attente
- Total utilisateurs
- Gestionnaires actifs
- Utilisateurs normaux
- Demandes en attente (alert)
```

---

## 7. CONTRAINTES & VALIDATION

✅ Numéro d'état = unique par chambre
✅ Certification date = cannot be future
✅ Un user = 0 ou 1 ou 2 (pas de multi-roles)
✅ Gestionnaire can manage multiple chambers
✅ SuperAdmin can delete chambers (soft delete?)
✅ All actions logged (audit trail) - PHASE 2

---

## 8. PHASES DE DÉVELOPPEMENT

### PHASE 1 (Immédiate):
✅ Améliorations dashboard
✅ Gestion chambres (list + certify modal)
✅ Gestion gestionnaires (list + promote modal)
✅ Demandes en attente (list + approve/reject)
✅ Emails notifications

### PHASE 2 (Futur):
📊 Graphiques dashboard
📧 Bulk notifications page
📝 Audit trail
⚙️ Admin settings

---

## 9. MIGRATIONS NÉCESSAIRES

```php
// Aucune migration pour Phase 1 (fields déjà existent)
// state_number exists
// certification_date exists
// verified exists
```


