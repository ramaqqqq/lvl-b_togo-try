<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nationality extends Model
{
    public function customers()
    {
        return $this->hasMany(Customer::class, 'nationality_id');
    }
}

