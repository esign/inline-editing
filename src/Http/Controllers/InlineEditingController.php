<?php

namespace Esign\InlineEditing\Http\Controllers;

use App\Libraries\InlineEditing;
use Illuminate\Http\Request;

class InlineEditingController extends Controller
{
    public function start()
    {
        session(['is_editing' => true]);
    }

    public function stop()
    {
        session(['is_editing' => false]);
    }

    public function updateTranslations(Request $request)
    {
        $success = InlineEditing::updateBatch($request->all());

        if ($success) {
            return $this->showSuccess('Page updated');
        } else {
            return $this->showError('Unknown error');
        }
    }
}