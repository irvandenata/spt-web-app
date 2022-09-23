<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function province(){
    return $this->belongsTo(Province::class);
    }

    public function transportCosts(){
    return $this->hasMany(TransportCost::class);
    }

    public function lodgingCosts (){
    return $this->hasMany(LodgingCost::class);
    }
}
