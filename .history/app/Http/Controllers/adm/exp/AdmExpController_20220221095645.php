<?php

namespace App\Http\Controllers\adm\exp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//서비스 클래스 추가
use App\Services\ExpService;
//request 클래스 추가
use App\Http\Requests\ExpListRequest;
//파일 관련 퍼사드 추가
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
//models 추가
use App\Models\ExpList;

use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use Illuminate\Support\Facades\Auth;    //인증
use Illuminate\Support\Facades\DB;
use App\Models\items;    //상품 모델 정의
use Validator;  //체크
use App\Models\categorys;

class AdmExpController extends Controller
{
    public function __construct(ExpService $expService, ExpList $expList)
    {
        $this->expService = $expService;
        $this->expList = $expList;
    }

    //뷰 리스트 관련 함수
    public function index(Request $request){
        $page = $request->input('page');
        $ca_id = $request->input('ca_id');
        $exp_date_start = $request->input('exp_date_start');

        $keyword = $request->input('keyword');
        //$page = 0;
        //$expAllLists = $this->expList->latest()->paginate(1);
        $exp_directory = "data/exp_list/editor";
        //setcookie('dir', public_path());
        setcookie('directory', $exp_directory, (time() + 10800),"/"); //일단 3시간 잡음(3*60*60)

        return $this->expService->set_page($page, '', $ca_id, $exp_date_start, $keyword);
        //return view('adm.exp.exp_list', compact('expAllLists'));
    }

    //체험단 신청 뷰 관련 함수
    public function view_create(){
        //신청 뷰로 이동
        //스마트 에디터 경로 설정(쿠키로 설정)
        //$exp_directory = "data/shopitem/editor";
        $exp_directory = "data/exp_list/editor";
        //setcookie('dir', public_path());
        setcookie('directory', $exp_directory, (time() + 10800),"/"); //일단 3시간 잡음(3*60*60)
        $path = public_path('data/exp_list');

        //폴더가 없으면 만들기
        if(!is_dir($path)){
            mkdir($path, 0755, true);
            @chmod($path, 0755);
        }

        if(!is_dir($exp_directory)){
            mkdir($exp_directory, 0755, true);
            @chmod($exp_directory, 0755);
        }

        return view('adm.exp.exp_create');
    }

    //체험단 저장 (서비스 클래스에 위임)
    public function view_save(ExpListRequest $request){
        //파일은 request 통해 확인하고 저장한 뒤에 DB이용 것들은 서비스 클래스에 위임 한다.

        $fileName = "";
        $path = "";

        $upload_max_filesize = ini_get('upload_max_filesize');  //서버 설정 파일 용량 제한
        $upload_max_filesize = substr($upload_max_filesize, 0, -1); //2M (뒤에 M자르기)

        $thumb_name = "";
        $thumb_name2 = "";
        $fileExtension = 'jpeg,jpg,png,gif,bmp,GIF,PNG,JPG,JPEG,BMP';  //이미지 일때 확장자 파악(이미지일 경우 썸네일 하기 위해)

        if($request->hasFile('exp_main_image'))
        {
            $exp_main_image = $request->file('exp_main_image');
            $file_type = $exp_main_image->getClientOriginalExtension();    //이미지 확장자 구함
            $file_size = $exp_main_image->getSize();  //첨부 파일 사이즈 구함

            //서버 php.ini 설정에 따른 첨부 용량 확인(php.ini에서 바꾸기)
            $max_size_mb = $upload_max_filesize * 1024;   //라라벨은 kb 단위라 함

            //첨부 파일 용량 예외처리
            Validator::validate($request->all(), [
                'exp_main_image'  => ['max:'.$max_size_mb, 'mimes:'.$fileExtension]
            ], ['max' => $upload_max_filesize."MB 까지만 저장 가능 합니다.", 'mimes' => $fileExtension.' 파일만 등록됩니다.']);

            $path = 'data/exp_list';     //첨부물 저장 경로
            $attachment_result = CustomUtils::attachment_save($exp_main_image,$path); //위의 패스로 이미지 저장됨

            if(!$attachment_result[0])
            {
                //return redirect()->route('adm.banner.create')->with('alert_messages', $Messages::$file_chk['file_chk']['file_false']);
                return false;
                exit;
            }else{
                for($k = 0; $k < 2; $k++){
                    $resize_width_file_tmp = explode("%%","360%%260");
                    $resize_height_file_tmp = explode("%%","180%%100");

                    $thumb_width = $resize_width_file_tmp[$k];
                    $thumb_height = $resize_height_file_tmp[$k];

                    $is_create = false;
                    $thumb_name .= "@@".CustomUtils::thumbnail($attachment_result[1], $path, $path, $thumb_width, $thumb_height, $is_create, $is_crop=false, $crop_mode='center', $is_sharpen=false, $um_value='80/0.5/3');
                }

                //$data['b_pc_ori_img'] = $attachment_result[2];  //배열에 추가 함
                //$data['exp_main_image'] = $attachment_result[1].$thumb_name;  //배열에 추가 함
                $request->exp_main_ori_image = $attachment_result[2];
                $request->exp_main_image = $attachment_result[1].$thumb_name;

                //서비스 클래스에 위임
                $this->expService->exp_save($request);
            }
        }

        return redirect()->route('adm_exp_index')->with('alert_messages', "등록이 완료되었습니다.");
    }

    //수정 페이지 반환 함수
    public function view_restore($id){

        $result_expList = $this->expList->find($id);

        return view('adm.exp.exp_modi', compact('result_expList'));
    }

    //실제 DB 수정 관련 함수
    public function view_modi(ExpListRequest $request, $id){

        $exp_title     = addslashes($request->input('exp_title'));

        if($id == "" || $exp_title == ""){
            return redirect()->back()->with('alert_messages', '잘못된 경로 입니다.');
            exit;
        }

        $upload_max_filesize = ini_get('upload_max_filesize');  //서버 설정 파일 용량 제한
        $upload_max_filesize = substr($upload_max_filesize, 0, -1); //2M (뒤에 M자르기)

        $fileExtension = 'jpeg,jpg,png,gif,bmp,GIF,PNG,JPG,JPEG,BMP';  //이미지 일때 확장자 파악(이미지일 경우 썸네일 하기 위해)

        $path = 'data/exp_list';     //첨부물 저장 경로

        $thumb_name = "";
        $thumb_name2 = "";

        $result_exp = $this->expList->find($id);

        $file_chk = $request->input('file_chk'); //수정,삭제,새로등록 체크 파악

        if($file_chk == 1){ //체크된 것들만 액션
            if($request->hasFile('exp_main_image'))    //첨부가 있음
            {
                $exp_main_image = $request->file('exp_main_image');
                $file_type = $exp_main_image->getClientOriginalExtension();    //이미지 확장자 구함
                $file_size = $exp_main_image->getSize();  //첨부 파일 사이즈 구함

                //서버 php.ini 설정에 따른 첨부 용량 확인(php.ini에서 바꾸기)
                $max_size_mb = $upload_max_filesize * 1024;   //라라벨은 kb 단위라 함

                //첨부 파일 용량 예외처리
                Validator::validate($request->all(), [
                    'exp_main_image'  => ['max:'.$max_size_mb, 'mimes:'.$fileExtension]
                ], ['max' => $upload_max_filesize."MB 까지만 저장 가능 합니다.", 'mimes' => $fileExtension.' 파일만 등록됩니다.']);

                $attachment_result = CustomUtils::attachment_save($exp_main_image,$path); //위의 패스로 이미지 저장됨
                if(!$attachment_result[0])
                {
                    return redirect()->route('adm_exp_index')->with('alert_messages', '첨부 파일이 잘못 되었습니다.');
                    exit;
                }else{
                    for($k = 0; $k < 2; $k++){
                        $resize_width_file_tmp = explode("%%","360%%260");
                        $resize_height_file_tmp = explode("%%","180%%100");

                        $thumb_width = $resize_width_file_tmp[$k];
                        $thumb_height = $resize_height_file_tmp[$k];

                        $is_create = false;
                        $thumb_name .= "@@".CustomUtils::thumbnail($attachment_result[1], $path, $path, $thumb_width, $thumb_height, $is_create, $is_crop=false, $crop_mode='center', $is_sharpen=false, $um_value='80/0.5/3');
                    }

                    $request->exp_main_ori_image = $attachment_result[2];
                    $request->exp_main_image = $attachment_result[1].$thumb_name;
                }
            }else{
                $request->exp_main_ori_image = '';
                $request->exp_main_image = '';
            }

            if($result_exp->main_image_name != ""){   //기존 첨부가 있는지 파악 - 있다면 기존 파일 전체 삭제후 재 등록
                $file_cnt = explode('@@',$result_exp->main_image_name);
                for($j = 0; $j < count($file_cnt); $j++){
                    $img_path = "";
                    $img_path = $path.'/'.$file_cnt[$j];
                    if (file_exists($img_path)) {
                        @unlink($img_path); //이미지 삭제
                    }
                }
            }
        }

        $this->expService->exp_modi($request, $id);

        return redirect()->route('adm_exp_index')->with('alert_messages', "수정이 완료되었습니다.");
    }

    //체험단 삭제 DB 저장
    public function delete_expList($id){

        $path = 'data/exp_list';     //첨부물 저장 경로

        $result_exp = $this->expList->find($id);

        //첨부 파일 삭제
        $main_image_name = $result_exp->main_image_name;
        if($main_image_name != ""){
            $file_cnt = explode('@@',$main_image_name);

            for($j = 0; $j < count($file_cnt); $j++){
                $img_path = "";
                $img_path = $path.'/'.$file_cnt[$j];
                if (file_exists($img_path)) {
                    @unlink($img_path); //이미지 삭제
                }
            }
        }

        $this->expService->exp_delete($id);

        return redirect()->route('adm_exp_index')->with('alert_messages', '삭제가 완료되었습니다.');
    }

    //체험단 등록 시 상품검색관련 라우트
    public function popup_for_search_item(Request $request){

        return $this->expService->exp_popup($request);
        //return view('adm.exp.item_search');

    }
}
