<?php
#############################################################################
#
#		파일이름		:		shopordertemps.php
#		파일설명		:		쇼핑몰 결제 검증을 위한 임시 테이블 Model
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 11월 01일
#		최종수정일		:		2021년 11월 01일
#
###########################################################################-->

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
        'de_send_cost',
        'od_send_cost',
        'od_send_cost2',
        'od_receipt_price',
        'od_receipt_point',
        'tot_item_point',
        'ad_zip1',
        'od_ip',
    ];

    protected $hidden = [

    ];

    protected $casts = [

    ];
}