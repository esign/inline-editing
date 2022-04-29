<?php

namespace Esign\InlineEdit\Http\Controllers;

use Illuminate\Http\Request;

class InlineEditController extends Controller
{
    public function start()
    {
        session(['is_editing' => true]);

        return redirect('/');
    }

    public function stop()
    {
        session(['is_editing' => false]);

        return redirect('/');
    }

    public function updateTranslations(Request $request)
    {
        $success = \Esign\InlineEdit\InlineEdit::updateBatch($request->all());

        if ($success) {
            return response()->json(['success' => 'term updated']);
        } else {
            return response()->json(['error' => 'failed to update term']);
        }
    }
}