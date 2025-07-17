<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Firm extends Model
{
    use HasFactory;

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

        // Define the relationship with branches
    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

    // Define the relationship with directors
    public function directors()
    {
        return $this->hasMany(Director::class);
    }    

    public function querys()
    {
        return $this->hasMany(Query::class);
    }    
    public function renewals()
    {
        return $this->hasMany(Renewal::class);
    }    
    public function notes()
    {
        return $this->hasOne(Notes::class);
    }

    public function previousApplications()
    {
        return $this->hasMany(Firm::class, 'user_id', 'user_id')
                    ->where('status', '0')
                    ->orderBy('created_at', 'desc');
    }
}
