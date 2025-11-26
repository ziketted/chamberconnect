# SuperAdmin Module - Integration Guide

## 🎯 Objectif

Intégrer complètement le module SuperAdmin dans ChamberConnect DRC en respectant l'architecture existante et la charte UI/UX.

---

## ✅ PARTIE 1 - BACKEND (PHASE 1 - COMPLÈTE)

### Fichiers créés et à vérifier:

#### 1. Services (`app/Services/Admin/`)
- ✅ `ChamberManagementService.php` - 125 lignes
- ✅ `UserManagementService.php` - 165 lignes
- ✅ `NotificationService.php` - 125 lignes

**À faire:** 
```bash
# Vérifier que les Services importent correctement les modèles et mailables
php artisan tinker
# Tester: new \App\Services\Admin\ChamberManagementService()
```

---

#### 2. Form Requests (`app/Http/Requests/Admin/`)
- ✅ `CertifyChamberRequest.php` - Validation certification
- ✅ `PromoteUserRequest.php` - Validation promotion

**À faire:**
```bash
# Vérifier les validations
# Aucune dépendance externe, basé sur les modèles existants
```

---

#### 3. Mail Classes (`app/Mail/`)
- ✅ `ChamberCertifiedMail.php`
- ✅ `ManagerPromotedMail.php`

**À faire:**
```bash
# Vérifier que les vues existent:
# - resources/views/emails/chamber-certified.blade.php
# - resources/views/emails/manager-promoted.blade.php
```

---

#### 4. Controllers (`app/Http/Controllers/Admin/`)
- ✅ `SuperAdminChamberController.php` - 160 lignes
- ✅ `SuperAdminUserController.php` - 155 lignes
- ✅ `SuperAdminNotificationController.php` - 120 lignes

**À faire:**
```bash
# Vérifier que les controllers utilisent les bons namespaces
# Vérifier que les routes existent (voir ci-dessous)
```

---

## 🛣️ PARTIE 2 - ROUTES (À ajouter dans `routes/web.php`)

### Ajouter après la ligne 82 (fin du middleware 'admin' existant):

```php
// ===== SUPERADMIN CHAMBER MANAGEMENT =====
Route::prefix('/admin/chambers')->name('admin.chambers.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\SuperAdminChamberController::class, 'index'])
        ->name('index');
    Route::get('/{chamber}', [\App\Http\Controllers\Admin\SuperAdminChamberController::class, 'show'])
        ->name('show');
    Route::post('/{chamber}/certify', [\App\Http\Controllers\Admin\SuperAdminChamberController::class, 'certify'])
        ->name('certify');
    Route::post('/{chamber}/uncertify', [\App\Http\Controllers\Admin\SuperAdminChamberController::class, 'uncertify'])
        ->name('uncertify');
    Route::delete('/{chamber}', [\App\Http\Controllers\Admin\SuperAdminChamberController::class, 'destroy'])
        ->name('destroy');
    Route::post('/{chamber}/approve', [\App\Http\Controllers\Admin\SuperAdminChamberController::class, 'approvePendingRequest'])
        ->name('approve');
    Route::post('/{chamber}/reject', [\App\Http\Controllers\Admin\SuperAdminChamberController::class, 'rejectPendingRequest'])
        ->name('reject');
});

// ===== SUPERADMIN MANAGER MANAGEMENT =====
Route::prefix('/admin/managers')->name('admin.managers.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\SuperAdminUserController::class, 'index'])
        ->name('index');
    Route::get('/{user}', [\App\Http\Controllers\Admin\SuperAdminUserController::class, 'show'])
        ->name('show');
    Route::get('/promote/form', [\App\Http\Controllers\Admin\SuperAdminUserController::class, 'showPromotePage'])
        ->name('promote.show');
    Route::post('/promote', [\App\Http\Controllers\Admin\SuperAdminUserController::class, 'promote'])
        ->name('promote');
    Route::post('/{user}/demote', [\App\Http\Controllers\Admin\SuperAdminUserController::class, 'demote'])
        ->name('demote');
});

// ===== SUPERADMIN NOTIFICATIONS =====
Route::prefix('/admin/notifications')->name('admin.notifications.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\SuperAdminNotificationController::class, 'index'])
        ->name('index');
    Route::get('/create', [\App\Http\Controllers\Admin\SuperAdminNotificationController::class, 'create'])
        ->name('create');
    Route::post('/send', [\App\Http\Controllers\Admin\SuperAdminNotificationController::class, 'send'])
        ->name('send');
    Route::get('/history', [\App\Http\Controllers\Admin\SuperAdminNotificationController::class, 'history'])
        ->name('history');
});

// ===== SUPERADMIN API ENDPOINTS =====
Route::prefix('/api/admin')->name('api.admin.')->group(function () {
    Route::get('/chambers/stats', [\App\Http\Controllers\Admin\SuperAdminChamberController::class, 'getStats'])
        ->name('chambers.stats');
    Route::get('/chambers/search', [\App\Http\Controllers\Admin\SuperAdminChamberController::class, 'search'])
        ->name('chambers.search');
    Route::get('/managers/search', [\App\Http\Controllers\Admin\SuperAdminUserController::class, 'search'])
        ->name('managers.search');
    Route::get('/managers/promotable/{chamber}', [\App\Http\Controllers\Admin\SuperAdminUserController::class, 'getPromotable'])
        ->name('managers.promotable');
    Route::post('/notifications/recipients', [\App\Http\Controllers\Admin\SuperAdminNotificationController::class, 'getRecipients'])
        ->name('notifications.recipients');
    Route::post('/notifications/validate', [\App\Http\Controllers\Admin\SuperAdminNotificationController::class, 'validateRecipients'])
        ->name('notifications.validate');
});
```

**À faire:**
```bash
# Vérifier les routes
php artisan route:list | grep admin
```

---

## 🎨 PARTIE 3 - VUES (À créer dans `resources/views/admin/super-admin/`)

### Structure de dossiers à créer:
```
resources/views/admin/super-admin/
├── chambers/
│   ├── index.blade.php        (À créer - Liste chambres)
│   ├── show.blade.php         (À créer - Détails)
│   └── _certify-modal.blade.php (À créer - Modal)
├── managers/
│   ├── index.blade.php        (À créer - Liste managers)
│   ├── show.blade.php         (À créer - Détails)
│   ├── promote.blade.php      (À créer - Page promotion)
│   └── _promote-modal.blade.php (À créer - Modal)
├── notifications/
│   ├── index.blade.php        (À créer - Dashboard)
│   ├── create.blade.php       (À créer - Création)
│   └── history.blade.php      (À créer - Historique)
└── dashboard.blade.php        (Exists - À améliorer)
```

---

## 🧩 PARTIE 4 - COMPOSANTS (À créer dans `resources/views/components/admin/`)

### Composants réutilisables:
```
resources/views/components/admin/
├── kpi-card.blade.php          - Affiche KPI
├── status-badge.blade.php      - Badge de statut
├── modal.blade.php             - Modal générique
├── table-header.blade.php      - En-tête table
├── action-menu.blade.php       - Menu actions
└── empty-state.blade.php       - État vide
```

---

## 📋 CHECKLIST INTEGRATION

### Backend
- [ ] Services créés et testés
- [ ] Form Requests validées
- [ ] Mail Classes configurées
- [ ] Controllers implémentés
- [ ] Routes ajoutées à `routes/web.php`
- [ ] Vérifier: `php artisan route:list`

### Frontend (Phase 2)
- [ ] Dossiers de vues créés
- [ ] Composants Blade créés
- [ ] Vues pages implémentées
- [ ] JavaScript pour modals/filtres
- [ ] Tester chaque page

### Tests
- [ ] Certification workflow test
- [ ] Promotion workflow test
- [ ] Approbation demande test
- [ ] Envoi notifications test
- [ ] Permissions test (is_admin check)

---

## 🧪 TESTS MANUELS

### 1. Tester Certification Chambre
```
1. Aller à /admin/chambers
2. Cliquer sur une chambre
3. Cliquer "Certifier"
4. Remplir: Numéro d'état (ex: "DRC-2024-001")
5. Cliquer "Certifier"
6. Vérifier: Chamber.state_number, email reçu
```

### 2. Tester Promotion Manager
```
1. Aller à /admin/managers/promote/form
2. Chercher et sélectionner un user normal
3. Optionnel: Sélectionner une chambre
4. Cliquer "Promouvoir"
5. Vérifier: User.is_admin = 2, email reçu
```

### 3. Tester Approbation Demande
```
1. Aller à /admin/chambers?status=pending
2. Cliquer sur une chambre en attente
3. Cliquer "Approuver"
4. Sélectionner ou créer un gestionnaire
5. Cliquer "Approuver"
6. Vérifier: Chamber.verified=true, emails
```

---

## 🔧 TROUBLESHOOTING

### Erreur: "Migration table not found"
```
# Si base de données est vide:
php artisan migrate
php artisan db:seed --class=SuperAdminSeeder
```

### Erreur: "Namespace not found"
```
# Vérifier que les fichiers sont dans les bons dossiers:
app/Services/Admin/*.php
app/Http/Controllers/Admin/*.php
app/Http/Requests/Admin/*.php
app/Mail/*.php
```

### Erreur: "is_admin constant not found"
```
# Les constantes sont dans User model:
User::ROLE_USER = 0
User::ROLE_CHAMBER_MANAGER = 2
User::ROLE_SUPER_ADMIN = 1
```

### Emails ne sont pas reçus
```
# Vérifier .env:
MAIL_MAILER=log (en développement)
MAIL_FROM_ADDRESS=noreply@chamberconnect.cd

# Pour tester en local:
php artisan tinker
Mail::fake();
# Les emails seront "capturés" plutôt qu'envoyés
```

---

## 🚀 DÉPLOIEMENT

### Sur serveur production:
```bash
# 1. Git push
git add .
git commit -m "feat: Add SuperAdmin module"
git push

# 2. Sur le serveur
composer install
php artisan migrate
php artisan optimize
```

### Vérifier l'intégration:
```bash
php artisan route:list | grep admin
php artisan tinker
# Tester les services
```

---

## 📞 CONTACTS & SUPPORT

- **Architecture docs:** `SUPERADMIN_ARCHITECTURE.md`
- **Progress:** `SUPERADMIN_IMPLEMENTATION_PROGRESS.md`
- **Code:** `/app/Services/Admin/`, `/app/Http/Controllers/Admin/`


