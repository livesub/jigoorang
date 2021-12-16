<?php
#############################################################################
#
#		파일이름		:		BannerController.php
#		파일설명		:		관리자 상단 배너 관리 control
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 11월 08일
#		최종수정일		:		2021년 11월 08일
#
###########################################################################-->

namespace App\Http\Controllers\adm\banner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use App\Helpers\Custom\PageSet; //페이지 함수
use Illuminate\Support\Facades\Auth;    //인증
use Illuminate\Support\Facades\DB;
use App\Models\banners;    //배너 모델 정의
use Validator;  //체크

class BannerController extends Controller
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

    public function index($type, Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $page       = $request->input('page');
        $pageScale  = 15;  //한페이지당 라인수
        $blockScale = 10; //출력할 블럭의 갯수(1,2,3,4... 갯수)

        if($page != "")
        {
            $start_num = $pageScale * ($page - 1);
        }else{
            $page = 1;
            $start_num = 0;
        }

        $banners = DB::table('banners')->where('b_type', $type);

        $total_record   = 0;
        $total_record   = $banners->count(); //총 게시물 수
        $total_page     = ceil($total_record / $pageScale);
        $total_page     = $total_page == 0 ? 1 : $total_page;

        $banner_rows = $banners->orderby('id', 'DESC')->offset($start_num)->limit($pageScale)->get();

        $virtual_num = $total_record - $pageScale * ($page - 1);

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

        if($type == 1) $title_ment = '상단';
        else $title_ment = '하단';

        return view('adm.banner.list',[
            'type'          => $type,
            'title_ment'    => $title_ment,
            'banners'       => $banner_rows,
            'virtual_num'   => $virtual_num,
            'pnPage'        => $pnPage,
            'page'          => $page,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($type)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        //첨부 파일 저장소
        $target_path = "data/banner";
        if (!is_dir($target_path)) {
            @mkdir($target_path, 0755);
            @chmod($target_path, 0755);
        }

        if($type == 1) $title_ment = '상단';
        else $title_ment = '하단';

        return view('adm.banner.create',[
            'type'          => $type,
            'title_ment'    => $title_ment,
        ]);
    }

    public function createsave(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $type       = $request->input('type');
        $b_name     = addslashes($request->input('b_name'));
        $b_display  = $request->input('b_display');
        $b_link     = addslashes($request->input('b_link'));
        $b_target   = $request->input('b_target');

        $upload_max_filesize = ini_get('upload_max_filesize');  //서버 설정 파일 용량 제한
        $upload_max_filesize = substr($upload_max_filesize, 0, -1); //2M (뒤에 M자르기)

        $thumb_name = "";
        $thumb_name2 = "";
        $fileExtension = 'jpeg,jpg,png,gif,bmp,GIF,PNG,JPG,JPEG,BMP';  //이미지 일때 확장자 파악(이미지일 경우 썸네일 하기 위해)

        //DB 저장 배열 만들기
        $data = array(
            'b_type'    => $type,
            'b_name'    => $b_name,
            'b_display' => $b_display,
            'b_link'    => $b_link,
            'b_target'  => $b_target,
        );

        if($request->hasFile('b_pc_img'))
        {
            $b_pc_img = $request->file('b_pc_img');
            $file_type = $b_pc_img->getClientOriginalExtension();    //이미지 확장자 구함
            $file_size = $b_pc_img->getSize();  //첨부 파일 사이즈 구함

            //서버 php.ini 설정에 따른 첨부 용량 확인(php.ini에서 바꾸기)
            $max_size_mb = $upload_max_filesize * 1024;   //라라벨은 kb 단위라 함

            //첨부 파일 용량 예외처리
            Validator::validate($request->all(), [
                'b_pc_img'  => ['max:'.$max_size_mb, 'mimes:'.$fileExtension]
            ], ['max' => $upload_max_filesize."MB 까지만 저장 가능 합니다.", 'mimes' => $fileExtension.' 파일만 등록됩니다.']);

            $path = 'data/banner';     //첨부물 저장 경로
            $attachment_result = CustomUtils::attachment_save($b_pc_img,$path); //위의 패스로 이미지 저장됨

            if(!$attachment_result[0])
            {
                return redirect()->route('adm.banner.create')->with('alert_messages', $Messages::$file_chk['file_chk']['file_false']);
                exit;
            }else{
                for($k = 0; $k < 2; $k++){
                    $resize_width_file_tmp = explode("%%","700%%100");
                    $resize_height_file_tmp = explode("%%","150%%100");

                    $thumb_width = $resize_width_file_tmp[$k];
                    $thumb_height = $resize_height_file_tmp[$k];

                    $is_create = false;
                    $thumb_name .= "@@".CustomUtils::thumbnail($attachment_result[1], $path, $path, $thumb_width, $thumb_height, $is_create, $is_crop=false, $crop_mode='center', $is_sharpen=false, $um_value='80/0.5/3');
                }

                $data['b_pc_ori_img'] = $attachment_result[2];  //배열에 추가 함
                $data['b_pc_img'] = $attachment_result[1].$thumb_name;  //배열에 추가 함
            }
        }

        if($request->hasFile('b_mobile_img'))
        {
            $b_mobile_img = $request->file('b_mobile_img');
            $file_type = $b_mobile_img->getClientOriginalExtension();    //이미지 확장자 구함
            $file_size = $b_mobile_img->getSize();  //첨부 파일 사이즈 구함

            //서버 php.ini 설정에 따른 첨부 용량 확인(php.ini에서 바꾸기)
            $max_size_mb = $upload_max_filesize * 1024;   //라라벨은 kb 단위라 함

            //첨부 파일 용량 예외처리
            Validator::validate($request->all(), [
                'b_mobile_img'  => ['max:'.$max_size_mb, 'mimes:'.$fileExtension]
            ], ['max' => $upload_max_filesize."MB 까지만 저장 가능 합니다.", 'mimes' => $fileExtension.' 파일만 등록됩니다.']);

            $path = 'data/banner';     //첨부물 저장 경로
            $attachment_result = CustomUtils::attachment_save($b_mobile_img,$path); //위의 패스로 이미지 저장됨

            if(!$attachment_result[0])
            {
                return redirect()->route('adm.banner.create')->with('alert_messages', $Messages::$file_chk['file_chk']['file_false']);
                exit;
            }else{
                for($k = 0; $k < 2; $k++){
                    $resize_width_file_tmp = explode("%%","700%%100");
                    $resize_height_file_tmp = explode("%%","150%%100");

                    $thumb_width = $resize_width_file_tmp[$k];
                    $thumb_height = $resize_height_file_tmp[$k];

                    $is_create = false;
                    $thumb_name2 .= "@@".CustomUtils::thumbnail($attachment_result[1], $path, $path, $thumb_width, $thumb_height, $is_create, $is_crop=false, $crop_mode='center', $is_sharpen=false, $um_value='80/0.5/3');
                }

                $data['b_mobile_ori_img'] = $attachment_result[2];  //배열에 추가 함
                $data['b_mobile_img'] = $attachment_result[1].$thumb_name2;  //배열에 추가 함
            }
        }

        //저장 처리
        $create_result = banners::create($data);
        $create_result->save();

        if($create_result) return redirect(route('adm.banner.index', $type))->with('alert_messages', '저장 되었습니다.');
        else return redirect(route('adm.banner.index', $type))->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['error']);  //치명적인 에러가 있을시
    }

    public function choice_del(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $type       = $request->input('type');

        $path = 'data/banner';     //첨부물 저장 경로

        for ($i = 0; $i < count($request->input('chk_id')); $i++) {
            //선택된 상품 일괄 삭제
            //먼저 배너를 검사하여 파일이 있는지 파악 하고 같이 삭제 함
            $banner_info = DB::table('banners')->where('id', $request->input('chk_id')[$i])->first();

            //첨부 파일 삭제
            $b_pc_img = $banner_info->b_pc_img;
            if($b_pc_img != ""){
                $file_cnt = explode('@@',$b_pc_img);

                for($j = 0; $j < count($file_cnt); $j++){
                    $img_path = "";
                    $img_path = $path.'/'.$file_cnt[$j];
                    if (file_exists($img_path)) {
                        @unlink($img_path); //이미지 삭제
                    }
                }
            }

            $b_mobile_img = $banner_info->b_mobile_img;
            if($b_mobile_img != ""){
                $file_cnt = explode('@@',$b_mobile_img);

                for($j = 0; $j < count($file_cnt); $j++){
                    $img_path = "";
                    $img_path = $path.'/'.$file_cnt[$j];
                    if (file_exists($img_path)) {
                        @unlink($img_path); //이미지 삭제
                    }
                }
            }

            DB::table('banners')->where('id',$request->input('chk_id')[$i])->delete();   //row 삭제
        }

        return redirect()->route('adm.banner.index', $type)->with('alert_messages', '삭제 되었습니다.');
    }

    public function modify(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $type       = $request->input('type');
        $id         = $request->input('num');
        $page       = $request->input('page');

        if($id == "" && $type == ""){
            return redirect()->back()->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['error']);
            exit;
        }

        $banner_info = DB::table('banners')->where('id', $id)->first();

        if($type == 1) $title_ment = '상단';
        else $title_ment = '하단';

        return view('adm.banner.modify',[
            'type'          => $type,
            'title_ment'    => $title_ment,
            'banner_info'   => $banner_info,
            'page'          => $page,
        ]);
    }

    public function modifysave(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $type       = $request->input('type');
        $id         = $request->input('num');
        $b_name     = addslashes($request->input('b_name'));
        $b_display  = $request->input('b_display');
        $b_link     = addslashes($request->input('b_link'));
        $b_target   = $request->input('b_target');
        $page       = $request->input('page');

        if($id == "" || $b_name == ""){
            return redirect()->back()->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['error']);
            exit;
        }

        $upload_max_filesize = ini_get('upload_max_filesize');  //서버 설정 파일 용량 제한
        $upload_max_filesize = substr($upload_max_filesize, 0, -1); //2M (뒤에 M자르기)

        $fileExtension = 'jpeg,jpg,png,gif,bmp,GIF,PNG,JPG,JPEG,BMP';  //이미지 일때 확장자 파악(이미지일 경우 썸네일 하기 위해)

        $path = 'data/banner';     //첨부물 저장 경로

        $thumb_name = "";
        $thumb_name2 = "";

        $banner_info = DB::table('banners')->where('id', $id)->first();

        //DB 저장 배열 만들기
        $data = array(
            'b_name'    => $b_name,
            'b_display' => $b_display,
            'b_link'    => $b_link,
            'b_target'  => $b_target,
        );

        $file_chk = $request->input('file_chk1'); //수정,삭제,새로등록 체크 파악
        if($file_chk == 1){ //체크된 것들만 액션
            if($request->hasFile('b_pc_img'))    //첨부가 있음
            {
                $b_pc_img = $request->file('b_pc_img');
                $file_type = $b_pc_img->getClientOriginalExtension();    //이미지 확장자 구함
                $file_size = $b_pc_img->getSize();  //첨부 파일 사이즈 구함

                //서버 php.ini 설정에 따른 첨부 용량 확인(php.ini에서 바꾸기)
                $max_size_mb = $upload_max_filesize * 1024;   //라라벨은 kb 단위라 함

                //첨부 파일 용량 예외처리
                Validator::validate($request->all(), [
                    'b_pc_img'  => ['max:'.$max_size_mb, 'mimes:'.$fileExtension]
                ], ['max' => $upload_max_filesize."MB 까지만 저장 가능 합니다.", 'mimes' => $fileExtension.' 파일만 등록됩니다.']);

                $attachment_result = CustomUtils::attachment_save($b_pc_img,$path); //위의 패스로 이미지 저장됨
                if(!$attachment_result[0])
                {
                    return redirect()->route('adm.banner.index')->with('alert_messages', $Messages::$file_chk['file_chk']['file_false']);
                    exit;
                }else{
                    for($k = 0; $k < 2; $k++){
                        $resize_width_file_tmp = explode("%%","700%%100");
                        $resize_height_file_tmp = explode("%%","150%%100");

                        $thumb_width = $resize_width_file_tmp[$k];
                        $thumb_height = $resize_height_file_tmp[$k];

                        $is_create = false;
                        $thumb_name .= "@@".CustomUtils::thumbnail($attachment_result[1], $path, $path, $thumb_width, $thumb_height, $is_create, $is_crop=false, $crop_mode='center', $is_sharpen=false, $um_value='80/0.5/3');
                    }

                    $data['b_pc_ori_img'] = $attachment_result[2];  //배열에 추가 함
                    $data['b_pc_img'] = $attachment_result[1].$thumb_name;  //배열에 추가 함
                }
            }else{
                $data['b_pc_ori_img'] = "";  //배열에 추가 함
                $data['b_pc_img'] = "";  //배열에 추가 함
            }

            if($banner_info->b_pc_img != ""){   //기존 첨부가 있는지 파악 - 있다면 기존 파일 전체 삭제후 재 등록
                $file_cnt1 = explode('@@',$banner_info->b_pc_img);
                for($j = 0; $j < count($file_cnt1); $j++){
                    $img_path = "";
                    $img_path = $path.'/'.$file_cnt1[$j];
                    if (file_exists($img_path)) {
                        @unlink($img_path); //이미지 삭제
                    }
                }
            }
        }

        $file_chk2 = $request->input('file_chk2'); //수정,삭제,새로등록 체크 파악
        if($file_chk2 == 1){ //체크된 것들만 액션
            if($request->hasFile('b_mobile_img'))    //첨부가 있음
            {
                $b_mobile_img = $request->file('b_mobile_img');
                $file_type = $b_mobile_img->getClientOriginalExtension();    //이미지 확장자 구함
                $file_size = $b_mobile_img->getSize();  //첨부 파일 사이즈 구함

                //서버 php.ini 설정에 따른 첨부 용량 확인(php.ini에서 바꾸기)
                $max_size_mb = $upload_max_filesize * 1024;   //라라벨은 kb 단위라 함

                //첨부 파일 용량 예외처리
                Validator::validate($request->all(), [
                    'b_mobile_img'  => ['max:'.$max_size_mb, 'mimes:'.$fileExtension]
                ], ['max' => $upload_max_filesize."MB 까지만 저장 가능 합니다.", 'mimes' => $fileExtension.' 파일만 등록됩니다.']);

                $attachment_result = CustomUtils::attachment_save($b_mobile_img,$path); //위의 패스로 이미지 저장됨
                if(!$attachment_result[0])
                {
                    return redirect()->route('adm.banner.index')->with('alert_messages', $Messages::$file_chk['file_chk']['file_false']);
                    exit;
                }else{
                    for($k = 0; $k < 2; $k++){
                        $resize_width_file_tmp = explode("%%","700%%100");
                        $resize_height_file_tmp = explode("%%","150%%100");

                        $thumb_width = $resize_width_file_tmp[$k];
                        $thumb_height = $resize_height_file_tmp[$k];

                        $is_create = false;
                        $thumb_name2 .= "@@".CustomUtils::thumbnail($attachment_result[1], $path, $path, $thumb_width, $thumb_height, $is_create, $is_crop=false, $crop_mode='center', $is_sharpen=false, $um_value='80/0.5/3');
                    }

                    $data['b_mobile_ori_img'] = $attachment_result[2];  //배열에 추가 함
                    $data['b_mobile_img'] = $attachment_result[1].$thumb_name2;  //배열에 추가 함
                }
            }else{
                $data['b_mobile_ori_img'] = "";  //배열에 추가 함
                $data['b_mobile_img'] = "";  //배열에 추가 함
            }

            if($banner_info->b_mobile_img != ""){   //기존 첨부가 있는지 파악 - 있다면 기존 파일 전체 삭제후 재 등록
                $file_cnt1 = explode('@@',$banner_info->b_mobile_img);
                for($j = 0; $j < count($file_cnt1); $j++){
                    $img_path = "";
                    $img_path = $path.'/'.$file_cnt1[$j];
                    if (file_exists($img_path)) {
                        @unlink($img_path); //이미지 삭제
                    }
                }
            }
        }

        $update_result = banners::find($id)->update($data);

        if($update_result) return redirect(route('adm.banner.index', $type))->with('alert_messages', '수정 되었습니다.');
        else return redirect(route('adm.banner.index', $type))->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['error']);  //치명적인 에러가 있을시
    }

}
