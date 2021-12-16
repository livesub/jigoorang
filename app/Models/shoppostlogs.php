<?php
#############################################################################
#
#		파일이름		:		shoppostlogs.php
#		파일설명		:		주문요청기록 로그 테이블 Model
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 10월 22일
#		최종수정일		:		2021년 10월 22일
#
###########################################################################-->

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shoppostlogs extends Model
{
    use HasFactory;

    protected $fillable = [
        'oid',
        'user_id',
        'post_data',
        'ol_code',
        'ol_msg',
        'ol_ip',
    ];

    protected $hidden = [

    ];

    protected $casts = [

    ];
}
