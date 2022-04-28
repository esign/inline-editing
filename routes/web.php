<?php

Route::get('/inline-editing/start', [\Esign\InlineEditing\Http\Controllers\InlineEditingController::class, 'start'])->name('inline-editing.start');
Route::get('/inline-editing/stop', [\Esign\InlineEditing\Http\Controllers\InlineEditingController::class, 'stop'])->name('inline-editing.stop');


