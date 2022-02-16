<?php

namespace App\Http\Controllers\adm\shop\category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use App\Helpers\Custom\PageSet; //페이지 함수
use Illuminate\Support\Facades\Auth;    //인증
use Illuminate\Support\Facades\DB;
use App\Models\shopcategorys;    //카테고리 모델 정의
use Validator;  //체크

class AdmShopCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $page     = $request->input('page');
        $pageScale  = 15;  //한페이지당 라인수
        $blockScale = 10; //출력할 블럭의 갯수(1,2,3,4... 갯수)

        if($page != "")
        {
            $start_num = $pageScale * ($page - 1);
        }else{
            $page = 1;
            $start_num = 0;
        }

        $scate_infos = DB::table('shopcategorys');

        $total_record   = 0;
        $total_record   = $scate_infos->count(); //총 게시물 수
        $total_page     = ceil($total_record / $pageScale);
        $total_page     = $total_page == 0 ? 1 : $total_page;

        $scate_rows = $scate_infos->orderby('sca_id', 'ASC')->offset($start_num)->limit($pageScale)->get();

        $virtual_num = $total_record - $pageScale * ($page - 1);
        $tailarr = array();
        //$tailarr['AA'] = 'AA';    //고정된 전달 파라메터가 있을때 사용

        $PageSet        = new PageSet;
        $showPage       = $PageSet->pageSet($total_page, $page, $pageScale, $blockScale, $total_record, $tailarr,"");
        $prevPage       = $PageSet->getPrevPage("<class='wide'>이전");
        $nextPage       = $PageSet->getNextPage("다음");
        $pre10Page      = $PageSet->pre10("이전10");
        $next10Page     = $PageSet->next10("다음10");
        $preFirstPage   = $PageSet->preFirst("처음");
        $nextLastPage   = $PageSet->nextLast("마지막");
        $listPage       = $PageSet->getPageList();
        $pnPage         = $preFirstPage.$prevPage.$listPage.$nextPage.$nextLastPage;

        return view('adm.shop.category.cate_list',[
            'virtual_num'       => $virtual_num,
            'totalCount'        => $total_record,
            "scate_infos"       => $scate_rows,
            'pnPage'            => $pnPage,
            'page'              => $page,
        ],$Messages::$mypage['mypage']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function catecreate(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $sca_id      = $request->input('sca_id');

        //코드 자동 생성
        $len        = strlen($sca_id);
        if ($len == 10){
            return redirect()->route('shop.cate.index')->with('alert_messages', $Messages::$category['insert']['cate_no']);
            exit;
        }

        $len2 = $len + 1;

        $max_sca_id = DB::select(" select MAX(SUBSTRING(sca_id,$len2,2)) as max_subid from shopcategorys where SUBSTRING(sca_id,1,$len) = '$sca_id' ");
        $subid = base_convert($max_sca_id[0]->max_subid, 36, 10);
        $subid += 36;

        if ($subid >= 36 * 36)
        {
        // 빈상태로
            $subid = "  ";
        }

        $subid = base_convert($subid, 10, 36);
        $subid = substr("00" . $subid, -2);
        $subid = $sca_id . $subid;

        $sublen = strlen($subid);

        return view('adm.shop.category.cate_create',[
            'mk_sca_id'          => $subid,
        ],$Messages::$mypage['mypage']);
    }

    public function createsave(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $mk_sca_id     = $request->input('mk_sca_id');

        if($mk_sca_id == "")    //1차 카테고리
        {
            return redirect('shop.cate.index')->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['error']);  //치명적인 에러가 있을시
            exit;
        }

        $sca_id          = $mk_sca_id;
        $sca_name_kr     = $request->input('sca_name_kr');
        $sca_name_en     = $request->input('sca_name_en');
        $sca_display     = $request->input('sca_display');
        $sca_rank        = $request->input('sca_rank');

        if($sca_rank == "") $sca_rank = 0;

        //DB 저장 배열 만들기
        $data = array(
            'sca_id'      => $sca_id,
            'sca_name_kr' => addslashes($sca_name_kr),
            'sca_name_en' => addslashes($sca_name_en),
            'sca_display' => $sca_display,
            'sca_rank'    => $sca_rank,
        );

        //이미지 첨부
        $fileExtension = 'jpeg,jpg,png,gif,bmp,GIF,PNG,JPG,JPEG,BMP';  //이미지 일때 확장자 파악(이미지일 경우 썸네일 하기 위해)
        $upload_max_filesize = ini_get('upload_max_filesize');  //서버 설정 파일 용량 제한
        $upload_max_filesize = substr($upload_max_filesize, 0, -1); //2M (뒤에 M자르기)

        $path = 'data/shopcate';     //첨부물 저장 경로

        if($request->hasFile('sca_img'))
        {
            $thumb_name = "";
            $sca_img = $request->file('sca_img');
            $file_type = $sca_img->getClientOriginalExtension();    //이미지 확장자 구함
            $file_size = $sca_img->getSize();  //첨부 파일 사이즈 구함

            //서버 php.ini 설정에 따른 첨부 용량 확인(php.ini에서 바꾸기)
            $max_size_mb = $upload_max_filesize * 1024;   //라라벨은 kb 단위라 함

            //첨부 파일 용량 예외처리
            Validator::validate($request->all(), [
                'sca_img'  => ['max:'.$max_size_mb, 'mimes:'.$fileExtension]
            ], ['max' => $upload_max_filesize."MB 까지만 저장 가능 합니다.", 'mimes' => $fileExtension.' 파일만 등록됩니다.']);

            $attachment_result = CustomUtils::attachment_save($sca_img,$path); //위의 패스로 이미지 저장됨
            if(!$attachment_result[0])
            {
                return redirect()->route('shop.cate.cate_add')->with('alert_messages', $Messages::$file_chk['file_chk']['file_false']);
                exit;
            }else{
                //썸네일 만들기
                for($k = 0; $k < 2; $k++){
                    $resize_width_file_tmp = explode("%%","230%%136");
                    $resize_height_file_tmp = explode("%%","230%%136");

                    $thumb_width = $resize_width_file_tmp[$k];
                    $thumb_height = $resize_height_file_tmp[$k];

                    $is_create = false;
                    $thumb_name .= "@@".CustomUtils::thumbnail($attachment_result[1], $path, $path, $thumb_width, $thumb_height, $is_create, $is_crop=false, $crop_mode='center', $is_sharpen=false, $um_value='80/0.5/3');
                }

                $data['sca_img_ori_file_name'] = $attachment_result[2];  //배열에 추가 함
                $data['sca_img'] = $attachment_result[1].$thumb_name;  //배열에 추가 함
            }
        }

        $create_result = shopcategorys::create($data)->exists();

/*
        $create_result = shopcategorys::create([
            'sca_id'      => $sca_id,
            'sca_name_kr' => addslashes($sca_name_kr),
            'sca_name_en' => addslashes($sca_name_en),
            'sca_display' => $sca_display,
            'sca_rank'    => $sca_rank,
        ])->exists();
*/
        if($create_result) return redirect()->route('shop.cate.index')->with('alert_messages', $Messages::$category['insert']['in_ok']);
        else return redirect()->route('shop.cate.index')->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['error']);  //치명적인 에러가 있을시 alert로 뿌리기 위해
    }

    public function cate_add(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $page        = $request->input('page');
        $sca_id      = $request->input('sca_id');

        if($sca_id == ""){
            return redirect()->route('shop.cate.index')->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['error']);  //치명적인 에러가 있을시 alert로 뿌리기 위해
            exit;
        }

        $categorys_name = DB::table('shopcategorys')->select('sca_name_kr','sca_name_en')->where('sca_id', $sca_id)->first();   //카테고리 이름 가져 오기

        //코드 자동 생성
        $len = strlen($sca_id);
        if ($len == 10){
            return redirect()->route('shop.cate.index')->with('alert_messages', $Messages::$category['insert']['cate_no']);
            exit;
        }

        $len2 = $len + 1;

        $max_sca_id = DB::select(" select MAX(SUBSTRING(sca_id,$len2,2)) as max_subid from shopcategorys where SUBSTRING(sca_id,1,$len) = '$sca_id' ");
        $subid = base_convert($max_sca_id[0]->max_subid, 36, 10);
        $subid += 36;

        if ($subid >= 36 * 36)
        {
        // 빈상태로
            $subid = "  ";
        }

        $subid = base_convert($subid, 10, 36);
        $subid = substr("00" . $subid, -2);
        $subid = $sca_id . $subid;

        $sublen = strlen($subid);

        //첨부 파일 저장소
        $target_path = "data/shopcate";
        if (!is_dir($target_path)) {
            @mkdir($target_path, 0755);
            @chmod($target_path, 0755);
        }

        return view('adm.shop.category.cate_add',[
            'mk_sca_id'         => $subid,
            'page'              => $page,
            'sca_name_kr'       => $categorys_name->sca_name_kr,
        ]);
    }

    public function cate_add_save(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $mk_sca_id     = $request->input('mk_sca_id');

        if($mk_sca_id == "")
        {
            return redirect('shop.cate.index')->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['error']);  //치명적인 에러가 있을시
            exit;
        }

        $sca_id          = $mk_sca_id;
        $sca_name_kr     = $request->input('sca_name_kr');
        $sca_name_en     = $request->input('sca_name_en');
        $sca_display     = $request->input('sca_display');
        $sca_rank        = $request->input('sca_rank');
        $page            = $request->input('page');

        if($sca_rank == "") $sca_rank = 0;

        //DB 저장 배열 만들기
        $data = array(
            'sca_id'      => $sca_id,
            'sca_name_kr' => addslashes($sca_name_kr),
            'sca_name_en' => addslashes($sca_name_en),
            'sca_display' => $sca_display,
            'sca_rank'    => $sca_rank,
        );

        //이미지 첨부
        $fileExtension = 'jpeg,jpg,png,gif,bmp,GIF,PNG,JPG,JPEG,BMP';  //이미지 일때 확장자 파악(이미지일 경우 썸네일 하기 위해)
        $upload_max_filesize = ini_get('upload_max_filesize');  //서버 설정 파일 용량 제한
        $upload_max_filesize = substr($upload_max_filesize, 0, -1); //2M (뒤에 M자르기)

        $path = 'data/shopcate';     //첨부물 저장 경로

        if($request->hasFile('sca_img'))
        {
            $thumb_name = "";
            $sca_img = $request->file('sca_img');
            $file_type = $sca_img->getClientOriginalExtension();    //이미지 확장자 구함
            $file_size = $sca_img->getSize();  //첨부 파일 사이즈 구함

            //서버 php.ini 설정에 따른 첨부 용량 확인(php.ini에서 바꾸기)
            $max_size_mb = $upload_max_filesize * 1024;   //라라벨은 kb 단위라 함

            //첨부 파일 용량 예외처리
            Validator::validate($request->all(), [
                'sca_img'  => ['max:'.$max_size_mb, 'mimes:'.$fileExtension]
            ], ['max' => $upload_max_filesize."MB 까지만 저장 가능 합니다.", 'mimes' => $fileExtension.' 파일만 등록됩니다.']);

            $attachment_result = CustomUtils::attachment_save($sca_img,$path); //위의 패스로 이미지 저장됨
            if(!$attachment_result[0])
            {
                return redirect()->route('shop.cate.cate_add')->with('alert_messages', $Messages::$file_chk['file_chk']['file_false']);
                exit;
            }else{
                //썸네일 만들기
                for($k = 0; $k < 2; $k++){
                    $resize_width_file_tmp = explode("%%","230%%136");
                    $resize_height_file_tmp = explode("%%","230%%136");

                    $thumb_width = $resize_width_file_tmp[$k];
                    $thumb_height = $resize_height_file_tmp[$k];

                    $is_create = false;
                    $thumb_name .= "@@".CustomUtils::thumbnail($attachment_result[1], $path, $path, $thumb_width, $thumb_height, $is_create, $is_crop=false, $crop_mode='center', $is_sharpen=false, $um_value='80/0.5/3');
                }

                $data['sca_img_ori_file_name'] = $attachment_result[2];  //배열에 추가 함
                $data['sca_img'] = $attachment_result[1].$thumb_name;  //배열에 추가 함
            }
        }

        $create_result = shopcategorys::create($data)->exists();

        if($create_result) return redirect()->route('shop.cate.index','&page='.$page)->with('alert_messages', $Messages::$category['insert']['in_ok']);
        else return redirect()->route('shop.cate.index')->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['error']);  //치명적인 에러가 있을시 alert로 뿌리기 위해
    }

    public function cate_modi(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $sca_id     = $request->input('sca_id');
        $page       = $request->input('page');

        if($sca_id == "")
        {
            return redirect('shop.cate.index')->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['error']);  //치명적인 에러가 있을시
            exit;
        }

        $categorys_info = DB::table('shopcategorys')->where('sca_id', $sca_id)->first();   //카테고리 정보 가져 오기

        return view('adm.shop.category.cate_modi',[
            'page'              => $page,
            'categorys_info'    => $categorys_info,
        ]);
    }

    public function cate_modi_save(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $id             = $request->input('id');
        $sca_id         = $request->input('sca_id');
        $page           = $request->input('page');
        $sca_name_kr     = $request->input('sca_name_kr');
        $sca_name_en     = $request->input('sca_name_en');
        $sca_display     = $request->input('sca_display');
        $sca_rank        = $request->input('sca_rank');

        if($id == "" || $sca_id == "")
        {
            return redirect('shop.cate.index')->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['error']);  //치명적인 에러가 있을시
            exit;
        }

        //DB 저장 배열 만들기
        $data = array(
            'sca_name_kr'    => addslashes($sca_name_kr),
            'sca_display'    => $sca_display,
        );

        if($sca_name_en == "") $data['sca_name_en'] = "";
        else $data['sca_name_en'] = addslashes($sca_name_en);

        if($sca_rank == "") $data['sca_rank'] = 0;
        else $data['sca_rank'] = $sca_rank;

        $cate_info = DB::table('shopcategorys')->where([['id', $id], ['sca_id',$sca_id]])->first();

        //첨부 이미지 처리
        $fileExtension = 'jpeg,jpg,png,gif,bmp,GIF,PNG,JPG,JPEG,BMP';  //이미지 일때 확장자 파악(이미지일 경우 썸네일 하기 위해)
        $upload_max_filesize = ini_get('upload_max_filesize');  //서버 설정 파일 용량 제한
        $upload_max_filesize = substr($upload_max_filesize, 0, -1); //2M (뒤에 M자르기)

        $path = 'data/shopcate';     //첨부물 저장 경로
        $file_chk = $request->input('file_chk'); //수정,삭제,새로등록 체크 파악

        if($file_chk == 1){ //체크된 것
            if($request->hasFile('sca_img'))    //첨부가 있음
            {
                $thumb_name = "";
                $sca_img = $request->file('sca_img');
                $file_type = $sca_img->getClientOriginalExtension();    //이미지 확장자 구함
                $file_size = $sca_img->getSize();  //첨부 파일 사이즈 구함

                //서버 php.ini 설정에 따른 첨부 용량 확인(php.ini에서 바꾸기)
                $max_size_mb = $upload_max_filesize * 1024;   //라라벨은 kb 단위라 함

                //첨부 파일 용량 예외처리
                Validator::validate($request->all(), [
                    'sca_img'  => ['max:'.$max_size_mb, 'mimes:'.$fileExtension]
                ], ['max' => $upload_max_filesize."MB 까지만 저장 가능 합니다.", 'mimes' => $fileExtension.' 파일만 등록됩니다.']);

                $attachment_result = CustomUtils::attachment_save($sca_img,$path); //위의 패스로 이미지 저장됨

                if(!$attachment_result[0])
                {
                    return redirect()->back()->with('alert_messages', $Messages::$file_chk['file_chk']['file_false']);
                    exit;
                }else{
                    //썸네일 만들기
                    for($k = 0; $k < 2; $k++){
                        $resize_width_file_tmp = explode("%%",'230%%136');
                        $resize_height_file_tmp = explode("%%",'230%%136');

                        $thumb_width = $resize_width_file_tmp[$k];
                        $thumb_height = $resize_height_file_tmp[$k];

                        $is_create = false;
                        $thumb_name .= "@@".CustomUtils::thumbnail($attachment_result[1], $path, $path, $thumb_width, $thumb_height, $is_create, $is_crop=false, $crop_mode='center', $is_sharpen=false, $um_value='80/0.5/3');
                    }

                    $data['sca_img_ori_file_name'] = $attachment_result[2];  //배열에 추가 함
                    $data['sca_img'] = $attachment_result[1].$thumb_name;  //배열에 추가 함

                    //기존 첨부 파일 삭제
                    $sca_img_tmp = 'sca_img';

                    if($cate_info->$sca_img_tmp != ""){   //기존 첨부가 있는지 파악 - 있다면 기존 파일 전체 삭제후 재 등록
                        $file_cnt1 = explode('@@',$cate_info->$sca_img_tmp);
                        for($j = 0; $j < count($file_cnt1); $j++){
                            $img_path = "";
                            $img_path = $path.'/'.$file_cnt1[$j];
                            if (file_exists($img_path)) {
                                @unlink($img_path); //이미지 삭제
                            }
                        }
                    }
                }
            }else{
                //체크는 되었으나 첨부파일이 없을때 기존 첨부 파일 삭제
                //기존 첨부 파일 삭제
                $sca_img_tmp = 'sca_img';

                if($cate_info->$sca_img_tmp != ""){   //기존 첨부가 있는지 파악 - 있다면 기존 파일 전체 삭제후 재 등록
                    $file_cnt1 = explode('@@',$cate_info->$sca_img_tmp);
                    for($j = 0; $j < count($file_cnt1); $j++){
                        $img_path = "";
                        $img_path = $path.'/'.$file_cnt1[$j];
                        if (file_exists($img_path)) {
                            @unlink($img_path); //이미지 삭제
                        }
                    }
                }

                $data['sca_img_ori_file_name'] = "";  //배열에 추가 함
                $data['sca_img'] = "";  //배열에 추가 함
            }
        }

        //$update_result = DB::table('shopcategorys')->where([['id', $id],['sca_id',$sca_id]])->update($data);
        $update_result = Shopcategorys::find($id)->update($data);

        if($update_result) return redirect()->route('shop.cate.index','&page='.$page)->with('alert_messages', $Messages::$category['update']['up_ok']);
        else return redirect('shop.cate.index')->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['error']);  //치명적인 에러가 있을시
    }

    public function cate_delete(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $id         = $request->input('id');
        $sca_id     = $request->input('sca_id');
        $page       = $request->input('page');

        //blade 에서 제어 했으나 한번더 제어 함(하위 카테고리가 있거나 상품이 있을 경우 삭제 안되게)
        $de_cate_info = DB::table('shopcategorys')->where('sca_id','like',$sca_id.'%')->count();   //하위 카테고리 갯수
        $de_item_info = DB::table('shopitems')->where('sca_id','like',$sca_id.'%')->count();   //상품 갯수

        $path = 'data/shopcate';     //첨부물 저장 경로

        if($de_cate_info == 1 && $de_item_info == 0){
            //이미지가 있는지 파악
            $cate_info = DB::table('shopcategorys')->where([['id', $id], ['sca_id',$sca_id]])->first();

            if($cate_info->sca_img != ""){
                $file_cnt = explode('@@',$cate_info->sca_img);

                for($j = 0; $j < count($file_cnt); $j++){
                    $img_path = "";
                    $img_path = $path.'/'.$file_cnt[$j];
                    if (file_exists($img_path)) {
                        @unlink($img_path); //이미지 삭제
                    }
                }
            }

            $cate_del = DB::table('shopcategorys')->where([['id',$id],['sca_id',$sca_id]])->delete();   //row 삭제

            if($cate_del){
                return redirect()->route('shop.cate.index')->with('alert_messages', $Messages::$category['cate_del']['cate_del_ok']);
            }else{
                return redirect()->back()->with('alert_messages', $Messages::$fatal_fail_ment['fatal_fail']['error']);
            }
        }else{
            return redirect()->route('shop.cate.index','page='.$page)->with('alert_messages', $Messages::$category['del']['del_chk']);
        }
    }

    public function downloadfile(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $id         = $request->input('id');

        $cate_info = DB::table('shopcategorys')->select('sca_img_ori_file_name', 'sca_img')->where('id', $id)->first();

        $file_cut = explode("@@",$cate_info->sca_img);
        $path = 'data/shopcate';     //첨부물 저장 경로

        $down_file = public_path($path.'/'.$file_cut[0]);

        return response()->download($down_file, $cate_info->sca_img_ori_file_name);
    }

    public function ajax_rank_choice(Request $request)
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $id                 = $request->input('id');
        $sca_rank_dispaly   = $request->input('sca_rank_dispaly');

        $update_result = Shopcategorys::find($id)->update(['sca_rank_dispaly' => $sca_rank_dispaly]);

        echo "ok";
        exit;
    }
}
