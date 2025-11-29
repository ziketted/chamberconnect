<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class OpportunityController extends Controller
{
    public function index()
    {
        // Récupérer le taux de change USD/CDF (même logique que HomeController)
        $exchangeRate = Cache::remember('usd_cdf_rate', 21600, function () {
            try {
                $response = Http::timeout(5)->get('https://open.er-api.com/v6/latest/USD');
                
                if ($response->successful()) {
                    $data = $response->json();
                    
                    if (isset($data['rates']['CDF'])) {
                        $rate = $data['rates']['CDF'];
                        
                        if ($rate >= 2000 && $rate <= 2500) {
                            Log::info('Exchange rate updated for opportunities page', ['rate' => $rate]);
                            return round($rate, 2);
                        }
                    }
                }
                
                return 2206.43;
            } catch (\Exception $e) {
                Log::error('Exchange rate error on opportunities page', ['message' => $e->getMessage()]);
                return 2206.43;
            }
        });

        return view('opportunities.index', compact('exchangeRate'));
    }
}
