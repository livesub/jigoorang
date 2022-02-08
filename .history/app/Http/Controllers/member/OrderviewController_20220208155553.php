<?php
#############################################################################
#
#		파일이름		:		OrderviewController.php
#		파일설명		:		주문 배송 내역
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2022년 01월 24일
#		최종수정일		:		2022년 01월 24일
#
###########################################################################-->

namespace App\Http\Controllers\member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;    //모델 정의
use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use App\Helpers\Custom\PageSet; //페이지 함수
use Illuminate\Support\Str;     //각종 함수(str_random)
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;    //인증
use App\Models\shopcarts;    //장바구니 모델 정의

class OrderviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function orderview(Request $request){
        //r관리자 배송 상태에 따라 추가 변경 해 줘야 함@!!!!
        $CustomUtils = new CustomUtils;
        $Messages = $CustomUtils->language_pack(session()->get('multi_lang'));

        $page       = $request->input('page');
        $pageScale  = 1;  //한페이지당 라인수
        $blockScale = 1; //출력할 블럭의 갯수(1,2,3,4... 갯수)

        if($page != "")
        {
            $start_num = $pageScale * ($page - 1);
        }else{
            $page = 1;
            $start_num = 0;
        }

        $orders = DB::table('shoporders')->where('user_id',Auth::user()->user_id);

        $total_record   = 0;
        $total_record   = $orders->count(); //총 게시물 수
        $total_page     = ceil($total_record / $pageScale);
        $total_page     = $total_page == 0 ? 1 : $total_page;

        $order_rows = $orders->orderby('id', 'desc')->offset($start_num)->limit($pageScale)->get();

        $tailarr = array();
        //$tailarr['AA'] = 'AA';    //고정된 전달 파라메터가 있을때 사용
        //$tailarr['bb'] = 'bb';

        $PageSet        = new PageSet;
        $showPage       = $PageSet->pageSet($total_page, $page, $pageScale, $blockScale, $total_record, $tailarr,"");
        $prevPage       = $PageSet->getPrevPage("이전");
        $nextPage       = $PageSet->getNextPage("다음");
        $pre10Page      = $PageSet->pre10("이전10");
        $next10Page     = $PageSet->next10("다음10");
        $preFirstPage   = $PageSet->preFirst("처음");
        $nextLastPage   = $PageSet->nextLast("마지막");
        $listPage       = $PageSet->getPageList();
        $pnPage         = $prevPage.$listPage.$nextPage;

        return view('member.orderview',[
            'orders'        => $order_rows,
            'CustomUtils'   => $CustomUtils,
            'pnPage'        => $pnPage,
        ]);
    }


}
