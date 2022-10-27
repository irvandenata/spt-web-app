<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use Str;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('webname', function () {
            $data =  Storage::disk('local')->get('public/about-us/about-us.json');
            if($data){
                $data = json_decode($data);
                $webname = Str::upper($data->company_name);
            }else{
                $webname = 'Website';
            }
            return "$webname";
        });

        Blade::directive('logo', function () {
            $data =  Storage::disk('local')->get('public/about-us/about-us.json');
            if($data){
                $data = json_decode($data);
                $logo = "/storage/$data->image";
            }else{
                $logo = asset('assets/img/no-image.png');
            }
            return $logo;
        });


    }
}
