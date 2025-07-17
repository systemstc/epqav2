<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Query extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'firm_id',
        'query',
        'status',
    ];

            // Define the inverse relationship with firm
    public function firm()
    {
        return $this->belongsTo(Firm::class);
    }

}
