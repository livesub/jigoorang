<?php
#############################################################################
#
#		파일이름		:		InfoController.php
#		파일설명		:		footer 이용약관, 개인정보 control
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 12월 27일
#		최종수정일		:		2021년 12월 27일
#
###########################################################################-->

namespace App\Http\Controllers\info;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function terms_use()
    {
        return view('info.terms_use',[
        ]);
    }

    public function privacy()
    {
        return view('info.privacy',[
        ]);
    }

}
