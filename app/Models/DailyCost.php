<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyCost extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function province (){
    return $this->belongsTo(Province::class);
    }
}
