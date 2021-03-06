<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/distribution', function (Request $request) {
    return $request->user();
});

Route::prefix('distribution')->group(function () {
    Route::prefix('zendesk')->middleware('ensure_issue_validity')->group(function () {
        Route::controller(ZendeskTasksController::class)->group(function () {
            Route::post('/new-task', 'newTaskCreated');
        });
    });
});
