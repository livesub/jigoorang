<?php
#############################################################################
#
#		파일이름		:		PopupController.php
#		파일설명		:		팝업관리
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 09월 03일
#		최종수정일		:		2021년 09월 03일
#
###########################################################################-->

namespace App\Http\Controllers\adm\popup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use App\Helpers\Custom\PageSet; //페이지 함수
use Illuminate\Support\Facades\Auth;    //인증
use Illuminate\Support\Facades\DB;
use App\Models\popups;    //팝업 모델 정의

class PopupController extends Controller
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

        $pop_infos = DB::table('popups');   //정보 읽기

        $total_record   = 0;
        $total_record   = $pop_infos->count(); //총 게시물 수
        $total_page     = ceil($total_record / $pageScale);
        $total_page     = $total_page == 0 ? 1 : $total_page;

        $pop_rows = $pop_infos->orderby('id', 'DESC')->offset($start_num)->limit($pageScale)->get();

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
        $pnPage         = $preFirstPage.$prevPage.$listPage.$nextPage.$nextLastPage;

        return view('adm.popup.popuplist',[
            "pop_infos"     => $pop_rows,
            'virtual_num'   => $virtual_num,
            'pnPage'        => $pnPage,
            'page'          => $page,
        ],$Messages::$mypage['mypage']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $path = 'data/popup';     //첨부물 저장 경로
        if (!is_dir($path)) {
            @mkdir($path, 0755);
            @chmod($path, 0755);
        }

/*
        //스마트 에디터 첨부파일 디렉토리 사용자 정의에 따라 변경 하기(관리 하기 편하게..)
        $directory = "data/popup/editor";
        setcookie('directory', $directory, (time() + 10800),"/"); //일단 3시간 잡음(3*60*60)
*/
        return view('adm.popup.popupcreate',[
        ],$Messages::$mypage['mypage']);
    }

    public function createsave(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

/*
        //스마트 에디터 시간 초과 파악
        if(!isset($_COOKIE['directory'])){
            return redirect()->back()->with('alert_messages', $Messages::$board['b_ment']['time_over']);
            exit;
        }
*/
        //DB 저장 배열 만들기
        $data = array(
            'pop_disable_hours' => $request->input('pop_disable_hours'),
            'pop_start_time'    => $request->input('pop_start_time')." 00:00:00",
            'pop_end_time'      => $request->input('pop_end_time')." 23:59:59",
            'pop_left'          => $request->input('pop_left'),
            'pop_top'           => $request->input('pop_top'),
            'pop_width'         => $request->input('pop_width'),
            'pop_height'        => $request->input('pop_height'),
            'pop_subject'       => addslashes($request->input('pop_subject')),
            'pop_content'       => $request->input('pop_content'),
            'pop_display'       => $request->input('pop_display'),
            'pop_url'           => $request->input('pop_url'),
            'pop_target'        => $request->input('pop_target'),
        );

        $thumb_name = "";

        if($request->hasFile('pop_img'))
        {
            $pop_img = $request->file('pop_img');

            $path = 'data/popup';     //첨부물 저장 경로
            $attachment_result = CustomUtils::attachment_save($pop_img,$path); //위의 패스로 이미지 저장됨

            if(!$attachment_result[0])
            {
                return redirect()->route('adm.pop.create')->with('alert_messages', $Messages::$file_chk['file_chk']['file_false']);
                exit;
            }else{
                for($k = 0; $k < 3; $k++){
                    $resize_width_file_tmp = explode("%%","640%%320%%100");
                    $resize_height_file_tmp = explode("%%","840%%420%%150");

                    $thumb_width = $resize_width_file_tmp[$k];
                    $thumb_height = $resize_height_file_tmp[$k];

                    $is_create = false;
                    $thumb_name .= "@@".CustomUtils::thumbnail($attachment_result[1], $path, $path, $thumb_width, $thumb_height, $is_create, $is_crop=false, $crop_mode='center', $is_sharpen=false, $um_value='80/0.5/3');
                }

                $data['pop_img_name'] = $attachment_result[2];  //배열에 추가 함
                $data['pop_img'] = $attachment_result[1].$thumb_name;  //배열에 추가 함
            }
        }

        $create_result = popups::create($data)->exists();

        if($create_result) return redirect()->route('adm.popup.index')->with('alert_messages', $Messages::$popup['in_ok']);
        else return redirect()->route('adm.popup.index')->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['error']);  //치명적인 에러가 있을시 alert로 뿌리기 위해
    }

    public function modify(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $id     = $request->input('num');
        $page   = $request->input('page');

        if($id == "")
        {
            return redirect('adm.popup.index')->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['error']);  //치명적인 에러가 있을시
            exit;
        }
/*
        //스마트 에디터 첨부파일 디렉토리 사용자 정의에 따라 변경 하기(관리 하기 편하게..)
        $directory = "data/popup/editor";
        setcookie('directory', $directory, (time() + 10800),"/"); //일단 3시간 잡음(3*60*60)
*/
        $popup_info = DB::table('popups')->where('id', $id)->first();   //pop 가져 오기

        return view('adm.popup.popupmodify',[
            'page'          => $page,
            'popup_info'    => $popup_info,
        ],$Messages::$board['b_ment']);
    }

    public function modifysave(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $id     = $request->input('num');
        $page   = $request->input('page');

        if($id == "")
        {
            return redirect('adm.popup.index')->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['error']);  //치명적인 에러가 있을시
            exit;
        }
/*
        //스마트 에디터 시간 초과 파악
        if(!isset($_COOKIE['directory'])){
            return redirect()->back()->with('alert_messages', $Messages::$board['b_ment']['time_over']);
            exit;
        }
*/

        //DB 저장 배열 만들기
        $data = array(
            'pop_disable_hours' => $request->input('pop_disable_hours'),
            'pop_start_time'    => $request->input('pop_start_time')." 00:00:00",
            'pop_end_time'      => $request->input('pop_end_time')." 23:59:59",
            'pop_left'          => $request->input('pop_left'),
            'pop_top'           => $request->input('pop_top'),
            'pop_width'         => $request->input('pop_width'),
            'pop_height'        => $request->input('pop_height'),
            'pop_subject'       => addslashes($request->input('pop_subject')),
            'pop_content'       => $request->input('pop_content'),
            'pop_display'       => $request->input('pop_display'),
            'pop_url'           => $request->input('pop_url'),
            'pop_target'        => $request->input('pop_target'),
        );


        $path = 'data/popup';     //첨부물 저장 경로

        $thumb_name = "";
        $popup_info = DB::table('popups')->where('id', $id)->first();

        $file_chk = $request->input('file_chk1'); //수정,삭제,새로등록 체크 파악
        if($file_chk == 1){ //체크된 것들만 액션
            if($request->hasFile('pop_img'))    //첨부가 있음
            {
                $pop_img = $request->file('pop_img');
                $attachment_result = CustomUtils::attachment_save($pop_img,$path); //위의 패스로 이미지 저장됨

                if(!$attachment_result[0])
                {
                    return redirect()->route('adm.banner.index')->with('alert_messages', $Messages::$file_chk['file_chk']['file_false']);
                    exit;
                }else{
                    for($k = 0; $k < 3; $k++){
                        $resize_width_file_tmp = explode("%%","640%%320%%100");
                        $resize_height_file_tmp = explode("%%","840%%420%%150");

                        $thumb_width = $resize_width_file_tmp[$k];
                        $thumb_height = $resize_height_file_tmp[$k];

                        $is_create = false;
                        $thumb_name .= "@@".CustomUtils::thumbnail($attachment_result[1], $path, $path, $thumb_width, $thumb_height, $is_create, $is_crop=false, $crop_mode='center', $is_sharpen=false, $um_value='80/0.5/3');
                    }

                    $data['pop_img_name'] = $attachment_result[2];  //배열에 추가 함
                    $data['pop_img'] = $attachment_result[1].$thumb_name;  //배열에 추가 함
                }
            }

            if($popup_info->pop_img != ""){   //기존 첨부가 있는지 파악 - 있다면 기존 파일 전체 삭제후 재 등록
                $file_cnt1 = explode('@@',$popup_info->pop_img);
                for($j = 0; $j < count($file_cnt1); $j++){
                    $img_path = "";
                    $img_path = $path.'/'.$file_cnt1[$j];
                    if (file_exists($img_path)) {
                        @unlink($img_path); //이미지 삭제
                    }
                }
            }
        }

        //$update_result = DB::table('popups')->where('id', $id)->update($data);
        $update_result = Popups::find($id)->update($data);

        if($update_result) return redirect()->route('adm.popup.index','&page='.$page)->with('alert_messages', $Messages::$popup['up_ok']);
        else return redirect('adm.popup.index')->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['error']);  //치명적인 에러가 있을시
    }

    public function destroy(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $id     = $request->input('num');

        if($id == "")
        {
            return redirect('adm.popup.index')->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['error']);  //치명적인 에러가 있을시
            exit;
        }

        $path = 'data/popup';     //첨부물 저장 경로
        $editor_path = $path."/editor";     //스마트 에디터 첨부 저장 경로

        $pop_info = DB::table('popups')->where('id', $id)->first();   //팝업 정보


        if($pop_info->pop_img != ""){   //기존 첨부가 있는지 파악 - 있다면 기존 파일 전체 삭제후 재 등록
            $file_cnt1 = explode('@@',$pop_info->pop_img);
            for($j = 0; $j < count($file_cnt1); $j++){
                $img_path = "";
                $img_path = $path.'/'.$file_cnt1[$j];
                if (file_exists($img_path)) {
                    @unlink($img_path); //이미지 삭제
                }
            }
        }

        //스마트 에디터 내용에 첨부된 이미지 색제
//        $editor_img_del = CustomUtils::editor_img_del($pop_info->pop_content, $editor_path);
        $delete_result = DB::table('popups')->where('id',$id)->delete();   //row 삭제

        return redirect()->route('adm.popup.index')->with('alert_messages', $Messages::$popup['del_ok']);
    }
}
