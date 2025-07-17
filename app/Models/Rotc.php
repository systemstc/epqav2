<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rotc extends Model
{
    use HasFactory;

    protected $fillable = [
	    'user_id',
        'rotc',
        'officer_incharge',
        'phone',
        'state',
        'state_code',
        'city',
        'address',
        'lat',
        'lng',
        'status'
    ];
}
