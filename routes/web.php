<?php

use App\Http\Controllers\DailyCostController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\LodgingCostController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\RentalCostController;
use App\Http\Controllers\TicketCostController;
use App\Http\Controllers\TransportCostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect()->route('home');
});
Route::get('employees/get-users', [EmployeeController::class, 'getUsers'])->name('employees.get.users');
Route::middleware('auth')->group(function(){
    Route::prefix('region')->name('region.')->group(function () {
        Route::resource('provinces', ProvinceController::class);
        Route::resource('districts', DistrictController::class);
    });
    Route::prefix('costs')->name('costs.')->group(function () {
        Route::resource('dailies', DailyCostController::class);
        Route::resource('transports', TransportCostController::class);
        Route::resource('tickets', TicketCostController::class);
        Route::resource('lodgings', LodgingCostController::class);
        Route::resource('rentals', RentalCostController::class);
    });

    Route::resource('users', UserController::class);
    Route::resource('employees', EmployeeController::class);
    Route::resource('groups', GroupController::class);
    Route::resource('grades', GradeController::class);
    Route::resource('positions', PositionController::class);

    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

});

Auth::routes(['register' => false]);
