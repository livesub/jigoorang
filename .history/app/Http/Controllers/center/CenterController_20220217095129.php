<?php
#############################################################################
#
#		파일이름		:		CenterController.php
#		파일설명		:		고객센터 control
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 12월 14일
#		최종수정일		:		2021년 12월 14일
#
###########################################################################-->

namespace App\Http\Controllers\center;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use Illuminate\Support\Facades\Auth;    //인증
use Illuminate\Support\Facades\DB;

class CenterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $CustomUtils = new CustomUtils;

        $order_infos = DB::table('shoporders')->where('user_id', Auth::user()->user_id)->orderby('id', 'desc')->get();

        return view('center.qnawrite',[
            'CustomUtils'   => $CustomUtils,
            'order_infos'   => $order_infos,
        ]);
    }

}
