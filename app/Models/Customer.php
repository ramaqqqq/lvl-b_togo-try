<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

    protected $table = 'customers'; // Nama tabel yang sesuai dalam database Anda.
    protected $primaryKey = 'cst_id'; // Kolom primary key yang sesuai.
    public $incrementing = true;

    public function nationality()
    {
        return $this->belongsTo(Nationality::class, 'nationality_id');
    }

    public function familyLists()
    {
        return $this->hasMany(FamilyList::class, 'cst_id');
    }

}
