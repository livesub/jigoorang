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
use App\Models\shopitemoptions;
use App\Models\shopitems;
use App\Models\shopcarts;    //장바구니 모델 정의
use Iamport;

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
        $pageScale  = 2;  //한페이지당 라인수
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
            'page'          => $page,
        ]);
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

            $all_cart_infos = DB::table('shopcarts')->where([['od_id', $order_id], ['user_id', $order_info->user_id], ['sct_select', 1]])->whereRaw('sct_status in (\'입금\', \'준비\', \'배송\', \'배송완료\', \'부분취소\', \'상품취소\', \'반품\', \'교환\')')->get();

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

                // 장바구니 수량변경
                $all_cart_up = DB::table('shopcarts')->where([['id', $all_cart_info->id], ['od_id', $order_info->order_id]])->update([
                    'sct_qty'       => 0,
                    'sct_status'    => '상품취소',
                ]);

                $user_id = Auth::user()->user_id;
                $user_name = Auth::user()->user_name;
                $mod_history .= date("Y-m-d H:i:s", time()).' '.$all_cart_info->sct_option.' 주문취소 '.$all_cart_info->sct_qty.' -> 0     '.$user_name."   ".$user_id."\n";
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

    public function orderview_detail(Request $request)
    {
        $CustomUtils = new CustomUtils;

        $page       = $request->input('page');
        $order_id   = $request->input('order_id');

        $order_info = DB::table('shoporders')->where([['order_id', $order_id], ['user_id', Auth::user()->user_id]])->first();
        $carts = DB::table('shopcarts')->where([['user_id',Auth::user()->user_id],['od_id', $order_info->order_id]])->get();

        //배송비 계산
        if($order_info->de_send_cost_free == 0){
            $send_cost = $order_info->de_send_cost + $order_info->od_send_cost + $order_info->od_send_cost2;
            $de_send_cost = $order_info->de_send_cost;
        }else{
            $send_cost = $order_info->od_send_cost + $order_info->od_send_cost2;
            $de_send_cost = 0;
        }

        //할부 멘트
        if($order_info->imp_card_quota == 0) $imp_card_quota = "일시불";
        else $imp_card_quota = $order_info->imp_card_quota."개월";

        $point_review = 0;
        $point_photo = 0;
        $point_review_sql = DB::table('shoppoints')->where([['order_id', $order_id], ['user_id', Auth::user()->user_id], ['po_type', 2]])->first();   //평가리뷰 포인트
        if(isset($point_review_sql)) $point_review = $point_review_sql->po_point;

        $point_photo_sql = DB::table('shoppoints')->where([['order_id', $order_id], ['user_id', Auth::user()->user_id], ['po_type', 12]])->first();   //포토리뷰 포인트
        if(isset($point_photo_sql) > 0) $point_photo = $point_photo_sql->po_point;

        $point_sql = DB::table('users')->select('user_point')->where('user_id', Auth::user()->user_id)->first();   //현재보유 포인트

        return view('member.orderview_detail',[
            'CustomUtils'   => $CustomUtils,
            'order_id'      => $order_id,
            'order_info'    => $order_info,
            'carts'         => $carts,
            'send_cost'     => $send_cost,
            'de_send_cost'  => $de_send_cost,
            'od_send_cost2' => $order_info->od_send_cost2,
            'imp_card_quota' => $imp_card_quota,
            'point_review'  => $point_review,
            'point_photo'  => $point_photo,
            'point_sql'     => $point_sql,
            'page'          => $page,
        ]);
    }

    public function cancel_return_info(Request $request)
    {
        return view('member.cancel_return_info',[
        ]);
    }

    public function return_sign_up(Request $request)
    {
        $CustomUtils = new CustomUtils;

        $order_id       = $request->input('order_id');
        $cart_num       = $request->input('cart_num');
//->whereRaw('sct_status in (\'입금\', \'준비\', \'배송\', \'배송완료\', \'부분취소\', \'상품취소\', \'반품\')')
        $order_info = DB::table('shoporders')->where([['order_id', $order_id], ['user_id', Auth::user()->user_id]])->whereRaw('od_status in (\'준비\', \'배송\', \'배송완료\')')->first();
        $cart = DB::table('shopcarts')->where([['user_id', Auth::user()->user_id],['od_id', $order_info->order_id], ['id', $cart_num]])->whereRaw('sct_status in (\'준비\', \'배송\', \'배송완료\')')->first();

        if($order_info == "" || $cart == ""){
            return redirect()->back()->with('alert_messages', '잘못된 경로 입니다.');
            exit;
        }

        $image = $CustomUtils->get_item_image($cart->item_code, 3);
        if($image == "") $image = asset("img/no_img.jpg");

        switch($cart->sct_status) {
            case "입금":
                $ment = "결제완료";
            break;
            case "준비":
                $ment = "상품준비중";
            break;
            case "배송":
                $ment = "배송중";
            break;
            case "완료":
                $ment = "구매완료";
            break;
            case "교환":
                $ment = "교환요청";
            break;
            case "상품취소":
                $ment = "주문취소";
            break;
        }

        //제조사
        $item = DB::table('shopitems')->where('item_code', $cart->item_code)->first();
        if($item->item_manufacture == "") $item_manufacture = "";
        else $item_manufacture = "[".$item->item_manufacture."]";

        //제목
        $item_name = $item_manufacture.stripslashes($cart->item_name);

        if(strpos($cart->sct_option, " / ") !== false) {
            $item_options = $cart->sct_option;
        } else {
            $item_options = "";
        }

        return view('member.return_sign_up',[
            "image" => $image,
            "ment"  => $ment,
            "item_name" => $item_name,
            "item_options"  => $item_options,
        ]);
    }


}
