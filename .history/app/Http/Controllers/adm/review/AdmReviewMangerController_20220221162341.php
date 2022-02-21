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
use App\Models\review_save_imgs;    //리뷰 이미지 모델 정의

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
        $ca_id          = $request->input('ca_id');
        $item_code      = $request->input('item_code');

var_dump("item_code====> ".$item_code);



        //페이지 이동 배열 만들기
        $page_move = "page=".$page."&seach_1=".$seach_1."&seach_2=".$seach_2."&seach_3=".$seach_3."&search_name=".$search_name."&ca_id=".$ca_id;

        $pageScale  = 10;  //한페이지당 라인수
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
        $tailarr['ca_id'] = $ca_id;
        $tailarr['seach_1'] = $seach_1;
        $tailarr['seach_2'] = $seach_2;
        $tailarr['seach_3'] = $seach_3;
        $tailarr['search_name'] = $search_name;
        $tailarr['item_code'] = $item_code;


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
            'page_move'         => $page_move,
            'ca_id'             => $ca_id,
            'item_code'         => $item_code,
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
        $review_save_imgs = DB::table('review_save_imgs')->where('rs_id', $review_save->id)->get();
        $exp_info = DB::table('exp_list')->select('title')->where('id', $review_save->exp_id)->first(); //체험단명 찾기
        $item_info = DB::table('shopitems')->select('item_name')->where('item_code', $review_save->item_code)->first(); //상품명 찾기
        $rating_item_info = DB::table('rating_item')->where('sca_id', $review_save->sca_id)->first();

        $page           = $request->input('page');
        $seach_1        = $request->input('seach_1');
        $seach_2        = $request->input('seach_2');
        $seach_3        = $request->input('seach_3');
        $search_name    = $request->input('search_name');

        //페이지 이동 배열 만들기
        $page_move = "page=".$page."&seach_1=".$seach_1."&seach_2=".$seach_2."&seach_3=".$seach_3."&search_name=".$search_name;

        if(is_null($exp_info)){
            $title_ment = '';
        }else{
            $title_ment = stripslashes($exp_info->title);
        }

        if($review_save->review_blind == 'N') $review_blind = "노출";
        else $review_blind = "블라인드";

        //rating 있는 지 파악
        $dip_name = "";
        for($i = 1; $i <= 5; $i++){
            $tmp = "item_name".$i;
            $score_tmp = "score".$i;

            $dip_name .= $rating_item_info->$tmp." ".number_format($review_save->$score_tmp, 2)." 점 / ";
        }
        $dip_name = substr($dip_name, 0, -2);

        return view('adm.review.review_modi',[
            'CustomUtils'       => $CustomUtils,
            'review_save'       => $review_save,
            'title_ment'        => $title_ment,
            'item_name'         => stripslashes($item_info->item_name),
            'review_blind'      => $review_blind,
            'dip_name'          => $dip_name,
            'review_content'    => $review_save->review_content,
            'review_save_imgs'  => $review_save_imgs,
            'num'               => $id,
            'page_move'         => $page_move,
        ]);
    }

    public function review_modi_save(Request $request)
    {
        $CustomUtils = new CustomUtils;

        $review_img = $request->file('review_img');
        $review_content = $request->input('review_content');
        $rs_id = $request->input('num');
        $page_move = $request->input('page_move');

        $path = 'data/review';     //첨부물 저장 경로
        $upload_max_filesize = ini_get('upload_max_filesize');  //서버 설정 파일 용량 제한
        $upload_max_filesize = substr($upload_max_filesize, 0, -1); //2M (뒤에 M자르기)

        //DB 저장 배열 만들기
        $data = array(
            'rs_id'             => $rs_id,
        );

        $thumb_name = "";
        $thumb_name2 = "";
        $photo_flag = false;

        for($i = 1; $i <= 5; $i++){
            $id_tmp = "review_id_".$i;
            $img_tmp = "review_img_".$i;
            $file_chk_tmp = "file_chk_".$i;

            $review_id = $request->input($id_tmp);  //수정된 id 값
            $review_img = $request->file($img_tmp); //이미지 첨부
            $file_chk = $request->input($file_chk_tmp); //체크 여부

            $review_save = DB::table('review_save_imgs')->where('id', $review_id)->first();

            if($file_chk == 1){
                if($review_img != ""){
                    $thumb_name = "";
                    $file_type = $review_img->getClientOriginalExtension();    //이미지 확장자 구함
                    $file_size = $review_img->getSize();  //첨부 파일 사이즈 구함

                    //서버 php.ini 설정에 따른 첨부 용량 확인(php.ini에서 바꾸기)
                    $max_size_mb = $upload_max_filesize * 1024;   //라라벨은 kb 단위라 함
                    $attachment_result = CustomUtils::attachment_save($review_img, $path); //위의 패스로 이미지 저장됨

                    //썸네일 만들기
                    for($k = 0; $k < 2; $k++){
                        $resize_width_file_tmp = explode("%%","400%%100");
                        $resize_height_file_tmp = explode("%%","400%%100");

                        $thumb_width = $resize_width_file_tmp[$k];
                        $thumb_height = $resize_height_file_tmp[$k];

                        $is_create = false;
                        $thumb_name .= "@@".CustomUtils::thumbnail($attachment_result[1], $path, $path, $thumb_width, $thumb_height, $is_create, $is_crop=false, $crop_mode='center', $is_sharpen=false, $um_value='80/0.5/3');
                    }

                    $data['review_img_name'] = $attachment_result[2];  //배열에 추가 함
                    $data['review_img'] = $attachment_result[1].$thumb_name;  //배열에 추가 함

                    if($review_save != ""){
                        //이미지가 있을땐 수정
                        //1. 기존 이미지 삭제 부터
                        $file_cnt = explode('@@', $review_save->review_img);
                        for($j = 0; $j < count($file_cnt); $j++){
                            $img_path = "";
                            $img_path = $path.'/'.$file_cnt[$j];

                            if (file_exists($img_path)) {
                                @unlink($img_path); //이미지 삭제
                            }
                        }

                        $update_result = review_save_imgs::find($review_id)->update($data);

                    }else{
                        //이미지가 없을땐 insert
                        //저장 처리
                        $create_result = review_save_imgs::create($data);
                        $create_result->save();
                    }
                }else{
                    //체크 박스에 체크는 되고 이미지를 첨부 안했을땐 이미지 삭제
                    if($review_save != ""){
                        //디비 이미지 삭제
                        $file_cnt = explode('@@', $review_save->review_img);
                        for($j = 0; $j < count($file_cnt); $j++){
                            $img_path = "";
                            $img_path = $path.'/'.$file_cnt[$j];

                            if (file_exists($img_path)) {
                                @unlink($img_path); //이미지 삭제
                            }
                        }

                        DB::table('review_save_imgs')->where([['id', $review_id], ['rs_id', $rs_id]])->delete();
                    }
                }
            }
        }

        $update_result = DB::table('review_saves')->where('id', $rs_id)->update([
            'review_content'    => $review_content,
        ]);

        return redirect(route('adm.review.reviewlist', $page_move))->with('alert_messages', '수정 되었습니다.');
    }

    public function ajax_item(Request $request)
    {
        $CustomUtils = new CustomUtils;

        $cate = $request->input('cate');
        $item_code = $request->input('item_code');

        $shopitems = DB::table('shopitems')->where('sca_id', $cate)->get();

        $html = "";
        foreach($shopitems as $shopitem){
            if($shopitem->item_code == $item_code) $aa = "";
            $html .= "
                <option value='".$shopitem->item_code."'>".$shopitem->item_name."</option>
            ";
        }

        echo $html;
    }

}
