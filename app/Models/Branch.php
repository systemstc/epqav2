<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        // 'id',
        'firm_id',
        'name',
        'gstin',
        'address',
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
