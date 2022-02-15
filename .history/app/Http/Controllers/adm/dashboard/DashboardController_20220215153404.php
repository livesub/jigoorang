<?php
#############################################################################
#
#		파일이름		:		DashboardController.php
#		파일설명		:		관리자 로그인후 대시 보드 연결
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2022년 02월 15일
#		최종수정일		:		2022년 02월 15일
#
###########################################################################-->

namespace App\Http\Controllers\adm\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use App\Helpers\Custom\PageSet; //페이지 함수
use Illuminate\Support\Facades\Auth;    //인증
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $CustomUtils = new CustomUtils;

        return view('adm.shop.order.orderlist',[
        ]);

    }
}
