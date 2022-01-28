<?php
#############################################################################
#
#		파일이름		:		banners.php
#		파일설명		:		배너 관리 테이블 Model
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 11월 08일
#		최종수정일		:		2021년 11월 08일
#
###########################################################################-->

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class banners extends Model
{
    use HasFactory;

    protected $fillable = [
        'b_name',
        'b_display',
        'b_link',
        'b_target',
        'b_pc_img',
        'b_pc_ori_img',
        'b_mobile_img',
        'b_mobile_ori_img',
        'b_type',
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];
}
