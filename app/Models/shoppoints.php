<?php
#############################################################################
#
#		파일이름		:		shoppoints.php
#		파일설명		:		포인트 관리 테이블 Model
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 10월 15일
#		최종수정일		:		2021년 10월 15일
#
###########################################################################-->

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shoppoints extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'po_content',
        'po_point',
        'po_use_point',
        'po_user_point',
        'po_type',
        'po_write_id',
        'item_code',
    ];

    protected $hidden = [

    ];

    protected $casts = [

    ];
}
