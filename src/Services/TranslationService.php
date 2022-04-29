<?php

namespace Esign\InlineEditing\Services;

use Illuminate\Support\Facades\DB;

class TranslationService
{
    private $dictionary;

    public function __construct()
    {
        $this->dictionary = DB::table(config('inline-edit.database'))->get();
    }

    public function findForTerm(string $term)
    {
        $result = $this->dictionary->first(function ($dictionary) use ($term) {
            if ($dictionary->term == $term) {
                return true;
            }

            return false;
        });

        if (empty($result)) {
            // Double check to prevent doubles
            $eloquentResult = DB::table(config('inline-edit.database'))->where('term', $term)->first();
            if (empty($eloquentResult)) {
                if (str_contains($term, '.seo')) {
                    return $this->createDictionaryForTerm($term, 'seo');
                }

                return $this->createDictionaryForTerm($term);
            }

            return null;
        }

        return $result;
    }

    public function addDictionary($term): void
    {
        $this->dictionary->push($term);
    }

    public function createDictionaryForTerm(string $term, string $type = 'text'): Dictionary
    {

        $term = DB::table(config('inline-edit.database'))
            ->insert(['type' => $type, 'term' => $term]);

        $this->addDictionary($term);

        return $term;
    }
}
