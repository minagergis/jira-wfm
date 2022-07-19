<?php

namespace App\Modules\Core\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\RedirectResponse;

class AbstractCoreController extends Controller
{
    protected function showErrorMessage($route, $message = 'Something Went Wrong'): RedirectResponse
    {
        return redirect()->route($route)->with([
            'alert-type' => 'error',
            'message'    => $message,
        ]);
    }
}
