<?php
#############################################################################
#
#		파일이름		:		ItemController.php
#		파일설명		:		카테고리별 상품 리스트 control
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 09월 24일
#		최종수정일		:		2021년 09월 24일
#
###########################################################################-->

namespace App\Http\Controllers\shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use App\Helpers\Custom\PageSet; //페이지 함수
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;     //각종 함수(str_random)

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $ca_id          = $request->input('ca_id');
        $sub_ca_id      = $request->input('sub_ca_id');
        $sub_cate       = $request->input('sub_cate');
        $length         = strlen($ca_id);
        $orderby_type   = $request->input('orderby_type');
dd("svsdvsdv");
        $orderby_add = '';
        $total_cnt = 0;

        if($ca_id == ""){
            return redirect()->route('shop.index');
            exit;
        }

        //pgae 관련
        $page       = $request->input('page');
        $pageScale  = 40;  //한페이지당 라인수
        $blockScale = 1; //출력할 블럭의 갯수(1,2,3,4... 갯수)

        if($page != "")
        {
            $start_num = $pageScale * ($page - 1);
        }else{
            $page = 1;
            $start_num = 0;
        }

        $cate_infos = DB::table('shopcategorys')->where('sca_display','Y')->whereRaw('length(sca_id) = 2')->orderby('sca_rank', 'ASC')->orderby('id', 'ASC')->get();
        $sub_cate_infos = DB::table('shopcategorys')->where('sca_display','Y')->whereRaw('length(sca_id) = 4')->whereRaw("sca_id like '{$ca_id}%'")->orderby('sca_rank', 'ASC')->orderby('id', 'ASC')->get();

        if($ca_id != ""){
            $item_sql = DB::table('shopitems')->where([['item_del', 'N'], ['item_display','Y']])->whereRaw("sca_id like '{$ca_id}%'");
            $total_cnt = $item_sql->count();
            //$item_infos = $item_sql->orderby('item_rank', 'DESC')->orderby('id', 'DESC')->offset($start_num)->limit($pageScale)->get();
        }

        if($sub_ca_id != "all" && $sub_ca_id != ""){
            $item_sql = DB::table('shopitems')->where([['item_del', 'N'], ['item_display','Y'], ['sca_id', $sub_ca_id]]);
            $total_cnt = $item_sql->count();
            //$item_infos = $item_sql->orderby('item_rank', 'DESC')->orderby('id', 'DESC')->offset($start_num)->limit($pageScale)->get();
        }

        if($orderby_type != ""){
            switch ($orderby_type) {
                case 'recent':
                    //$orderby_add = "'id', 'DESC'";
                    $item_sql->orderby('id','DESC');
                    $total_cnt = $item_sql->count();
                    $item_infos= $item_sql->offset($start_num)->limit($pageScale)->get();
                    break;
                case 'sale':
                    //$orderby_add = "'total', 'desc'";
                    $item_sql = DB::table('shopitems as a')
                    ->select('a.*', DB::raw('count(b.item_code) as total'))
                    ->leftjoin('shopcarts as b', function($join) {
                            $join->on('a.item_code', '=', 'b.item_code')->whereRaw('b.sct_status in (\'입금\', \'준비\', \'배송\', \'완료\')');
                        });
                    if($sub_ca_id != "all" && $sub_ca_id != ""){
                        $item_sql = $item_sql->where([['item_del', 'N'], ['a.item_display','Y'], ['a.sca_id', $sub_ca_id]]);
                    }else{
                        $item_sql = $item_sql->whereRaw("a.sca_id like '{$ca_id}%'");
                    }
                    $item_sql = $item_sql->groupBy('a.item_code')->orderBy('total', 'desc');

                    $item_cnt = $item_sql->get();

                    $item_sql = $item_sql->offset($start_num)->limit($pageScale)->get();

                    $item_infos = $item_sql;
                    $total_cnt = count($item_cnt);

                    break;
                case 'high_price':
                    //$orderby_add = "'item_price', 'DESC'";
                    $item_sql->orderby('item_price','DESC');
                    $total_cnt = $item_sql->count();
                    $item_infos= $item_sql->offset($start_num)->limit($pageScale)->get();
                    break;
                case 'low_price':
                    //$orderby_add = "'item_price', 'ASC'";
                    $item_sql->orderby('item_price','ASC');
                    $total_cnt = $item_sql->count();
                    $item_infos= $item_sql->offset($start_num)->limit($pageScale)->get();
                    break;
                case 'review':
                    //$orderby_add = "'review_cnt', 'DESC'";
                    $item_sql->orderby('review_cnt','DESC');
                    $total_cnt = $item_sql->count();
                    $item_infos= $item_sql->offset($start_num)->limit($pageScale)->get();
                    break;
                default:
                    //$orderby_add = "'id', 'DESC'";
                    $item_sql->orderby('id','DESC');
                    $total_cnt = $item_sql->count();
                    $item_infos= $item_sql->offset($start_num)->limit($pageScale)->get();
                    break;
            }
        }else{
            $item_infos = $item_sql->orderby('item_rank', 'ASC')->orderby('id', 'DESC')->offset($start_num)->limit($pageScale)->get();
        }

        $total_record   = 0;
        $total_record   = $total_cnt; //총 게시물 수

        $total_page     = ceil($total_record / $pageScale);
        $total_page     = $total_page == 0 ? 1 : $total_page;

        $virtual_num = $total_record - $pageScale * ($page - 1);

        $tailarr = array();
        $tailarr['ca_id'] = $ca_id;    //고정된 전달 파라메터가 있을때 사용
        $tailarr['sub_ca_id'] = $sub_ca_id;
        $tailarr['orderby_type'] = $orderby_type;

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

        $CustomUtils = new CustomUtils();
        return view('shop.item_page',[
            'ca_id'             => $ca_id,
            'sub_ca_id'         => $sub_ca_id,
            'orderby_type'      => $orderby_type,
            'cate_infos'        => $cate_infos,
            'sub_cate_infos'    => $sub_cate_infos,
            'item_infos'        => $item_infos,
            'page'              => $page,
            'pnPage'            => $pnPage,
            'total_record'      => $total_record,
            //'keymethod'     => $keymethod,
            //'keyword'       => $keyword,
            'CustomUtils'       => $CustomUtils,
            'sub_cate'          => $sub_cate,
        ]);
    }

    public function sitemdetail(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $item_code          = $request->input('item_code');

        $item_info = DB::select("select a.*, b.sca_display from shopitems a, shopcategorys b where a.item_code = '$item_code' and a.sca_id = b.sca_id ");

        //상단 네비세이션 부분 처리
        $k = 0;
        $sca_id_len = strlen($item_info[0]->sca_id);
        for($i = 2; $i <= $sca_id_len; $i += 2){
            $str_tmp = substr($item_info[0]->sca_id, 0, $i);
            $cate_name = DB::table('shopcategorys')->where([['sca_display', 'Y'], ['sca_id', $str_tmp]])->first();
            $disp_sca_id[$k] = $str_tmp;
            $disp_cate_name[$k] = $cate_name->sca_name_kr;
            $k++;
        }

        if(count($item_info) == 0){
            return redirect()->back()->with('alert_messages', $Messages::$shop['no_data']);
            exit;
        }

        if($item_info[0]->item_del == 'Y'){
            return redirect()->back()->with('alert_messages', "판매 중지된 상품입니다.");
            exit;
        }
        //예외처리(카테고리 비출력, 상품 비출력, 판매 가능 여부)
        if($item_info[0]->sca_display == 'N' || $item_info[0]->item_display == 'N' || $item_info[0]->item_use == '0'){
            return redirect()->back()->with('alert_messages', $Messages::$shop['now_no_item']);
            exit;
        }

        //이미지 처리
        $j = 0;
        $p = 0;
        $big_img_disp = array();
        $small_img = array();
        $small_img_disp = array();
        $small_item_img = array();

        for($i=1; $i<=10; $i++) {
            $item_img = "item_img".$i;

            if($item_info[0]->$item_img == "") continue;

            $item_img_cut = explode("@@",$item_info[0]->$item_img);

            //큰이미지 출력
            $big_img_disp[$p] = "/data/shopitem/".$item_img_cut[1];

            //작은 이미지 출력 배열
            $small_img_disp[$p] = "/data/shopitem/".$item_img_cut[4];
            $small_item_img[$p] = $i;
/*
            if($item_info[0]->$item_img == "") continue;

            $j++;
            $item_img_cut = explode("@@",$item_info[0]->$item_img);

            if(count($item_img_cut) == 1) $item_img_disp = $item_img_cut[0];
            else $item_img_disp = $item_img_cut[1];

            if($j == 1){
                //큰이미지 출력
                $big_img_disp = "/data/shopitem/".$item_img_disp;
            }

            //작은 이미지 출력 배열
            $small_img_disp[$p] = "/data/shopitem/".$item_img_cut[3];
            $small_item_img[$p] = $i;
*/
            $p++;
        }

        $CustomUtils = new CustomUtils();
        $use_point = $CustomUtils->setting_infos(); //환경 설정 포인트 설정

        //포인트 타입에 따른 변경
        $use_point_disp = "";
        if($use_point->company_use_point == 1){ //포인트 사용
            $use_point_disp = "구매금액의 ".$item_info[0]->item_point."%";
        }

        //배송비 타입에 따른 변경
        $sc_method_disp = '';
        if($item_info[0]->item_sc_price > 0) $sc_method_disp = number_format($item_info[0]->item_sc_price).'원';

        // 상품품절체크
        $is_soldout = $CustomUtils->is_soldout($item_info[0]->item_code);

        // 주문가능체크
        $is_orderable = true;

        if($item_info[0]->item_use != 1 || $item_info[0]->item_tel_inq == 1 || $is_soldout){
            $is_orderable = false;
        }

        $option_item = $supply_item = '';

        if($is_orderable){
            //선택 옵션
            $option_item = $CustomUtils->get_item_options($item_info[0]->item_code, $item_info[0]->item_option_subject, '');
            $supply_item = $CustomUtils->get_item_supply($item_info[0]->item_code, $item_info[0]->item_supply_subject, '');
        }

        //시중가격(정가) 계산
        $disp_discount_rate = 0;
        if($item_info[0]->item_cust_price > 0){
            //시중가격 값이 있을때 할인율 계산
            $discount = (int)$item_info[0]->item_cust_price - (int)$item_info[0]->item_price; //할인액
            $discount_rate = ($discount / (int)$item_info[0]->item_cust_price) * 100;  //할인율
            $disp_discount_rate = round($discount_rate);    //반올림
        }

        //리뷰 관련
        $review_cnt = DB::table('review_saves')->where([['item_code', $item_info[0]->item_code], ['temporary_yn', 'n'], ['review_blind', 'N']])->count();
        $rating_arr = $CustomUtils->item_each_average($item_info[0]->item_code, $item_info[0]->sca_id);

        return view('shop.item_detail',[
            "item_info"         => $item_info[0],
            "big_img_disp"      => $big_img_disp,
            "small_img_disp"    => $small_img_disp,
            "small_item_img"    => $small_item_img,
            "CustomUtils"       => $CustomUtils,
            "use_point"         => $use_point->company_use_point,
            "de_send_cost"      => $use_point->de_send_cost,
            "use_point_disp"    => $use_point_disp,
            "sc_method_disp"    => $sc_method_disp,
            "point"             => $item_info[0]->item_point,
            "is_orderable"      => $is_orderable,   //재고가 있는지 파악 여부
            "option_item"       => $option_item,    //선택 옵션
            "supply_item"       => $supply_item,    //추가 옵션
            "disp_sca_id"       => $disp_sca_id,
            "disp_cate_name"    => $disp_cate_name,
            "img_cnt"           => $p,
            "disp_discount_rate" => $disp_discount_rate,
            "review_cnt"        => $review_cnt,
            "rating_arr"        => $rating_arr,
        ]);
    }

    public function ajax_review_item(Request $request)
    {
        $CustomUtils = new CustomUtils;

        $page       = $request->input('page');
        $item_code  = $request->input('item_code');

        $review_sql = DB::table('review_saves')->where([['item_code', $item_code], ['temporary_yn', 'n'], ['review_blind', 'N']]);

        $pageScale  = 5;  //한페이지당 라인수

        if($page != "")
        {
            $start_num = $pageScale * ($page - 1);
            $end_row = $pageScale * $page;
        }else{
            $page = 1;
            $start_num = 0;
        }

        $total_record   = 0;
        $total_record   = $review_sql->count(); //총 게시물 수

        $total_page     = ceil($total_record / $pageScale);
        $total_page     = $total_page == 0 ? 1 : $total_page;

        $review_infos = $review_sql->orderBy('id', 'DESC')->offset($start_num)->limit($pageScale)->get();
        $end_cnt = $review_sql->orderBy('id', 'DESC')->offset($end_row)->limit($pageScale)->get();

        $view = view('shop.ajax_review_item',[
            'CustomUtils'   => $CustomUtils,
            'review_infos'  => $review_infos,
            'page'          => $page,
            'review_page'   => $page,
            'review_end_cnt'    => count($end_cnt),
        ]);

        return $view;

    }



    //ajax 큰이미지 변환
    public function ajax_big_img_change(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $item_code  = $request->input('item_code');
        $item_img   = $request->input('item_img');

        $item_img_col = "item_img".$item_img;

        $img_serach = DB::table('shopitems')->select($item_img_col)->where('item_code',$item_code)->first();   //이미지 찾기
        $item_img_cut = explode("@@",$img_serach->$item_img_col);

        echo "/data/shopitem/".$item_img_cut[1];
    }

    //선택 옵션 ajax
    public function ajax_option_change(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $item_code  = $request->input('item_code');
        $opt_id     = $request->input('opt_id');
        $idx        = $request->input('idx');
        $sel_count  = $request->input('sel_count');
        $op_title   = $request->input('op_title');

        $item_info = CustomUtils::get_shop_item($item_code);

        if(count($item_info) == 0){
            echo "No";
            exit;
        }

        $options = DB::table('shopitemoptions')->where([['sio_type','0'],['item_code',$item_code],['sio_use','1'],['sio_id','like',$opt_id.chr(30).'%']])->orderby('id', 'asc')->get();   //옵션 찾기
        $option_title = '선택';

        if( $op_title && ($op_title !== $option_title) && $item_info[0]->item_option_subject ){
            $array_tmps = explode(',', $item_info[0]->item_option_subject);
            if( isset($array_tmps[$idx+1]) && $array_tmps[$idx+1] ){
                $option_title = $array_tmps[$idx+1];
            }
        }

        $str = '<option value="">'.$option_title.'</option>';
        $opt = array();

        foreach($options as $option){
            $val = explode(chr(30), $option->sio_id);
            $key = $idx + 1;

            if(!strlen($val[$key])) continue;

            $continue = false;
            foreach($opt as $v) {
                if(strval($v) === strval($val[$key])) {
                    $continue = true;
                    break;
                }
            }

            if($continue) continue;

            $opt[] = strval($val[$key]);

            if($key + 1 < $sel_count) {
                $str .= PHP_EOL.'<option value="'.$val[$key].'">'.$val[$key].'</option>';
            } else {
                if($option->sio_price >= 0)
                    $price = '&nbsp;&nbsp;+ '.number_format($option->sio_price).'원';
                else
                    $price = '&nbsp;&nbsp; '.number_format($option->sio_price).'원';

                $sio_stock_qty = CustomUtils::get_option_stock_qty($item_code, $option->sio_id, $option->sio_type);

                if($sio_stock_qty < 1)
                    $soldout = '&nbsp;&nbsp;[품절]';
                else
                    $soldout = '';

                $str .= PHP_EOL.'<option value="'.$val[$key].','.$option->sio_price.','.$sio_stock_qty.'">'.$val[$key].$price.$soldout.'</option>';
            }
        }

        echo $str;
    }



}
