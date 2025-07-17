<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tempbranch extends Model
{
    use HasFactory;

    protected $table = 'temp_branch';

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

    public function tempfirm()
    {
        return $this->belongsTo(Tempfirm::class);
    }
}
