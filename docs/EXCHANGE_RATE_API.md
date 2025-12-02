# Configuration de l'API de Taux de Change USD/CDF

## Vue d'ensemble

Le taux de change USD/CDF est affiché sur la page d'accueil de ChamberConnect. Actuellement, un taux fixe de **2,850 CDF** est utilisé. Ce document explique comment intégrer une vraie API pour obtenir des taux en temps réel.

## APIs Recommandées

### 1. ExchangeRate-API (Recommandé)
**URL**: https://www.exchangerate-api.com/

**Avantages**:
- 1,500 requêtes gratuites par mois
- Support du Franc Congolais (CDF)
- Mise à jour quotidienne
- Fiable et rapide

**Exemple d'utilisation**:
```php
use Illuminate\Support\Facades\Http;

$response = Http::get('https://v6.exchangerate-api.com/v6/YOUR_API_KEY/latest/USD');
$rate = $response->json()['conversion_rates']['CDF'];
```

### 2. Fixer.io
**URL**: https://fixer.io/

**Avantages**:
- Très précis
- Support de 170+ devises
- Plan gratuit disponible

**Inconvénient**:
- Nécessite un abonnement pour certaines devises africaines

### 3. Open Exchange Rates
**URL**: https://openexchangerates.org/

**Avantages**:
- 1,000 requêtes gratuites par mois
- Données historiques disponibles
- API bien documentée

## Implémentation dans HomeController

### Étape 1: Installer Guzzle (si nécessaire)
```bash
composer require guzzlehttp/guzzle
```

### Étape 2: Ajouter la clé API dans .env
```env
EXCHANGE_RATE_API_KEY=your_api_key_here
```

### Étape 3: Modifier HomeController.php

#### Option A: ExchangeRate-API
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index()
    {
        // Récupérer les 3 prochains événements à venir
        $upcomingEvents = Event::with(['chamber', 'creator'])
            ->whereHas('chamber')
            ->where('date', '>=', now()->toDateString())
            ->whereIn('status', ['upcoming', 'full'])
            ->orderBy('date', 'asc')
            ->take(3)
            ->get()
            ->map(function ($event) {
                $event->participants_count = $event->participants()->count();
                $event->available_spots = $event->availableSpots();
                return $event;
            });

        // Récupérer le taux de change USD/CDF (avec cache de 6 heures)
        $exchangeRate = Cache::remember('usd_cdf_rate', 21600, function () {
            try {
                $apiKey = config('services.exchange_rate.api_key');
                $response = Http::timeout(5)->get("https://v6.exchangerate-api.com/v6/{$apiKey}/latest/USD");
                
                if ($response->successful()) {
                    $data = $response->json();
                    return $data['conversion_rates']['CDF'] ?? 2850;
                }
                
                Log::warning('Exchange rate API call failed', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                
                return 2850; // Taux par défaut
            } catch (\Exception $e) {
                Log::error('Exchange rate API error', [
                    'message' => $e->getMessage()
                ]);
                return 2850; // Taux par défaut en cas d'erreur
            }
        });

        return view('home', compact('upcomingEvents', 'exchangeRate'));
    }
}
```

#### Option B: Fixer.io
```php
$exchangeRate = Cache::remember('usd_cdf_rate', 21600, function () {
    try {
        $apiKey = config('services.fixer.api_key');
        $response = Http::get("http://data.fixer.io/api/latest", [
            'access_key' => $apiKey,
            'base' => 'USD',
            'symbols' => 'CDF'
        ]);
        
        if ($response->successful()) {
            $data = $response->json();
            return $data['rates']['CDF'] ?? 2850;
        }
        
        return 2850;
    } catch (\Exception $e) {
        Log::error('Fixer.io API error', ['message' => $e->getMessage()]);
        return 2850;
    }
});
```

### Étape 4: Ajouter la configuration dans config/services.php
```php
return [
    // ... autres services
    
    'exchange_rate' => [
        'api_key' => env('EXCHANGE_RATE_API_KEY'),
    ],
    
    // OU pour Fixer.io
    'fixer' => [
        'api_key' => env('FIXER_API_KEY'),
    ],
];
```

## Gestion du Cache

### Durée du Cache
- **Actuel**: 1 heure (3600 secondes)
- **Recommandé**: 6 heures (21600 secondes) pour les taux journaliers
- **Pour production**: 12-24 heures si les taux ne changent pas souvent

### Commandes de Cache
```bash
# Vider le cache du taux de change
php artisan cache:forget usd_cdf_rate

# Vider tout le cache
php artisan cache:clear
```

### Forcer la mise à jour manuelle
Créer une commande Artisan:
```php
php artisan make:command UpdateExchangeRate
```

```php
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class UpdateExchangeRate extends Command
{
    protected $signature = 'exchange:update';
    protected $description = 'Update USD/CDF exchange rate';

    public function handle()
    {
        $this->info('Updating exchange rate...');
        
        Cache::forget('usd_cdf_rate');
        
        // Le prochain appel à la page d'accueil mettra à jour le cache
        
        $this->info('Exchange rate cache cleared. Will be updated on next request.');
        return 0;
    }
}
```

## Planification Automatique

Ajouter dans `app/Console/Kernel.php`:
```php
protected function schedule(Schedule $schedule)
{
    // Mettre à jour le taux de change tous les jours à 8h
    $schedule->command('exchange:update')->dailyAt('08:00');
}
```

## Affichage Amélioré

### Ajouter la date de mise à jour
Dans HomeController:
```php
$exchangeRateData = Cache::remember('usd_cdf_rate_data', 21600, function () {
    // ... code API ...
    return [
        'rate' => $rate,
        'updated_at' => now()->toIso8601String()
    ];
});

return view('home', [
    'upcomingEvents' => $upcomingEvents,
    'exchangeRate' => $exchangeRateData['rate'],
    'exchangeRateUpdated' => $exchangeRateData['updated_at']
]);
```

Dans home.blade.php:
```blade
<div class="text-white">
    <span class="text-sm opacity-80">Taux du jour:</span>
    <span class="ml-2 font-bold text-lg">1 USD = {{ number_format($exchangeRate, 0, ',', ' ') }} CDF</span>
    @if(isset($exchangeRateUpdated))
    <span class="block text-xs opacity-60 mt-1">
        Mis à jour: {{ \Carbon\Carbon::parse($exchangeRateUpdated)->diffForHumans() }}
    </span>
    @endif
</div>
```

## Tests

### Test unitaire
```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ExchangeRateTest extends TestCase
{
    public function test_exchange_rate_displays_on_homepage()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        $response->assertSee('Taux du jour');
        $response->assertSee('USD');
        $response->assertSee('CDF');
    }
    
    public function test_exchange_rate_uses_cache()
    {
        Cache::put('usd_cdf_rate', 2900, 3600);
        
        $response = $this->get('/');
        
        $response->assertSee('2 900');
    }
}
```

## Monitoring et Logs

### Surveiller les erreurs API
```php
// Dans HomeController
if (!$response->successful()) {
    Log::channel('slack')->warning('Exchange Rate API Failed', [
        'status' => $response->status(),
        'timestamp' => now()
    ]);
}
```

### Créer une alerte si le taux est anormal
```php
$rate = $data['conversion_rates']['CDF'];

// Vérifier si le taux est dans une plage acceptable
if ($rate < 2000 || $rate > 4000) {
    Log::critical('Abnormal exchange rate detected', [
        'rate' => $rate,
        'expected_range' => '2000-4000'
    ]);
    return 2850; // Utiliser le taux par défaut
}

return $rate;
```

## Sécurité

1. **Ne jamais exposer la clé API** dans le code source
2. **Utiliser HTTPS** pour toutes les requêtes API
3. **Limiter les tentatives** avec un timeout court (5 secondes)
4. **Valider les données** reçues de l'API
5. **Avoir un fallback** en cas d'échec

## Coûts

| Service | Plan Gratuit | Plan Payant |
|---------|--------------|-------------|
| ExchangeRate-API | 1,500 req/mois | $10/mois (100K req) |
| Fixer.io | 100 req/mois | $10/mois (1K req) |
| Open Exchange Rates | 1,000 req/mois | $12/mois (10K req) |

**Recommandation**: ExchangeRate-API avec cache de 6-12 heures = ~120 requêtes/mois (largement dans le plan gratuit)

## Support

Pour toute question ou problème:
- Documentation Laravel Cache: https://laravel.com/docs/cache
- Documentation HTTP Client: https://laravel.com/docs/http-client
- ExchangeRate-API Docs: https://www.exchangerate-api.com/docs






