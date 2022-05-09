<?php

namespace App\Modules\Distribution\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Modules\Core\Http\Controllers\CoreController;

class ZendeskTasksController extends CoreController
{
    public function newTaskCreated(Request $request)
    {
        //dd(json_encode($request->all()));
        Log::warning(json_encode($request->toArray()));
    }
}
