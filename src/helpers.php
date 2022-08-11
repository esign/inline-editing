<?php

if (! function_exists('esign_inline')) {
    function esign_inline(string $term, array $replaces = []): ?string
    {
        if (session()->get('is_editing')) {
            return \Esign\InlineEdit\InlineEdit::string($term, $replaces);
        }
        
        $service = new \Esign\InlineEdit\Services\TranslationService();
        
        $result = $service->findForTerm($term);

        if (config('inline-edit.is_multilang')) {
            $lang = app()->getLocale();

            if (empty($result->{"value_$lang"})) {
                return show_term_for_dev_env($term);
            }
    
            $string = $result->{"value_$lang"};
        } else {
            if (empty($result->value)) {
                return show_term_for_dev_env($term);
            }
    
            $string = $result->value;
        }


        foreach ($replaces as $search => $replace) {
            $string = str_replace($search, $replace, $string);
        }

        return $string;
    }
}

if (! function_exists('show_term_for_dev_env')) {
    function show_term_for_dev_env($term): ?string
    {
        if (App::environment('production')) {
            return null;
        }

        return $term;
    }
}