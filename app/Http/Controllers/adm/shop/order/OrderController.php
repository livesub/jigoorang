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
use App\Models\shopitemoptions;
use App\Models\shopitems;
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

        $carts = DB::table('shopcarts')->select('id', 'od_id', 'item_code', 'item_name', 'sct_status')->where('od_id', $order_id)->groupBy('item_code')->orderBy('id')->get();

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

    public function ajax_orderprocess(Request $request)
    {
        $CustomUtils = new CustomUtils;

        $ct_chk     = $request->input('ct_chk');
        $sct_status = $request->input('sct_status');   //상태 값(입금,취소,준비,배송 등등)

        if($ct_chk == ''){
            echo json_encode(['message' => 'all_cancel']);
            exit;
        }

        $order_id   = $request->input('order_id');

        $user_id    = $request->input('user_id');
        $od_email   = $request->input('od_email');
        $page_move  = $request->input('page_move');

        $it_sel     = $request->input('it_sel');
        $ct_id      = $request->input('ct_id');     //장바구니 순번
        $sct_qty    = $request->input('sct_qty');   //수량

        $order_info = DB::table('shoporders')->select('order_id', 'od_receipt_price', 'od_receipt_point', 'od_misu')->where('order_id', $order_id)->first();
        if(is_null($order_info)){
            echo json_encode(['message' => 'no_order']);
            exit;
        }

        //카드 결제 금액(실 결제 금액 : 결제금액(주문금액 + 모든 배송비) + 결제시 사용 포인트)
        $card_price = (int)$order_info->od_receipt_price - (int)$order_info->od_receipt_point;

        $amount = 0;
        $custom_data = array();

        for($i = 0; $i < count($ct_id); $i++){
            if(isset($ct_chk[$i])){

                $cart_info = DB::table('shopcarts')->where([['od_id', $order_id], ['id', $ct_id[$i]]])->first();

                if($sct_status == '입력수량취소'){

                    if($cart_info->sct_qty < $sct_qty[$i]){ //장바구니 수량 보다 더 입력 했을 경우
                        echo json_encode(['message' => 'qty_big']);
                        exit;
                    }else{
                        if($cart_info->sct_qty != $sct_qty[$i]){
                            //수량 차이가 있을 경우
                            //입력수량취소
                            $minus_qty = $cart_info->sct_qty - $sct_qty[$i];   //차감 갯수

                            //갯수에 따른 환불 금액
                            $qty_price = ($cart_info->sct_price + $cart_info->sio_price) * $minus_qty;

                            if($card_price > $qty_price){
                                //결제 금액이 취소금액 보다 클때(신용카드만 부분 취소)
                                $amount = $amount + $qty_price;
                            }else if($card_price < $qty_price){
                                //결제 금액 보다 취소금액이 클때(신용카드는 일단 돌려 주고)
                                $amount = $order_info->od_receipt_price;    //카드금액 돌려 주고 나머지는 포인트로
                            }

                            $custom_data[$i]['ct_id'] = $ct_id[$i];
                            $custom_data[$i]['minus_qty'] = $minus_qty;
                        }
                    }
                }else if($sct_status == '취소'){

                }

            }

        }

        $custom_data = json_encode($custom_data);
        if($custom_data == '' || $amount == 0){
            echo json_encode(['message' => 'no_qty']);
            exit;
        }else{
            echo json_encode(['message' => 'pay_cancel', 'amount' => $amount, 'custom_data' => $custom_data]);
            exit;
        }

    }

    public function ajax_admorderpaycancel(Request $request)
    {
        $CustomUtils = new CustomUtils;

        //결제 취소
        $imp_uid                = $request->input('imp_uid');
        $merchant_uid           = $request->input('merchant_uid');  //order 테이블의 order_id 값
        $cancel_request_amount  = $request->input('cancel_request_amount');
        $reason                 = $request->input('reason');
        $custom_data            = json_decode($request->input('custom_data'), true);
        $refund_holder          = $request->input('refund_holder');
        $refund_bank            = $request->input('refund_bank');
        $refund_account         = $request->input('refund_account');

        $order_id               = $merchant_uid;

        $order_info = DB::table('shoporders')->where([['order_id', $order_id], ['imp_uid', $imp_uid]])->first();

        $cancel_result = Iamport::cancelPayment($imp_uid, $cancel_request_amount, $reason); //실제 취소 이루어 지는 부분

        if($cancel_result->success == true){
            $mod_history = '';
            foreach($custom_data as $k=>$v)
            {
                //echo $custom_data[$k]['ct_id'];
                //echo $custom_data[$k]['minus_qty'];
                $cart_info = DB::table('shopcarts')->where([['od_id', $order_id], ['id', $custom_data[$k]['ct_id']]])->first();

                //남은 수량 계산
                $have = $cart_info->sct_qty - $custom_data[$k]['minus_qty'];

                if($cart_info->sio_id){ //옵션 상품일때
                    //취소 갯수 만큼 재고 늘리기
                    $qty_up = shopitemoptions::where([['item_code', $cart_info->item_code], ['sio_id', $cart_info->sio_id], ['sio_type',$cart_info->sio_type]])->first();
                    $qty_up->sio_stock_qty = $qty_up->sio_stock_qty + $custom_data[$k]['minus_qty'];
                    $update_result = $qty_up->save();
                }else{
                    $qty_up = shopitems::where('item_code', $cart_info->item_code)->first();
                    $qty_up->item_stock_qty = $qty_up->item_stock_qty + $custom_data[$k]['minus_qty'];
                    $update_result = $qty_up->save();
                }

                // 장바구니 수량변경
                $cart_up = DB::table('shopcarts')->where([['id', $custom_data[$k]['ct_id']], ['od_id', $order_id]])->update([
                    'sct_qty'       => $have,
                    'sct_status'    => '입력수량취소',
                ]);

                //구입 적립 포인트 회수
                $chagam_point = $cart_info->sct_point * $custom_data[$k]['minus_qty'];
                $CustomUtils->insert_point($order_info->user_id, (-1) * $chagam_point, '구매 적립 취소', 9,'', $order_id);

                $mod_history .= $order_info->od_mod_history.date("Y-m-d H:i:s", time()).' '.$cart_info->sct_option.' 입력수량취소 '.$cart_info->sct_qty.' -> '.$have."\n";

                //order 업데이트
                $od_cart_price = $order_info->od_cart_price - $cancel_request_amount;   //총금액 - 취소 금액
                $od_cancel_price = $cancel_request_amount; //취소금액
                $od_misu = $order_info->od_misu + ((-1) * $cancel_request_amount); //미수금액(누적)

                $order_up = DB::table('shoporders')->where([['order_id', $order_id], ['imp_uid', $imp_uid]])->update([
                    'od_cart_price'     => $od_cart_price,
                    'od_cancel_price'   => $od_cancel_price,
                    'od_misu'           => $od_misu,
                    'od_mod_history'    => $mod_history,
                    'od_status'         => '입력수량취소',
                ]);
            }

            echo "ok";
            exit;
        }else{
            echo "error";
            exit;
        }
    }
}
