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

        $orders_cnt1 = DB::table('shoporders')->where('od_status', '입금')->count();    //결제 완료건
        $orders_cnt2 = DB::table('shoporders')->where('od_status', '준비')->count();    //준비 건
        $orders_cnt3 = DB::table('shoporders')->where('od_status', '배송')->count();    //배송 건
        $orders_cnt4 = DB::table('shoporders')->where('od_status', '완료')->count();    //완료 건
        //$orders_cnt5 = DB::table('shoporders')->where('exchange_item_chk', 'Y')->count();    //교환 건

        $orders_cnt5 = DB::table('shoporders as a')
        ->select('a.*', 'b.return_process')
        ->leftjoin('shopcarts as b', function($join) {
                $join->on('a.order_id', '=', 'b.od_id');
            })
        ->where('a.exchange_item_chk', 'Y')
        ->where('b.return_process','N')
        ->groupBy('a.order_id')->count();

        $orders_cnt6 = DB::table('shoporders')->where('od_status', '상품취소')->count();    //취소 건

        $qna_cnt = DB::table('qnas')->whereNull('qna_answer')->count();    //1:1문의

        $review_cnt = DB::table('review_saves')->where([['temporary_yn', 'n'], ['review_blind', 'N']])->count();    //review

        $now_date = date("Y-m-d");
        $review_now_cnt = DB::table('review_saves')->where([['temporary_yn', 'n'], ['review_blind', 'N']])->whereBetween('updated_at', [$now_date.' 00:00:00', $now_date.' 23:59:59'])->count();    //review

        $members_cnt = DB::table('users')->where('user_level','>','2')->count(); //총회원수
        $new_members_cnt = DB::table('users')->where('user_level','>','2')->whereBetween('created_at', [$now_date.' 00:00:00', $now_date.' 23:59:59'])->count(); //신규회원

        return view('adm.dashboard.dashboard',[
            'orders_cnt1'   => $orders_cnt1,
            'orders_cnt2'   => $orders_cnt2,
            'orders_cnt3'   => $orders_cnt3,
            'orders_cnt4'   => $orders_cnt4,
            'orders_cnt5'   => $orders_cnt5,
            'orders_cnt6'   => $orders_cnt6,
            'qna_cnt'       => $qna_cnt,
            'review_cnt'    => $review_cnt,
            'now_date'      => $now_date,
            'review_now_cnt' => $review_now_cnt,
            'members_cnt'   => $members_cnt,
        ]);

    }
}
