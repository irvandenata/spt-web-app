<?php

use App\Models\Log;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
    return view('front.landing');
});
Route::middleware('auth')->prefix('admin/')->group(function () {
    Route::get('dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('home');

    //Module Slider Begin
    Route::resource('sliders', App\Http\Controllers\Admin\SliderController::class);
    Route::put('sliders/{id}/change-show', [App\Http\Controllers\Admin\SliderController::class, 'changeShow'])->name('sliders.changeShow');
    //Module Slider End

    //Module Service Begin
    Route::resource('services', App\Http\Controllers\Admin\ServiceController::class);
    Route::put('services/{id}/change-show', [App\Http\Controllers\Admin\ServiceController::class, 'changeShow'])->name('services.changeShow');
    //Module Service End

    //Module Project Begin
    Route::resource('projects', App\Http\Controllers\Admin\ProjectController::class);
    Route::put('projects/{id}/change-show', [App\Http\Controllers\Admin\ProjectController::class, 'changeShow'])->name('projects.changeShow');
    //Module Project End

    //Module Partner Begin
    Route::resource('partners', App\Http\Controllers\Admin\PartnerController::class);
    Route::put('partners/{id}/change-show', [App\Http\Controllers\Admin\PartnerController::class, 'changeShow'])->name('partners.changeShow');
    //Module Partner End

    //Module About Us Begin
    Route::resource('about-us', App\Http\Controllers\Admin\AboutUsController::class);
    //Module About Us End

    //Module Social Media Begin
    Route::resource('social-medias', App\Http\Controllers\Admin\SocialMediaController::class);
    Route::put('social-medias/{id}/change-show', [App\Http\Controllers\Admin\SocialMediaController::class, 'changeShow'])->name('social-medias.changeShow');
    //Module Social Media End


});
Route::get('/test',function(Request $request){
     $ip = $request->ip();
     $nowDate = date('Y-m-d');
     $logIp = Log::where('log_key','ip')->where('log_value',$ip)->whereDate('created_at', Carbon::today())->first();
     if(!$logIp){
            $logIp = new Log();
            $logIp->log_key = 'ip';
            $logIp->log_value = $ip;
            $logIp->log_group = 'visitor';
            $logIp->save();
     }
    return $ip;
});

Auth::routes(['register' => false]);
