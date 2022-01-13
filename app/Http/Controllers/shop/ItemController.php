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

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $ca_id          = $request->input('ca_id');
        $sub_ca_id      = $request->input('sub_ca_id');
        $length         = strlen($ca_id);
        $orderby_type   = $request->input('orderby_type');

        if($ca_id == ""){
            return redirect()->route('shop.index');
            exit;
        }

        //pgae 관련
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


/*
        //검색 처리
        $keymethod      = $request->input('keymethod');
        $keyword        = $request->input('keyword');

        $search_sql = "";
        if($keymethod != "" && $keyword != ""){
            $search_sql = " AND a.{$keymethod} LIKE '%{$keyword}%' ";
        }

        $search_sql = "";
        if($keymethod != "" && $keyword != ""){
            $search_sql = " AND a.{$keymethod} LIKE '%{$keyword}%' ";
        }

        if($ca_id == ""){
            $cate_infos = DB::table('shopcategorys')->select('sca_id', 'sca_name_kr')->where('sca_display','Y')->whereRaw('length(sca_id) = 2')->orderby('sca_rank', 'DESC')->get();

            $total_count = DB::select("select count(*) as cnt from shopitems a, shopcategorys b where a.item_del = 'N' AND a.item_display = 'Y' AND a.item_use = 1 AND a.sca_id = b.sca_id AND b.sca_display = 'Y' {$search_sql} ");
        }else{
            $down_cate = DB::table('shopcategorys')->where('sca_id','like',$ca_id.'%')->count();   //하위 카테고리 갯수
            if($down_cate != 1){
                $length = $length + 2;
                $cate_infos = DB::table('shopcategorys')->select('sca_id', 'sca_name_kr')->where('sca_display','Y')->where('sca_id','<>',$ca_id )->whereRaw('length(sca_id) = '.$length)->whereRaw("sca_id like '{$ca_id}%'")->orderby('sca_rank', 'DESC')->get();
            }else{  //하위 카테고리가 없을때 처리
                $cate_infos = DB::table('shopcategorys')->select('sca_id', 'sca_name_kr')->where('sca_display','Y')->where('sca_id','=',$ca_id )->whereRaw('length(sca_id) = '.$length)->whereRaw("sca_id like '{$ca_id}%'")->orderby('sca_rank', 'DESC')->get();
            }

            $total_count = DB::select("select count(*) as cnt from shopitems a, shopcategorys b where a.item_del = 'N' AND a.item_display = 'Y' AND a.item_use = 1 AND a.sca_id = b.sca_id AND b.sca_display = 'Y' AND a.sca_id like '{$ca_id}%' {$search_sql} ");
        }
*/
        $cate_infos = DB::table('shopcategorys')->where('sca_display','Y')->whereRaw('length(sca_id) = 2')->orderby('sca_rank', 'DESC')->orderby('id', 'asc')->get();
        $sub_cate_infos = DB::table('shopcategorys')->where('sca_display','Y')->whereRaw('length(sca_id) = 4')->whereRaw("sca_id like '{$ca_id}%'")->orderby('sca_rank', 'DESC')->orderby('id', 'ASC')->get();

/*
        $total_record   = 0;
        $total_record   = $total_count[0]->cnt; //총 게시물 수
        $total_page     = ceil($total_record / $pageScale);
        $total_page     = $total_page == 0 ? 1 : $total_page;

        $item_infos = DB::select("select a.*, b.sca_id from shopitems a, shopcategorys b where a.item_del = 'N' AND a.item_display = 'Y' AND a.item_use = 1 AND a.sca_id = b.sca_id AND b.sca_display = 'Y'  AND a.sca_id like '{$ca_id}%' {$search_sql} order by a.item_rank DESC limit {$start_num}, {$pageScale} ");

        $virtual_num = $total_record - $pageScale * ($page - 1);

        $tailarr = array();
        $tailarr['ca_id'] = $ca_id;    //고정된 전달 파라메터가 있을때 사용
        $tailarr['keymethod'] = $keymethod;
        $tailarr['keyword'] = $keyword;

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
*/
        $CustomUtils = new CustomUtils();
        return view('shop.item_page',[
            'ca_id'             => $ca_id,
            'sub_ca_id'         => $sub_ca_id,
            'orderby_type'      => $orderby_type,
            'cate_infos'        => $cate_infos,
            'sub_cate_infos'    => $sub_cate_infos,
            //'item_infos'    => $item_infos,
            //'page'          => $page,
            //'pnPage'        => $pnPage,
            //'keymethod'     => $keymethod,
            //'keyword'       => $keyword,
            'CustomUtils'   => $CustomUtils,
        ]);
    }

    public function ajax_subcate(Request $request)
    {
        var_dump("KKKKKKKKKKKKKKKKKKK");
    }



    public function sitemdetail(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $item_code          = $request->input('item_code');

        $item_info = DB::select("select a.*, b.sca_display from shopitems a, shopcategorys b where a.item_code = '$item_code' and a.sca_id = b.sca_id ");

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
        $big_img_disp = "";
        $small_img = array();
        $small_img_disp = array();
        $small_item_img = array();

        for($i=1; $i<=10; $i++) {
            $item_img = "item_img".$i;

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
        $sc_method_disp = '무료';
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
        ]);
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
