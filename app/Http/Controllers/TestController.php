<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class TestController extends Controller
{
    public function testTranslations()
    {
        $currentLocale = App::getLocale();
        $translations = [
            'current_locale' => $currentLocale,
            'home' => __('messages.home'),
            'chambers' => __('messages.chambers'),
            'opportunities' => __('messages.opportunities'),
            'events' => __('messages.events'),
            'login' => __('auth.login'),
            'register' => __('auth.register'),
        ];
        
        return response()->json($translations);
    }
}