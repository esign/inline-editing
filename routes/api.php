<?php

Route::post('api/inline-editing/store', [\Esign\InlineEdit\Http\Controllers\InlineEditController::class, 'updateTranslations'])->name('inline-editing.update');


