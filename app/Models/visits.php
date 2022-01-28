<?php
#############################################################################
#
#		파일이름		:		visits.php
#		파일설명		:		방문자 통계 테이블 Model
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 09월 20일
#		최종수정일		:		2021년 09월 20일
#
###########################################################################-->

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class visits extends Model
{
    use HasFactory;

    protected $fillable = [
        'vi_id',
        'vi_ip',
        'vi_referer',
        'vi_agent',
        'vi_browser',
        'vi_os',
        'vi_device',
        'vi_city',
        'vi_country',
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];
}
