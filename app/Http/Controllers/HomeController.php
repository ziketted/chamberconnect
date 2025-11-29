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
                // Essayer plusieurs APIs dans l'ordre de préférence
                
                // API 1: ExchangeRate-API (gratuite, fiable, mise à jour quotidienne)
                // ✅ Testé et vérifié: retourne 2,206.43 CDF (taux correct)
                try {
                    $response = Http::timeout(5)->get('https://open.er-api.com/v6/latest/USD');
                    
                    if ($response->successful()) {
                        $data = $response->json();
                        
                        if (isset($data['rates']['CDF'])) {
                            $rate = $data['rates']['CDF'];
                            
                            // Vérifier que le taux est dans une plage acceptable (2000-2500)
                            if ($rate >= 2000 && $rate <= 2500) {
                                Log::info('Exchange rate updated from ExchangeRate-API', [
                                    'rate' => $rate,
                                    'timestamp' => now()
                                ]);
                                return round($rate, 2);
                            } else {
                                Log::warning('Exchange rate out of range from ExchangeRate-API', [
                                    'rate' => $rate,
                                    'expected_range' => '2000-2500'
                                ]);
                            }
                        }
                    }
                } catch (\Exception $e) {
                    Log::warning('ExchangeRate-API failed', ['error' => $e->getMessage()]);
                }
                
                // API 2: CurrencyAPI (fallback)
                // ✅ Testé: retourne 2,280.75 CDF (légèrement différent mais acceptable)
                try {
                    $response = Http::timeout(5)->get('https://cdn.jsdelivr.net/npm/@fawazahmed0/currency-api@latest/v1/currencies/usd.json');
                    
                    if ($response->successful()) {
                        $data = $response->json();
                        
                        if (isset($data['usd']['cdf'])) {
                            $rate = $data['usd']['cdf'];
                            
                            if ($rate >= 2000 && $rate <= 2500) {
                                Log::info('Exchange rate updated from CurrencyAPI', [
                                    'rate' => $rate,
                                    'timestamp' => now()
                                ]);
                                return round($rate, 2);
                            }
                        }
                    }
                } catch (\Exception $e) {
                    Log::warning('CurrencyAPI failed', ['error' => $e->getMessage()]);
                }
                
                // Si toutes les APIs échouent, utiliser le taux par défaut
                Log::warning('All exchange rate APIs failed, using default rate', [
                    'default_rate' => 2206.43
                ]);
                return 2206.43; // Taux par défaut actuel (vérifié le 29/11/2025)
                
            } catch (\Exception $e) {
                Log::error('Exchange rate API error', [
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                return 2206.43; // Taux par défaut en cas d'erreur
            }
        });

        return view('home', compact('upcomingEvents', 'exchangeRate'));
    }
    
    /**
     * Forcer la mise à jour du taux de change
     */
    public function refreshExchangeRate()
    {
        Cache::forget('usd_cdf_rate');
        return redirect()->route('home')->with('success', 'Taux de change mis à jour');
    }
}

