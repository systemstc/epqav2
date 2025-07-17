<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tempfirm extends Model
{
    use HasFactory;

    protected $table = 'temp_firms';

    protected $fillable = [
        'user_id',
        'subadmin_selected',
        'firm_name',
        'dob',
        'address',
        'address_2',
        'city',
        'district',
        'state',
        'pincode',
        'nature_of_firm',
        'postal_address',
        'telephone',
        'fax',
        'website',
        'email',
        'manufacturing_address',
        'manufacturing_telephone',
        'manufacturing_fax',
        'is_merchant_exporter',
        'category_of_export',
        'year_of_establishment',
        'ie_code',
        'iec_path',
        'pan_number',
        'ie_code_date',
        'gstin_number',
        'commodities',
        'payment_details',
        'status',
        'created_at',
        'updated_at',
	];

    public function tempbranches()
    {
        return $this->hasMany(Tempbranch::class, 'firm_id', 'id');
    }

    // Define the relationship with directors
    public function tempdirectors()
    {
        return $this->hasMany(Tempdirector::class, 'firm_id', 'id');
    }
}
