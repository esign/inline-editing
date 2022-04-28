<?php

namespace Esign\InlineEditing\Facades;

use Illuminate\Support\Facades\Facade;

class InlineEditing extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Esign\InlineEditing\InlineEditing::class;
    }
}
