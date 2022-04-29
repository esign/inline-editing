<?php

if (! function_exists('esign_inline')) {
    function esign_inline(string $term, array $replaces = []): ?string
    {
        if (session()->get('is_editing')) {
            return \Esign\InlineEditing\InlineEditing::string($term, $replaces);
        }

        $result = \Esign\InlineEditing\Services\TranslationService::findForTerm($term);

        if (empty($result->value)) {
            return show_term_for_dev_env($term);
        }

        $string = $result->value;

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