<?php

return [
    'database'   => env('INLINE_EDIT_DB_TABLE', 'dictionary'),
    'web-middleware'   => ['web'],
    'api-middleware'   => ['api'],
];