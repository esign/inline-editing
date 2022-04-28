<?php

Route::post('api/inline-editing/store', [\Esign\InlineEditing\Http\Controllers\InlineEditingController::class, 'updateTranslations'])->name('inline-editing.update');


