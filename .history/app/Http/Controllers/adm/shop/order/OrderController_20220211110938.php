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
use App\Models\shopcarts;    //장바구니 모델 정의
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
        $order_sort         = $request->input('order_sort');

        if($od_status == "") $od_status = "입금";
/*
        $data = array(
            'sel_field'          => $request->input('sel_field'),
            'search'             => $request->input('search'),
            'od_status'          => $request->input('od_status'),
            'od_settle_case'     => $request->input('od_settle_case'),
            'od_cancel_price'    => $request->input('od_cancel_price'),
            'od_refund_price'    => $request->input('od_refund_price'),
            'od_receipt_point'   => $request->input('od_receipt_point'),
            'fr_date'            => $request->input('fr_date'),
            'to_date'            => $request->input('to_date'),
            'page'               => $request->input('page'),
        );
*/

        $orders = DB::table('shoporders')->where('od_status', $od_status);

        if ($search != "") {    //검색
            if ($sel_field != "") {
                $orders->where($sel_field, 'like', '%'.$search.'%');
            }
        }

        if ($fr_date && $to_date) {
            $orders->whereBetween('od_receipt_time', [$fr_date.' 00:00:00', $to_date.' 23:59:59']);
        }

        $page       = $request->input('page');
        $pageScale  = 10;  //한페이지당 라인수
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

        if($order_sort == "" || $order_sort == "desc"){
            $order_rows = $orders->orderby('id', 'desc')->offset($start_num)->limit($pageScale)->get();
        }else{
            $order_rows = $orders->orderby('id', 'asc')->offset($start_num)->limit($pageScale)->get();
        }

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

        $page_move = "&page=$page&sel_field=$sel_field&search=$search&od_status=$od_status&fr_date=$fr_date&to_date=$to_date";
        $sort_page_move = "&sel_field=$sel_field&search=$search&od_status=$od_status&fr_date=$fr_date&to_date=$to_date";

        return view('adm.shop.order.orderlist',[
/*
            'od_status'         => $data['od_status'],
            'sel_field'         => $data['sel_field'],
            'search'            => $data['search'],
            'fr_date'           => $data['fr_date'],
            'to_date'           => $data['to_date'],
            'data'              => $data,
*/

            'orders'            => $order_rows,
            'CustomUtils'       => $CustomUtils,
            'sel_field'         => $sel_field,
            'search'            => $search,
            'od_status'         => $od_status,
            //'od_settle_case'    => $od_settle_case,
            //'od_cancel_price'   => $od_cancel_price,
            //'od_refund_price'   => $od_refund_price,
            //'od_receipt_point'  => $od_receipt_point,
            'fr_date'           => $fr_date,
            'to_date'           => $to_date,
            'page_move'         => $page_move,
            'sort_page_move'    => $sort_page_move,
            'pnPage'            => $pnPage,
            'order_sort'        => $order_sort,
        ]);
    }

    public function order_check(Request $request)
    {
        $CustomUtils = new CustomUtils;

        $ct_chk     = $request->input('ct_chk');
        for($i = 0; $i < count($ct_chk); $i++){
            $order_info = DB::table('shoporders')->where('order_id', $ct_chk[$i])->first();

            $cart_up = DB::table('shopcarts')->where([['user_id', $order_info->user_id], ['od_id', $order_info->order_id]])->update([
                'sct_status'    => '준비',
            ]);

            $order_up = DB::table('shoporders')->where([['order_id', $order_id], ['imp_uid', $imp_uid]])->update([
                'od_status'         => '준비',
            ]);

        }

    }


    public function deposit_function($data)
    {
        $CustomUtils = new CustomUtils;

        $orders = DB::table('shoporders')->where('od_status', '입금');

        if ($data['search'] != "") {    //검색
            if ($data['sel_field'] != "") {
                $orders->where($data['sel_field'], 'like', '%'.$data['search'].'%');
            }
        }

        if ($data['fr_date'] && $data['to_date']) {
            $orders->whereBetween('od_receipt_time', [$data['fr_date'].' 00:00:00', $data['to_date'].' 23:59:59']);
        }

        $page       = $data['page'];
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
        $tailarr['sel_field']           = $data['sel_field'];
        $tailarr['search']              = $data['search'];
        $tailarr['od_status']           = $data['od_status'];
        $tailarr['fr_date']             = $data['fr_date'];
        $tailarr['to_date']             = $data['to_date'];

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

        $page_move = "&page=$page&sel_field={$data['sel_field']}&search={$data['search']}&od_status={$data['od_status']}&fr_date={$data['fr_date']}&to_date={$data['to_date']}";

        return view('adm.shop.order.deposit_list',[
            'orders'            => $order_rows,
            'total_record'      => $total_record,
            'CustomUtils'       => $CustomUtils,
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

        $carts = DB::table('shopcarts')->where('od_id', $order_id)->groupBy('item_code')->orderBy('id')->get();

        if(count($carts) == 0){
            return redirect()->back()->with('alert_messages', '잘못된 경로 입니다.');
        }

        //교환건 찾기
        $return_story_cnt = DB::table('shopcarts')->where([['od_id', $order_id], ['return_story', '!=', '']])->count();
        $return_process_cnt = DB::table('shopcarts')->where([['od_id', $order_id], ['return_story', '!=', ''], ['return_process', 'Y']])->count();

        //주문자 정보
        $mem_info = DB::table('users')->where('user_id', $order_info->user_id)->first();

        return view('adm.shop.order.orderdetail',[
            'CustomUtils'   => $CustomUtils,
            'order_info'    => $order_info,
            'carts'         => $carts,
            'page_move'     => $page_move,
            'mem_info'      => $mem_info,
            'return_story_cnt'  => $return_story_cnt,
            'return_process_cnt' => $return_process_cnt,
        ]);
    }

    public function ajax_orderqtyprocess(Request $request)
    {
        //입력 수량 취소
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

        $order_info = DB::table('shoporders')->where('order_id', $order_id)->first();
        if(is_null($order_info)){
            echo json_encode(['message' => 'no_order']);
            exit;
        }

        //카드 결제 금액(실 결제 금액 = 결제금액(주문금액 + 모든 배송비) - 결제시 사용 포인트) - 취소된 금액이 있는지 - 무료배송비정책금액 이하로 떨어 졌을때 한번 뺴는 칼럼
        //실제 카드 결제 금액
        //$card_price = ((int)$order_info->od_receipt_price - (int)$order_info->od_receipt_point) - (int)$order_info->od_cancel_price - (int)$order_info->de_cost_minus;
        $card_price = ((int)$order_info->od_receipt_price - (int)$order_info->od_receipt_point) - (int)$order_info->od_cancel_price;
var_dump("card_price===> ".$card_price);
        if($card_price < 0) $card_price = 0;    //카드 환불이 완료 됐다면 계속 0원

        $amount = 0;
        $point_amount = 0;
        $now_point = 0;
        $custom_data = array();

        for($i = 0; $i < count($ct_id); $i++){
            if(isset($ct_chk[$i])){
                $cart_info = DB::table('shopcarts')->where([['od_id', $order_id], ['id', $ct_id[$i]]])->first();

                if($cart_info->sct_qty < $sct_qty[$i]){ //장바구니 수량 보다 더 입력 했을 경우
                    echo json_encode(['message' => 'qty_big']);
                    exit;
                }else{
                    //입력수량취소 일때
                    if($cart_info->sct_qty != $sct_qty[$i]){
                        //수량 차이가 있을 경우
                        $minus_qty = $cart_info->sct_qty - $sct_qty[$i];   //차감 갯수

                        //갯수에 따른 환불 금액
                        $qty_price = ($cart_info->sct_price + $cart_info->sio_price) * $minus_qty;

                        $amount = $amount + $qty_price;

                        $custom_data[$i]['ct_id'] = $ct_id[$i];
                        $custom_data[$i]['minus_qty'] = $minus_qty;
                    }
                }
            }
        }

        if($card_price > $amount){
            //결제 금액이 취소금액 보다 클때(신용카드만 부분 취소)
            $amount = $amount;
        }else{
            //결제 금액 보다 취소금액이 크거나 같을때(신용카드는 일단 돌려 주고)
            $point_amount = $amount;
            $amount = $card_price;
        }
var_dump("kkkkkkk===> ".$amount);
        //기본 배송비무료 정책(3만원)인데 취소 처리
        $CustomUtils->set_cookie('de_cost_minus'.$order_id, '', time() - 86400); // 하루동안 저장

        if($order_info->de_send_cost_free != 0){
            //무료 정책비 보다 주문 상품 금액이 같거나 클때 de_send_cost_free 값 생기게 설계
            //주문 상품 총금액 - 취소 금액 이 무료 정책 이하라면
            if(($order_info->od_cart_price - $amount) < $order_info->de_send_cost_free){
                if($order_info->od_cart_price < $order_info->de_send_cost){
                    //주문 상품 총금액 < 무료 배송정책비
                    echo json_encode(['message' => 'no_cancel']);
                    exit;
                }else{
                    //무료배송비 정책 이하로 취소시 취소 금액에서 기본 배송비를 빼고 돌려 준다
                    //한번 빼고 돌려 줬는지 디비에 저장 한다.
                    if($order_info->de_cost_minus == 0){
                        $CustomUtils->set_cookie('de_cost_minus'.$order_id, 'yes', time() + 86400); // 하루동안 저장
                        if($card_price > $amount){
                            $amount = $amount - $order_info->de_send_cost;
                            //$amount = $card_price - $order_info->de_send_cost;
                        }else{
                            $amount = $card_price;
                        }
                    }else{
                        $CustomUtils->set_cookie('de_cost_minus'.$order_id, '', time() - 86400); // 하루동안 저장
                        $amount = $amount;
                    }
                }
            }
var_dump("de_send_cost===> ".$order_info->de_send_cost);
var_dump("amount===> ".$amount);
exit;
        }

        if(empty($custom_data)){
            echo json_encode(['message' => 'no_qty']);
            exit;
        }else{
            $custom_data = json_encode($custom_data);
            echo json_encode(['message' => 'pay_cancel', 'amount' => $amount, 'custom_data' => $custom_data]);
            exit;
        }
    }

    public function ajax_orderitemprocess(Request $request)
    {
var_dump("일단 막음");
exit;
        //상품별 취소
        $CustomUtils = new CustomUtils;

        $ct_chk     = $request->input('ct_chk');
        $sct_status = $request->input('sct_status');   //상태 값(입금,취소,준비,배송 등등)
        $all_chkbox = $request->input('all_chkbox');    //체크 박스 올 선택시 값 Y

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

        $order_info = DB::table('shoporders')->where('order_id', $order_id)->first();

        if(is_null($order_info)){
            echo json_encode(['message' => 'no_order']);
            exit;
        }

        //카드 결제 금액(실 결제 금액 = 결제금액(주문금액 + 모든 배송비) - 결제시 사용 포인트) - 취소된 금액이 있는지
        $card_price = ((int)$order_info->od_receipt_price - (int)$order_info->od_receipt_point) - (int)$order_info->od_cancel_price;

        $amount = 0;
        $custom_data = array();
        $item_id = array();
        $temp2 = '';
        $ct_id_arr = '';
        $item_id_arr = array();
        $choice_cnt = 0;
        $new_tmp = '';
        $new_tmp2 = '';
        $new_tmp3 = '';
        $tot_price = 0;

        for($k = 0; $k < count($ct_id); $k++){
            if(isset($ct_chk[$k])){
                $temp2 .= $ct_id[$k].',';
            }
        }

        $ct_id_arr = substr($temp2, 0, -1);

        if(!is_null($it_sel)){
            for($i = 0; $i < count($it_sel); $i++){
                $tmp = '';
                $item_cnts = DB::table('shopcarts')->select('id')->where([['od_id', $order_info->order_id], ['item_code', $it_sel[$i]]])->orderBy('id', 'asc')->get();

                foreach($item_cnts as $item_cnt){
                    $tmp .= $item_cnt->id.',';
                }

                $item_id[$i] = $tmp;
                $item_id_arr[$i] = substr($item_id[$i], 0, -1);
            }
        }

        $choice_cnt = count($item_id_arr);  //선택된 묶음 객수

        //총 주문 선택시
        if($choice_cnt == $order_info->od_cart_count){
            $amount = $card_price;
            $custom_data[0] = 0;
        }else{
            if(count($item_id_arr) != 0){

                $item_id_arr_cut = '';

                for($m = 0; $m < count($item_id_arr); $m++){

                    if(strpos($ct_id_arr, $item_id_arr[$m]) !== false) {
                        $item_id_arr_cut = explode(",", $item_id_arr[$m]);

                        for($p = 0; $p < count($item_id_arr_cut); $p++){
                            //묶음 취소 처리
                            $cart_info = DB::table('shopcarts')->where([['od_id', $order_id], ['id', $item_id_arr_cut[$p]]])->first();

                            //상품 금액만
                            if($cart_info->sio_type) $tot_price += $cart_info->sio_price * $cart_info->sct_qty;
                            else $tot_price += ($cart_info->sct_price + $cart_info->sio_price) * $cart_info->sct_qty;

                            //상품별 배송비 한번만 계산
                            if($p == 0) $tot_price += $cart_info->item_sc_price;
                            $new_tmp .= $item_id_arr_cut[$p].',';
                        }
                    }
                }
            }

            $new_tmp2 = substr($new_tmp, 0, -1); //묶음 배송 처리 id

            /* 묶음 배송 처리가 끝난 것들 이외 처리 위해*/
            $arr_tmp1 = '';
            $arr_tmp2 = '';
            $arr_tmp3 = '';

            $arr_tmp1 = explode(",", $ct_id_arr);
            $arr_tmp2 = explode(",", $new_tmp2);

            $arr_tmp3 = array_merge(array_diff($arr_tmp1, $arr_tmp2),array_diff($arr_tmp2, $arr_tmp1));

            //묶음 취소로 해결 되지 않는 선택 취소
            if(count(array_filter($arr_tmp3)) != 0){
                for($g = 0; $g < count(array_filter($arr_tmp3)); $g++){
                    $cart_info2 = DB::table('shopcarts')->where([['od_id', $order_id], ['id', $arr_tmp3[$g]]])->first();
var_dump($cart_info2->item_sc_price);
                    //상품 금액만
                    if($cart_info2->sio_type) $tot_price += $cart_info2->sio_price * $cart_info2->sct_qty;
                    else $tot_price += ($cart_info2->sct_price + $cart_info2->sio_price) * $cart_info2->sct_qty;





                    $new_tmp3 .= $arr_tmp3[$g].',';
                }
            }
var_dump("tot_price-====> ".$tot_price);
exit;
            //추가 배송비(산간지역)를 취소 하기 위해(-전체 상품이 취소되는 시점에서 추가 배송비를 취소 한다.)
            if($order_info->od_send_cost2 > 0){     //추가 배송비가 있는 상태
                //주문 상품 총 갯수
                $cart_cnt = DB::table('shopcarts')->where('od_id', $order_info->order_id)->count();

                //취소된 주문 상품 총 갯수
                $cart_cancel_cnt = DB::table('shopcarts')->where([['od_id', $order_info->order_id], ['sct_status', '취소']])->count();
                $tmp_total = $cart_cancel_cnt + count($arr_tmp1);
                if($all_chkbox == 'Y' || $cart_cnt == $tmp_total){
                    $tot_price = $tot_price + $order_info->od_send_cost2;
                }
            }

            if($card_price > $tot_price){
                //결제 금액이 취소금액 보다 클때(신용카드만 부분 취소)
                $amount = $tot_price;
            }else if($card_price <= $tot_price){
                //결제 금액 보다 취소금액이 크거나 같을때(신용카드는 일단 돌려 주고)
                $amount = $card_price;    //카드금액 돌려 주고 나머지는 포인트로
            }
var_dump($amount);
exit;
            $custom_data = $new_tmp.$new_tmp3;
            $custom_data = array_filter(explode(',', substr($custom_data, 0, -1)));
        }

        if(empty($custom_data)){
            echo json_encode(['message' => 'no_qty']);
            exit;
        }else{
            $custom_data = json_encode($custom_data);
            echo json_encode(['message' => 'pay_cancel', 'amount' => $amount, 'custom_data' => $custom_data]);
            exit;
        }
    }

    public function ajax_admorderqtypaycancel(Request $request)
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

        $success = '';

//var_dump("cancel_request_amount===> ".$cancel_request_amount);
//exit;
        if($cancel_request_amount > 0){
            //취소 금액이 0원 보다 클때 Iamport 를 태운다.
            $cancel_result = Iamport::cancelPayment($imp_uid, $cancel_request_amount, $reason); //실제 취소 이루어 지는 부분
            $success = $cancel_result->success;
//$success = true;
        }else if($cancel_request_amount == 0){
            //취소 금액이 0원일때 때문에..
            $success = true;
        }

        if($success == true){
            $mod_history = '';
            $now_point = 0;

            $order_info = DB::table('shoporders')->where([['order_id', $order_id], ['imp_uid', $imp_uid]])->first();

            //카드 결제 금액(실 결제 금액 = 결제금액(주문금액 + 모든 배송비) - 결제시 사용 포인트) - 취소된 금액이 있는지
            $card_price = ((int)$order_info->od_receipt_price - (int)$order_info->od_receipt_point) - (int)$order_info->od_cancel_price;
            $receipt_price = (int)$order_info->od_receipt_price - (int)$order_info->od_cancel_price;

            $hap_qty_price = 0;
            $chagam_point = 0;
            $hap_misu = 0;
            $od_cancel_price = 0;
            $return_point = 0;
            $hap_point = 0;
            $od_return_point = 0;

            foreach($custom_data as $k=>$v)
            {
                $cart_info = DB::table('shopcarts')->where([['od_id', $order_id], ['id', $custom_data[$k]['ct_id']]])->first();

                //남은 수량 계산
                $have = $cart_info->sct_qty - $custom_data[$k]['minus_qty'];

                //(판매가격 + 옵션 추가 금액) * 수량
                $qty_price = ((int)$cart_info->sct_price + (int)$cart_info->sio_price) * $custom_data[$k]['minus_qty'];

                $hap_qty_price += $qty_price;

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
                    'sct_status'    => '부분취소',
                ]);

                //적립 상품 인지 미적립 상품인지 파악
                $item_info = DB::table('shopitems')->where([['item_code', $cart_info->item_code], ['item_give_point', 'Y']])->count();
                if($item_info > 0){
                    $return_point += $qty_price * ($order_info->set_tot_item_point / 100);
                }

                $mod_history .= $order_info->od_mod_history.date("Y-m-d H:i:s", time()).' '.$cart_info->sct_option.' 부분취소 '.$cart_info->sct_qty.' -> '.$have."\n";
            }

            //포인트 반환 로직
            if($order_info->tot_item_point != 0){   //구매시 적립 포인트가 있는지
                $hap_point = $return_point + (int)$order_info->od_return_point;

                if($order_info->tot_item_point <= $hap_point){
                    $od_return_point = $order_info->tot_item_point;
                }else{
                    $od_return_point = $hap_point;
                }

                if($order_info->od_return_point != $od_return_point){
                    $return_point = DB::table('shoporders')->where([['order_id', $order_id], ['imp_uid', $imp_uid]])->update([
                        'od_return_point' => $od_return_point,
                    ]);
                    $CustomUtils->insert_point($order_info->user_id, (-1) * $od_return_point, '구매 적립 취소', 9,'', $order_id);
                }
            }


//var_dump("HHHHHHHH====> ".$CustomUtils->get_cookie('de_cost_minus'.$order_id));
            $de_send_cost = 0;
            if($CustomUtils->get_cookie('de_cost_minus'.$order_id) == "yes"){
                $de_send_cost = $order_info->de_send_cost;
            }

//var_dump("de_send_cost====> ".$de_send_cost);

            if(($card_price + $de_send_cost) < ($hap_qty_price + $de_send_cost)){
//$aa = $hap_qty_price - $card_price;
//var_dump("포인트 돌려줌====================".$aa);
                $misu = $hap_qty_price;
                $od_cancel_price = $order_info->od_cancel_price + $cancel_request_amount + $de_send_cost; //취소금액
                if($card_price > 0){
                    $CustomUtils->insert_point($order_info->user_id, $hap_qty_price - $card_price, '상품구매부분취소', 10,'', $order_id);
                }else{
                    $CustomUtils->insert_point($order_info->user_id, $hap_qty_price, '상품구매부분취소', 10,'', $order_id);
                }
            }else{
//var_dump("22222222222");
                $misu = $hap_qty_price;
                $od_cancel_price = $order_info->od_cancel_price + $cancel_request_amount + $de_send_cost; //취소금액
            }

            //order 업데이트
            $od_cart_price = $order_info->od_cart_price - $misu;   //총금액 - 취소 금액
            $od_misu = $order_info->od_misu + ((-1) * $misu); //미수금액(누적)

/*
var_dump("card_price(카드금액)====> ".$card_price);
var_dump("chagam_point====> ".$chagam_point);
var_dump("receipt_price(원결제금액)====> ".$receipt_price);
var_dump("hap_qty_price(수량금액)===> ".$hap_qty_price);
var_dump("misu===> ".$misu);
var_dump("od_cancel_price(누적 취소금액)===> ".$od_cancel_price);
var_dump("od_cart_price(상품 총금액)===> ".$od_cart_price);
var_dump("od_misu(누적미수)===> ".$od_misu);
exit;
*/

            //무료배송비 정책 이하로 취소시 취소 금액에서 기본 배송비를 빼고 돌려 준다
            //한번 빼고 돌려 줬는지 디비에 저장 한다.
            if($CustomUtils->get_cookie('de_cost_minus'.$order_id) == "yes"){
                $de_send_cost_up = DB::table('shoporders')->where([['order_id', $order_id], ['imp_uid', $imp_uid]])->update([
                    'de_cost_minus' => $order_info->de_send_cost,
                ]);
                $CustomUtils->set_cookie('de_cost_minus'.$order_id, '', time() - 86400);
            }

            $order_up = DB::table('shoporders')->where([['order_id', $order_id], ['imp_uid', $imp_uid]])->update([
                'od_cart_price'     => $od_cart_price,
                'od_cancel_price'   => $od_cancel_price,
                'od_misu'           => $od_misu,
                'od_mod_history'    => $mod_history,
                'od_status'         => '부분취소',
            ]);

            echo "ok";
            exit;
        }else{
            echo "error";
            exit;
        }
    }

    public function ajax_admorderitempaycancel(Request $request)
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

        //각 상픔의 갯수를 구한다
        $cart_cnts = DB::table('shopcarts')->select('item_code',  DB::raw("count(*) as cnt"))->where('od_id', $order_id)->groupBy('item_code')->get();

        $item_cnt = array();
        foreach($cart_cnts as $cart_cnt){
            $item_cnt[$cart_cnt->item_code] = $cart_cnt->cnt;
        }

        //카드 결제 금액(실 결제 금액 = 결제금액(주문금액 + 모든 배송비) - 결제시 사용 포인트) - 취소된 금액이 있는지
        $card_price = (int)$order_info->od_receipt_price - (int)$order_info->od_receipt_point - (int)$order_info->od_cancel_price;

        $success = '';
        $chagam_point = 0;
        $all_chagam_point = 0;
        $qty_price = 0;
        $misu = 0;
        $mod_history = '';
var_dump($cancel_request_amount);
exit;
        if($cancel_request_amount > 0){
            //취소 금액이 0원 보다 클때 Iamport 를 태운다.
            $cancel_result = Iamport::cancelPayment($imp_uid, $cancel_request_amount, $reason); //실제 취소 이루어 지는 부분
            $success = $cancel_result->success;
//$success = true;
        }else{
            //취소 금액이 0원일때 때문에..
            $success = true;
        }

        if($success == true){
            $mod_history = '';

            if($custom_data[0] == 0){
                //전체 취소
                //한개라도 취소한 상품이 있으면 여기 못들어 오게
                $exception_cnt = DB::table('shopcarts')->where([['od_id', $order_id], ['user_id', $order_info->user_id], ['sct_select', 1], ['sct_status', '상품취소']])->count();
                if($exception_cnt > 0){
                    echo "exception";
                    exit;
                }

                $all_cart_infos = DB::table('shopcarts')->where([['od_id', $order_id], ['user_id', $order_info->user_id], ['sct_select', 1]])->whereRaw('sct_status in (\'입금\', \'준비\', \'배송\', \'배송완료\', \'부분취소\', \'상품취소\', \'반품\')')->get();

                $mod_history = $order_info->od_mod_history; //히스토리 내역

                foreach($all_cart_infos as $all_cart_info){
                    //재고 늘리기
                    if($all_cart_info->sio_id){ //옵션 상품일때
                        //취소 갯수 만큼 재고 늘리기
                        $all_qty_up = shopitemoptions::where([['item_code', $all_cart_info->item_code], ['sio_id', $all_cart_info->sio_id], ['sio_type',$all_cart_info->sio_type]])->first();
                        $all_qty_up->sio_stock_qty = $all_qty_up->sio_stock_qty + $all_cart_info->sct_qty;
                        $all_update_result = $all_qty_up->save();
                    }else{
                        $all_qty_up = shopitems::where('item_code', $all_cart_info->item_code)->first();
                        $all_qty_up->item_stock_qty = $all_qty_up->item_stock_qty + $all_cart_info->sct_qty;
                        $all_update_result = $all_qty_up->save();
                    }

                    //구입 적립 포인트 회수
                    $chagam_point += $all_cart_info->sct_point * $all_cart_info->sct_qty;

                    // 장바구니 수량변경
                    $all_cart_up = DB::table('shopcarts')->where([['id', $all_cart_info->id], ['od_id', $order_id]])->update([
                        'sct_qty'       => 0,
                        'sct_status'    => '상품취소',
                    ]);

                    $mod_history .= date("Y-m-d H:i:s", time()).' '.$all_cart_info->sct_option.' 주문취소 '.$all_cart_info->sct_qty.' -> 0'."\n";
                }

                $CustomUtils->insert_point($order_info->user_id, (-1) * $chagam_point, '구매 적립 취소', 9,'', $order_id);

                //사용한 포인트가 있다면 반환
                if($order_info->od_receipt_point != 0){
                    $give_point_sum = DB::table('shoppoints')->where([['order_id', $order_info->order_id] , ['po_type', '10']])->sum('po_point');
                    $give_point = $order_info->od_receipt_point - $give_point_sum;
                    $CustomUtils->insert_point($order_info->user_id, $give_point, '상품 구매 취소', 11,'', $order_id);
                }

                //order 업데이트
                $order_up = DB::table('shoporders')->where([['order_id', $order_id], ['imp_uid', $imp_uid]])->update([
                    'od_cancel_price'   => $cancel_request_amount,
                    'od_misu'           => (-1) * $cancel_request_amount,
                    //'od_cart_price'     => 0,
                    //'od_receipt_point'  => 0,
                    //'de_send_cost'      => 0,
                    //'od_send_cost'      => 0,
                    //'od_send_cost2'     => 0,
                    //'od_receipt_price'  => 0,
                    'od_mod_history'    => $mod_history,
                    'od_status'         => '상품취소',
                ]);
            }else{
                $mod_history2 = '';
                $mod_history2 = $order_info->od_mod_history;

                foreach($custom_data as $k=>$v)
                {
                    $od_send_cost = 0;
                    $cart_info = DB::table('shopcarts')->where([['od_id', $order_id], ['id', $custom_data[$k]]])->first();
                    $order_misu = DB::table('shoporders')->select('od_cancel_price', 'od_misu')->where([['order_id', $order_id], ['imp_uid', $imp_uid]])->first();

                    //남은 수량 계산
                    $have = $cart_info->sct_qty - $cart_info->sct_qty;

                    if($cart_info->sio_id){ //옵션 상품일때
                        //취소 갯수 만큼 재고 늘리기
                        $qty_up = shopitemoptions::where([['item_code', $cart_info->item_code], ['sio_id', $cart_info->sio_id], ['sio_type',$cart_info->sio_type]])->first();
                        $qty_up->sio_stock_qty = $qty_up->sio_stock_qty + $cart_info->sct_qty;
                        $update_result = $qty_up->save();
                    }else{
                        $qty_up = shopitems::where('item_code', $cart_info->item_code)->first();
                        $qty_up->item_stock_qty = $qty_up->item_stock_qty + $cart_info->sct_qty;
                        $update_result = $qty_up->save();
                    }

                    //구입 적립 포인트 회수
                    $chagam_point = $cart_info->sct_point * $cart_info->sct_qty;
                    $CustomUtils->insert_point($order_info->user_id, (-1) * $chagam_point, '구매 적립 취소', 9,'', $order_id);

                    // 장바구니 수량변경

                    $cart_up = DB::table('shopcarts')->where([['id', $custom_data[$k]], ['od_id', $order_id]])->update([
                        'sct_qty'       => $have,
                        'sct_status'    => '상품취소',
                    ]);

                    $mod_history2 .= date("Y-m-d H:i:s", time()).' '.$cart_info->sct_option.' 주문취소 '.$cart_info->sct_qty.' -> '.$have."\n";


                    //포인트 지급전에 개별 배송비가 있다면 포함해서 지급
                    $cancel_cart_cnt = DB::table('shopcarts')->where([['item_code', $cart_info->item_code],['sct_status', '상품취소']])->count();
                    if($item_cnt[$cart_cnt->item_code] == $cancel_cart_cnt){
                        $od_send_cost = $order_info->od_send_cost;  //상품 부분 취소일 경우 상품별 배송비도 같이 포함
                    }

                //1000 < 2000
                    $qty_price = ($cart_info->sct_price + $cart_info->sio_price) * $cart_info->sct_qty;   //취소 금액

                    //현재 카드 결제 잔액
                    $now_order_info = DB::table('shoporders')->where([['order_id', $order_id], ['imp_uid', $imp_uid]])->first();
                    $now_card_price = (int)$now_order_info->od_receipt_price - (int)$now_order_info->od_receipt_point - (int)$now_order_info->od_cancel_price;

                    if($now_card_price < $qty_price){   //결제금액 보다 취소 금액이 클때
                        if($order_misu->od_misu  == 0){
                            //처음 취소 일때 카드값 전부 돌려 주고, 상품값 - 신용카드값 을 포인트로 지급
                            $misu = $qty_price - $card_price + $od_send_cost;
                        }else{
                            //두번쨰 부터는
                            $misu = $qty_price;
                        }

                        $CustomUtils->insert_point($order_info->user_id, $misu, '상품 구매 부분 취소', 10,'', $order_id);

                        if($cancel_request_amount == 0){
                            //취소 금액이 0원이라는 것은 카드 금액을 다 돌려 준 상태임
                            $od_cancel_price = $order_info->od_cancel_price; //취소금액
                        }else{
                            $od_cancel_price = $cancel_request_amount; //취소금액
                        }
//var_dump($od_cancel_price);
                    }else{
                        //$misu = $cancel_request_amount;
                        $misu = $qty_price;
                        //$od_cancel_price = $order_misu->od_cancel_price + $cancel_request_amount; //취소금액
                        $od_cancel_price = $order_misu->od_cancel_price + $misu; //취소금액
                    }

                    //order 업데이트
                    $od_cart_price = $order_info->od_cart_price - $misu;   //총금액 - 취소 금액
                    $od_misu = $order_misu->od_misu + ((-1) * $misu); //미수금액(누적)
//var_dump("od_cart_price====> ".$od_misu);



                    $order_up = DB::table('shoporders')->where([['order_id', $order_id], ['imp_uid', $imp_uid]])->update([
                        'od_cart_price'     => $od_cart_price,
                        'od_cancel_price'   => $od_cancel_price,
                        'od_misu'           => $od_misu,
                        //'od_mod_history'    => $mod_history,
                        'od_status'         => '상품취소',
                    ]);

                }
//exit;

                //추가 배송비(산간지역)를 취소 하기 위해(-전체 상품이 취소되는 시점에서 추가 배송비를 취소 한다.)
                if($order_info->od_send_cost2 > 0){     //추가 배송비가 있는 상태
                    //주문 상품 총 갯수
                    $cart_cnt = DB::table('shopcarts')->where('od_id', $order_info->order_id)->count();

                    //취소된 주문 상품 총 갯수
                    $cart_cancel_cnt = DB::table('shopcarts')->where([['od_id', $order_info->order_id], ['sct_status', '상품취소']])->count();

                    if($cart_cnt == $cart_cancel_cnt){

                    }
                }

                //내역 따로 업뎃
                $order_od_mod_history_up = DB::table('shoporders')->where([['order_id', $order_id], ['imp_uid', $imp_uid]])->update([
                    'od_mod_history'    => $mod_history2,
                ]);

            }

            echo "ok";
            exit;
        }else{
            echo "error";
            exit;
        }
    }

    public function ajax_shop_memo(Request $request)
    {
        $CustomUtils = new CustomUtils;

        $id             = $request->input('id');
        $order_id       = $request->input('order_id');
        $od_shop_memo   = $request->input('od_shop_memo');

        if($id == "" || $order_id == ""){
            echo "error";
            exit;
        }

        $shop_memo_up = DB::table('shoporders')->where([['id', $id], ['order_id', $order_id]])->update([
            'od_shop_memo'    => addslashes($od_shop_memo),
        ]);

        echo "ok";
        exit;
    }

    public function ajax_addr_change(Request $request)
    {
        $CustomUtils = new CustomUtils;

        $id         = $request->input('num');
        $order_id   = $request->input('order_id');

        if($id == "" || $order_id == ""){
            echo "error";
            exit;
        }

        $data = array(
            'ad_name'   => addslashes($request->input('ad_name')),
            'ad_hp'     => $request->input('ad_hp'),
            'ad_zip1'   => $request->input('ad_zip1'),
            'ad_addr1'  => $request->input('ad_addr1'),
            'ad_addr2'  => $request->input('ad_addr2'),
            'ad_addr3'  => $request->input('ad_addr3'),
            'ad_jibeon' => $request->input('ad_jibeon'),
            'od_memo'   => addslashes($request->input('od_memo')),
        );

        $shop_memo_up = DB::table('shoporders')->where([['id', $id], ['order_id', $order_id]])->update($data);

        echo "ok";
        exit;
    }

    public function ajax_itemspaycancel(Request $request)
    {
        $CustomUtils = new CustomUtils;

        $imp_uid                = $request->input('imp_uid');
        $merchant_uid           = $request->input('merchant_uid');  //order 테이블의 order_id 값
        $cancel_request_amount  = $request->input('cancel_request_amount');
        $reason                 = $request->input('reason');
        $custom_data            = json_decode($request->input('custom_data'), true);
        $refund_holder          = $request->input('refund_holder');
        $refund_bank            = $request->input('refund_bank');
        $refund_account         = $request->input('refund_account');

        $order_id               = $merchant_uid;

        $cancel_result = Iamport::cancelPayment($imp_uid, $cancel_request_amount, $reason); //실제 취소 이루어 지는 부분
        $success = $cancel_result->success;
//$success = true;
        if($success == true){
            $order_info = DB::table('shoporders')->where([['order_id', $order_id], ['imp_uid', $imp_uid]])->first();

            $mod_history = $order_info->od_mod_history; //히스토리 내역

            $CustomUtils->set_cart_id(0);
            $cart_infos = DB::table('shopcarts as a')
            ->select('a.id', 'a.od_id', 'a.item_code', 'a.item_name', 'a.sct_price', 'a.sct_point', 'a.sct_qty', 'a.sct_status', 'a.sct_send_cost', 'a.item_sc_type', 'b.sca_id')
            ->leftjoin('shopitems as b', function($join) {
                    $join->on('a.item_code', '=', 'b.item_code');
                })
            //->where('a.od_id',$s_cart_id)
            ->where([['a.user_id', Auth::user()->user_id], ['a.sct_status','쇼핑'], ['a.sct_direct','0']])  //장바구니 사라짐 문제
            //->groupBy('a.item_code')
            ->orderBy('a.id')
            ->get();

            if(count($cart_infos) > 0){
                //장바구니 사라짐 문제 때문에 다시 세션 구움
                $CustomUtils->set_session('ss_cart_id', $cart_infos[0]->od_id);
                $tmp_cart_id = $CustomUtils->get_session('ss_cart_id');
            }else{
                $tmp_cart_id = $CustomUtils->get_session('ss_cart_id');
            }

            $all_cart_infos = DB::table('shopcarts')->where([['od_id', $order_id], ['user_id', $order_info->user_id], ['sct_select', 1]])->whereRaw('sct_status in (\'입금\', \'준비\', \'배송\', \'배송완료\', \'부분취소\', \'상품취소\', \'반품\', \'교환\')')->get();

            foreach($all_cart_infos as $all_cart_info){
                $item_info = DB::table('shopitems')->where('item_code', $all_cart_info->item_code)->first();

                //상품 취소시 새로운 상품(기존 값으로) 으로 장바구니 담아 놓기
                $data = array(
                    'od_id'             => $tmp_cart_id,
                    'user_id'           => $all_cart_info->user_id,
                    'item_code'         => $all_cart_info->item_code,
                    'item_name'         => addslashes($all_cart_info->item_name),
                    'de_send_cost'      => $all_cart_info->de_send_cost, //기본 배송비
                    'item_sc_price'     => $all_cart_info->item_sc_price,
                    'sct_status'        => '쇼핑',
                    'sct_history'       => '',
                    'sct_price'         => $all_cart_info->sct_price,
                    'sct_point'         => $all_cart_info->sct_point,
                    'sct_point_use'     => 0,
                    'sct_stock_use'     => 0,
                    'sct_option'        => $all_cart_info->sct_option,
                    'sct_qty'           => $all_cart_info->sct_qty,
                    'sio_id'            => $all_cart_info->sio_id,
                    'sio_type'          => $all_cart_info->sio_type,
                    'sio_price'         => $all_cart_info->sio_price,
                    'sct_ip'            => $all_cart_info->sct_ip,
                    'sct_send_cost'     => $all_cart_info->sct_send_cost,
                    'sct_direct'        => 0,
                    'sct_select'        => 0,
                    'sct_select_time'   => '',
                );

                $in_result = shopcarts::create($data);
                $in_result->save();

                //재고 늘리기
                if($all_cart_info->sio_id){ //옵션 상품일때
                    //취소 갯수 만큼 재고 늘리기
                    $all_qty_up = shopitemoptions::where([['item_code', $all_cart_info->item_code], ['sio_id', $all_cart_info->sio_id], ['sio_type',$all_cart_info->sio_type]])->first();
                    $all_qty_up->sio_stock_qty = $all_qty_up->sio_stock_qty + $all_cart_info->sct_qty;
                    $all_update_result = $all_qty_up->save();
                }else{
                    $all_qty_up = shopitems::where('item_code', $all_cart_info->item_code)->first();
                    $all_qty_up->item_stock_qty = $all_qty_up->item_stock_qty + $all_cart_info->sct_qty;
                    $all_update_result = $all_qty_up->save();
                }

                // 장바구니 수량변경
                $all_cart_up = DB::table('shopcarts')->where([['id', $all_cart_info->id], ['od_id', $order_info->order_id]])->update([
                    'sct_qty'       => 0,
                    'sct_status'    => '상품취소',
                ]);

                $user_id = Auth::user()->user_id;
                $user_name = Auth::user()->user_name;
                //$sct_option = mb_substr($all_cart_info->sct_option, 0, 20, 'utf-8');

                if(strpos($all_cart_info->sct_option, " / ") !== false) {
                    $item_options = $all_cart_info->sct_option;
                } else {
                    $item_options = "";
                }

                //제조사및 상품명 찾기
                if($item_info->item_manufacture == "") $item_manufacture = "";
                else $item_manufacture = "[".$item_info->item_manufacture."]";
                //제목
                $item_name = $item_manufacture.stripslashes($item_info->item_name);

                $yoil = $CustomUtils->get_yoil(date("Y-m-d H:i:s", time()));

                $mod_history .= '
                <tr>
                    <td>'.date("Y-m-d H:i:s", time()).' ('.$yoil.')</td>
                    <td class="prod_name">
                        <div>'.$item_name.'</div>
                        <div>'.$item_options.'</div>
                    </td>
                    <td>취소</td>
                    <td>0</td>
                    <td>'.$all_cart_info->sct_qty_cancel.'</td>
                    <td class="buyer">
                        <div>'.$user_name.'</div>
                        <div>'.$user_id.'</div>
                    </td>
                </tr>
                ';
                //$mod_history .= date("Y-m-d H:i:s", time()).' '.$sct_option.' 주문취소 '.$all_cart_info->sct_qty.' -> 0     '.$user_name."   ".$user_id."\n";
            }

            //모든 사용 포인트 적립 포인트를 되돌려 놓는다
            if($order_info->tot_item_point > 0) $CustomUtils->insert_point($order_info->user_id, (-1) * $order_info->tot_item_point, '구매 적립 취소', 9,'', $order_info->order_id);
            if($order_info->od_receipt_point > 0) $CustomUtils->insert_point($order_info->user_id, $order_info->od_receipt_point, '상품 구매 취소', 11,'', $order_info->order_id);

            //order 업데이트
            $order_up = DB::table('shoporders')->where([['order_id', $order_id], ['imp_uid', $imp_uid]])->update([
                'od_cancel_price'   => $cancel_request_amount,
                'od_misu'           => (-1) * $cancel_request_amount,
                'od_mod_history'    => $mod_history,
                'pay_cancel_date'   => date("Y-m-d H:i:s", time()),
                'od_status'         => '상품취소',
            ]);

            echo "ok";
            exit;
        }else{
            echo "error";
            exit;
        }
    }

    public function ajax_return_process(Request $request)
    {
        $CustomUtils = new CustomUtils;

        $ct_chk     = $request->input('ct_chk');
        $sct_status = $request->input('sct_status');   //상태 값(입금,취소,준비,배송 등등)

        if($ct_chk == ''){
            echo 'all_cancel';
            exit;
        }

        $order_id   = $request->input('order_id');

        $user_id    = $request->input('user_id');
        $od_email   = $request->input('od_email');
        $page_move  = $request->input('page_move');

        $it_sel     = $request->input('it_sel');
        $ct_id      = $request->input('ct_id');     //장바구니 순번
        $sct_qty    = $request->input('sct_qty');   //수량

        $order_info = DB::table('shoporders')->where('order_id', $order_id)->first();
        if(is_null($order_info)){
            echo 'no_order';
            exit;
        }

        $mod_history = '';
        $user_name = Auth::user()->user_name;
        $user_id = Auth::user()->user_id;

        $mod_history = $order_info->od_mod_history; //히스토리 내역

        for($i = 0; $i < count($ct_id); $i++){
            if(isset($ct_chk[$i])){
                $cart_info = DB::table('shopcarts')->where([['od_id', $order_id], ['id', $ct_id[$i]]])->first();
                $item_info = DB::table('shopitems')->where('item_code', $cart_info->item_code)->first();

                if($cart_info->sct_qty != $sct_qty[$i]){
                    if($cart_info->sct_qty > $sct_qty[$i]){
                        if($cart_info->return_story == ""){

                            $cart_up = DB::table('shopcarts')->where([['od_id', $order_id], ['id', $ct_id[$i]]])->update([
                                'return_story'  => '그 외 기타사유',
                                'return_story_content' => '관리자 직접 처리',
                                'return_process' => 'Y',
                                'return_process_date'  => date("Y-m-d H:i:s", time()),
                            ]);
                        }else{
                            $cart_up = DB::table('shopcarts')->where([['od_id', $order_id], ['id', $ct_id[$i]]])->update([
                                'return_process' => 'Y',
                                'return_process_date'  => date("Y-m-d H:i:s", time()),
                            ]);
                        }

                        //$sct_option = mb_substr($cart_info->sct_option, 0, 20, 'utf-8');
                        if(strpos($cart_info->sct_option, " / ") !== false) {
                            $item_options = $cart_info->sct_option;
                        } else {
                            $item_options = "";
                        }

                        //제조사및 상품명 찾기
                        if($item_info->item_manufacture == "") $item_manufacture = "";
                        else $item_manufacture = "[".$item_info->item_manufacture."]";
                        //제목
                        $item_name = $item_manufacture.stripslashes($item_info->item_name);

                        $yoil = $CustomUtils->get_yoil(date("Y-m-d H:i:s", time()));

                        $mod_history .= '
                        <tr>
                            <td>'.date("Y-m-d H:i:s", time()).' ('.$yoil.')</td>
                            <td class="prod_name">
                                <div>'.$item_name.'</div>
                                <div>'.$item_options.'</div>
                            </td>
                            <td>교환</td>
                            <td>'.$sct_qty[$i].'</td>
                            <td>'.$cart_info->sct_qty_cancel.'</td>
                            <td class="buyer">
                                <div>'.$user_name.'</div>
                                <div>'.$user_id.'</div>
                            </td>
                        </tr>
                        ';
                        //$mod_history .= date("Y-m-d H:i:s", time()).' '.$sct_option_name.' 교환 '.$cart_info->sct_qty.' -> '.$sct_qty[$i].'  '.$user_name."   ".$user_id."\n";
                    }
                }
            }
        }

        $order_up = DB::table('shoporders')->where('order_id', $order_id)->update([
            'od_mod_history'    => $mod_history,
        ]);

        echo "ok";
        exit;
    }

    public function return_popup(Request $request)
    {
        $CustomUtils = new CustomUtils;

        $order_id   = $request->input('order_id');
        $cart_num   = $request->input('cart_num');

        $order_info = DB::table('shoporders')->where('order_id', $order_id)->first();
        $carts = DB::table('shopcarts')->where('id', $cart_num)->first();

/*
        if(isset($order_info) || isset($carts)){
            echo "
                <script>
                    alert('잘못된 경로 입니다);
                    window.close();
                </script>
            ";
            exit;
        }
*/
        $return_regi_date = "";
        if($carts->return_regi_date != "") $return_regi_date = $carts->return_regi_date."(".$CustomUtils->get_yoil($carts->return_regi_date).")";

        $return_process_date = "";
        if($carts->return_process_date != "") $return_process_date = $carts->return_process_date."(".$CustomUtils->get_yoil($carts->return_process_date).")";

        //상태
        $return_process_ment = "";
        $selected1 = "";
        $selected2 = "";
        $selected3 = "";
        switch($carts->return_process) {
            case 'N':
                $return_process_ment = "미처리";
                $selected1 = "selected";
            break;
            case 'Y':
                $return_process_ment = "교환";
                $selected2 = "selected";
            break;
            case 'T':
                $return_process_ment = "교환불가";
                $selected3 = "selected";
            break;
        }

        return view('adm.shop.order.return_info',[
            'CustomUtils'       => $CustomUtils,
            'order_id'          => $order_id,
            'cart_num'          => $cart_num,
            'return_regi_date'  => $return_regi_date,
            'return_process_date'   => $return_process_date,
            'return_story'      => $carts->return_story,
            'return_story_content'  => $carts->return_story_content,
            'return_process_ment'   => $return_process_ment,
            'sct_qty_cancel'   => $carts->sct_qty_cancel,
            'selected1'         => $selected1,
            'selected2'         => $selected2,
            'selected3'         => $selected3,
        ]);
    }

    public function return_popup_process(Request $request)
    {
        $CustomUtils = new CustomUtils;

        $order_id   = $request->input('order_id');
        $cart_num   = $request->input('cart_num');
        $return_process   = $request->input('return_process');
        $cancel_qty   = $request->input('cancel_qty');

        $order_info = DB::table('shoporders')->where('order_id', $order_id)->first();
        $cart_info = DB::table('shopcarts')->where('id', $cart_num)->first();
        $item_info = DB::table('shopitems')->where('item_code', $cart_info->item_code)->first();

        if($order_info == "" || $cart_info == "" || $item_info == ""){
            echo "
            <script>
                alert('잘못된 경로 입니다');
                window.close();
            </script>
            ";
        }

        switch($return_process) {
            case 'N':
                $return_process_ment = "미처리";
            break;
            case 'Y':
                $return_process_ment = "교환";
            break;
            case 'T':
                $return_process_ment = "교환불가";
            break;
        }

        $return_up = DB::table('shopcarts')->where([['id', $cart_num], ['od_id', $order_id]])->update([
            'return_process'          => $return_process,
            'return_process_date'      => date("Y-m-d H:i:s", time()),
        ]);

        if(strpos($cart_info->sct_option, " / ") !== false) {
            $item_options = $cart_info->sct_option;
        } else {
            $item_options = "";
        }

        $mod_history = $order_info->od_mod_history; //히스토리 내역

        $user_id = Auth::user()->user_id;
        $user_name = Auth::user()->user_name;

        //제조사및 상품명 찾기
        if($item_info->item_manufacture == "") $item_manufacture = "";
        else $item_manufacture = "[".$item_info->item_manufacture."]";
        //제목
        $item_name = $item_manufacture.stripslashes($item_info->item_name);

        $yoil = $CustomUtils->get_yoil(date("Y-m-d H:i:s", time()));

        $mod_history .= '
        <tr>
            <td>'.date("Y-m-d H:i:s", time()).' ('.$yoil.')</td>
            <td class="prod_name">
                <div>'.$item_name.'</div>
                <div>'.$item_options.'</div>
            </td>
            <td>'.$return_process_ment.'</td>
            <td>'.$cancel_qty.'</td>
            <td>'.$cart_info->sct_qty_cancel.'</td>
            <td class="buyer">
                <div>'.$user_name.'</div>
                <div>'.$user_id.'</div>
            </td>
        </tr>
        ';

        $order_up = DB::table('shoporders')->where('order_id', $order_id)->update([
            'od_mod_history'    => $mod_history,
        ]);

        echo "
            <script>
                opener.parent.location.reload();
                window.close();
            </script>
        ";
    }
}
