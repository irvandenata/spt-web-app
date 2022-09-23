<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketCost extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function arrival(){
    return $this->belongsTo(Province::class, 'arrival_id');
    }

    public function destination(){
      return $this->belongsTo(Province::class,'destination_id');
    }
}
