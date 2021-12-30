<?php
#############################################################################
#
#		파일이름		:		ReviewPossibleController.php
#		파일설명		:		mypage 체험단 관리 control
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 11월 23일
#		최종수정일		:		2021년 11월 23일
#
###########################################################################-->

namespace App\Http\Controllers\member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use App\Helpers\Custom\PageSet; //페이지 함수
use Illuminate\Support\Facades\Auth;    //인증
use Illuminate\Support\Facades\DB;
use Validator;  //체크
use App\Models\review_saves;    //review 모델 정의
use App\Models\review_save_imgs;    //review 이미지 모델 정의

class ReviewPossibleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function index()
    {
        $CustomUtils = new CustomUtils;

        $now_date = date('Y-m-d', time());

        //체험단 쿼리
        $exp_appinfos = DB::table('exp_application_list as a')
            ->select('b.*', 'a.id as exp_app_id', 'a.exp_id', 'a.item_id', 'a.sca_id', 'a.created_at as regi_date')
            ->join('exp_list as b', function($join) {
                    $join->on('a.exp_id', '=', 'b.id');
                })
            ->where([['b.exp_review_end', '>=', $now_date], ['a.user_id', Auth::user()->user_id], ['a.access_yn','y'], ['a.write_yn', 'n']])
            ->orderBy('a.created_at', 'DESC')
            ->get();

        //쇼핑몰 쿼리
        $orders = DB::table('shoporders as a')
            ->select('b.*', 'a.order_id', 'a.created_at as regi_date')
            ->leftjoin('shopcarts as b', function($join) {
                $join->on('a.order_id', '=', 'b.od_id');
                })
            ->where([['a.user_id', Auth::user()->user_id], ['b.sct_qty','!=', '0'], ['b.review_yn', 'n'], ['b.sct_status', '!=', '취소']])
            ->where(DB::raw('a.created_at + INTERVAL 30 DAY'), '>=', now())
            ->orderBy('a.created_at', 'DESC')
            ->get();

        return view('member.review_possible_list',[
            'CustomUtils'   => $CustomUtils,
            'exp_appinfos'  => $exp_appinfos,
            'orders'        => $orders,
            'po_total_record'   => count($exp_appinfos),
        ]);
    }

    public function ajax_review_possible_list(Request $request)
    {
        $CustomUtils = new CustomUtils;

        $page       = $request->input('page');
        $now_date   = date('Y-m-d', time());

        //체험단 쿼리
        $exp_app = DB::table('exp_application_list as a')
            ->select('b.*', 'a.id as exp_app_id', 'a.exp_id', 'a.item_id', 'a.sca_id', 'a.created_at as regi_date', )
            ->join('exp_list as b', function($join) {
                    $join->on('a.exp_id', '=', 'b.id');
                })
            ->where([['b.exp_review_end', '>=', $now_date], ['a.user_id', Auth::user()->user_id], ['a.access_yn','y'], ['a.write_yn', 'n']]);

        $pageScale  = 10;  //한페이지당 라인수
        if($page != "")
        {
            $start_num = $pageScale * ($page - 1);
            $end_row = $pageScale * $page;
        }else{
            $page = 1;
            $start_num = 0;
        }

        $total_record   = 0;
        $total_record   = $exp_app->count(); //총 게시물 수
        $total_page     = ceil($total_record / $pageScale);
        $total_page     = $total_page == 0 ? 1 : $total_page;

        $exp_appinfos = $exp_app->orderBy('a.created_at', 'DESC')->offset($start_num)->limit($pageScale)->get();
        $end_cnt = $exp_app->orderBy('a.created_at', 'DESC')->offset($end_row)->limit($pageScale)->get();

        $view = view('member.ajax_review_possible_list',[
            'CustomUtils'   => $CustomUtils,
            'exp_appinfos'  => $exp_appinfos,
            'page'          => $page,
            'po_end_cnt'    => count($end_cnt),
        ]);

        return $view;
    }

    public function ajax_review_shop_list(Request $request)
    {
        $CustomUtils = new CustomUtils;

        $page       = $request->input('page');
        $now_date   = date('Y-m-d', time());

        //쇼핑몰 쿼리
        $orders_info = DB::table('shoporders as a')
            ->select('b.*', 'a.order_id', 'a.created_at as regi_date')
            ->leftjoin('shopcarts as b', function($join) {
                $join->on('a.order_id', '=', 'b.od_id');
                })
            ->where([['a.user_id', Auth::user()->user_id], ['b.sct_qty','!=', '0'], ['b.review_yn', 'n'], ['b.sct_status', '!=', '취소']])
            ->where(DB::raw('a.created_at + INTERVAL 30 DAY'), '>=', now());

        $pageScale  = 10;  //한페이지당 라인수
        if($page != "")
        {
            $start_num = $pageScale * ($page - 1);
            $end_row = $pageScale * $page;
        }else{
            $page = 1;
            $start_num = 0;
        }

        $total_record   = 0;
        $total_record   = $orders_info->count(); //총 게시물 수
        $total_page     = ceil($total_record / $pageScale);
        $total_page     = $total_page == 0 ? 1 : $total_page;

        $orders = $orders_info->orderBy('a.created_at', 'DESC')->offset($start_num)->limit($pageScale)->get();
        $end_cnt = $orders_info->orderBy('a.created_at', 'DESC')->offset($end_row)->limit($pageScale)->get();

        $view = view('member.ajax_review_shop_list',[
            'CustomUtils'   => $CustomUtils,
            'orders'        => $orders,
            'shop_page'     => $page,
            'shop_end_cnt'    => count($end_cnt),
        ]);

        return $view;
    }

    public function review_possible_shopwrite(Request $request)
    {
        $CustomUtils = new CustomUtils;

        $cart_id    = $request->input('cart_id');
        $order_id   = $request->input('order_id');
        $item_code  = $request->input('item_code');

        if($order_id == "" || $item_code == "" || $cart_id == ""){
            return redirect()->back()->with('alert_messages', '잘못된 경로 입니다.');
            exit;
        }

        //예외 처리
        $item_info = DB::table('shopitems')->select('sca_id')->where('item_code', $item_code)->first();

        if(is_null($item_info)){
            return redirect()->back()->with('alert_messages', '잠시 시스템 장애가 발생 하였습니다. 관리자에게 문의 하세요.-1');
            exit;
        }

        $order_info = DB::table('shoporders')->select('id', 'created_at')->where([['order_id', $order_id], ['user_id', Auth::user()->user_id]])->first();
        if(is_null($order_info)){
            return redirect()->back()->with('alert_messages', '잠시 시스템 장애가 발생 하였습니다. 관리자에게 문의 하세요.-2');
            exit;
        }

        $cart_info = DB::table('shopcarts')->select('id')->where([['id', $cart_id], ['user_id', Auth::user()->user_id]])->first();
        if(is_null($cart_info)){
            return redirect()->back()->with('alert_messages', '잠시 시스템 장애가 발생 하였습니다. 관리자에게 문의 하세요.-3');
            exit;
        }

        $review_saves_cnt = DB::table('review_saves')->where([['cart_id', $cart_id], ['item_code', $item_code], ['user_id', Auth::user()->user_id],['temporary_yn', 'n']])->count();
        if($review_saves_cnt > 0){
            return redirect(route('mypage.review_possible_list'))->with('alert_messages', '이미 리뷰를 작성 하셨습니다.');
            exit;
        }

        $rating_item_info = DB::table('rating_item')->where('sca_id', $item_info->sca_id)->first();
        if(is_null($rating_item_info)){
            return redirect(route('mypage.review_possible_list'))->with('alert_messages', '정량 평가 항목이 없습니다.\n관리자에게 문의 하세요.');
            exit;
        }

        //첨부 파일 저장소
        $target_path = "data/review";
        if (!is_dir($target_path)) {
            @mkdir($target_path, 0755);
            @chmod($target_path, 0755);
        }

        $review_saves = DB::table('review_saves')->where([['cart_id', $cart_id], ['item_code', $item_code], ['user_id', Auth::user()->user_id], ['temporary_yn', 'y']]);
        $review_saves_info = array();

        $imgs_tmp = '';
        $img_key = '';

        if($review_saves->count() > 0){
            $review_saves_info = $review_saves->first();

            //리뷰 첨부 이미지 구하기
            $review_save_imgs = DB::table('review_save_imgs')->where('rs_id', $review_saves_info->id);
            $review_save_imgs_cnt = $review_save_imgs->count();
            $review_save_imgs_infos = array();

            if($review_save_imgs_cnt > 0){
                $review_save_imgs_infos = $review_save_imgs->get();
                foreach($review_save_imgs_infos as $review_save_imgs_info){
                    $review_img = explode("@@", $review_save_imgs_info->review_img);
                    //$imgs_tmp .= "'".$review_img[2]."@@".$review_save_imgs_info->id."',";
                    $imgs_tmp .= "'".$review_img[2]."',";
                    $img_key .= $review_save_imgs_info->id."@@";
                }

                $imgs_tmp = substr($imgs_tmp, 0, -1);
                $img_key = substr($img_key, 0, -2);
            }

            return view('member.review_possible_modify',[
                'CustomUtils'       => $CustomUtils,
                'rating_item_info'  => $rating_item_info,
                'cart_id'           => $cart_id,
                'order_id'          => $order_id,
                'item_code'         => $item_code,
                'review_saves_info' => $review_saves_info,
                'exp_id'            => 0,
                'exp_app_id'        => 0,
                'sca_id'            => $item_info->sca_id,
                'imgs_tmp'          => $imgs_tmp,
                'img_key'           => $img_key,
            ]);
        }else{
            return view('member.review_possible_write',[
                'CustomUtils'       => $CustomUtils,
                'rating_item_info'  => $rating_item_info,
                'cart_id'           => $cart_id,
                'order_id'          => $order_id,
                'item_code'         => $item_code,
                'exp_id'            => 0,
                'exp_app_id'        => 0,
                'sca_id'            => $item_info->sca_id,
            ]);
        }
    }

    public function review_possible_save(Request $request)
    {
        $CustomUtils = new CustomUtils;

        $cart_id        = $request->input('cart_id');
        $order_id       = $request->input('order_id');
        $item_code      = $request->input('item_code');
        $temporary_yn   = $request->input('temporary_yn');
        $average        = $request->input('average');
        $review_content = $request->input('review_content');

        //체험단 관련
        $exp_id         = $request->input('exp_id');
        $exp_app_id     = $request->input('exp_app_id');
        $sca_id         = $request->input('sca_id');

        //예외처리
        if($exp_id > "0" && $exp_app_id > "0"){
            //체험단
            $review_saves_cnt = DB::table('review_saves')->where([['exp_id', $exp_id], ['item_code', $item_code], ['user_id', Auth::user()->user_id]])->count();
        }else{
            //쇼핑
            $review_saves_cnt = DB::table('review_saves')->where([['cart_id', $cart_id], ['item_code', $item_code], ['user_id', Auth::user()->user_id]])->count();
        }

        if($review_saves_cnt > 0){
            return redirect(route('mypage.review_possible_list'))->with('alert_messages', '이미 리뷰를 작성 하셨습니다.');
            exit;
        }

        //DB 저장 배열 만들기
        $data = array(
            'cart_id'           => $cart_id,
            'order_id'          => $order_id,
            'item_code'         => $item_code,
            'exp_id'            => $exp_id,
            'exp_app_id'        => $exp_app_id,
            'sca_id'            => $sca_id,
            'temporary_yn'      => $temporary_yn,
            'average'           => $average,
            'user_id'           => Auth::user()->user_id,
            'user_name'         => Auth::user()->user_name,
            'review_content'    => $review_content,
        );

        $score_val = '';
        for($j = 1; $j <= 5; $j++){
            $score_val  = 'score'.$j;
            $score      = $request->input($score_val);
            $data[$score_val] = $score;
        }

        $upload_max_filesize = ini_get('upload_max_filesize');  //서버 설정 파일 용량 제한
        $upload_max_filesize = substr($upload_max_filesize, 0, -1); //2M (뒤에 M자르기)

        $thumb_name = "";
        $thumb_name2 = "";
        $photo_flag = false;
        $give_point = 0;

        $fileExtension = 'jpeg,jpg,png,gif,bmp,GIF,PNG,JPG,JPEG,BMP';  //이미지 일때 확장자 파악(이미지일 경우 썸네일 하기 위해)

        $path = 'data/review';     //첨부물 저장 경로

        //첨부파일 관리
        $data_img_tmp = array();
        $review_img_cnt = $request->file('review_img');
        if($review_img_cnt != ""){
            for($i = 0; $i < count($review_img_cnt); $i++){
                if($request->hasFile('review_img'))
                {
                    $thumb_name = "";
                    $review_img[$i] = $request->file('review_img')[$i];
                    $file_type = $review_img[$i]->getClientOriginalExtension();    //이미지 확장자 구함
                    $file_size = $review_img[$i]->getSize();  //첨부 파일 사이즈 구함

                    //서버 php.ini 설정에 따른 첨부 용량 확인(php.ini에서 바꾸기)
                    $max_size_mb = $upload_max_filesize * 1024;   //라라벨은 kb 단위라 함

                    //첨부 파일 용량 예외처리
                    Validator::validate($request->all(), [
                        'review_img[]'  => ['max:'.$max_size_mb, 'mimes:'.$fileExtension]
                    ], ['max' => $upload_max_filesize."MB 까지만 저장 가능 합니다.", 'mimes' => $fileExtension.' 파일만 등록됩니다.']);

                    $attachment_result = CustomUtils::attachment_save($review_img[$i],$path); //위의 패스로 이미지 저장됨

                    if(!$attachment_result[0])
                    {
                        return redirect()->back()->with('alert_messages', '첨부 파일이 잘못 되었습니다.');
                        exit;
                    }else{
                        //썸네일 만들기
                        for($k = 0; $k < 2; $k++){
                            $resize_width_file_tmp = explode("%%","400%%100");
                            $resize_height_file_tmp = explode("%%","400%%100");

                            $thumb_width = $resize_width_file_tmp[$k];
                            $thumb_height = $resize_height_file_tmp[$k];

                            $is_create = false;
                            $thumb_name .= "@@".CustomUtils::thumbnail($attachment_result[1], $path, $path, $thumb_width, $thumb_height, $is_create, $is_crop=false, $crop_mode='center', $is_sharpen=false, $um_value='80/0.5/3');
                        }

                        $data_img_tmp[$i]['review_img_name'] = $attachment_result[2];  //배열에 추가 함
                        $data_img_tmp[$i]['review_img'] = $attachment_result[1].$thumb_name;  //배열에 추가 함

                        $photo_flag = true;
                    }
                }
            }
        }

        if($temporary_yn == 'y'){
            $ment = '리뷰가 임시 등록되었습니다.';
            //$save_ok = redirect(route('mypage.review_possible_list'))->with('alert_messages', $ment);
            $save_ok = response()->json(['route' => route('mypage.review_possible_list'), 'status' => 'temp_save'], 200, [], JSON_PRETTY_PRINT);
        }else{
            $ment = '리뷰가 등록되었습니다.';
            $route_link = route("mypage.review_possible_list");
            $route_my_link = route("mypage.review_my_list");
/*
            $save_ok = '
                <script>
                    if (confirm("리뷰가 등록되었습니다.\\n해당페이지에서 확인하시겠습니까?") == true){    //확인
                        location.href="'.$route_my_link.'";
                    }else{   //취소
                        location.href="'.$route_link.'";
                    }
                </script>
            ';
*/
            $save_ok = response()->json(['route' => route('mypage.review_possible_list'), 'status' => 'save_ok', 'my_page' => route('mypage.review_my_list')], 200, [], JSON_PRETTY_PRINT);

            if($exp_id == 0){
                //쇼핑몰 멘트
                $point_ment1 = '상품 평가 적립';
                $point_ment2 = '상품 포토 리뷰 적립';
                $point_key1 = 2;
                $point_key2 = 12;
            }else{
                //체험단 멘트
                $point_ment1 = '평가단 평가 적립';
                $point_ment2 = '평가단 포토 리뷰 적립';
                $point_key1 = 5;
                $point_key2 = 14;
            }

            //포인트 지급 처리
            $setting = $CustomUtils->setting_infos();
            $CustomUtils->insert_point(Auth::user()->user_id, $setting->text_point, $point_ment1, $point_key1,'', 0);

            if($photo_flag == true){
                $CustomUtils->insert_point(Auth::user()->user_id, $setting->photo_point, $point_ment2, $point_key2,'', $order_id);
            }
        }

        //저장 처리
        $create_result = review_saves::create($data);
        $create_result->save();

        $data_img = array();
        $data_img['rs_id'] = $create_result->id;    //마지막 auto increment 값

        //첨부 이미지 저장
        for($y = 0; $y < count($data_img_tmp); $y++){
            $data_img['review_img_name'] = $data_img_tmp[$y]['review_img_name'];
            $data_img['review_img'] = $data_img_tmp[$y]['review_img'];

            //이미지 저장 처리
            $create_img_result = review_save_imgs::create($data_img);
            $create_img_result->save();
        }

        if($temporary_yn == 'n'){
            //저장 처리 완료후 상품 평점 상품 테이블에 저장
            $CustomUtils->item_average($item_code);
        }

        if($create_result){
            //echo $save_ok;
            return $save_ok;
            exit;
        }else{
            return response()->json(['route' => route('mypage.review_possible_list'),'status' => 'error'], 200, [], JSON_PRETTY_PRINT);
            //echo "error";
            exit;
        }
/*
        if($create_result) return $save_ok;
        else return redirect(route('mypage.review_possible_list'))->with('alert_messages', '잠시 시스템 장애가 발생 하였습니다. 관리자에게 문의 하세요.');
*/
    }

    public function review_possible_modi_save(Request $request)
    {
        $CustomUtils = new CustomUtils;

        $review_save_id = $request->input('review_save_id');

        $cart_id        = $request->input('cart_id');
        $order_id       = $request->input('order_id');
        $item_code      = $request->input('item_code');
        $temporary_yn   = $request->input('temporary_yn');
        $average        = $request->input('average');
        $review_content = $request->input('review_content');

        //체험단 관련
        $exp_id         = $request->input('exp_id');
        $exp_app_id     = $request->input('exp_app_id');
        $sca_id         = $request->input('sca_id');

        //예외처리
        if($review_save_id == ""){
            return redirect()->back()->with('alert_messages', '잘못된 경로 입니다.');
            exit;
        }

        if($exp_id > 0){
            //체험단 예외처리
            $review_saves_cnt = DB::table('review_saves')->where([['id', $review_save_id], ['exp_id', $exp_id], ['exp_app_id', $exp_app_id], ['item_code', $item_code], ['user_id', Auth::user()->user_id], ['temporary_yn', 'n']])->count();
            if($review_saves_cnt > 0){
                return redirect(route('mypage.review_possible_list'))->with('alert_messages', '이미 리뷰를 작성 하셨습니다.');
                exit;
            }

            $review_save_info = DB::table('review_saves')->where([['id', $review_save_id], ['exp_id', $exp_id], ['exp_app_id', $exp_app_id], ['item_code', $item_code], ['user_id', Auth::user()->user_id], ['temporary_yn', 'y']])->first();
        }else{
            //쇼핑몰 예외처리
            $review_saves_cnt = DB::table('review_saves')->where([['id', $review_save_id], ['cart_id', $cart_id], ['item_code', $item_code], ['user_id', Auth::user()->user_id], ['temporary_yn', 'n']])->count();
            if($review_saves_cnt > 0){
                return redirect(route('mypage.review_possible_list'))->with('alert_messages', '이미 리뷰를 작성 하셨습니다.');
                exit;
            }

            $review_save_info = DB::table('review_saves')->where([['id', $review_save_id], ['cart_id', $cart_id], ['item_code', $item_code], ['user_id', Auth::user()->user_id], ['temporary_yn', 'y']])->first();
        }

        $rating_item_info = DB::table('rating_item')->where('sca_id', $sca_id)->first();
        if(is_null($rating_item_info)){
            return redirect(route('mypage.review_possible_list'))->with('alert_messages', '정량 평가 항목이 없습니다.\n관리자에게 문의 하세요.');
            exit;
        }

        //DB 저장 배열 만들기
        $data = array(
            'temporary_yn'      => $temporary_yn,
            'average'           => $average,
            'review_content'    => $review_content,
        );

        $score_val = '';
        for($j = 1; $j <= 5; $j++){
            $score_val  = 'score'.$j;
            $score      = $request->input($score_val);
            $data[$score_val] = $score;
        }

        $upload_max_filesize = ini_get('upload_max_filesize');  //서버 설정 파일 용량 제한
        $upload_max_filesize = substr($upload_max_filesize, 0, -1); //2M (뒤에 M자르기)

        $thumb_name = "";
        $thumb_name2 = "";
        $photo_flag = false;
        $give_point = 0;

        $fileExtension = 'jpeg,jpg,png,gif,bmp,GIF,PNG,JPG,JPEG,BMP';  //이미지 일때 확장자 파악(이미지일 경우 썸네일 하기 위해)

        $path = 'data/review';     //첨부물 저장 경로
        $setting = $CustomUtils->setting_infos();


        $data_img_tmp = array();
        $review_img_cnt = $request->file('review_img');

        if($review_img_cnt != ""){
            for($i = 0; $i < count($review_img_cnt); $i++){
                if($request->hasFile('review_img'))
                {
                    $thumb_name = "";
                    $review_img[$i] = $request->file('review_img')[$i];
                    $file_type = $review_img[$i]->getClientOriginalExtension();    //이미지 확장자 구함
                    $file_size = $review_img[$i]->getSize();  //첨부 파일 사이즈 구함

                    //서버 php.ini 설정에 따른 첨부 용량 확인(php.ini에서 바꾸기)
                    $max_size_mb = $upload_max_filesize * 1024;   //라라벨은 kb 단위라 함

                    //첨부 파일 용량 예외처리
                    Validator::validate($request->all(), [
                        'review_img[]'  => ['max:'.$max_size_mb, 'mimes:'.$fileExtension]
                    ], ['max' => $upload_max_filesize."MB 까지만 저장 가능 합니다.", 'mimes' => $fileExtension.' 파일만 등록됩니다.']);

                    $attachment_result = CustomUtils::attachment_save($review_img[$i],$path); //위의 패스로 이미지 저장됨
                    if(!$attachment_result[0])
                    {
                        return redirect()->back()->with('alert_messages', '첨부 파일이 잘못 되었습니다.');
                        exit;
                    }else{
                        //썸네일 만들기
                        for($k = 0; $k < 2; $k++){
                            $resize_width_file_tmp = explode("%%","400%%100");
                            $resize_height_file_tmp = explode("%%","400%%100");

                            $thumb_width = $resize_width_file_tmp[$k];
                            $thumb_height = $resize_height_file_tmp[$k];

                            $is_create = false;
                            $thumb_name .= "@@".CustomUtils::thumbnail($attachment_result[1], $path, $path, $thumb_width, $thumb_height, $is_create, $is_crop=false, $crop_mode='center', $is_sharpen=false, $um_value='80/0.5/3');
                        }

                        $data_img_tmp[$i]['review_img_name'] = $attachment_result[2];  //배열에 추가 함
                        $data_img_tmp[$i]['review_img'] = $attachment_result[1].$thumb_name;  //배열에 추가 함

                        $photo_flag = true;
                    }
                }
            }

            //첨부 이미지 저장
            $data_img = array();
            $data_img['rs_id'] = $review_save_id;
            for($y = 0; $y < count($data_img_tmp); $y++){
                $data_img['review_img_name'] = $data_img_tmp[$y]['review_img_name'];
                $data_img['review_img'] = $data_img_tmp[$y]['review_img'];

                //이미지 저장 처리
                $create_img_result = review_save_imgs::create($data_img);
                $create_img_result->save();
            }
        }

        if($exp_id == 0){
            //쇼핑몰 멘트
            $point_ment1 = '상품 평가 적립';
            $point_ment2 = '상품 포토 리뷰 적립';
            $point_key1 = 2;
            $point_key2 = 12;
        }else{
            //체험단 멘트
            $point_ment1 = '평가단 평가 적립';
            $point_ment2 = '평가단 포토 리뷰 적립';
            $point_key1 = 5;
            $point_key2 = 14;
        }

        if($temporary_yn == 'y'){
            $ment = '리뷰가 수정되었습니다.';
            //$save_ok = redirect(route('mypage.review_possible_list'))->with('alert_messages', $ment);
            $save_ok = response()->json(['route' => route('mypage.review_possible_list'), 'status' => 'temp_save'], 200, [], JSON_PRETTY_PRINT);
        }else{
            $ment = '리뷰가 등록되었습니다.';
            $route_link = route("mypage.review_possible_list");
            $route_my_link = route("mypage.review_my_list");
/*
            $save_ok = '
                <script>
                    if (confirm("리뷰가 등록되었습니다.\\n해당페이지에서 확인하시겠습니까?") == true){    //확인
                        location.href="'.$route_my_link.'";
                    }else{   //취소
                        location.href="'.$route_link.'";
                    }
                </script>
            ';
*/
            $save_ok = response()->json(['route' => route('mypage.review_possible_list'), 'status' => 'save_ok', 'my_page' => route('mypage.review_my_list')], 200, [], JSON_PRETTY_PRINT);

            //포인트 지급 처리
            $CustomUtils->insert_point(Auth::user()->user_id, $setting->text_point, $point_ment1, $point_key1, '', 0);
        }

        //저장 처리
        $update_result = review_saves::find($review_save_id)->update($data);

        if($temporary_yn == 'n'){
            //저장 버튼일때 이미지가 있는지 다시 파악해서 있으면 상품 포토 리뷰 적립를 적립 한다.
            $review_save_img = DB::table('review_save_imgs')->where('rs_id', $review_save_id)->count();
            if($review_save_img > 0){
                $photo_flag = true;
            }

            if($photo_flag == true){
                $CustomUtils->insert_point(Auth::user()->user_id, $setting->photo_point, $point_ment2, $point_key2,'' , 0);
            }

            //저장 처리 완료후 상품 평점 상품 테이블에 저장
            $CustomUtils->item_average($item_code);
        }

        /*
        if($update_result) return $save_ok;
        else return redirect(route('mypage.review_possible_list'))->with('alert_messages', '잠시 시스템 장애가 발생 하였습니다. 관리자에게 문의 하세요.');
        */
        if($update_result){
            //echo $save_ok;
            return $save_ok;
            exit;
        }else{
            return response()->json(['route' => route('mypage.review_possible_list'),'status' => 'error'], 200, [], JSON_PRETTY_PRINT);
            //echo "error";
            exit;
        }
    }

    /*** 체험단 관련 처리 */
    public function review_possible_expwrite(Request $request)
    {
        $CustomUtils = new CustomUtils;

        $exp_id     = $request->input('exp_id');
        $exp_app_id = $request->input('exp_app_id');
        $item_id    = $request->input('item_id');
        $sca_id     = $request->input('sca_id');

        //예외 처리
        if($exp_id == "" || $exp_app_id == "" || $item_id == "" || $sca_id == ""){
            return redirect()->back()->with('alert_messages', '잘못된 경로 입니다.');
            exit;
        }

        $item_info = DB::table('shopitems')->select('item_code', 'sca_id')->where('id', $item_id)->first();
        if(is_null($item_info)){
            return redirect()->back()->with('alert_messages', '잠시 시스템 장애가 발생 하였습니다. 관리자에게 문의 하세요.-1');
            exit;
        }

        $exp_info = DB::table('exp_list')->where('id', $exp_id)->first();
        if(is_null($exp_info)){
            return redirect()->back()->with('alert_messages', '잠시 시스템 장애가 발생 하였습니다. 관리자에게 문의 하세요.-2');
            exit;
        }

        $exp_app_info = DB::table('exp_application_list')->where([['id', $exp_app_id], ['user_id', Auth::user()->user_id], ['exp_id', $exp_id], ['item_id', $item_id], ['sca_id', $sca_id],  ['access_yn','y']])->first();
        if(is_null($exp_app_info)){
            return redirect()->back()->with('alert_messages', '잘못된 경로 입니다.');
            exit;
        }

        $review_saves_cnt = DB::table('review_saves')->where([['exp_id', $exp_id], ['exp_app_id', $exp_app_id], ['sca_id', $sca_id], ['item_code', $item_info->item_code], ['user_id', Auth::user()->user_id], ['temporary_yn', 'n']])->count();
        if($review_saves_cnt > 0){
            return redirect(route('mypage.review_possible_list'))->with('alert_messages', '이미 리뷰를 작성 하셨습니다.');
            exit;
        }

        $rating_item_info = DB::table('rating_item')->where('sca_id', $item_info->sca_id)->first();
        if(is_null($rating_item_info)){
            return redirect(route('mypage.review_possible_list'))->with('alert_messages', '정량 평가 항목이 없습니다.\n관리자에게 문의 하세요.');
            exit;
        }

        //첨부 파일 저장소
        $target_path = "data/review";
        if (!is_dir($target_path)) {
            @mkdir($target_path, 0755);
            @chmod($target_path, 0755);
        }

        $review_saves = DB::table('review_saves')->where([['exp_id', $exp_id], ['exp_app_id', $exp_app_id], ['sca_id', $sca_id], ['item_code', $item_info->item_code], ['user_id', Auth::user()->user_id], ['temporary_yn', 'y']]);
        $review_saves_info = array();

        $imgs_tmp = '';
        $img_key = '';
        if($review_saves->count() > 0){
            $review_saves_info = $review_saves->first();
            //리뷰 첨부 이미지 구하기
            $review_save_imgs = DB::table('review_save_imgs')->where('rs_id', $review_saves_info->id);
            $review_save_imgs_cnt = $review_save_imgs->count();
            $review_save_imgs_infos = array();

            if($review_save_imgs_cnt > 0){
                $review_save_imgs_infos = $review_save_imgs->get();
                foreach($review_save_imgs_infos as $review_save_imgs_info){
                    $review_img = explode("@@", $review_save_imgs_info->review_img);
                    //$imgs_tmp .= "'".$review_img[2]."@@".$review_save_imgs_info->id."',";
                    $imgs_tmp .= "'".$review_img[2]."',";
                    $img_key .= $review_save_imgs_info->id."@@";
                }

                $imgs_tmp = substr($imgs_tmp, 0, -1);
                $img_key = substr($img_key, 0, -2);
            }

            return view('member.review_possible_modify',[
                'CustomUtils'       => $CustomUtils,
                'rating_item_info'  => $rating_item_info,
                'item_code'         => $item_info->item_code,
                'review_saves_info' => $review_saves_info,
                'cart_id'           => 0,
                'order_id'          => 0,
                'exp_id'            => $exp_id,
                'exp_app_id'        => $exp_app_id,
                'sca_id'            => $sca_id,
                'imgs_tmp'          => $imgs_tmp,
                'img_key'           => $img_key,
                'review_save_imgs_cnt'      => $review_save_imgs_cnt,
                'review_save_imgs_infos'    => $review_save_imgs_infos,
            ]);
        }else{
            return view('member.review_possible_write',[
                'CustomUtils'       => $CustomUtils,
                'rating_item_info'  => $rating_item_info,
                'cart_id'           => 0,
                'order_id'          => 0,
                'exp_id'            => $exp_id,
                'exp_app_id'        => $exp_app_id,
                'sca_id'            => $sca_id,
                'item_code'         => $item_info->item_code,
            ]);
        }
    }

    public function review_my_list(Request $request)
    {
        $CustomUtils = new CustomUtils;

        $date_type = $request->input('date_type');

        //리뷰 관련
        $where_exp = '';
        $where_shop = '';

        $review_saves_exp_sql = DB::table('review_saves')->where([['user_id', Auth::user()->user_id], ['temporary_yn', 'n']]);
        $review_saves_shop_sql = DB::table('review_saves')->where([['user_id', Auth::user()->user_id], ['temporary_yn', 'n']]);

        switch($date_type)
        {
            case 'one_month':
                $where_exp = $review_saves_exp_sql->where('exp_id', '!=', '0')->whereRaw("updated_at between DATE_ADD(NOW(), INTERVAL -1 MONTH) and NOW()");
                $where_shop = $review_saves_shop_sql->where([['exp_id', '0'], ['cart_id', '!=', '0']])->whereRaw("updated_at between DATE_ADD(NOW(), INTERVAL -1 MONTH) and NOW()");
                break;

            case 'three_month':
                $where_exp = $review_saves_exp_sql->where('exp_id', '!=', '0')->whereRaw("updated_at between DATE_ADD(NOW(), INTERVAL -3 MONTH) and NOW()");
                $where_shop = $review_saves_shop_sql->where([['exp_id', '0'], ['cart_id', '!=', '0']])->whereRaw("updated_at between DATE_ADD(NOW(), INTERVAL -3 MONTH) and NOW()");
                break;

            case 'six_month':
                $where_exp = $review_saves_exp_sql->where('exp_id', '!=', '0')->whereRaw("updated_at between DATE_ADD(NOW(), INTERVAL -6 MONTH) and NOW()");
                $where_shop = $review_saves_shop_sql->where([['exp_id', '0'], ['cart_id', '!=', '0']])->whereRaw("updated_at between DATE_ADD(NOW(), INTERVAL -6 MONTH) and NOW()");
                break;

            case 'one_year':
                $where_exp = $review_saves_exp_sql->where('exp_id', '!=', '0')->whereRaw("updated_at between DATE_ADD(NOW(), INTERVAL -1 YEAR) and NOW()");
                $where_shop = $review_saves_shop_sql->where([['exp_id', '0'], ['cart_id', '!=', '0']])->whereRaw("updated_at between DATE_ADD(NOW(), INTERVAL -1 YEAR) and NOW()");
                break;

            case 'three_year':
                $where_exp = $review_saves_exp_sql->where('exp_id', '!=', '0')->whereRaw("updated_at between DATE_ADD(NOW(), INTERVAL -3 YEAR) and NOW()");
                $where_shop = $review_saves_shop_sql->where([['exp_id', '0'], ['cart_id', '!=', '0']])->whereRaw("updated_at between DATE_ADD(NOW(), INTERVAL -3 YEAR) and NOW()");
                break;

            case 'all':
                $where_exp = $review_saves_exp_sql->where('exp_id', '!=', '0');
                $where_shop = $review_saves_shop_sql->where([['exp_id', '0'], ['cart_id', '!=', '0']]);
                break;

            default:
                $where_exp = $review_saves_exp_sql->where('exp_id', '!=', '0')->whereRaw("updated_at between DATE_ADD(NOW(), INTERVAL -1 MONTH) and NOW()");
                $where_shop = $review_saves_shop_sql->where([['exp_id', '0'], ['cart_id', '!=', '0']])->whereRaw("updated_at between DATE_ADD(NOW(), INTERVAL -1 MONTH) and NOW()");
                break;
        }

        $review_saves_exp_infos = $where_exp->orderBy('id', 'DESC')->get();     //체험단 쿼리
        $review_saves_shop_infos = $where_shop->orderBy('id', 'DESC')->get();     //shop 쿼리

        return view('member.review_my_list',[
            'CustomUtils'               => $CustomUtils,
            'review_saves_exp_infos'    => $review_saves_exp_infos,
            'review_saves_shop_infos'   => $review_saves_shop_infos,
            'date_type'                 => $date_type,
        ]);
    }

    //내가 쓴 리뷰 체험단
    public function ajax_review_my_exp_list(Request $request)
    {
        $CustomUtils = new CustomUtils;

        $page       = $request->input('page');
        $date_type  = $request->input('date_type');
        $po_project_val = $request->input('po_project_val');

        //리뷰 관련
        $where_exp = '';

        $review_saves_exp_sql = DB::table('review_saves')->where([['user_id', Auth::user()->user_id], ['temporary_yn', 'n']]);

        switch($date_type)
        {
            case 'one_month':
                $where_exp = $review_saves_exp_sql->where('exp_id', '!=', '0')->whereRaw("updated_at between DATE_ADD(NOW(), INTERVAL -1 MONTH) and NOW()");
                break;

            case 'three_month':
                $where_exp = $review_saves_exp_sql->where('exp_id', '!=', '0')->whereRaw("updated_at between DATE_ADD(NOW(), INTERVAL -3 MONTH) and NOW()");
                break;

            case 'six_month':
                $where_exp = $review_saves_exp_sql->where('exp_id', '!=', '0')->whereRaw("updated_at between DATE_ADD(NOW(), INTERVAL -6 MONTH) and NOW()");
                break;

            case 'one_year':
                $where_exp = $review_saves_exp_sql->where('exp_id', '!=', '0')->whereRaw("updated_at between DATE_ADD(NOW(), INTERVAL -1 YEAR) and NOW()");
                break;

            case 'three_year':
                $where_exp = $review_saves_exp_sql->where('exp_id', '!=', '0')->whereRaw("updated_at between DATE_ADD(NOW(), INTERVAL -3 YEAR) and NOW()");
                break;

            case 'all':
                $where_exp = $review_saves_exp_sql->where('exp_id', '!=', '0');
                break;

            default:
                $where_exp = $review_saves_exp_sql->where('exp_id', '!=', '0')->whereRaw("updated_at between DATE_ADD(NOW(), INTERVAL -1 MONTH) and NOW()");
                break;
        }

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
        $total_record   = $where_exp->count(); //총 게시물 수
        $total_page     = ceil($total_record / $pageScale);
        $total_page     = $total_page == 0 ? 1 : $total_page;

        $review_saves_exp_infos = $where_exp->orderBy('id', 'DESC')->offset($start_num)->limit($pageScale)->get();
        $end_cnt = $where_exp->orderBy('id', 'DESC')->offset($end_row)->limit($pageScale)->get();

        //$review_saves_exp_infos = $where_exp->orderBy('id', 'DESC')->get();     //체험단 쿼리

        $view = view('member.ajax_review_my_exp_list',[
            'CustomUtils'               => $CustomUtils,
            'review_saves_exp_infos'    => $review_saves_exp_infos,
            'exp_page'                  => $page,
            'exp_end_cnt'               => count($end_cnt),
        ]);

        return $view;
    }

    //내가 쓴 리뷰 쇼핑몰
    public function ajax_review_my_shop_list(Request $request)
    {
        $CustomUtils = new CustomUtils;

        $page       = $request->input('page');
        $date_type  = $request->input('date_type');

        $where_shop = '';

        $review_saves_shop_sql = DB::table('review_saves')->where([['user_id', Auth::user()->user_id], ['temporary_yn', 'n']]);
        switch($date_type)
        {
            case 'one_month':
                $where_shop = $review_saves_shop_sql->where([['exp_id', '0'], ['cart_id', '!=', '0']])->whereRaw("updated_at between DATE_ADD(NOW(), INTERVAL -1 MONTH) and NOW()");
                break;

            case 'three_month':
                $where_shop = $review_saves_shop_sql->where([['exp_id', '0'], ['cart_id', '!=', '0']])->whereRaw("updated_at between DATE_ADD(NOW(), INTERVAL -3 MONTH) and NOW()");
                break;

            case 'six_month':
                $where_shop = $review_saves_shop_sql->where([['exp_id', '0'], ['cart_id', '!=', '0']])->whereRaw("updated_at between DATE_ADD(NOW(), INTERVAL -6 MONTH) and NOW()");
                break;

            case 'one_year':
                $where_shop = $review_saves_shop_sql->where([['exp_id', '0'], ['cart_id', '!=', '0']])->whereRaw("updated_at between DATE_ADD(NOW(), INTERVAL -1 YEAR) and NOW()");
                break;

            case 'three_year':
                $where_shop = $review_saves_shop_sql->where([['exp_id', '0'], ['cart_id', '!=', '0']])->whereRaw("updated_at between DATE_ADD(NOW(), INTERVAL -3 YEAR) and NOW()");
                break;

            case 'all':
                $where_shop = $review_saves_shop_sql->where([['exp_id', '0'], ['cart_id', '!=', '0']]);
                break;

            default:
                $where_shop = $review_saves_shop_sql->where([['exp_id', '0'], ['cart_id', '!=', '0']])->whereRaw("updated_at between DATE_ADD(NOW(), INTERVAL -1 MONTH) and NOW()");
                break;
        }

        $review_saves_shop_infos = $where_shop->orderBy('id', 'DESC')->get();     //shop 쿼리

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
        $total_record   = $where_shop->count(); //총 게시물 수
        $total_page     = ceil($total_record / $pageScale);
        $total_page     = $total_page == 0 ? 1 : $total_page;

        $review_saves_shop_infos = $where_shop->orderBy('id', 'DESC')->offset($start_num)->limit($pageScale)->get();
        $end_cnt = $where_shop->orderBy('id', 'DESC')->offset($end_row)->limit($pageScale)->get();

        $view = view('member.ajax_review_my_shop_list',[
            'CustomUtils'               => $CustomUtils,
            'review_saves_shop_infos'   => $review_saves_shop_infos,
            'shop_page'                 => $page,
            'shop_end_cnt'              => count($end_cnt),
        ]);

        return $view;
    }

    //마이페이지 (평가단 신청 결과 확인)
    public function exp_app_list(Request $request)
    {
        $CustomUtils = new CustomUtils;

        $page       = $request->input('page');
        $pageScale  = 10;  //한페이지당 라인수
        $blockScale = 1; //출력할 블럭의 갯수(1,2,3,4... 갯수)

        if($page != "")
        {
            $start_num = $pageScale * ($page - 1);
        }else{
            $page = 1;
            $start_num = 0;
        }

        $exp_app_list = DB::table('exp_application_list')->where('user_id', Auth::user()->user_id);

        $total_record   = 0;
        $total_record   = $exp_app_list->count(); //총 게시물 수
        $total_page     = ceil($total_record / $pageScale);
        $total_page     = $total_page == 0 ? 1 : $total_page;

        $exp_app_rows = $exp_app_list->orderby('id', 'DESC')->offset($start_num)->limit($pageScale)->get();

        $tailarr = array();
        //$tailarr['AA'] = 'AA';    //고정된 전달 파라메터가 있을때 사용

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

        return view('member.exp_app_list',[
            'CustomUtils'   => $CustomUtils,
            'exp_app_rows'  => $exp_app_rows,
            'pnPage'        => $pnPage,
        ]);
    }

    public function ajax_review_possible_img_del(Request $request)
    {
        $CustomUtils = new CustomUtils;

        $id     = $request->input('num');
        $rs_id  = $request->input('rs_id');

        $review_save_imgs_info = DB::table('review_save_imgs')->where([['id', $id], ['rs_id', $rs_id]])->first();

        $path = 'data/review';     //첨부물 저장 경로

        $file_cnt = explode('@@',$review_save_imgs_info->review_img);

        for($j = 0; $j < count($file_cnt); $j++){
            $img_path = "";
            $img_path = $path.'/'.$file_cnt[$j];
            if (file_exists($img_path)) {
                @unlink($img_path); //이미지 삭제
            }
        }

        DB::table('review_save_imgs')->where([['id', $id], ['rs_id', $rs_id]])->delete();
    }

}
