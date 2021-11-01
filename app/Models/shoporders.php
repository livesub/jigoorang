<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shoporders extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'od_id',
        'user_id',
        'od_deposit_name',
        'ad_name',
        'ad_tel',
        'ad_hp',
        'ad_zip1',
        'ad_addr1',
        'ad_addr2',
        'ad_addr3',
        'ad_jibeon',
        'od_memo',
        'od_cart_count',
        'od_cart_price',
        'de_send_cost',
        'od_send_cost',
        'od_send_cost2',
        'od_receipt_price',
        'od_cancel_price',
        'od_receipt_point',
        'od_refund_price',
        'od_receipt_time',
        'od_shop_memo',
        'od_status',
        'od_settle_case',
        'od_pg',
        'od_tno',
        'imp_uid',
        'imp_apply_num',
        'od_delivery_company',
        'od_invoice',
        'od_ip',
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];
}
