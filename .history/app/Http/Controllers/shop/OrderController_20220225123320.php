<?php
#############################################################################
#
#		파일이름		:		OrderController.php
#		파일설명		:		주문서 control
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 10월 01일
#		최종수정일		:		2021년 10월 01일
#
###########################################################################-->

namespace App\Http\Controllers\shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use App\Helpers\Custom\PageSet; //페이지 함수
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;    //인증
use App\Models\shopordertemps;    //결제 검증을 위한 임시 테이블
use App\Models\shoporders;  //주문서
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
        $this->middleware('auth'); //회원만 들어 오기
    }

    public function orderform(Request $request)
    {
        session_start();
        $CustomUtils = new CustomUtils;
        $Messages = $CustomUtils->language_pack(session()->get('multi_lang'));

        $sw_direct  = $request->input('sw_direct');     //장바구니 0, 바로구매 1

        $CustomUtils->set_session("ss_direct", $sw_direct);

        $parameter = "";
        if($sw_direct){
            $tmp_cart_id = $CustomUtils->get_session('ss_cart_direct');
            $parameter = "sw_direct=1";
        }else{
            $tmp_cart_id = $CustomUtils->get_session('ss_cart_id');
        }

        if ($CustomUtils->get_cart_count($tmp_cart_id) == 0){
            return redirect()->route('cartlist')->with('alert_messages', '장바구니가 비어 있습니다.');
            exit;
        }

        if(!$CustomUtils->before_check_cart_price($tmp_cart_id)){
            return redirect()->route('cartlist')->with('alert_messages', '장바구니 금액에 변동사항이 있습니다.\n상품을 삭제 후 다시 담아 주세요.');
            exit;
        }

        // 새로운 주문번호 생성
        $od_id = $CustomUtils->get_uniqid();
        $CustomUtils->set_session('ss_order_id', $od_id);
        $s_cart_id = $tmp_cart_id;

        $order_id = $CustomUtils->get_session('ss_order_id');   //실제 주문번호

        $tot_price = 0;
        $tot_point = 0;
        $tot_sell_price = 0;

        $goods = $goods_item_code = "";
        $goods_count = -1;

        $cart_infos = DB::table('shopcarts as a')
            ->select('a.*', 'b.sca_id', 'b.item_manufacture', 'b.item_price', 'b.item_give_point')
            ->leftjoin('shopitems as b', function($join) {
                    $join->on('a.item_code', '=', 'b.item_code');
                });
            //->where([['a.od_id',$tmp_cart_id], ['a.sct_select','1']])
            if($sw_direct){
                $cart_infos = $cart_infos->where([['a.od_id', $tmp_cart_id], ['a.sct_select','1'],['a.sct_direct', '1'], ['a.sct_status','쇼핑'], ['a.user_id', Auth::user()->user_id]]);
            }else{
                $cart_infos = $cart_infos->where([['a.od_id', $tmp_cart_id], ['a.sct_select','1'], ['a.sct_direct', '0'], ['a.sct_status','쇼핑'], ['a.user_id', Auth::user()->user_id]]);
            }
            //->groupBy('a.item_code')
            $cart_infos = $cart_infos->orderBy('a.id')->get();

        if(count($cart_infos) == 0){
            return redirect()->route('cartlist')->with('alert_messages', '주문 하실 상품이 없습니다.');
            exit;
        }

        $user_name = '';
        $user_tel = '';
        $user_phone = '';
        $user_zip = '';
        $user_addr1 = '';
        $user_addr2 = '';
        $user_addr3 = '';
        $user_addr_jibeon = '';
        $addr_list = "";

        if(Auth::user()){
            $user_info = DB::table('users')->where('user_id', Auth::user()->user_id)->first();

            if(Auth::user()->user_name != "") $user_name = $user_info->user_name;
            if(Auth::user()->user_tel != "") $user_tel = $user_info->user_tel;
            if(Auth::user()->user_phone != "") $user_phone = $user_info->user_phone;
            if(Auth::user()->user_zip != "") $user_zip = $user_info->user_zip;
            if(Auth::user()->user_addr1 != "") $user_addr1 = $user_info->user_addr1;
            if(Auth::user()->user_addr2 != "") $user_addr2 = $user_info->user_addr2;
            if(Auth::user()->user_addr3 != "") $user_addr3 = $user_info->user_addr3;
            if(Auth::user()->user_addr_jibeon != "") $user_addr_jibeon = $user_info->user_addr_jibeon;
            $user_point = $user_info->user_point;
            //배송지
            $address = DB::table('baesongjis')->where([['user_id', Auth::user()->user_id], ['ad_default','1']])->first();

            $addr_list .= '<button type="button" onclick="baesongji();">배송지 목록</button>';
        }else{
            // 주문자와 동일
            //$addr_list .= '<input type="checkbox" name="ad_sel_addr" value="same" id="ad_sel_addr_same">'.PHP_EOL;
            //$addr_list .= '<label for="ad_sel_addr_same">주문자와 동일</label>'.PHP_EOL;
        }

        $setting_info = DB::table('shopsettings')->select('de_send_cost','de_send_cost_free')->first(); //기본 배송비 구하기

        //$cart_count = DB::table('shopcarts')->select('item_code')->where([['od_id',$tmp_cart_id], ['sct_select','1']])->distinct('item_code')->count(); //장바구니 상품 개수
        $cart_count = DB::table('shopcarts')->select('item_code')->where([['od_id',$tmp_cart_id], ['sct_select','1']])->count(); //장바구니 상품 개수

        return view('shop.order_page',[
            's_cart_id'         => $s_cart_id,
            'cart_infos'        => $cart_infos,
            'CustomUtils'       => $CustomUtils,
            'de_send_cost'      => $setting_info->de_send_cost,
            'de_send_cost_free' => $setting_info->de_send_cost_free,
            'user_name'         => $user_name,
            'user_tel'          => $user_tel,
            'user_phone'        => $user_phone,
            'user_zip'          => $user_zip,
            'user_addr1'        => $user_addr1,
            'user_addr2'        => $user_addr2,
            'user_addr3'        => $user_addr3,
            'user_addr_jibeon'  => $user_addr_jibeon,
            'order_id'          => $order_id,
            'addr_list'         => $addr_list, //주문자 동일, 최근 배송지 히든 처리
            'tot_sell_price'    => $tot_sell_price,
            'send_cost'         => 0,
            'cart_count'        => $cart_count,
            'address'           => $address,
            'user_point'        => $user_point,
            'parameter'         => $parameter,
        ]);
    }

    //무통장 은행명 찾기
    public function ajax_orderbank(Request $request)
    {
        $CustomUtils = new CustomUtils;
        $Messages = $CustomUtils->language_pack(session()->get('multi_lang'));

        $setting_info = DB::table('shopsettings')->first();

        $str = '';
        $bank_account = '';

        // 은행계좌를 배열로 만든후
        $str = explode("\n", trim($setting_info->company_bank_account));

        $bank_account = '<label for="od_bank_account" class="sound_only">입금할 계좌</label>';

        if (count($str) <= 1)
        {
            $bank_account .= '<input type="hidden" name="od_bank_account" value="'.$str[0].'">'.$str[0].PHP_EOL;
        }
        else
        {
            $bank_account .= '<select name="od_bank_account" id="od_bank_account">'.PHP_EOL;
            $bank_account .= '<option value="">선택하십시오.</option>';
            for ($i=0; $i<count($str); $i++)
            {
                //$str[$i] = str_replace("\r", "", $str[$i]);
                $str[$i] = trim($str[$i]);
                $bank_account .= '<option value="'.$str[$i].'">'.$str[$i].'</option>'.PHP_EOL;
            }
            $bank_account .= '</select>'.PHP_EOL;
        }

        $bank_account .= '<br><label for="od_deposit_name">입금자명</label> ';
        $bank_account .= '<input type="text" name="od_deposit_name" id="od_deposit_name" size="10" maxlength="20">';
        echo $bank_account;
    }

    //재고체크
    public function ajax_orderstock(Request $request)
    {
        session_start();
        $CustomUtils = new CustomUtils;
        $Messages = $CustomUtils->language_pack(session()->get('multi_lang'));

        if($CustomUtils->get_session('ss_direct')){
            $tmp_cart_id = $CustomUtils->get_session('ss_cart_direct');
        }else{
            $tmp_cart_id = $CustomUtils->get_session('ss_cart_id');
        }

        if($CustomUtils->get_cart_count($tmp_cart_id) == 0){    // 장바구니에 담기
            echo json_encode(['messge' => 'no_cart']);
            exit;
        }

        //구매전 상품 내용 변경이 있는지 체크
        $item_chk = $CustomUtils->before_check_cart_price($tmp_cart_id);

        if(!$item_chk){     //변동 사항이 있을때
            echo json_encode(['messge' => 'variance_chk']);
            exit;
        }

        // 재고체크
        $qty_chks = DB::table('shopcarts')->where([['od_id',$tmp_cart_id], ['sct_select', '1'], ['sct_status', '쇼핑']])->get();

        foreach($qty_chks as $qty_chk){
            $ct_qty = $qty_chk->sct_qty;

            // 해당 상품이 품절 또는 판매중지 상태인지 체크합니다.
            $item_chks = DB::table('shopitems')->select('item_soldout', 'item_use', 'sca_id')->where('item_code', $qty_chk->item_code)->first();

            $category_str = '';
            $soldout_txt = '';
            $it_stock_qty = 0;

            // 분류에서 판매가능한지 체크합니다.
            if($item_chks->item_use && $item_chks->sca_id ){
                $cate_chks = DB::table('shopcategorys')->select('sca_display')->where('sca_id', $item_chks->sca_id)->get();

                foreach($cate_chks as $cate_chk){
                    if($cate_chk->sca_display != 'Y'){
                        $item_chks->item_use = false;
                        $category_str = '분류에서 ';
                    }
                }
            }

            if($item_chks->item_soldout || !$item_chks->item_use){
                $soldout_txt = $item_chks->item_soldout ? '품절' : $category_str.'판매중지';
                $item_option = $qty_chk->item_name;

                if($qty_chk->item_code) $item_option .= '('.$qty_chk->sct_option.')';

                echo json_encode(['message' => 'soldout', 'item_option' => $item_option, 'txt' => $soldout_txt]);
                exit;
            }

            if(!$qty_chk->sio_id){
                $it_stock_qty = $CustomUtils->get_item_stock_qty($qty_chk->item_code);
            }else{
                $it_stock_qty = $CustomUtils->get_option_stock_qty($qty_chk->item_code, $qty_chk->sio_id, $qty_chk->sio_type);
            }

            if ($ct_qty > $it_stock_qty)
            {
                $item_option = $qty_chk->item_name;
                if($qty_chk->sio_id) $item_option .= '('.$qty_chk->sct_option.')';

                echo json_encode(['message' => 'qty_lack', 'item_option' => $item_option, 'txt' => number_format($it_stock_qty)]);
                exit;
            }
        }

        echo json_encode(['message' => 'ok']);
        die("");
        exit;
    }

    //결제 검증 하기
    public function ajax_ordercomfirm(Request $request)
    {
        //header("Content-Type: application/json");
        session_start();
        $CustomUtils = new CustomUtils;

        $data = file_get_contents('php://input');
        parse_str($data, $output);

        $imp_uid        = $output['imp_uid'];
        $merchant_uid   = $output['merchant_uid'];
        $amount         = (int)$output['amount'];    //카드사 결제 금액

        $result = json_encode(['reason' => ''], JSON_PRETTY_PRINT);
        $http_status = 200; //성공시 200

        // 장바구니가 비어있는가
        if($CustomUtils->get_session("ss_direct")){
            $tmp_cart_id = $CustomUtils->get_session('ss_cart_direct');
        }else{
            $tmp_cart_id = $CustomUtils->get_session('ss_cart_id');
        }

        if ($CustomUtils->get_cart_count($tmp_cart_id) == 0) {    // 장바구니에 담기
            $CustomUtils->add_order_post_log($request->input(), '장바구니가 비어 있습니다.');
            //$result = json_encode(['reason' => '장바구니가 비어 있습니다.'], JSON_PRETTY_PRINT);
            $result = json_encode(['reason' => '장바구니가 비어 있습니다.'], JSON_UNESCAPED_UNICODE);
            $http_status = 201;
        }

        // 장바구니 상품 재고 검사
        $qty_chks = DB::table('shopcarts')->where([['od_id', $tmp_cart_id], ['sct_select', '1']])->get();

        $i = 0;
        $error = '';
        $error1 = '';

        foreach($qty_chks as $qty_chk){
            // 상품에 대한 현재고수량
            if($qty_chk->sio_id) {  //옵션 상품
                $it_stock_qty = (int)$CustomUtils->get_option_stock_qty($qty_chk->item_code, $qty_chk->sio_id, $qty_chk->sio_type);
            } else {
                $it_stock_qty = (int)$CustomUtils->get_item_stock_qty($qty_chk->item_code);
            }

            //삭제되거나 비출력된 상품인지 파악
            $item_chk = DB::table('shopitems')->where('item_code', $qty_chk->item_code)->first();

            if($item_chk->item_display == 'N' || $item_chk->item_del == 'Y')
            {
                $error .= $qty_chk->sct_option." 은 판매 중단된 상품입니다.";
                //$result = json_encode(['reason' => $error], JSON_PRETTY_PRINT);
                $result = json_encode(['reason' => $error], JSON_UNESCAPED_UNICODE);
                $http_status = 201;
            }

            // 장바구니 수량이 재고수량보다 많다면 오류
            if ($qty_chk->sct_qty > $it_stock_qty){
                $error .= $qty_chk->sct_option." 의 재고수량이 부족합니다. 현재고수량 : $it_stock_qty 개\n\n";
                //$result = json_encode(['reason' => $error], JSON_PRETTY_PRINT);
                $result = json_encode(['reason' => $error], JSON_UNESCAPED_UNICODE);
                $http_status = 201;
            }
            $i++;
        }

        if($i == 0) {
            $CustomUtils->add_order_post_log($request->input(), '장바구니가 비어 있습니다.');
            //$result = json_encode(['reason' => '장바구니가 비어 있습니다.'], JSON_PRETTY_PRINT);
            $result = json_encode(['reason' => '장바구니가 비어 있습니다.'], JSON_UNESCAPED_UNICODE);
            $http_status = 201;
        }

        if ($error != "")
        {
            $error1 = "다른 고객님께서 먼저 주문하신 경우입니다. 불편을 끼쳐 죄송합니다.";
            $CustomUtils->add_order_post_log($request->input(), $error1);
            //$result = json_encode(['reason' => $error1], JSON_PRETTY_PRINT);
            $result = json_encode(['reason' => $error1], JSON_UNESCAPED_UNICODE);
            $http_status = 201;
        }

        $ordertemp = DB::table('shopordertemps')->where([['od_id',$tmp_cart_id], ['user_id', Auth::user()->user_id]])->first();

        $i_price        = (int)$ordertemp->od_cart_price;
        $i_de_send_cost = (int)$ordertemp->de_send_cost; //기본 배송비
        $i_send_cost    = (int)$ordertemp->od_send_cost;    //각 상품 배송비
        $i_send_cost2   = (int)$ordertemp->od_send_cost2;
        $i_temp_point   = (int)$ordertemp->od_receipt_point;
        $tot_price      = $i_price + $i_de_send_cost + $i_send_cost + $i_send_cost2;
        $tot_payment    = $tot_price - $i_temp_point;   //실제 결제 금액

        // 주문금액이 상이함
        $price = DB::select(" select SUM(IF(sio_type = 1, (sio_price * sct_qty), ((sct_price + sio_price) * sct_qty))) as od_price, COUNT(distinct item_code) as cart_count from shopcarts where od_id = '$tmp_cart_id' and sct_select = '1' ");

        $tot_ct_price = $price[0]->od_price;
        $cart_count = $price[0]->cart_count;
        $tot_od_price = $tot_ct_price;

        if($i_price != $tot_od_price){
            $error1 = '주문금액이 변경 되었습니다.';
            $CustomUtils->add_order_post_log($request->input(), $error1);
            //$result = json_encode(['reason' => $error1], JSON_PRETTY_PRINT);
            $result = json_encode(['reason' => $error1], JSON_UNESCAPED_UNICODE);
            $http_status = 201;
        }

        //기본 배송비 상이함
        $setting_info = DB::table('shopsettings')->select('de_send_cost')->first(); //기본 배송비 구하기
        if($setting_info->de_send_cost != $ordertemp->de_send_cost){
            $error1 = '기본 배송비가 변경 되었습니다.';
            $CustomUtils->add_order_post_log($request->input(), $error1);
            //$result = json_encode(['reason' => $error1], JSON_PRETTY_PRINT);
            $result = json_encode(['reason' => $error1], JSON_UNESCAPED_UNICODE);
            $http_status = 201;
        }

        //각 상품 배송비가 상이함
        $send_cost = $CustomUtils->get_sendcost($tmp_cart_id);
        if($i_send_cost != $send_cost){
            $error1 = '배송비가 변경 되었습니다.';
            $CustomUtils->add_order_post_log($request->input(), $error1);
            //$result = json_encode(['reason' => $error1], JSON_PRETTY_PRINT);
            $result = json_encode(['reason' => $error1], JSON_UNESCAPED_UNICODE);
            $http_status = 201;
        }

        // 추가배송비가 상이함
        //$od_b_zip   = preg_replace('/[^0-9]/', '', $ordertemp->ad_zip1);
        $od_b_zip   = $ordertemp->ad_zip1;
        $sendcost_info = DB::table('sendcosts')->select('id', 'sc_price')->where([['sc_zip1', '<=', $od_b_zip], ['sc_zip2', '>=', $od_b_zip]])->first();

        if($i_send_cost2 != (int)$sendcost_info->sc_price){
            $error1 = '추가배송비가 변경 되었습니다.';
            $CustomUtils->add_order_post_log($request->input(), $error1);
            //$result = json_encode(['reason' => $error1], JSON_PRETTY_PRINT);
            $result = json_encode(['reason' => $error1], JSON_UNESCAPED_UNICODE);
            $http_status = 201;
        }

        // 결제포인트가 상이함
        if($i_temp_point > $CustomUtils->get_point_sum(Auth::user()->user_id)){
            $error1 = '보유 적립금 보다 많이 결제할 수 없습니다.';
            $CustomUtils->add_order_post_log($request->input(), $error1);
            //$result = json_encode(['reason' => $error1], JSON_PRETTY_PRINT);
            $result = json_encode(['reason' => $error1], JSON_UNESCAPED_UNICODE);
            $http_status = 201;
        }

        if($i_temp_point > $tot_price){
            $error1 = '주문금액 보다 많이 적립금을 결제할 수 없습니다.';
            $CustomUtils->add_order_post_log($request->input(), $error1);
            //$result = json_encode(['reason' => $error1], JSON_PRETTY_PRINT);
            $result = json_encode(['reason' => $error1], JSON_UNESCAPED_UNICODE);
            $http_status = 201;
        }

        //카드사에서 전달받은 결제금액과 서버에 저장 된 결제 금액이 다를때 체크
        if($tot_payment != $amount){
            $error1 = '주문금액이 변경 되었습니다.';
            $CustomUtils->add_order_post_log($request->input(), $error1);
            //$result = json_encode(['reason' => $error1], JSON_PRETTY_PRINT);
            $result = json_encode(['reason' => $error1], JSON_UNESCAPED_UNICODE);
            $http_status = 201;
        }

        return response()->json(['reason' => $result], $http_status, [], JSON_PRETTY_PRINT);
        exit;
    }

    public function ajax_ordertemp(Request $request)
    {
        //결제전 검증을 위한 임시 테이블 저장
        $order_id           = $request->input('order_id');
        $od_id              = $request->input('od_id');
        $od_cart_price      = (int)$request->input('od_cart_price');
        $de_send_cost       = (int)$request->input('de_send_cost');  //기본 배송비
        $de_send_cost_free  = (int)$request->input('de_send_cost_free');  //기본 배송비 무료 정책 추가
        $od_send_cost       = (int)$request->input('od_send_cost');  //각 상품 배송비
        $od_send_cost2      = (int)$request->input('od_send_cost2');
        $od_receipt_price   = (int)$request->input('od_receipt_price');
        $od_temp_point      = (int)$request->input('od_temp_point');
        $od_b_zip           = $request->input('od_b_zip');
        $item_give_point    = $request->input('item_give_point');


        $od_pg              = $request->input('pg');
        $od_settle_case     = $request->input('method');
        $ad_name            = $request->input('od_b_name');
        $ad_tel             = $request->input('od_b_tel');
        $ad_hp              = $request->input('od_b_hp');
        //$ad_zip1            = $request->input('od_b_zip');
        $ad_addr1           = $request->input('od_b_addr1');
        $ad_addr2           = $request->input('od_b_addr2');
        $ad_addr3           = $request->input('od_b_addr3');
        $ad_jibeon          = $request->input('od_b_addr_jibeon');
        $od_memo            = $request->input('od_memo');
        $od_cart_count      = $request->input('cart_count');

        var_dump("cart_count===> ".$cart_count);
        var_dump("od_settle_case===> ".$od_settle_case);
exit;
        //20220204일 결제 금액 - 사용 포인트 * 환경 설정 적립률로 바꿈 !!!!
        //$tot_item_point     = (int)$request->input('tot_item_point');

        $ordertemp_cnt = DB::table('shopordertemps')->where([['od_id',$od_id], ['user_id', Auth::user()->user_id]])->count();

        //주문금액 배송비 무료 정책 추가(211112)
        if($od_cart_price >= $de_send_cost_free){
            $tmp_de_send_cost = 0;
        }else{
            //무료배송비 정책 금액 이하 일때
            $tmp_de_send_cost = $de_send_cost;
            $de_send_cost_free = 0;
        }

        //20220204일 주문 금액 - 사용 포인트 * 환경 설정 적립률로 바꿈 !!!!
        $setting_info = CustomUtils::setting_infos();
        //220207 (상품 금액 - 적립금 미제공 금액) - 사용포인트
        $tmp1 = ($od_cart_price - $item_give_point) - $od_temp_point;
        if($tmp1 > 0){
            $tot_item_point = $tmp1 * ($setting_info->tot_item_point / 100);
        }else{
            $tot_item_point = 0;
        }

        if($ordertemp_cnt == 0){
            $create_result = shopordertemps::create([
                'order_id'          => $order_id,
                'od_id'             => $od_id,
                'user_id'           => Auth::user()->user_id,
                'od_cart_price'     => $od_cart_price,
                'de_send_cost'      => $de_send_cost,
                'de_send_cost_free' => $de_send_cost_free,
                'od_send_cost'      => $od_send_cost,
                'od_send_cost2'     => $od_send_cost2,
                'od_receipt_price'  => $od_receipt_price,
                'od_receipt_point'  => $od_temp_point,
                'tot_item_point'    => $tot_item_point,
                'ad_zip1'           => $od_b_zip,
                'od_ip'             => $_SERVER["REMOTE_ADDR"],

                'od_pg'             => $od_pg,
                'od_settle_case'    => $od_settle_case,
                'ad_name'           => $ad_name,
                'ad_tel'            => $ad_tel,
                'ad_hp'             => $ad_hp,
                'ad_addr1'          => $ad_addr1,
                'ad_addr2'          => $ad_addr2,
                'ad_addr3'          => $ad_addr3,
                'ad_jibeon'         => $ad_jibeon,
                'od_memo'           => $od_memo,
                'od_cart_count'     => $od_cart_count,
            ])->exists();
        }else{
            $update_result = DB::table('shopordertemps')->where([['od_id', $od_id], ['user_id', Auth::user()->user_id]])->update([
                'order_id'          => $order_id,
                'od_cart_price'     => $od_cart_price,
                'de_send_cost'      => $de_send_cost,
                'de_send_cost_free' => $de_send_cost_free,
                'od_send_cost'      => $od_send_cost,
                'od_send_cost2'     => $od_send_cost2,
                'od_receipt_price'  => $od_receipt_price,
                'od_receipt_point'  => $od_temp_point,
                'tot_item_point'    => $tot_item_point,
                'ad_zip1'           => $od_b_zip,
                'od_ip'             => $_SERVER["REMOTE_ADDR"],

                'od_pg'             => $od_pg,
                'od_settle_case'    => $od_settle_case,
                'ad_name'           => $ad_name,
                'ad_tel'            => $ad_tel,
                'ad_hp'             => $ad_hp,
                'ad_addr1'          => $ad_addr1,
                'ad_addr2'          => $ad_addr2,
                'ad_addr3'          => $ad_addr3,
                'ad_jibeon'         => $ad_jibeon,
                'od_memo'           => $od_memo,
                'od_cart_count'     => $od_cart_count,
            ]);
        }
    }

    public function ajax_orderpaycancel(Request $request)
    {
        $CustomUtils = new CustomUtils;

        //결제 취소
        $imp_uid                = $request->input('imp_uid');
        $merchant_uid           = $request->input('merchant_uid');  //order 테이블의 order_id 값
        $cancel_request_amount  = $request->input('cancel_request_amount');
        $reason                 = $request->input('reason');
        $refund_holder          = $request->input('refund_holder');
        $refund_bank            = $request->input('refund_bank');
        $refund_account         = $request->input('refund_account');

        $order_id               = $merchant_uid;

        $refund_chk = $CustomUtils->payrefund_chk(Auth::user()->user_id, $order_id, $cancel_request_amount);
        if($refund_chk == true){
            $cancel_result = Iamport::cancelPayment($imp_uid, $cancel_request_amount, $reason); //실제 취소 이루어 지는 부분

            if($cancel_result->success == true){
                $refund_update = $CustomUtils->payrefund_update(Auth::user()->user_id, $order_id, $cancel_request_amount);
                echo "ok";
                exit;
            }else{
                echo "error";
                exit;
            }
        }else{
            echo "end";
            exit;
        }
    }

    //결제 하기
    public function orderpayment(Request $request)
    {
        $CustomUtils = new CustomUtils;
        $Messages = $CustomUtils->language_pack(session()->get('multi_lang'));

        /*
        //기본 배송지 처리
        $ad_default         = $request->input('ad_default'); //기본 배송지 체크여부
        $ad_subject         = $request->input('ad_subject'); //배송지명
        $od_b_name          = $request->input('od_b_name');  //이름
        $od_b_tel           = $request->input('od_b_tel');    //전화번호
        $od_b_hp            = $request->input('od_b_hp');  //핸드폰
        $od_b_zip           = $request->input('od_b_zip');    //우편번호
        $od_b_addr1         = $request->input('od_b_addr1');    //주소
        $od_b_addr2         = $request->input('od_b_addr2');    //상세주소
        $od_b_addr3         = $request->input('od_b_addr3');    //참고항목
        $od_b_addr_jibeon   = $request->input('od_b_addr_jibeon');    //지번(지번인지 도로명인지)

        $CustomUtils->baesongji_process($ad_default, $ad_subject, $od_b_name, $od_b_tel, $od_b_hp, $od_b_zip, $od_b_addr1, $od_b_addr2, $od_b_addr3, $od_b_addr_jibeon);
        //기본 배송지 처리 끝
        */

        //변수 받기
        $order_id           = $request->input('order_id');
        $od_id              = $request->input('od_id');
        $od_deposit_name    = Auth::user()->user_name;
        $ad_name            = $request->input('od_b_name');
        $ad_tel             = $request->input('od_b_tel');
        $ad_hp              = $request->input('od_b_hp');
        $ad_zip1            = $request->input('od_b_zip');
        $ad_addr1           = $request->input('od_b_addr1');
        $ad_addr2           = $request->input('od_b_addr2');
        $ad_addr3           = $request->input('od_b_addr3');
        $ad_jibeon          = $request->input('od_b_addr_jibeon');
        $od_memo            = $request->input('od_memo');
        $od_cart_count      = $request->input('cart_count');

        $ordertemp = DB::table('shopordertemps')->where([['order_id', $order_id], ['od_id', $od_id], ['user_id', Auth::user()->user_id]])->first();

        //예외 처리
        if(!$ordertemp){
            return redirect()->route('cartlist')->with('alert_messages', '잠시 시스템 장애가 발생 하였습니다. 관리자에게 문의 하세요.-2');
            exit;
        }

        $od_cart_price      = $ordertemp->od_cart_price;
        $de_send_cost       = $ordertemp->de_send_cost;
        $de_send_cost_free  = $ordertemp->de_send_cost_free;
        $od_send_cost       = $ordertemp->od_send_cost;
        $od_send_cost2      = $ordertemp->od_send_cost2;
        $od_receipt_price   = $ordertemp->od_receipt_price;
        $od_receipt_point   = $ordertemp->od_receipt_point;
        $tot_item_point     = $ordertemp->tot_item_point;
        $od_receipt_time    = date('Y-m-d H:i:s', time());
        $od_status          = '입금';
        $od_pg              = $request->input('pg');
        $od_settle_case     = $request->input('method');
        $imp_uid            = $request->input('imp_uid');
        $imp_apply_num      = $request->input('apply_num'); //카드사에서 전달 받는 값(카드 승인번호)
        $imp_paid_amount    = $request->input('paid_amount');  //카드사에서 받은 최종 결제 금액
        $imp_merchant_uid   = $request->input('imp_merchant_uid');
        $pg_provider        = $request->input('pg_provider');   //결제승인/시도된 PG사
        $od_shop_memo       = '';
        $imp_card_name      = $request->input('imp_card_name');   //카드사에서 전달 받는 값(카드사명칭)
        $imp_card_quota     = $request->input('imp_card_quota');   //카드사에서 전달 받는 값(할부개월수)
        $imp_card_number    = $request->input('imp_card_number');   //카드사에서 전달 받는 값(카드번호)

        $aa = Iamport::getPayment($imp_uid);

        var_dump($aa->data->__get('merchant_uid'));



exit;
        //예외 처리
        if($imp_apply_num == "" || $imp_apply_num == "0" || $imp_paid_amount == "" || $imp_paid_amount == "0" || $imp_merchant_uid == "" || $imp_merchant_uid == "0" || $imp_uid == "" || $imp_uid == "0"){
            return redirect()->route('cartlist')->with('alert_messages', '잠시 시스템 장애가 발생 하였습니다. 관리자에게 문의 하세요.-3');
            exit;
        }
/*
//데스트 위함
$imp_paid_amount = 7500;
$imp_uid = 'imp_1212';
$imp_apply_num= '12345678';
*/
        //예외 처리(카드사에서 보내온 결제 금액과 order에 저장 되는 결제금액이 같은가?)
        $real_card_price    = $od_receipt_price - $od_receipt_point;

        //주문 당시 관리자 페이지 포인트 적립률 구하기
        $setting_info = CustomUtils::setting_infos();

        if($imp_paid_amount != $real_card_price){
            return redirect()->route('cartlist')->with('alert_messages', '잠시 시스템 장애가 발생 하였습니다. 관리자에게 문의 하세요.-1');
            exit;
        }else{
            $create_result = shoporders::create([
                'order_id'          => $order_id,
                'od_id'             => $od_id,
                'user_id'           => Auth::user()->user_id,
                'od_deposit_name'   => $od_deposit_name,
                'ad_name'           => $ad_name,
                'ad_tel'            => $ad_tel,
                'ad_hp'             => $ad_hp,
                'ad_zip1'           => $ad_zip1,
                'ad_addr1'          => $ad_addr1,
                'ad_addr2'          => $ad_addr2,
                'ad_addr3'          => $ad_addr3,
                'ad_jibeon'         => $ad_jibeon,
                'od_memo'           => $od_memo,
                'od_cart_count'     => (int)$od_cart_count,
                'od_cart_price'     => (int)$od_cart_price,
                'de_send_cost'      => (int)$de_send_cost,
                'de_send_cost_free' => (int)$de_send_cost_free,
                'od_send_cost'      => (int)$od_send_cost,
                'od_send_cost2'     => (int)$od_send_cost2,
                'od_receipt_price'  => (int)$od_receipt_price,
                'od_receipt_point'  => (int)$od_receipt_point,
                'real_card_price'   => (int)$real_card_price,
                'od_receipt_time'   => $od_receipt_time,
                'od_shop_memo'      => $od_shop_memo,
                'od_status'         => $od_status,
                'od_settle_case'    => $od_settle_case,
                'od_pg'             => $od_pg,
                'imp_uid'           => $imp_uid,
                'imp_apply_num'     => $imp_apply_num,
                'imp_card_name'     => $imp_card_name,
                'imp_card_quota'    => $imp_card_quota,
                'imp_card_number'   => $imp_card_number,
                'od_ip'             => $_SERVER["REMOTE_ADDR"],
                'tot_item_point'    => $tot_item_point,
                'set_tot_item_point'    => $setting_info->tot_item_point,
                'od_delivery_company'   => $setting_info->send_company_name,
                'od_delivery_tel'   => $setting_info->send_company_tel,
                'od_delivery_url'   => $setting_info->send_company_url,
            ])->exists();

            if($create_result){
                $update_result = DB::table('shopcarts')->where([['od_id', $od_id], ['user_id', Auth::user()->user_id], ['sct_select','1']])->update([
                    'sct_status'    => $od_status,
                    'od_id'         => $order_id,
                ]);

                //구매 완료시 상품 재고 정리
                $CustomUtils->item_qty($order_id, 'minus');

                //포인트를 사용했다면 테이블에 사용을 추가
                if ($od_receipt_point > 0){
                    $CustomUtils->insert_point(Auth::user()->user_id, (-1) * $od_receipt_point, "상품 구매", 7, '', $order_id);
                }

                //상품 구매 포인트가 있다면
                if($tot_item_point > 0){
                    //상품 구매 포인트
                    $CustomUtils->insert_point(Auth::user()->user_id, $tot_item_point, "구매 적립", 8, '', $order_id);
                }

                return redirect()->route('mypage.orderview');
                exit;
            }
        }

        //return redirect()->route('mypage.orderview');
        //exit;
    }

}
