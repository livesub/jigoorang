<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shopordertemps extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'od_id',
        'user_id',
        'od_cart_price',
        'od_send_cost',
        'od_send_cost2',
        'od_receipt_price',
        'od_receipt_point',
        'ad_zip1',
        'od_ip',
    ];

    protected $hidden = [

    ];

    protected $casts = [

    ];
}