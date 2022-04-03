<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Facades\App\Modules\JiraIntegration\Facades\JIRA;

Route::prefix('jira-integration')->group(function () {

    Route::get('/test', function () {
        $testTask =  JIRA::createIssue(
            'STL',
            'WFM Tool Automatic task',
            'this is a testing from the WFM tool',
        );
        dd($testTask);
    });
});
