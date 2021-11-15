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

    public function ajax_orderprocess(Request $request)
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
        $ct_id      = $request->input('ct_id');     //장바구니 순번
        $ct_chk     = $request->input('ct_chk');
        $sct_qty    = $request->input('sct_qty');   //수량
        $sct_status = $request->input('sct_status');   //상태 값(입금,취소,준비,배송 등등)

        $order_info = DB::table('shoporders')->select('order_id', 'od_receipt_price', 'od_receipt_point', 'od_misu')->where('order_id', $order_id)->first();
        if(is_null($order_info)){
            echo json_encode(['message' => 'no_order']);
            exit;
        }

        //카드 결제 금액(실 결제 금액 : 결제금액(주문금액 + 모든 배송비) + 결제시 사용 포인트)
        $card_price = (int)$order_info->od_receipt_price - (int)$order_info->od_receipt_point;

        //수량 취소 일 경우
        $amount = 0;
        for($i = 0; $i < count($ct_id); $i++){
            if(isset($ct_id[$i]) == isset($ct_chk[$i])){
                $cart_info = DB::table('shopcarts')->where([['od_id', $order_id], ['id', $ct_id[$ct_chk[$i]]]])->first();
                $order_price = ($cart_info->sct_price + $cart_info->sio_price) * $cart_info->sct_qty;   //한건 주문금액

                if($sct_status == '취소'){

                    if($cart_info->sct_qty < $sct_qty[$ct_chk[$i]]){
                        echo json_encode(['message' => 'qty_big']);
                        exit;
                    }

                    if($cart_info->sct_qty != $sct_qty[$ct_chk[$i]]){
                        //수량 취소 일 경우(장바구니 수량과 상세 처리 수량이 다를 경우 수량 취소로)
                        $minus_qty = $cart_info->sct_qty - $sct_qty[$ct_chk[$i]];   //차감 갯수

                        //갯수에 따른 환불 금액
                        $qty_price = ($cart_info->sct_price + $cart_info->sio_price) * $minus_qty;

                        if($card_price > $qty_price){
                            //결제 금액이 취소금액 보다 클때
                            $od_misu = $order_info->od_misu - $qty_price;
                            // 미수금 등의 정보
                            //$info = get_order_info($od_id);
                            //var_dump($od_misu);
                        }else if($card_price < $qty_price){
                            //결제 금액 보다 취소금액이 클때
                            //var_dump("BBBBBBBBBBBB");
                        }

                        $amount = $amount + $qty_price;

                        $custom_data[$ct_chk[$i]]['ct_id'] = $ct_id[$i];
                        $custom_data[$ct_chk[$i]]['minus_qty'] = $minus_qty;
                        $custom_data[$ct_chk[$i]]['od_misu'] = $od_misu;





                        //$CustomUtils->item_qty($order_id, 'plus');  //
                        //echo json_encode(['message' => 'qty_cancel']);
                    }else{

                    }
                }
            }
        }

        $custom_data = json_encode($custom_data);
        echo json_encode(['message' => 'pay_cancel', 'amount' => $amount, 'custom_data' => $custom_data]);
        exit;


/*
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

*/

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






        //ok 안에 집어 넣을것
        foreach($custom_data as $k=>$v)
        {
            //echo $custom_data[$k]['ct_id'];
            //echo $custom_data[$k]['minus_qty'];
            $cart_info = DB::table('shopcarts')->where([['od_id', $order_id], ['id', $custom_data[$k]['ct_id']]])->first();

            if($cart_info->sio_id){
/*
                $update_result = DB::table('shopitemoptions')->where([['item_code', $cart_info->item_code], ['sio_id', $cart_info->sio_id], ['sio_type',$cart_info->sio_type]])->update(
                    sio_stock_qty = sio_stock_qty + $custom_data[$k]['minus_qty']
                );
*/
            }


/*
 수량 + 시켜 주는 작업 필요
                            if($ct['io_id']) {
                                $sql = " update {$g5['g5_shop_item_option_table']}
                                            set io_stock_qty = io_stock_qty + '$diff_qty'
                                            where it_id = '{$ct['it_id']}'
                                              and io_id = '{$ct['io_id']}'
                                              and io_type = '{$ct['io_type']}' ";
                            } else {
                                $sql = " update {$g5['g5_shop_item_table']}
                                            set it_stock_qty = it_stock_qty + '$diff_qty'
                                            where it_id = '{$ct['it_id']}' ";
                            }

        // 장바구니 수량변경
        $sql = " update {$g5['g5_shop_cart_table']}
                    set ct_qty = '$ct_qty'
                    where ct_id = '$ct_id'
                      and od_id = '$od_id' ";
        sql_query($sql);
        $mod_history .= G5_TIME_YMDHIS.' '.$ct['ct_option'].' 수량변경 '.$ct['ct_qty'].' -> '.$ct_qty."\n";


*/


var_dump($cart_info);
        }


exit;
/*
        $cancel_result = Iamport::cancelPayment($imp_uid, $cancel_request_amount, $reason); //실제 취소 이루어 지는 부분

        if($cancel_result->success == true){
            echo "ok";
            exit;
        }else{
            echo "error";
            exit;
        }
*/

//echo $custom_data->ct_id[0];


    }




}
