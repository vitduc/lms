<?php

if (!function_exists('localized_url')) {
    /**
     * Generate a localized URL with locale prefix
     *
     * @param string $path
     * @param string|null $locale
     * @return string
     */
    function localized_url($path = '', $locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        $path = ltrim($path, '/');
        
        // Remove existing locale prefix if present
        $path = preg_replace('#^(en|vi)/#', '', $path);
        
        return '/' . $locale . ($path ? '/' . $path : '');
    }
}

if (!function_exists('localized_route')) {
    /**
     * Generate a route URL with automatic locale parameter
     *
     * @param string $name
     * @param mixed $parameters
     * @param bool $absolute
     * @return string
     */
    function localized_route($name, $parameters = [], $absolute = true)
    {
        // Convert single parameter to array
        if (!is_array($parameters)) {
            $singleParam = $parameters;
            $parameters = [];
            
            // Try to get route to determine parameter name
            try {
                $route = \Illuminate\Support\Facades\Route::getRoutes()->getByName($name);
                if ($route) {
                    $paramNames = $route->parameterNames();
                    // Skip locale parameter
                    $paramNames = array_filter($paramNames, fn($name) => $name !== 'locale');
                    if (!empty($paramNames)) {
                        $firstParam = reset($paramNames);
                        $parameters[$firstParam] = $singleParam;
                    } else {
                        $parameters = [$singleParam];
                    }
                } else {
                    $parameters = [$singleParam];
                }
            } catch (\Exception $e) {
                $parameters = [$singleParam];
            }
        }
        
        // Check if route needs locale parameter
        try {
            $route = \Illuminate\Support\Facades\Route::getRoutes()->getByName($name);
            if ($route && in_array('locale', $route->parameterNames()) && !isset($parameters['locale'])) {
                $parameters['locale'] = app()->getLocale();
            }
        } catch (\Exception $e) {
            // Route not found, continue without locale
        }
        
        return route($name, $parameters, $absolute);
    }
}

