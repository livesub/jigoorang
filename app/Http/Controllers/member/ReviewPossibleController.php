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
        ]);
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

        //첨부 파일 저장소
        $target_path = "data/review";
        if (!is_dir($target_path)) {
            @mkdir($target_path, 0755);
            @chmod($target_path, 0755);
        }

        $review_saves = DB::table('review_saves')->where([['cart_id', $cart_id], ['item_code', $item_code], ['user_id', Auth::user()->user_id], ['temporary_yn', 'y']]);
        $review_saves_info = array();
        if($review_saves->count() > 0){
            $review_saves_info = $review_saves->first();

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
/*
        $imagepush = $request->file('imagepush');

        if($request->hasFile('imagepush')){
            dd("ok");
        }else{
            dd("no");
        }

dd($imagepush);
*/
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
        for($i = 1; $i <= 5; $i++){
            if($request->hasFile('review_img'.$i))
            {
                $thumb_name = "";
                $review_img[$i] = $request->file('review_img'.$i);
                $file_type = $review_img[$i]->getClientOriginalExtension();    //이미지 확장자 구함
                $file_size = $review_img[$i]->getSize();  //첨부 파일 사이즈 구함

                //서버 php.ini 설정에 따른 첨부 용량 확인(php.ini에서 바꾸기)
                $max_size_mb = $upload_max_filesize * 1024;   //라라벨은 kb 단위라 함

                //첨부 파일 용량 예외처리
                Validator::validate($request->all(), [
                    'review_img'.$i  => ['max:'.$max_size_mb, 'mimes:'.$fileExtension]
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

                    $data['review_img_name'.$i] = $attachment_result[2];  //배열에 추가 함
                    $data['review_img'.$i] = $attachment_result[1].$thumb_name;  //배열에 추가 함

                    $photo_flag = true;
                }
            }
        }

        if($temporary_yn == 'y'){
            $ment = '리뷰가 임시 등록되었습니다.';
            $save_ok = redirect(route('mypage.review_possible_list'))->with('alert_messages', $ment);
        }else{
            $ment = '리뷰가 등록되었습니다.';
            $route_link = route("mypage.review_possible_list");
            $route_my_link = route("mypage.review_my_list");
            $save_ok = '
                <script>
                    if (confirm("리뷰가 등록되었습니다.\\n해당페이지에서 확인하시겠습니까?") == true){    //확인
                        location.href="'.$route_my_link.'";
                    }else{   //취소
                        location.href="'.$route_link.'";
                    }
                </script>
            ';

            //포인트 지급 처리
            $setting = $CustomUtils->setting_infos();
            $CustomUtils->insert_point(Auth::user()->user_id, $setting->text_point, '상품 평가 적립', 2,'', $order_id);

            if($photo_flag == true){
                $CustomUtils->insert_point(Auth::user()->user_id, $setting->photo_point, '상품 포토 리뷰 적립', 12,'', $order_id);
            }
        }

        //저장 처리
        $create_result = review_saves::create($data);
        $create_result->save();

        if($temporary_yn == 'n'){
            //저장 처리 완료후 상품 평점 상품 테이블에 저장
            $CustomUtils->item_average($item_code);
        }

        if($create_result) return $save_ok;
        else return redirect(route('mypage.review_possible_list'))->with('alert_messages', '잠시 시스템 장애가 발생 하였습니다. 관리자에게 문의 하세요.');
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

        for($i = 1; $i <= 5; $i++){
            $thumb_name = "";
            $file_chk_tmp = 'file_chk'.$i;
            $file_chk = $request->input($file_chk_tmp); //수정,삭제,새로등록 체크 파악

            if($file_chk == 1){ //체크된 것들만 액션
                if($request->hasFile('review_img'.$i))    //첨부가 있음
                {
                    $review_img[$i] = $request->file('review_img'.$i);
                    $file_type = $review_img[$i]->getClientOriginalExtension();    //이미지 확장자 구함
                    $file_size = $review_img[$i]->getSize();  //첨부 파일 사이즈 구함

                    //서버 php.ini 설정에 따른 첨부 용량 확인(php.ini에서 바꾸기)
                    $max_size_mb = $upload_max_filesize * 1024;   //라라벨은 kb 단위라 함

                    //첨부 파일 용량 예외처리
                    Validator::validate($request->all(), [
                        'review_img'.$i  => ['max:'.$max_size_mb, 'mimes:'.$fileExtension]
                    ], ['max' => $upload_max_filesize."MB 까지만 저장 가능 합니다.", 'mimes' => $fileExtension.' 파일만 등록됩니다.']);

                    $attachment_result = CustomUtils::attachment_save($review_img[$i],$path); //위의 패스로 이미지 저장됨

                    if(!$attachment_result[0])
                    {
                        return redirect()->route('shop.item.create')->with('alert_messages', $Messages::$file_chk['file_chk']['file_false']);
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

                        $data['review_img_name'.$i] = $attachment_result[2];  //배열에 추가 함
                        $data['review_img'.$i] = $attachment_result[1].$thumb_name;  //배열에 추가 함

                        //기존 첨부 파일 삭제
                        $review_img_tmp = 'review_img'.$i;

                        if($review_save_info->$review_img_tmp != ""){   //기존 첨부가 있는지 파악 - 있다면 기존 파일 전체 삭제후 재 등록
                            $file_cnt1 = explode('@@',$review_save_info->$review_img_tmp);
                            for($j = 0; $j < count($file_cnt1); $j++){
                                $img_path = "";
                                $img_path = $path.'/'.$file_cnt1[$j];
                                if (file_exists($img_path)) {
                                    @unlink($img_path); //이미지 삭제
                                }
                            }
                        }
                    }

                    $photo_flag = true;

                }else{
                    //체크는 되었으나 첨부파일이 없을때 기존 첨부 파일 삭제
                    //기존 첨부 파일 삭제
                    $review_img_tmp = 'review_img'.$i;

                    if($review_save_info->$review_img_tmp != ""){   //기존 첨부가 있는지 파악 - 있다면 기존 파일 전체 삭제후 재 등록
                        $file_cnt1 = explode('@@',$review_save_info->$review_img_tmp);
                        for($j = 0; $j < count($file_cnt1); $j++){
                            $img_path = "";
                            $img_path = $path.'/'.$file_cnt1[$j];
                            if (file_exists($img_path)) {
                                @unlink($img_path); //이미지 삭제
                            }
                        }
                    }

                    $data['review_img_name'.$i] = "";  //배열에 추가 함
                    $data['review_img'.$i] = "";  //배열에 추가 함
                }
            }
        }

        if($temporary_yn == 'y'){
            $ment = '리뷰가 수정되었습니다.';
            $save_ok = redirect(route('mypage.review_possible_list'))->with('alert_messages', $ment);
        }else{
            $ment = '리뷰가 등록되었습니다.';
            $route_link = route("mypage.review_possible_list");
            $route_my_link = route("mypage.review_my_list");
            $save_ok = '
                <script>
                    if (confirm("리뷰가 등록되었습니다.\\n해당페이지에서 확인하시겠습니까?") == true){    //확인
                        location.href="'.$route_my_link.'";
                    }else{   //취소
                        location.href="'.$route_link.'";
                    }
                </script>
            ';

            //포인트 지급 처리
            $CustomUtils->insert_point(Auth::user()->user_id, $setting->text_point, '상품 평가 적립', 2,'', $order_id);
        }

        //저장 처리
        $update_result = review_saves::find($review_save_id)->update($data);

        if($temporary_yn == 'n'){
            //저장 버튼일때 이미지가 있는지 다시 파악해서 있으면 상품 포토 리뷰 적립를 적립 한다.
            $review_save_img = DB::table('review_saves')->select('review_img1', 'review_img2', 'review_img3', 'review_img4', 'review_img5')->where([['id', $review_save_id], ['item_code', $item_code], ['user_id', Auth::user()->user_id]])->first();

            for($r = 1; $r <= 5; $r++){
                $tmp_name = "review_img".$r;
                if($review_save_img->$tmp_name != ''){
                    //한개라도 등록 되어 있다면
                    $photo_flag = true;
                }
            }

            if($photo_flag == true){
                $CustomUtils->insert_point(Auth::user()->user_id, $setting->photo_point, '상품 포토 리뷰 적립', 12,'', $order_id);
            }

            //저장 처리 완료후 상품 평점 상품 테이블에 저장
            $CustomUtils->item_average($item_code);
        }

        if($update_result) return $save_ok;
        else return redirect(route('mypage.review_possible_list'))->with('alert_messages', '잠시 시스템 장애가 발생 하였습니다. 관리자에게 문의 하세요.');
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

        //첨부 파일 저장소
        $target_path = "data/review";
        if (!is_dir($target_path)) {
            @mkdir($target_path, 0755);
            @chmod($target_path, 0755);
        }

        $review_saves = DB::table('review_saves')->where([['exp_id', $exp_id], ['exp_app_id', $exp_app_id], ['sca_id', $sca_id], ['item_code', $item_info->item_code], ['user_id', Auth::user()->user_id], ['temporary_yn', 'y']]);
        $review_saves_info = array();

        if($review_saves->count() > 0){
            $review_saves_info = $review_saves->first();

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
        ]);
    }


}
