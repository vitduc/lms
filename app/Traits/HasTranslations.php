<?php

namespace App\Traits;

trait HasTranslations
{
    /**
     * Get translated value from JSON column
     *
     * @param string $column
     * @param string|null $locale
     * @param mixed $fallback
     * @return mixed
     */
    public function getTranslated(string $column, ?string $locale = null, $fallback = null)
    {
        $locale = $locale ?? app()->getLocale();
        $translations = $this->getAttribute($column . '_translations');
        
        if (is_string($translations)) {
            $translations = json_decode($translations, true);
        }
        
        if (is_array($translations) && isset($translations[$locale])) {
            return $translations[$locale];
        }
        
        // Fallback to English if current locale not found
        if ($locale !== 'en' && is_array($translations) && isset($translations['en'])) {
            return $translations['en'];
        }
        
        // Fallback to original column value if exists
        if ($fallback === null && $this->getAttribute($column)) {
            return $this->getAttribute($column);
        }
        
        return $fallback;
    }

    /**
     * Set translated value in JSON column
     *
     * @param string $column
     * @param string $locale
     * @param mixed $value
     * @return void
     */
    public function setTranslated(string $column, string $locale, $value): void
    {
        $translations = $this->getAttribute($column . '_translations');
        
        if (is_string($translations)) {
            $translations = json_decode($translations, true) ?? [];
        } else {
            $translations = $translations ?? [];
        }
        
        $translations[$locale] = $value;
        $this->setAttribute($column . '_translations', $translations);
    }
}

