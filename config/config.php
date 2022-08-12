<?php

return [
    'database'   => env('INLINE_EDIT_DB_TABLE', 'dictionary'),
    'is_multilang'   => env('INLINE_EDIT_MULTILANG', true),
    'web-middleware'   => ['web'],
    'api-middleware'   => [\App\Http\Middleware\EncryptCookies::class],
];