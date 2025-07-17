<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tempdirector extends Model
{
    use HasFactory;

    protected $table = 'temp_director';

    protected $fillable = [
        'firm_id',
        'director_name',
        'designation',
        'director_pan',
        'status',
        'created_at',
        'updated_at',
    ];

    public function tempfirm()
    {
        return $this->belongsTo(Tempfirm::class);
    }
}
