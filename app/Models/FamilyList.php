<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyList extends Model
{
    protected $table = 'family_lists';
    protected $primaryKey = 'fl_id';
    
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'cst_id');
    }
}
