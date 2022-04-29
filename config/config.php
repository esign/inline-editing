<?php

return [
    'database'   => env('INLINE_EDIT_DB_TABLE', 'dictionary'),
    'web-middleware'   => env('INLINE_EDIT_ROUTE_MIDDLEWARE', ['web']),
    'api-middleware'   => env('INLINE_EDIT_ROUTE_MIDDLEWARE', ['api']),
];