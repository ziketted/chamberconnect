<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ExchangeRateService
{
    /**
     * Mapping des pays vers leurs codes de devise
     */
    private const COUNTRY_CURRENCIES = [
        'Suisse' => 'CHF',
        'France' => 'EUR',
        'Belgique' => 'EUR',
        'États-Unis' => 'USD',
        'USA' => 'USD',
        'Canada' => 'CAD',
        'Royaume-Uni' => 'GBP',
        'Angleterre' => 'GBP',
        'Japon' => 'JPY',
        'Chine' => 'CNY',
        'Afrique du Sud' => 'ZAR',
        'Maroc' => 'MAD',
        'Algérie' => 'DZD',
        'Tunisie' => 'TND',
        'Sénégal' => 'XOF',
        'Côte d\'Ivoire' => 'XOF',
        'Kenya' => 'KES',
        'Nigeria' => 'NGN',
        'Égypte' => 'EGP',
        'Inde' => 'INR',
        'Brésil' => 'BRL',
        'Australie' => 'AUD',
    ];

    /**
     * Symboles des devises
     */
    private const CURRENCY_SYMBOLS = [
        'CHF' => 'CHF',
        'EUR' => '€',
        'USD' => '$',
        'CAD' => 'CAD',
        'GBP' => '£',
        'JPY' => '¥',
        'CNY' => '¥',
        'ZAR' => 'R',
        'MAD' => 'DH',
        'DZD' => 'DA',
        'TND' => 'DT',
        'XOF' => 'CFA',
        'KES' => 'KSh',
        'NGN' => '₦',
        'EGP' => 'E£',
        'INR' => '₹',
        'BRL' => 'R$',
        'AUD' => 'AUD',
    ];

    /**
     * Obtenir le code de devise pour un pays
     */
    public function getCurrencyCodeByCountry(string $country): ?string
    {
        return self::COUNTRY_CURRENCIES[$country] ?? null;
    }

    /**
     * Obtenir le taux de change d'une devise vers CDF
     * Utilise le cache pour éviter trop d'appels API (cache de 6 heures)
     */
    public function getExchangeRate(string $currencyCode): ?array
    {
        if ($currencyCode === 'CDF') {
            return [
                'rate' => 1,
                'symbol' => 'FC',
                'formatted' => '1 FC = 1 FC'
            ];
        }

        $cacheKey = "exchange_rate_{$currencyCode}_CDF";

        return Cache::remember($cacheKey, 21600, function () use ($currencyCode) {
            try {
                // Utiliser l'API gratuite exchangerate-api.com
                // Alternative : fixer.io, currencyapi.com
                $response = Http::timeout(5)->get("https://api.exchangerate-api.com/v4/latest/{$currencyCode}");

                if ($response->successful()) {
                    $data = $response->json();
                    $rateToCDF = $data['rates']['CDF'] ?? null;

                    if ($rateToCDF) {
                        return [
                            'rate' => round($rateToCDF, 2),
                            'symbol' => self::CURRENCY_SYMBOLS[$currencyCode] ?? $currencyCode,
                            'formatted' => $this->formatRate($currencyCode, $rateToCDF)
                        ];
                    }
                }
            } catch (\Exception $e) {
                Log::error('Exchange rate API error: ' . $e->getMessage());
            }

            return null;
        });
    }

    /**
     * Obtenir le taux de change pour un pays
     */
    public function getExchangeRateByCountry(string $country): ?array
    {
        $currencyCode = $this->getCurrencyCodeByCountry($country);

        if (!$currencyCode) {
            return null;
        }

        return $this->getExchangeRate($currencyCode);
    }

    /**
     * Formater le taux de change
     */
    private function formatRate(string $currencyCode, float $rate): string
    {
        $symbol = self::CURRENCY_SYMBOLS[$currencyCode] ?? $currencyCode;
        $formattedRate = number_format($rate, 2, ',', ' ');

        return "1 {$symbol} = {$formattedRate} FC";
    }

    /**
     * Nettoyer le cache des taux de change
     */
    public function clearCache(string $currencyCode = null): void
    {
        if ($currencyCode) {
            Cache::forget("exchange_rate_{$currencyCode}_CDF");
        } else {
            // Nettoyer tous les taux de change en cache
            foreach (self::COUNTRY_CURRENCIES as $currency) {
                Cache::forget("exchange_rate_{$currency}_CDF");
            }
        }
    }
}
