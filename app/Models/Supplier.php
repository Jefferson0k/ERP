<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model{
    use HasFactory;
    protected $fillable = [
        'registration_date',
        'sales_executive',
        'ruc',
        'business_name',
        'trade_name',
        'address',
        'economic_activity',
        'activity_start_date',
        'expected_rate',
        'commission',
        'contact_person',
        'position',
        'email',
        'website',
        'notes',
    ];
}
