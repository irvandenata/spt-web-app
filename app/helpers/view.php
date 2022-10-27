<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Str;

class View
{
    public static function currency(int $value)
    {
        return number_format($value, 0, '.', ',') . ' đ';
    }

    public static function websiteName(){
        $data =  Storage::disk('local')->get('public/about-us/about-us.json');
        if($data){
            $data = json_decode($data);
            $webname = $data->company_name;
        }else{
            $webname = 'Website';
        }
        return "$webname";
    }

    public static function logo(){
        $data =  Storage::disk('local')->get('public/about-us/about-us.json');
        if($data){
            $data = json_decode($data);
            $logo = "/storage/$data->image";
        }else{
            $logo = asset('assets/img/no-image.png');
        }
        return $logo;
    }
}
