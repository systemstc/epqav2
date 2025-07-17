<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Director extends Model
{
    use HasFactory;

    protected $fillable = [
        'firm_id',
        'director_name',
        'designation',
        'director_pan',
        'status',
        'created_at',
        'updated_at',
    ];

        // Define the inverse relationship with firm
    public function firm()
    {
        return $this->belongsTo(Firm::class);
    }
}
