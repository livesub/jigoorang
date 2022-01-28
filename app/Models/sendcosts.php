<?php
#############################################################################
#
#		파일이름		:		sendcost.php
#		파일설명		:		추가 배송비 관리 테이블 Model
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 10월 18일
#		최종수정일		:		2021년 10월 18일
#
###########################################################################-->

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sendcosts extends Model
{
    use HasFactory;

    protected $fillable = [
        'sc_name',
        'sc_zip1',
        'sc_zip2',
        'sc_price',
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];
}
