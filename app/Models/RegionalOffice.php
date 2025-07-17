<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegionalOffice extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'officer_incharge',
        'phone',
        'email',
        'lat',
        'lng',
        'state',
        'state_code',
        'city',
        'status',
        'created_at',
        'updated_at',
    ];
}
