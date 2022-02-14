<?php
#############################################################################
#
#		파일이름		:		shoporders.php
#		파일설명		:		쇼핑몰 주문서 관리 테이블 Model
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 11월 01일
#		최종수정일		:		2021년 11월 01일
#
###########################################################################-->

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
        'de_send_cost_free',
        'od_send_cost',
        'od_send_cost2',
        'od_receipt_price',
        'od_cancel_price',
        'od_receipt_point',
        'real_card_price',
        'od_return_point',
        'od_refund_price',
        'od_receipt_time',
        'od_shop_memo',
        'od_status',
        'od_settle_case',
        'od_pg',
        'od_tno',
        'imp_uid',
        'imp_apply_num',
        'imp_card_name',
        'imp_card_quota',
        'imp_card_number',
        'od_delivery_company',
        'od_invoice',
        'od_misu',
        'de_cost_minus',
        'od_mod_history',
        'od_ip',
        'tot_item_point',
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];
}
