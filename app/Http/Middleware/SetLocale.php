<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get locale from URL segment (first segment)
        $locale = $request->segment(1);
        
        // Validate locale (only allow 'en' or 'vi')
        if (!in_array($locale, ['en', 'vi'])) {
            // If no valid locale in URL, check session or default
            $locale = Session::get('locale', config('app.locale', 'en'));
        } else {
            // Store locale in session when found in URL
            Session::put('locale', $locale);
        }
        
        // Validate locale again
        if (!in_array($locale, ['en', 'vi'])) {
            $locale = 'en';
        }
        
        // Set the application locale
        App::setLocale($locale);
        
        return $next($request);
    }
}
