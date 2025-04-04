<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerVisit extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'visit_type',
        'location',
        'latitude',
        'longitude',
        'shop_name',
        'contact_person',
        'contact_number',
        'gst_number',
        'pincode',
        'name_board_image',
        'customer_id',
        'customer_category_id',
        'voice_record',
        'reason_for_visit',
        'remarks'
    ];
}
