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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;    //인증
use App\Models\shopordertemps;    //장바구니 키
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
        session_start();
        $this->middleware('auth'); //회원만 들어 오기
    }

    public function orderform(Request $request)
    {
        $CustomUtils = new CustomUtils;
        $Messages = $CustomUtils->language_pack(session()->get('multi_lang'));

        $sw_direct  = $request->input('sw_direct');     //장바구니 0, 바로구매 1

        $CustomUtils->set_session("ss_direct", $sw_direct);

        if($sw_direct){
            $tmp_cart_id = $CustomUtils->get_session('ss_cart_direct');
        }else{
            $tmp_cart_id = $CustomUtils->get_session('ss_cart_id');
        }

        if ($CustomUtils->get_cart_count($tmp_cart_id) == 0){
            return redirect()->route('cartlist')->with('alert_messages', '장바구니가 비어 있습니다.');
            exit;
        }

        if(!$CustomUtils->before_check_cart_price($tmp_cart_id)){
            return redirect()->route('cartlist')->with('alert_messages', '장바구니 금액에 변동사항이 있습니다.\n장바구니를 다시 확인해 주세요.');
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
            ->select('a.id', 'a.item_code', 'a.item_name', 'a.sct_price', 'a.sct_point', 'a.sct_qty', 'a.sct_status', 'a.sct_send_cost', 'a.item_sc_type', 'b.sca_id')
            ->leftjoin('shopitems as b', function($join) {
                    $join->on('a.item_code', '=', 'b.item_code');
                })
            ->where([['a.od_id',$tmp_cart_id], ['a.sct_select','1']])
            ->groupBy('a.item_code')
            ->orderBy('a.id')
            ->get();

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
            if(Auth::user()->user_name != "") $user_name = Auth::user()->user_name;
            if(Auth::user()->user_tel != "") $user_tel = Auth::user()->user_tel;
            if(Auth::user()->user_phone != "") $user_phone = Auth::user()->user_phone;
            if(Auth::user()->user_zip != "") $user_zip = Auth::user()->user_zip;
            if(Auth::user()->user_addr1 != "") $user_addr1 = Auth::user()->user_addr1;
            if(Auth::user()->user_addr2 != "") $user_addr2 = Auth::user()->user_addr2;
            if(Auth::user()->user_addr3 != "") $user_addr3 = Auth::user()->user_addr3;
            if(Auth::user()->user_addr_jibeon != "") $user_addr_jibeon = Auth::user()->user_addr_jibeon;

/*
            // 기본배송지
            $default_baesongji = DB::table('baesongjis')->where([['user_id', Auth::user()->user_id], ['ad_default','1']])->first();

            $sep = chr(30);
            $val1 = "";

            // 주문자와 동일
            $addr_list .= '<input type="radio" name="ad_sel_addr" value="same" id="ad_sel_addr_same">'.PHP_EOL;
            $addr_list .= '<label for="ad_sel_addr_same">주문자와 동일</label>'.PHP_EOL;

            if(isset($default_baesongji->id) && $default_baesongji->id) {
                $val1 = $default_baesongji->ad_name.$sep.$default_baesongji->ad_tel.$sep.$default_baesongji->ad_hp.$sep.$default_baesongji->ad_zip1.$sep.$default_baesongji->ad_addr1.$sep.$default_baesongji->ad_addr2.$sep.$default_baesongji->ad_addr3.$sep.$default_baesongji->ad_jibeon.$sep.$default_baesongji->ad_subject;
                $addr_list .= '<input type="radio" name="ad_sel_addr" value="'.$val1.'" id="ad_sel_addr_def">'.PHP_EOL;
                $addr_list .= '<label for="ad_sel_addr_def">기본배송지</label>'.PHP_EOL;
            }

            // 최근배송지
            $lately_baesongji = DB::table('baesongjis')->where([['user_id', Auth::user()->user_id], ['ad_default','0']])->orderBy('id', 'desc')->first();
            if(!is_null($lately_baesongji)){
                if($lately_baesongji->ad_subject == "") $disp_list = $lately_baesongji->ad_name;
                else $disp_list = $lately_baesongji->ad_subject;

                $val1 = $lately_baesongji->ad_name.$sep.$lately_baesongji->ad_tel.$sep.$lately_baesongji->ad_hp.$sep.$lately_baesongji->ad_zip1.$sep.$lately_baesongji->ad_addr1.$sep.$lately_baesongji->ad_addr2.$sep.$lately_baesongji->ad_addr3.$sep.$lately_baesongji->ad_jibeon.$sep.$lately_baesongji->ad_subject;
                $val2 = '<label for="ad_sel_addr_1">최근배송지('.$disp_list.')</label>';
                $addr_list .= '<input type="radio" name="ad_sel_addr" value="'.$val1.'" id="ad_sel_addr_1"> '.PHP_EOL.$val2.PHP_EOL;
            }
*/
            //$addr_list .= '<input type="radio" name="ad_sel_addr" value="new" id="od_sel_addr_new">'.PHP_EOL;
            //$addr_list .= '<label for="od_sel_addr_new">신규배송지</label>'.PHP_EOL;

            $addr_list .= '<button type="button" onclick="baesongji();">배송지 목록</button>';
        }else{
            // 주문자와 동일
            //$addr_list .= '<input type="checkbox" name="ad_sel_addr" value="same" id="ad_sel_addr_same">'.PHP_EOL;
            //$addr_list .= '<label for="ad_sel_addr_same">주문자와 동일</label>'.PHP_EOL;
        }

        $setting_info = DB::table('shopsettings')->first();

        return view('shop.order_page',[
            's_cart_id'     => $s_cart_id,
            'cart_infos'    => $cart_infos,
            'CustomUtils'   => $CustomUtils,
            'setting_info'  => $setting_info,
            'user_name'     => $user_name,
            'user_tel'      => $user_tel,
            'user_phone'    => $user_phone,
            'user_zip'      => $user_zip,
            'user_addr1'    => $user_addr1,
            'user_addr2'    => $user_addr2,
            'user_addr3'    => $user_addr3,
            'user_addr_jibeon'  => $user_addr_jibeon,
            'order_id'      => $order_id,
            'addr_list'     => $addr_list, //주문자 동일, 최근 배송지 히든 처리
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
        $CustomUtils = new CustomUtils;

        $imp_uid        = $request->input('imp_uid');
        $merchant_uid   = $request->input('merchant_uid');
        $amount         = (int)$request->input('amount');    //카드사 결제 금액

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
            if($qty_chk->sio_id) {
                $it_stock_qty = (int)$CustomUtils->get_option_stock_qty($qty_chk->item_code, $qty_chk->sio_id, $qty_chk->sio_type);
            } else {
                $it_stock_qty = (int)$CustomUtils->get_item_stock_qty($qty_chk->item_code);
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
        $i_send_cost    = (int)$ordertemp->od_send_cost;
        $i_send_cost2   = (int)$ordertemp->od_send_cost2;
        $i_temp_point   = (int)$ordertemp->od_receipt_point;
        $tot_price      = $i_price + $i_send_cost + $i_send_cost2;
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

        // 배송비가 상이함
        $send_cost = $CustomUtils->get_sendcost($tmp_cart_id);
        if($i_send_cost != $send_cost){
            $error1 = '배송비가 변경 되었습니다.';
            $CustomUtils->add_order_post_log($request->input(), $error1);
            //$result = json_encode(['reason' => $error1], JSON_PRETTY_PRINT);
            $result = json_encode(['reason' => $error1], JSON_UNESCAPED_UNICODE);
            $http_status = 201;
        }

        // 추가배송비가 상이함
        $od_b_zip   = preg_replace('/[^0-9]/', '', $ordertemp->ad_zip1);
        $sendcost_info = DB::table('sendcosts')->select('id', 'sc_price')->where([['sc_zip1', '<=', $od_b_zip], ['sc_zip2', '>=', $od_b_zip]])->first();

        if($i_send_cost2 != (int)$sendcost_info->sc_price){
            $error1 = '추가배송비가 변경 되었습니다.';
            $CustomUtils->add_order_post_log($request->input(), $error1);
            //$result = json_encode(['reason' => $error1], JSON_PRETTY_PRINT);
            $result = json_encode(['reason' => $error1], JSON_UNESCAPED_UNICODE);
            $http_status = 201;
        }

        // 결제포인트가 상이함
        if($i_temp_point > Auth::user()->user_point){
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
        $od_cart_price      = $request->input('od_cart_price');
        $od_send_cost       = $request->input('od_send_cost');
        $od_send_cost2      = $request->input('od_send_cost2');
        $od_receipt_price   = $request->input('od_receipt_price');
        $od_temp_point      = $request->input('od_temp_point');
        $od_b_zip           = $request->input('od_b_zip');

        $ordertemp_cnt = DB::table('shopordertemps')->where([['od_id',$od_id], ['user_id', Auth::user()->user_id]])->count();

        if($ordertemp_cnt == 0){
            $create_result = shopordertemps::create([
                'order_id'          => $order_id,
                'od_id'             => $od_id,
                'user_id'           => Auth::user()->user_id,
                'od_cart_price'     => $od_cart_price,
                'od_send_cost'      => $od_send_cost,
                'od_send_cost2'     => $od_send_cost2,
                'od_receipt_price'  => $od_receipt_price,
                'od_receipt_point'  => $od_temp_point,
                'ad_zip1'           => $od_b_zip,
                'od_ip'             => $_SERVER["REMOTE_ADDR"],
            ])->exists();
        }else{
            $update_result = DB::table('shopordertemps')->where([['od_id', $od_id], ['user_id', Auth::user()->user_id]])->update([
                'order_id'          => $order_id,
                'od_cart_price'     => $od_cart_price,
                'od_send_cost'      => $od_send_cost,
                'od_send_cost2'     => $od_send_cost2,
                'od_receipt_price'  => $od_receipt_price,
                'od_receipt_point'  => $od_temp_point,
                'ad_zip1'           => $od_b_zip,
                'od_ip'             => $_SERVER["REMOTE_ADDR"],
            ]);
        }
    }

    public function ajax_orderpaycancel(Request $request)
    {
        //결제시 상품 변동등 문제가 있을시 결제 취소를 하기 위함
        //confirm_url 로 대체 됨 나중에 삭제
        $merchant_uid  = $request->input('merchant_uid');
        $cancel_request_amount  = $request->input('cancel_request_amount');
        $reason  = $request->input('reason');
        $refund_holder  = $request->input('refund_holder');
        $refund_bank  = $request->input('refund_bank');
        $refund_account  = $request->input('refund_account');

        $aa = Iamport::cancelPayment('imp_370953301637','93299','test');
dd($aa);
exit;
        //require_once '../../vendor/autoload.php';
echo $cancel_request_amount;
    }

    //결제 하기
    public function orderpayment(Request $request)
    {
        $CustomUtils = new CustomUtils;
        $Messages = $CustomUtils->language_pack(session()->get('multi_lang'));

        // 장바구니가 비어있는가?
        if($CustomUtils->get_session("ss_direct")){
            $tmp_cart_id = $CustomUtils->get_session('ss_cart_direct');
        }else{
            $tmp_cart_id = $CustomUtils->get_session('ss_cart_id');
        }

        //$sw_direct  = $request->input('sw_direct');     //장바구니 0, 바로구매 1

        if ($CustomUtils->get_cart_count($tmp_cart_id) == 0) {    // 장바구니에 담기
            $CustomUtils->add_order_post_log($request->input(), '장바구니가 비어 있습니다.');
            return redirect()->route('cartlist')->with('alert_messages', '장바구니가 비어 있습니다.\\n\\n이미 주문하셨거나 장바구니에 담긴 상품이 없는 경우입니다.');
            exit;
        }

        //기본 배송지 처리
        $ad_default = $request->input('ad_default'); //기본 배송지 체크여부
        $ad_subject = $request->input('ad_subject'); //배송지명
        $od_b_name = $request->input('od_b_name');  //이름
        $od_b_tel = $request->input('od_b_tel');    //전화번호
        $od_b_hp = $request->input('od_b_hp');  //핸드폰
        $od_b_zip = $request->input('od_b_zip');    //우편번호
        $od_b_addr1 = $request->input('od_b_addr1');    //주소
        $od_b_addr2 = $request->input('od_b_addr2');    //상세주소
        $od_b_addr3 = $request->input('od_b_addr3');    //참고항목
        $od_b_addr_jibeon = $request->input('od_b_addr_jibeon');    //지번(지번인지 도로명인지)

        $CustomUtils->baesongji_process($ad_default, $ad_subject, $od_b_name, $od_b_tel, $od_b_hp, $od_b_zip, $od_b_addr1, $od_b_addr2, $od_b_addr3, $od_b_addr_jibeon);
        //기본 배송지 처리 끝

        //결제 방법
        $pg = $request->input('pg');
        $method = $request->input('method');

        $order_id = $CustomUtils->get_session('ss_order_id');




/*
// 주문서에 입력
$sql = " insert {$g5['g5_shop_order_table']}
            set od_id             = '$od_id',
                mb_id             = '{$member['mb_id']}',
                od_pwd            = '$od_pwd',
                od_name           = '$od_name',
                od_email          = '$od_email',
                od_tel            = '$od_tel',
                od_hp             = '$od_hp',
                od_zip1           = '$od_zip1',
                od_zip2           = '$od_zip2',
                od_addr1          = '$od_addr1',
                od_addr2          = '$od_addr2',
                od_addr3          = '$od_addr3',
                od_addr_jibeon    = '$od_addr_jibeon',
                od_b_name         = '$od_b_name',
                od_b_tel          = '$od_b_tel',
                od_b_hp           = '$od_b_hp',
                od_b_zip1         = '$od_b_zip1',
                od_b_zip2         = '$od_b_zip2',
                od_b_addr1        = '$od_b_addr1',
                od_b_addr2        = '$od_b_addr2',
                od_b_addr3        = '$od_b_addr3',
                od_b_addr_jibeon  = '$od_b_addr_jibeon',
                od_deposit_name   = '$od_deposit_name',
                od_memo           = '$od_memo',
                od_cart_count     = '$cart_count',
                od_cart_price     = '$tot_ct_price',
                od_cart_coupon    = '$tot_it_cp_price',
                od_send_cost      = '$od_send_cost',
                od_send_coupon    = '$tot_sc_cp_price',
                od_send_cost2     = '$od_send_cost2',
                od_coupon         = '$tot_od_cp_price',
                od_receipt_price  = '$od_receipt_price',
                od_receipt_point  = '$od_receipt_point',
                od_bank_account   = '$od_bank_account',
                od_receipt_time   = '$od_receipt_time',
                od_misu           = '$od_misu',
                od_pg             = '$od_pg',
                od_tno            = '$od_tno',
                od_app_no         = '$od_app_no',
                od_escrow         = '$od_escrow',
                od_tax_flag       = '$od_tax_flag',
                od_tax_mny        = '$od_tax_mny',
                od_vat_mny        = '$od_vat_mny',
                od_free_mny       = '$od_free_mny',
                od_status         = '$od_status',
                od_shop_memo      = '',
                od_hope_date      = '$od_hope_date',
                od_time           = '".G5_TIME_YMDHIS."',
                od_ip             = '$REMOTE_ADDR',
                od_settle_case    = '$od_settle_case',
                od_other_pay_type = '$od_other_pay_type',
                od_test           = '{$default['de_card_test']}'
                ";
$result = sql_query($sql, false);
*/








        echo "KKK====> 작업중!!!!!!!!!! ";
        exit;



        $od_temp_point  = $request->input('od_temp_point');

echo "KKK====> ".$od_temp_point;
exit;

    }
}
