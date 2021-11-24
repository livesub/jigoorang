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
            ->select('b.*','a.created_at as regi_date')
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

        $rating_item_info = DB::table('rating_item')->where('sca_id', $item_info->sca_id)->first();

        //첨부 파일 저장소
        $target_path = "data/review";
        if (!is_dir($target_path)) {
            @mkdir($target_path, 0755);
            @chmod($target_path, 0755);
        }

        return view('member.review_possible_write',[
            'CustomUtils'       => $CustomUtils,
            'rating_item_info'  => $rating_item_info,
            'cart_id'           => $cart_id,
            'order_id'          => $order_id,
            'item_code'         => $item_code,
        ]);
    }

    public function review_possible_save(Request $request)
    {
        $CustomUtils = new CustomUtils;

        $cart_id        = $request->input('cart_id');
        $order_id       = $request->input('order_id');
        $item_code      = $request->input('item_code');
        $temporary_yn   = $request->input('temporary_yn');
        $average        = $request->input('average');

        //DB 저장 배열 만들기
        $data = array(
            'cart_id'       => $cart_id,
            'order_id'      => $order_id,
            'item_code'     => $item_code,
            'temporary_yn'  => $temporary_yn,
            'average'       => $average,
            'user_id'       => Auth::user()->user_id,
        );

        $score_val = '';
        for($j = 1; $j <= 5; $j++){
            $score_val  = 'score'.$j;
            $score      = $request->input($score_val);
            $data[$score_val] = $score;
        }
//var_dump($data);
        $review_content = $request->input('review_content');

        $upload_max_filesize = ini_get('upload_max_filesize');  //서버 설정 파일 용량 제한
        $upload_max_filesize = substr($upload_max_filesize, 0, -1); //2M (뒤에 M자르기)

        $thumb_name = "";
        $thumb_name2 = "";
        $photo_flag = false;
        $give_point = 0;

        $fileExtension = 'jpeg,jpg,png,gif,bmp,GIF,PNG,JPG,JPEG,BMP';  //이미지 일때 확장자 파악(이미지일 경우 썸네일 하기 위해)

        $path = 'data/review';     //첨부물 저장 경로

        //첨부파일 관리
        for($i = 1; $i <= 10; $i++){
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
        }else{
            $ment = '리뷰가 등록되었습니다.';
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

        if($create_result) return redirect(route('mypage.review_possible_list'))->with('alert_messages', $ment);
        else return redirect(route('mypage.review_possible_list'))->with('alert_messages', '잠시 시스템 장애가 발생 하였습니다. 관리자에게 문의 하세요.');
    }

}
