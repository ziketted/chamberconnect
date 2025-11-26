# SuperAdmin Module - Commandes Utiles

## 🔧 Développement

### Vérifier les routes

```bash
php artisan route:list | grep admin
# Affiche toutes les routes admin
```

### Tester les services

```bash
php artisan tinker

# Créer un test de certification
$chamber = \App\Models\Chamber::first();
$service = new \App\Services\Admin\ChamberManagementService();
$service->certifyChamber($chamber, [
    'state_number' => 'DRC-2024-001',
    'certification_date' => now()->toDateString(),
    'certification_notes' => 'Test'
]);

# Vérifier
$chamber->refresh();
echo $chamber->state_number; // Affiche: DRC-2024-001
```

### Tester les emails (en développement)

```bash
# Dans .env, ajouter:
MAIL_MAILER=log
# Les emails seront loggés au lieu d'être envoyés

# Ou utiliser:
php artisan tinker
Mail::fake(); // Capture les emails
```

### Créer un super admin pour test

```bash
php artisan tinker

$user = \App\Models\User::create([
    'name' => 'Super Admin Test',
    'email' => 'admin@test.com',
    'password' => bcrypt('password123'),
    'is_admin' => 1,  // ROLE_SUPER_ADMIN
    'email_verified_at' => now(),
]);
```

### Créer un gestionnaire pour test

```bash
php artisan tinker

$user = \App\Models\User::create([
    'name' => 'Manager Test',
    'email' => 'manager@test.com',
    'password' => bcrypt('password123'),
    'is_admin' => 2,  // ROLE_CHAMBER_MANAGER
    'email_verified_at' => now(),
]);

# Assigner à une chambre
$chamber = \App\Models\Chamber::first();
$chamber->members()->attach($user->id, [
    'role' => 'manager',
    'status' => 'approved'
]);
```

---

## 📋 Debugging

### Vérifier les rôles d'un utilisateur

```bash
php artisan tinker

$user = \App\Models\User::find(1);
echo $user->is_admin; // 0, 1, ou 2
echo $user->isSuperAdmin(); // true/false
echo $user->isChamberManager(); // true/false
echo $user->isRegularUser(); // true/false
```

### Vérifier les chambres

```bash
php artisan tinker

# Chambres en attente de certification
\App\Models\Chamber::where('verified', false)->count();

# Chambres certifiées
\App\Models\Chamber::whereNotNull('state_number')->count();

# Détails d'une chambre
$chamber = \App\Models\Chamber::find(1);
$chamber->load('members.pivot');
```

### Vérifier les gestionnaires

```bash
php artisan tinker

# Tous les gestionnaires
\App\Models\User::where('is_admin', 2)->count();

# Gestionnaires avec chambres
\App\Models\User::where('is_admin', 2)
    ->with('chambers')
    ->get();
```

### Logs d'erreurs

```bash
# Voir les logs en temps réel
tail -f storage/logs/laravel.log

# Sur Windows (PowerShell)
Get-Content storage/logs/laravel.log -Wait
```

---

## 🧪 Tests

### Tester l'authentification

```bash
# Vérifier qu'un utilisateur n'a pas accès à /admin/*
# En tant qu'utilisateur normal (is_admin=0)
# Devrait rediriger vers /dashboard

# En tant que gestionnaire (is_admin=2)
# Devrait aussi rediriger

# En tant que super admin (is_admin=1)
# Devrait afficher la page
```

### Tester la certification workflow

```bash
1. Créer une chambre non-vérifiée
2. Aller à /admin/chambers (si vues existent)
3. Chercher la chambre
4. Cliquer "Certifier"
5. Entrer numéro d'état unique
6. Vérifier:
   - Chamber.state_number = nouvelle valeur
   - Chamber.verified = true
   - Email envoyé au gestionnaire
```

### Tester la promotion workflow

```bash
1. Avoir un utilisateur normal (is_admin=0)
2. Aller à /admin/managers/promote/form
3. Chercher l'utilisateur
4. Sélectionner optionnellement une chambre
5. Cliquer "Promouvoir"
6. Vérifier:
   - User.is_admin = 2
   - User attaché à la chambre si sélectionnée
   - Email reçu par l'utilisateur
```

---

## 🚀 Déploiement

### Avant de déployer

```bash
# 1. Vérifier tous les tests passent
php artisan test

# 2. Vérifier les migrations
php artisan migrate:status

# 3. Vérifier les routes
php artisan route:list | grep admin

# 4. Vérifier la syntaxe
php artisan tinker
# exit
```

### Commandes de production

```bash
# Sur le serveur
composer install --no-dev
php artisan migrate
php artisan optimize
php artisan config:cache
php artisan route:cache
```

---

## 📊 Database Queries Utiles

### Statistiques

```sql
-- Total chambres par statut
SELECT
    COUNT(*) as total,
    SUM(CASE WHEN verified=1 THEN 1 ELSE 0 END) as verified,
    SUM(CASE WHEN state_number IS NOT NULL THEN 1 ELSE 0 END) as certified
FROM chambers;

-- Gestionnaires et leurs chambres
SELECT
    u.id, u.name, u.email,
    COUNT(cu.chamber_id) as chambers_managed
FROM users u
LEFT JOIN chamber_user cu ON u.id = cu.user_id AND cu.role = 'manager'
WHERE u.is_admin = 2
GROUP BY u.id;

-- Demandes en attente
SELECT * FROM chambers WHERE verified = 0 ORDER BY created_at DESC;

-- Utilisateurs non-promotables (non-vérifiés)
SELECT * FROM users
WHERE is_admin = 0 AND email_verified_at IS NULL;
```

---

## 🔍 Checklist Avant Live

### Backend

-   [ ] Toutes les routes fonctionnent
-   [ ] Services testés
-   [ ] Emails configurés
-   [ ] Base de données migrée
-   [ ] Permissions vérifiées

### Frontend (Phase 2)

-   [ ] Vues créées
-   [ ] Composants fonctionnels
-   [ ] Modals testés
-   [ ] Responsive design ok
-   [ ] Formulaires validés

### Sécurité

-   [ ] Middleware 'admin' en place
-   [ ] Validations backend
-   [ ] Pas de SQL injection
-   [ ] CSRF protection activée

### Performance

-   [ ] Requêtes optimisées (N+1 queries)
-   [ ] Indices DB créés
-   [ ] Cache activé
-   [ ] Pagination implémentée

---

## 💡 Tips & Tricks

### Copier les fichiers rapidement

```bash
# Tous les fichiers backend sont dans:
# app/Services/Admin/
# app/Http/Controllers/Admin/
# app/Http/Requests/Admin/
# app/Mail/
# resources/views/emails/

# Vérifier que tous les fichiers sont présents:
ls -la app/Services/Admin/
ls -la app/Http/Controllers/Admin/
```

### Déboguer les services

```bash
# Dans un service, ajouter des logs:
\Log::info('Debug message', ['data' => $variable]);

# Voir dans storage/logs/laravel.log
```

### Tester les Form Requests

```bash
php artisan tinker

# Créer une request et valider
$request = new \App\Http\Requests\Admin\CertifyChamberRequest();
$request->setUserResolver(fn () => auth()->user());
$validated = $request->validate($request->rules());
```

---

## 🎯 Points à Retenir

-   SuperAdmin = is_admin = 1
-   Tous les endpoints /admin/\* requièrent le middleware 'admin'
-   Les services gèrent la logique, les controllers les routes
-   Les emails sont loggés en développement (MAIL_MAILER=log)
-   Les routes ne sont PAS encore à web.php → À ajouter!
