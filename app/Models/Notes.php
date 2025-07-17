<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notes extends Model
{
    use HasFactory;

    protected $fillable = [
        'firm_id',
        'note',
        'status',
    ];

    public function firm()
    {
        return $this->belongsTo(Firm::class);
    }
}
