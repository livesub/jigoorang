<?php
#############################################################################
#
#		파일이름		:		NoticeController.php
#		파일설명		:		지구록 관리(소식) control
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2022년 01월 25일
#		최종수정일		:		2022년 01월 25일
#
###########################################################################-->

namespace App\Http\Controllers\adm\notice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use App\Helpers\Custom\PageSet; //페이지 함수
use Illuminate\Support\Facades\Auth;    //인증
use Illuminate\Support\Facades\DB;
use App\Models\notices;    //팝업 모델 정의

class NoticeController extends Controller
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

    public function notice_list(Request $request)
    {
        $CustomUtils = new CustomUtils;

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

        $notices = DB::table('notices');

        $total_record   = 0;
        $total_record   = $notices->count(); //총 게시물 수
        $total_page     = ceil($total_record / $pageScale);
        $total_page     = $total_page == 0 ? 1 : $total_page;

        $notice_rows = $notices->orderby('id', 'DESC')->offset($start_num)->limit($pageScale)->get();

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

        return view('adm.notice.notice',[
            'notices'       => $notice_rows,
            'virtual_num'   => $virtual_num,
            'pnPage'        => $pnPage,
            'page'          => $page,
        ]);
    }

    public function notice_write(Request $request)
    {
        $CustomUtils = new CustomUtils;

        //스마트 에디터 첨부파일 디렉토리 사용자 정의에 따라 변경 하기(관리 하기 편하게..)
        $directory = "data/notice/editor";
        setcookie('directory', $directory, (time() + 10800),"/"); //일단 3시간 잡음(3*60*60)

        //첨부 파일 저장소
        $target_path = "data/notice";
        if (!is_dir($target_path)) {
            @mkdir($target_path, 0755);
            @chmod($target_path, 0755);
        }

        return view('adm.notice.write',[
        ]);
    }

    public function notice_write_save(Request $request)
    {
        $CustomUtils = new CustomUtils;

        //스마트 에디터 시간 초과 파악
        if(!isset($_COOKIE['directory'])){
            return redirect()->back()->with('alert_messages', '글쓰기 시간이 초과 되었습니다');
            exit;
        }

        //DB 저장 배열 만들기
        $data = array(
            'n_subject'  => addslashes($request->input('n_subject')),
            'n_explain'  => addslashes($request->input('n_explain')),
            'n_content'  => $request->input('n_content'),
        );

        $thumb_name = "";

        if($request->hasFile('n_img'))
        {
            $n_img = $request->file('n_img');

            $path = 'data/notice';     //첨부물 저장 경로
            $attachment_result = CustomUtils::attachment_save($n_img,$path); //위의 패스로 이미지 저장됨

            if(!$attachment_result[0])
            {
                return redirect()->route('adm.pop.create')->with('alert_messages', '첨부 파일이 잘못 되었습니다');
                exit;
            }else{
                for($k = 0; $k < 3; $k++){
                    $resize_width_file_tmp = explode("%%","720%%360%%100");
                    $resize_height_file_tmp = explode("%%","360%%180%%70");

                    $thumb_width = $resize_width_file_tmp[$k];
                    $thumb_height = $resize_height_file_tmp[$k];

                    $is_create = false;
                    $thumb_name .= "@@".CustomUtils::thumbnail($attachment_result[1], $path, $path, $thumb_width, $thumb_height, $is_create, $is_crop=false, $crop_mode='center', $is_sharpen=false, $um_value='80/0.5/3');
                }

                $data['n_img_name'] = $attachment_result[2];  //배열에 추가 함
                $data['n_img'] = $attachment_result[1].$thumb_name;  //배열에 추가 함
            }
        }

        $create_result = notices::create($data)->exists();

        if($create_result) return redirect()->route('adm.notice')->with('alert_messages', '등록 되었습니다');
        else return redirect()->route('adm.notice')->with('alert_messages', '잠시 시스템 장애가 발생 하였습니다. 관리자에게 문의 하세요');  //치명적인 에러가 있을시 alert로 뿌리기 위해
    }


    public function notice_write_del(Request $request)
    {
        $CustomUtils = new CustomUtils;

        $id     = $request->input('num');

        if($id == "")
        {
            return redirect('adm.notice')->with('alert_messages', '잠시 시스템 장애가 발생 하였습니다. 관리자에게 문의 하세요');  //치명적인 에러가 있을시
            exit;
        }

        $path = 'data/notice';     //첨부물 저장 경로
        $editor_path = $path."/editor";     //스마트 에디터 첨부 저장 경로

        $notice_info = DB::table('notices')->where('id', $id)->first();   //팝업 정보

        if($notice_info->n_img != ""){   //기존 첨부가 있는지 파악 - 있다면 기존 파일 전체 삭제후 재 등록
            $file_cnt1 = explode('@@',$notice_info->n_img);
            for($j = 0; $j < count($file_cnt1); $j++){
                $img_path = "";
                $img_path = $path.'/'.$file_cnt1[$j];
                if (file_exists($img_path)) {
                    @unlink($img_path); //이미지 삭제
                }
            }
        }

        //스마트 에디터 내용에 첨부된 이미지 색제
        $editor_img_del = CustomUtils::editor_img_del($notice_info->n_content, $editor_path);
        $delete_result = DB::table('notices')->where('id',$id)->delete();   //row 삭제

        return redirect()->route('adm.notice')->with('alert_messages', '삭제 되었습니다');
    }

    public function notice_modify(Request $request)
    {
        $CustomUtils = new CustomUtils;

        $id     = $request->input('num');
        $page   = $request->input('page');

        if($id == "")
        {
            return redirect('adm.notice')->with('alert_messages', '잠시 시스템 장애가 발생 하였습니다. 관리자에게 문의 하세요');  //치명적인 에러가 있을시
            exit;
        }

        //스마트 에디터 첨부파일 디렉토리 사용자 정의에 따라 변경 하기(관리 하기 편하게..)
        $directory = "data/notice/editor";
        setcookie('directory', $directory, (time() + 10800),"/"); //일단 3시간 잡음(3*60*60)

        $notice_info = DB::table('notices')->where('id', $id)->first();

        return view('adm.notice.modify',[
            'page'          => $page,
            'notice_info'    => $notice_info,
        ]);
    }



}
