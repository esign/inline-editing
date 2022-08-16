<?php

namespace Esign\InlineEdit\Services\Facades;

use Illuminate\Support\Facades\Facade;

class TranslationService extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Esign\InlineEdit\Services\TranslationService::class;
    }
}
