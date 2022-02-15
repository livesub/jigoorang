<?php
#############################################################################
#
#		파일이름		:		AdmReviewManagerController.php
#		파일설명		:		관리자페이지 리뷰 관리 control
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 11월 29일
#		최종수정일		:		2021년 11월 29일
#
###########################################################################-->


namespace App\Http\Controllers\adm\review;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use App\Helpers\Custom\PageSet; //페이지 함수
use Illuminate\Support\Facades\Auth;    //인증
use Illuminate\Support\Facades\DB;

class AdmReviewMangerController extends Controller
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

        $page           = $request->input('page');
        $seach_1        = $request->input('seach_1');
        $seach_2        = $request->input('seach_2');
        $seach_3        = $request->input('seach_3');
        $search_name    = $request->input('search_name');

        $pageScale  = 15;  //한페이지당 라인수
        $blockScale = 10; //출력할 블럭의 갯수(1,2,3,4... 갯수)

        if($page != "")
        {
            $start_num = $pageScale * ($page - 1);
        }else{
            $page = 1;
            $start_num = 0;
        }
        $exp_selects = DB::table('exp_list')->orderBy('id', 'desc')->get(); //체험단 리스트 검색

        $review_save_list = DB::table('review_saves')->where('temporary_yn', 'n');

        if($seach_1 == "exp"){
            $review_save_list->where('exp_id', '!=', '0');
        }else if($seach_1 == "shop"){
            $review_save_list->where('cart_id', '!=', '0');
        }else if($seach_1 == "blind"){
            $review_save_list->where('review_blind', 'Y');
        }

        if($seach_2 != ""){
            $review_save_list->where('exp_id', $seach_2);
        }

        if($seach_3 != "" && $search_name != ""){
            $review_save_list->where($seach_3, 'like', '%'.$search_name.'%');
        }

        $total_record   = 0;
        $total_record   = $review_save_list->count(); //총 게시물 수
        $total_page     = ceil($total_record / $pageScale);
        $total_page     = $total_page == 0 ? 1 : $total_page;

        $review_save_rows = $review_save_list->orderby('id', 'DESC')->offset($start_num)->limit($pageScale)->get();

        $virtual_num = $total_record - $pageScale * ($page - 1);

        $tailarr = array();
        $tailarr['seach_1'] = $seach_1;
        $tailarr['seach_2'] = $seach_2;
        $tailarr['seach_3'] = $seach_3;
        $tailarr['search_name'] = $search_name;

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

        return view('adm.review.reviewlist',[
            'CustomUtils'       => $CustomUtils,
            'exp_selects'       => $exp_selects,
            'review_save_rows'  => $review_save_rows,
            'pnPage'            => $pnPage,
            'virtual_num'       => $virtual_num,
            'seach_1'           => $seach_1,
            'seach_2'           => $seach_2,
            'seach_3'           => $seach_3,
            'search_name'       => $search_name,
        ]);
    }

    public function review_blind(Request $request)
    {
        $CustomUtils = new CustomUtils;

        $id = $request->input('num');
        $setting = $CustomUtils->setting_infos();

        $review_save_list = DB::table('review_saves')->where('id', $id)->first();

        if($review_save_list->review_blind == 'N') $blind_type = 'Y';
        else $blind_type = 'N';

        $update_result = DB::table('review_saves')->where('id', $id)->update(['review_blind' => $blind_type]);

        //체험단 평인지 쇼핑몰 구매 평인지 파악
        if($review_save_list->exp_id == 0){
            //쇼핑몰 구매평
            if($blind_type == 'Y'){
                $point_ment1 = '상품 평가 취소';
                $point_ment2 = '상품 포토 리뷰 취소';
                $point_key1 = 3;
                $point_key2 = 13;
            }else{
                $point_ment1 = '상품 평가 적립';
                $point_ment2 = '상품 포토 리뷰 적립';
                $point_key1 = 2;
                $point_key2 = 12;
            }
        }else{
            //체험단평
            if($blind_type == 'Y'){
                $point_ment1 = '평가단 평가 취소';
                $point_ment2 = '평가단 포토 리뷰 취소';
                $point_key1 = 6;
                $point_key2 = 15;
            }else{
                $point_ment1 = '평가단 평가 적립';
                $point_ment2 = '평가단 포토 리뷰 적립';
                $point_key1 = 5;
                $point_key2 = 14;
            }
        }

        $photo_flag = false;
        $review_save_imgs_cnt = DB::table('review_save_imgs')->where('rs_id', $id)->count();
        if($review_save_imgs_cnt > 0) $photo_flag = true;   //한개라도 등록 되어 있다면

        if($blind_type == 'Y'){
            $CustomUtils->item_average($review_save_list->item_code);

            $CustomUtils->insert_point($review_save_list->user_id, (-1) * $setting->text_point, $point_ment1, $point_key1, $id, 0);

            if($photo_flag){

                $CustomUtils->insert_point($review_save_list->user_id, (-1) * $setting->photo_point, $point_ment2, $point_key2, $id, 0);
            }

            $update_user_result = DB::table('users')->where('user_id', $review_save_list->user_id)->update(['blacklist' => 'y']);   //블랙리스트처리

            echo "blind_ok";
        }else{
            $CustomUtils->item_average($review_save_list->item_code);

            $CustomUtils->insert_point($review_save_list->user_id, $setting->text_point, $point_ment1, $point_key1, $id, 0);

            if($photo_flag){
                $CustomUtils->insert_point($review_save_list->user_id, $setting->photo_point, $point_ment2, $point_key2, $id, 0);
            }

            $update_user_result = DB::table('users')->where('user_id', $review_save_list->user_id)->update(['blacklist' => 'n']);   //블랙리스트해제
            echo "blind_no";
        }

        exit;
    }

    public function review_modi(Request $request)
    {
        $CustomUtils = new CustomUtils;

        $id = $request->input('num');
        $review_save = DB::table('review_saves')->where('id', $id)->first();
        //$review_save_imgs = DB::table('review_save_imgs')->where('rs_id', $review_save->id)->get();


        $exp_info = DB::table('exp_list')->select('title')->where('id', $review_save->exp_id)->first(); //체험단명 찾기

        if(is_null($exp_info)){
            $title_ment = '';
        }else{
            $title_ment = stripslashes($exp_info->title);
        }

        if($review_save->review_blind == 'N') $review_blind = "노출";
        else $review_blind = "블라인드";

        $item_info = DB::table('shopitems')->select('item_name')->where('item_code', $review_save->item_code)->first(); //상품명 찾기
        $rating_item_info = DB::table('rating_item')->where('sca_id', $review_save->sca_id)->first();
        //rating 있는 지 파악
        for($i = 1; $i <= 5; $i++){
            $tmp = "item_name".$i;
            $score_tmp = "score".$i;

            $dip_name .= $rating_item_info->$tmp." ".number_format($review_save_row->$score_tmp, 2)." 점 / ";
        }
        $dip_name = substr($dip_name, 0, -2);


        return view('adm.review.review_modi',[
            'CustomUtils'       => $CustomUtils,
            'review_save'       => $review_save,
            'title_ment'        => $title_ment,
            'item_name'         => stripslashes($item_info->item_name),
            'review_blind'      => $review_blind,
        ]);
var_dump($id);
    }

}
