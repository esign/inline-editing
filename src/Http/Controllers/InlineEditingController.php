<?php

namespace Esign\InlineEditing\Http\Controllers;

class InlineEditingController extends Controller
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

    public function updateTranslations($request)
    {
        $success = \Esign\InlineEditing\InlineEditing::updateBatch($request->all());

        if ($success) {
            return $this->showSuccess('Page updated');
        } else {
            return $this->showError('Unknown error');
        }
    }
}