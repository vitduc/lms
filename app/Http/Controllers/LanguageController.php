<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    /**
     * Switch language
     */
    public function switch(Request $request, string $locale)
    {
        // Validate locale
        if (!in_array($locale, ['en', 'vi'])) {
            $locale = 'en';
        }

        // Store locale in session
        Session::put('locale', $locale);

        // Get the current URL path
        $referer = $request->headers->get('referer');
        
        if ($referer) {
            $parsedUrl = parse_url($referer);
            $currentPath = isset($parsedUrl['path']) ? $parsedUrl['path'] : '/';
            
            // Remove existing locale prefix if present
            $currentPath = preg_replace('#^/(en|vi)(/|$)#', '/', $currentPath);
            $currentPath = ltrim($currentPath, '/');
            
            // Build new URL with locale prefix
            $newUrl = '/' . $locale . ($currentPath ? '/' . $currentPath : '');
            
            // Preserve query string if exists
            if (isset($parsedUrl['query'])) {
                $newUrl .= '?' . $parsedUrl['query'];
            }
        } else {
            // Fallback to home with locale
            $newUrl = '/' . $locale;
        }
        
        // Redirect to new URL with locale prefix
        return redirect($newUrl);
    }
}
