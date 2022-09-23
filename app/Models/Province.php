<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function districts()
    {
        return $this->hasMany(District::class);
    }

    public function dailyCosts()
    {
        return $this->hasMany(DailyCost::class);

    }

    public function ticketCostsArrival()
    {
        return $this->hasMany(TicketCost::class, 'arrival_id');
    }

    public function ticketCostsDestination()
    {
        return $this->hasMany(TicketCost::class, 'destination_id');
    }

    public function rentalCosts()
    {
        return $this->hasMany(RentalCost::class);
    }

}
