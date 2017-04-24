<?php

namespace App;

use App\Customer;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $table = 'card';

    public $timestamps = false;

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}