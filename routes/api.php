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

Route::prefix('employee')->group(function () {
    Route::post('', ['uses' => 'App\Http\Controllers\EmployeesController@store', 'as' => 'employee.store']);
    Route::get('{employee}', ['uses' => 'App\Http\Controllers\EmployeesController@show', 'as' => 'employee.show']);
    Route::post('{employee}/delegation', ['uses' => 'App\Http\Controllers\EmployeeDelegationsController@store', 'as' => 'employee.delegations.store']);
});
