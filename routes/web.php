<?php

Route::get('/inline-editing/start', [\Esign\InlineEdit\Http\Controllers\InlineEditController::class, 'start'])->name('inline-editing.start');
Route::get('/inline-editing/stop', [\Esign\InlineEdit\Http\Controllers\InlineEditController::class, 'stop'])->name('inline-editing.stop');


