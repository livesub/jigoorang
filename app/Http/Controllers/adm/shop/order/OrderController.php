<?php
#############################################################################
#
#		파일이름		:		OrderController.php
#		파일설명		:		관리자 쇼핑몰 주문관리 control
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 11월 04일
#		최종수정일		:		2021년 11월 04일
#
###########################################################################-->

namespace App\Http\Controllers\adm\shop\order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use App\Helpers\Custom\PageSet; //페이지 함수
use Illuminate\Support\Facades\Auth;    //인증
use Illuminate\Support\Facades\DB;
use Iamport;

class OrderController extends Controller
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

    public function index(Request $request)
    {
        $CustomUtils = new CustomUtils;
        $Messages = $CustomUtils->language_pack(session()->get('multi_lang'));

        $sel_field          = $request->input('sel_field');
        $search             = $request->input('search');
        $od_status          = $request->input('od_status');
        $od_settle_case     = $request->input('od_settle_case');
        $od_cancel_price    = $request->input('od_cancel_price');
        $od_refund_price    = $request->input('od_refund_price');
        $od_receipt_point   = $request->input('od_receipt_point');
        $fr_date            = $request->input('fr_date');
        $to_date            = $request->input('to_date');

        $orders = DB::table('shoporders');

        if ($search != "") {    //검색
            if ($sel_field != "") {
                $orders->where($sel_field, 'like', '%'.$search.'%');
            }
        }

        if ($od_status) {   //주문상태
            switch($od_status) {
                case '전체취소':
                    $orders->where('od_status', '취소');
                    break;
                case '부분취소':
                    $orders->whereRaw("od_status IN('주문', '입금', '준비', '배송', '완료') and od_cancel_price > 0");
                    break;
                default:
                    $orders->where('od_status', $od_status);
                    break;
            }
        }

        if ($od_settle_case) {  //결제수단
            $orders->where('od_settle_case', $od_settle_case);
        }

        if ($od_cancel_price) { //반품,품절
            $orders->where('od_cancel_price', '!=', '0');
        }

        if ($od_refund_price) { //환불
            $orders->where('od_refund_price', '!=', '0');
        }

        if ($od_receipt_point) {    //포인트주문
            $orders->where('od_receipt_point', '!=', '0');
        }

        if ($fr_date && $to_date) {
            $orders->whereBetween('od_receipt_time', [$fr_date.' 00:00:00', $to_date.' 23:59:59']);
        }

        $page       = $request->input('page');
        $pageScale  = 15;  //한페이지당 라인수
        $blockScale = 10; //출력할 블럭의 갯수(1,2,3,4... 갯수)

        if($page != "")
        {
            $start_num = $pageScale * ($page - 1);
        }else{
            $page = 1;
            $start_num = 0;
        }

        $total_record   = 0;
        $total_record   = $orders->count(); //총 게시물 수
        $total_page     = ceil($total_record / $pageScale);
        $total_page     = $total_page == 0 ? 1 : $total_page;

        $order_rows = $orders->orderby('id', 'desc')->offset($start_num)->limit($pageScale)->get();

        $tailarr = array();
        $tailarr['sel_field']           = $sel_field;
        $tailarr['search']              = $search;
        $tailarr['od_status']           = $od_status;
        $tailarr['od_settle_case']      = $od_settle_case;
        $tailarr['od_cancel_price']     = $od_cancel_price;
        $tailarr['od_refund_price']     = $od_refund_price;
        $tailarr['od_receipt_point']    = $od_receipt_point;
        $tailarr['fr_date']             = $od_receipt_point;
        $tailarr['to_date']             = $to_date;

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

        $page_move = "&page=$page&sel_field=$sel_field&search=$search&od_status=$od_status&od_settle_case=$od_settle_case&od_cancel_price=$od_cancel_price&od_refund_price=$od_refund_price&od_receipt_point=$od_receipt_point&fr_date=$fr_date&to_date=$to_date";

        return view('adm.shop.order.orderlist',[
            'orders'            => $order_rows,
            'CustomUtils'       => $CustomUtils,
            'sel_field'         => $sel_field,
            'search'            => $search,
            'od_status'         => $od_status,
            'od_settle_case'    => $od_settle_case,
            'od_cancel_price'   => $od_cancel_price,
            'od_refund_price'   => $od_refund_price,
            'od_receipt_point'  => $od_receipt_point,
            'fr_date'           => $fr_date,
            'to_date'           => $to_date,
            'page_move'         => $page_move,
            'pnPage'            => $pnPage,
        ]);

    }

    public function orderdetail(Request $request)
    {
        $CustomUtils = new CustomUtils;
        $Messages = $CustomUtils->language_pack(session()->get('multi_lang'));

        $order_id           = $request->input('order_id');
        $page               = $request->input('page');
        $sel_field          = $request->input('sel_field');
        $search             = $request->input('search');
        $od_status          = $request->input('od_status');
        $od_settle_case     = $request->input('od_settle_case');
        $od_cancel_price    = $request->input('od_cancel_price');
        $od_refund_price    = $request->input('od_refund_price');
        $od_receipt_point   = $request->input('od_receipt_point');
        $fr_date            = $request->input('fr_date');
        $to_date            = $request->input('to_date');

        $page_move = "&page=$page&sel_field=$sel_field&search=$search&od_status=$od_status&od_settle_case=$od_settle_case&od_cancel_price=$od_cancel_price&od_refund_price=$od_refund_price&od_receipt_point=$od_receipt_point&fr_date=$fr_date&to_date=$to_date";

        $order_info = DB::table('shoporders')->where('order_id', $order_id)->first();

        if(is_null($order_info)) {
            return redirect()->back()->with('alert_messages', '잘못된 경로 입니다.');
        }

        $carts = DB::table('shopcarts')->select('id', 'od_id', 'item_code', 'item_name')->where('od_id', $order_id)->groupBy('item_code')->orderBy('id')->get();

        if(count($carts) == 0){
            return redirect()->back()->with('alert_messages', '잘못된 경로 입니다.');
        }

        return view('adm.shop.order.orderdetail',[
            'CustomUtils'   => $CustomUtils,
            'order_info'    => $order_info,
            'carts'         => $carts,
            'page_move'     => $page_move,
        ]);

    }

    public function orderprocess(Request $request)
    {
        $CustomUtils = new CustomUtils;

        $ct_chk     = $request->input('ct_chk');
        $sct_status = $request->input('sct_status');

        if($ct_chk == '' || $sct_status == ''){
            return redirect()->back()->with('alert_messages', '처리할 자료를 하나 이상 선택해 주십시오.');
            exit;
        }

        $order_id   = $request->input('order_id');
        $user_id    = $request->input('user_id');
        $od_email   = $request->input('od_email');
        $page_move  = $request->input('page_move');

        $it_sel     = $request->input('it_sel');
        $ct_id      = $request->input('ct_id');
        $ct_chk     = $request->input('ct_chk');


dd($it_sel);
        $order_info = DB::table('shoporders')->select('order_id')->where('order_id', $order_id)->first();
        if(is_null($order_info)){
            return redirect()->back()->with('alert_messages', '해당 주문번호로 주문서가 존재하지 않습니다.');
            exit;
        }

        $arr_it_id = array();

        for ($i = 0; $i < count($ct_id); $i++)
        {
            if($ct_chk[$i] == '') continue;
            if($ct_id[$i] == '') continue;

            $cart_info = DB::table('shopcarts')->where([['od_id', $order_id], ['id', $ct_id]])->first();

            if(is_null($cart_info)) continue;





dd("FFFFFFFFF");
        }









        $status_normal = array('주문','입금','준비','배송','완료');
        $status_cancel = array('취소','반품','품절');


dd($ct_chk);



    }


}
