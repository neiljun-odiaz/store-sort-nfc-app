<?php

namespace App;

use App\Customer;
use Illuminate\Database\Eloquent\Model;

class POS extends Model
{
    protected $table = 'pos';

    public $timestamps = false;

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}