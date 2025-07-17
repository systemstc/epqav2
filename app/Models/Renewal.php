<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Renewal extends Model
{
    use HasFactory;

    protected $fillable = [
	    'user_id',
        'firm_id',
        'applied_date',
        'issue_date',
        'expired_date',
        'status' ,
    ];


            // Define the inverse relationship with firm
    public function firm()
    {
        return $this->belongsTo(Firm::class);
    }
}
