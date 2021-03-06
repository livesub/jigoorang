<?php
#############################################################################
#
#		파일이름		:		CustomUtils.php
#		파일설명		:		사용자 제작 함수
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 07월 14일
#		최종수정일		:		2021년 07월 14일
#
###########################################################################-->

namespace App\Helpers\Custom;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//use Validator;  //체크
use Illuminate\Support\Facades\Mail;    //메일 class
use App\Helpers\Custom\Messages_kr;    //한글 error 메세지 모음
use App\Helpers\Custom\Messages_en;    //영어 error 메세지 모음
use Illuminate\Support\Facades\DB;
use App\Models\shop_uniqids;    //장바구니 키
use App\Models\shoppoints;    //포인트 모델 정의
use App\Models\User;    //회원 모델 정의
use App\Models\wishs;    //wish 모델 정의
use App\Models\shoppostlogs;    //주문시 오류 로그 모델 정의
use App\Models\baesongjis;    //배송지 모델 정의
use Illuminate\Support\Facades\Auth;    //인증

class CustomUtils extends Controller
{
/*    안씀!!!
    //$request => 입력값, $name => 입력 필드 이름, $chk => 체크 형태 )
    public static function validator_chk($request, $name, $chk)
    {
        $validator = Validator::make($request, $chk);

return $validator;

//        if ($validator->fails()) return false;
//        else return true;
    }
*/
    //가입 이메일 보내기 함수
    public static function email_send($email_blade, $user_name, $user_id, $subject, $data)
    {
        Mail::send(
            $email_blade,
            $data,
            //function($message) use ($to_name, $to_email) {
            function($message) use ($user_name, $user_id, $subject) {
                $message->to($user_id, $user_name)->subject($subject);
                //이메일, 이름
                $message->from(config('app.ADMIN_ID'),config('app.ADMIN_NAME'));
            }
        );

        if(count(Mail::failures()) > 0){
            return false;
        }else{
            return true;
        }
    }

    //회원 이메일 보내기 함수(첨부파일)
    public static function email_mem_send($email_blade, $data, $files = '')
    {
        Mail::send(
            $email_blade,
            $data,
            //function($message) use ($to_name, $to_email) {
            function($message) use ($data, $files) {
                $message->to($data["email"], $data["name"])->subject($data["subject"]);

                if(count($files) != 0){
                    foreach ($files as $file){
                        $message->attach($file);
                    }
                }

                //이메일, 이름
                $message->from(config('app.ADMIN_ID'),config('app.ADMIN_NAME'));
            }
        );

        if(count(Mail::failures()) > 0){
            return false;
        }else{
            return true;
        }
    }

    //파일 경로를 반환 하는 함수
    public static function attachments_path($path = '')
    {
        //return public_path($path.($path ? DIRECTORY_SEPARATOR.$path : $path));
        return public_path($path);
    }

    public static function attachment_save($file,$path)
    {
        //$file_name = time().filter_var($file->getClientOriginalName(),FILTER_SANITIZE_URL);     //파일 이름 변환
        //이슈!! 한글 파일명일때 변환을 해 주지 않아 같은 시간대로 파일 덮어 버림
        $file_name = uniqid().filter_var($file->getClientOriginalName(),FILTER_SANITIZE_URL);     //파일 이름 변환
        $file_ori_name = $file->getClientOriginalName();    //원본 파일 이름

        if (!$file->move(CustomUtils::attachments_path($path),$file_name)) {
            return ['false', $file_name, $file_ori_name];
        }else{
            return ['true', $file_name, $file_ori_name];
        }
    }

    public static function language_pack($type)
    {
        if($type == 'kr' || $type == '') $Messages = new Messages_kr;
        else $Messages = new Messages_en;

        return $Messages;
    }

    public static function page_function($table_name, $pageNum, $writeList, $pageNumList, $type, $bm_tb_name='', $cate='', $keymethod='', $keyword='')
    {
        //$table_name = 테이블 이름
        //$pageNum = get 방식의 호출 페이지 번호
        //$writeList = 한 화면에 보여줄 데이터 갯수
        //$pageNumList = 한 페이지당 표시될 글 갯수
        //$type = 게시판 페이징인지 다른 곳 페이징인지 선택
        //$bm_tb_name = 게시판 이름
        //$cate = 카테고리 선택시
        //$keymethod = 검색 이 있을시 (칼럼) - 조건으로도 쓰임
        //$keyword = 검색 이 있을시 (검색어) - 조건으로도 쓰임

        $page = array();
        $searchinfo = "";
        $cateinfo = '';
        $search_sql = "";
        $search_cate = "";

        if($type == 'member' || $type == 'cate' || $type == 'menu' || $type == 'email' || $type == 'visits' || $type == 'membervisits' || $type == 'shopcate' || $type == 'popup'){
            if($type == 'member'){
                $total_cnt = DB::table($table_name)->where('user_level','>','1')->count();
            }else{
                $total_cnt = DB::table($table_name)->count();
            }

        }else if($type == 'items'){
            if($cate != "") $search_sql = " AND a.ca_id = b.ca_id AND a.ca_id LIKE '{$cate}%' AND a.{$keymethod} LIKE '%{$keyword}%' ";
            else $search_sql = " AND a.ca_id = b.ca_id AND a.{$keymethod} LIKE '%{$keyword}%' ";

            $cateinfo = "&ca_id=".$cate;
            $cateinfo .= "&item_search=".$keymethod;
            $cateinfo .= "&keyword=".$keyword;

            $total_tmp = DB::select("select count(*) as cnt from items a, categorys b where 1 {$search_sql} ");
            $total_cnt = $total_tmp[0]->cnt;
        }else if($type == 'shopitems'){ //쇼핑몰 상품
            if($cate != "") $search_sql = " AND a.sca_id = b.sca_id AND a.sca_id LIKE '{$cate}%' AND a.{$keymethod} LIKE '%{$keyword}%' ";
            else $search_sql = " AND a.sca_id = b.sca_id AND a.{$keymethod} LIKE '%{$keyword}%' ";

            $cateinfo = "&ca_id=".$cate;
            $cateinfo .= "&item_search=".$keymethod;
            $cateinfo .= "&keyword=".$keyword;

            $total_tmp = DB::select("select count(*) as cnt from shopitems a, shopcategorys b where a.item_del = 'N' AND a.item_display = 'Y' {$search_sql} ");
            $total_cnt = $total_tmp[0]->cnt;
        }else if($type == 'f_shopitems'){ //프론트 쇼핑몰 상품 리스트
            if($cate != "") $search_sql = " AND a.sca_id = b.sca_id AND a.sca_id LIKE '{$cate}%' AND a.{$keymethod} LIKE '%{$keyword}%' ";
            else $search_sql = " AND a.sca_id = b.sca_id AND a.{$keymethod} LIKE '%{$keyword}%' ";

            $cateinfo = "&ca_id=".$cate;
            $cateinfo .= "&item_search=".$keymethod;
            $cateinfo .= "&keyword=".$keyword;

            $total_tmp = DB::select("select count(*) as cnt from shopitems a, shopcategorys b where a.item_del = 'N' AND a.item_display = 'Y' {$search_sql} and a.item_display = 'Y' and a.item_use = 1 and b.sca_display = 'Y' ");
            $total_cnt = $total_tmp[0]->cnt;
        }else if($type == 'email_send'){
            //이메일 발송 리스트 일때
            $total_cnt = DB::table($table_name)->where($keymethod,$keyword)->count();
            $cateinfo = "&id=".$keyword;
        }else{
            //게시판일때
            if($keymethod != "" && $keyword != ""){
                if($keymethod == "all"){
                    $search_sql = " AND (bdt_subject LIKE '%{$keyword}%' OR bdt_content LIKE '%{$keyword}%') ";
                }else{
                    $search_sql = " AND {$keymethod} LIKE '%{$keyword}%' ";
                }
                $searchinfo = "&keymethod=".$keymethod."&keyword=".$keyword;
            }

            $cate_sql = "";
            if($cate != ""){
                $cate_sql = " AND bdt_category = '{$cate}'";
                $cateinfo = "&cate=".$cate;
            }

            $total_tmp = DB::select("select count(*) as cnt from board_datas_tables where bm_tb_name = '{$bm_tb_name}' {$cate_sql} {$search_sql}");
            $total_cnt = $total_tmp[0]->cnt;
        }

        // view에서 넘어온 현재페이지의 파라미터 값.
        $page['pageNum']     = (isset($pageNum)?$pageNum:1);
        // 페이지 번호가 없으면 1, 있다면 그대로 사용
        $page['startNum']    = ($page['pageNum'] - 1) * $writeList;
        // 한 페이지당 표시될 글 갯수
        $page['pageNumList'] = $pageNumList;
        // 전체 페이지 중 표시될 페이지 갯수
        $page['pageGroup']   = ceil($page['pageNum'] / $page['pageNumList']);
        // 페이지 그룹 번호
        //$page['startPage']   = (($page['pageGroup'] - 1) * $page['pageNumList']) + 1;
        $page['startPage']   = 1;
        // 페이지 그룹 내 첫 페이지 번호
        $page['endPage']     = $page['startPage'] + $page['pageNumList'] - 1;
        // 페이지 그룹 내 마지막 페이지 번호
        $page['totalCount']  = $total_cnt;
        // 전체 게시글 갯수
        $page['totalPage']   = ceil($page['totalCount'] / $writeList); //5
        // 전체 페이지 갯수
        //if($page['endPage'] >= $page['totalPage']) {
            $page['endPage'] = $page['totalPage'];
        //} // 페이지 그룹이 마지막일 때 마지막 페이지 번호

        $page['virtual_num'] = $page['totalCount'] - $page['pageNumList'] * ($page['pageNum'] - 1);

        //페이징 관련
        if($page['endPage'] != 0){
            $page['preFirstPage'] = "<a href = '?pageNum=".$page['startPage'].$cateinfo.$searchinfo."'><<&nbsp</a>";
        }else{
            $page['preFirstPage'] = "<<&nbsp";
        }

        if($page['pageNum'] == 1)
        {
            $page['pre1Page'] = "";
        }else{
            $page['pre1Page'] = "<a href = '?page=".($page['pageNum'] - 1).$cateinfo.$searchinfo."'>&nbsp<</a>";
        }

        $page_hap = "";
        if($page['endPage'] != 0){
            for($i=$page['startPage']; $i<=$page['endPage']; $i++)
            {
                $page_hap .= "<a href = '?page=".$i.$cateinfo.$searchinfo."'>&nbsp".$i."&nbsp</a>";
            }
        }else{
            $page_hap = "&nbsp1&nbsp";
        }

        $page['listPage'] = $page_hap;

        if($page['pageNum'] == $page['totalPage'])
        {
            $page['next1Page'] = "";
        }else{
            if($page['endPage'] != 0){
                $page['next1Page'] = "<a href = '?page=".($page['pageNum'] + 1).$cateinfo.$searchinfo."'>&nbsp>&nbsp</a>";
            }else{
                $page['next1Page'] = "";
            }
        }

        if($page['endPage'] != 0){
            $page['nextLastPage'] = "<a href = '?page=".$page['endPage'].$cateinfo.$searchinfo."'>&nbsp>></a>";
        }else{
            $page['nextLastPage'] = "&nbsp>>";
        }

        return $page;
    }

    public static function admin_access($user_level,$admin_level)
    {
        if($user_level > $admin_level){
            return false;
        }else{
            return true;
        }
    }

    public static function thumbnail($filename, $source_path, $target_path, $thumb_width, $thumb_height, $is_create, $is_crop=false, $crop_mode='center', $is_sharpen=false, $um_value='80/0.5/3')
    {
/*
$filename, -> 확장자를 포함한 파일명(ex abc.jpg) - 서버에 올라간 파일명
$source_path, -> 파일의 위치(ex G5_DATA_PATH.'/file/bo_table')
$target_path, -> 썸네일 폴더 생성위치(ex G5_DATA_PATH.'/file/bo_table')
$thumb_width, -> 생성 썸네일의 기준 넓이 또는 제한넓이
$thumb_height,-> 생성 썸네일의 기준 높이 또는 제한높이
$is_create, -> 페이지 새로고침 시 마다 썸네일을 재성성 할지 여부
$is_crop=false, -> 썸네일이 기준보다 클 경우 자를지여부
$crop_mode='center', -> 자를때 기준점
$is_sharpen=false,
$um_value='80/0.5/3'
*/

        if(!$thumb_width && !$thumb_height)
            return;

        $source_file = "$source_path/$filename";

        if(!is_file($source_file)) // 원본 파일이 없다면
            return;

        $size = @getimagesize($source_file);
        if(!isset($size[2]) || $size[2] < 1 || $size[2] > 3) // gif, jpg, png 에 대해서만 적용
            return;

        if (!is_dir($target_path)) {
            @mkdir($target_path, 0755);
            @chmod($target_path, 0755);
        }

        // 디렉토리가 존재하지 않거나 쓰기 권한이 없으면 썸네일 생성하지 않음
        if(!(is_dir($target_path) && is_writable($target_path)))
            return '';

        // Animated GIF는 썸네일 생성하지 않음
/*
        if($size[2] == 1) {
            if(is_animated_gif($source_file))
                return basename($source_file);
        }
*/
        $ext = array(1 => 'gif', 2 => 'jpg', 3 => 'png');

        $thumb_filename = preg_replace("/\.[^\.]+$/i", "", $filename); // 확장자제거
        $thumb_file = "$target_path/thumb-{$thumb_filename}_{$thumb_width}x{$thumb_height}.".$ext[$size[2]];

        $thumb_time = @filemtime($thumb_file);
        $source_time = @filemtime($source_file);

        if (file_exists($thumb_file)) {
            if ($is_create == false && $source_time < $thumb_time) {
                return basename($thumb_file);
            }
        }

        // 원본파일의 GD 이미지 생성
        $src = null;
        $degree = 0;

        if ($size[2] == 1) {
            $src = @imagecreatefromgif($source_file);
            $src_transparency = @imagecolortransparent($src);
        } else if ($size[2] == 2) {
            $src = @imagecreatefromjpeg($source_file);

            if(function_exists('exif_read_data')) {
                // exif 정보를 기준으로 회전각도 구함
                $exif = @exif_read_data($source_file);
                if(!empty($exif['Orientation'])) {
                    switch($exif['Orientation']) {
                        case 8:
                            $degree = 90;
                            break;
                        case 3:
                            $degree = 180;
                            break;
                        case 6:
                            $degree = -90;
                            break;
                    }

                    // 회전각도 있으면 이미지 회전
                    if($degree) {
                        $src = imagerotate($src, $degree, 0);

                        // 세로사진의 경우 가로, 세로 값 바꿈
                        if($degree == 90 || $degree == -90) {
                            $tmp = $size;
                            $size[0] = $tmp[1];
                            $size[1] = $tmp[0];
                        }
                    }
                }
            }
        } else if ($size[2] == 3) {
            $src = @imagecreatefrompng($source_file);
            @imagealphablending($src, true);
        } else {
            return;
        }

        if(!$src)
            return;

        $is_large = true;
        // width, height 설정

        if($thumb_width) {
            if(!$thumb_height) {
                $thumb_height = round(($thumb_width * $size[1]) / $size[0]);
            } else {
                if($crop_mode === 'center' && ($size[0] > $thumb_width || $size[1] > $thumb_height)){
                    $is_large = true;
                } else if($size[0] < $thumb_width || $size[1] < $thumb_height) {
                    $is_large = false;
                }
            }
        } else {
            if($thumb_height) {
                $thumb_width = round(($thumb_height * $size[0]) / $size[1]);
            }
        }

        $dst_x = 0;
        $dst_y = 0;
        $src_x = 0;
        $src_y = 0;
        $dst_w = $thumb_width;
        $dst_h = $thumb_height;
        $src_w = $size[0];
        $src_h = $size[1];

        $ratio = $dst_h / $dst_w;

        if($is_large) {
            // 크롭처리
            if($is_crop) {
                switch($crop_mode)
                {
                    case 'center':
                        if($size[1] / $size[0] >= $ratio) {
                            $src_h = round($src_w * $ratio);
                            $src_y = round(($size[1] - $src_h) / 2);
                        } else {
                            $src_w = round($size[1] / $ratio);
                            $src_x = round(($size[0] - $src_w) / 2);
                        }
                        break;
                    default:
                        if($size[1] / $size[0] >= $ratio) {
                            $src_h = round($src_w * $ratio);
                        } else {
                            $src_w = round($size[1] / $ratio);
                        }
                        break;
                }

                $dst = imagecreatetruecolor($dst_w, $dst_h);

                if($size[2] == 3) {
                    imagealphablending($dst, false);
                    imagesavealpha($dst, true);
                } else if($size[2] == 1) {
                    $palletsize = imagecolorstotal($src);
                    if($src_transparency >= 0 && $src_transparency < $palletsize) {
                        $transparent_color   = imagecolorsforindex($src, $src_transparency);
                        $current_transparent = imagecolorallocate($dst, $transparent_color['red'], $transparent_color['green'], $transparent_color['blue']);
                        imagefill($dst, 0, 0, $current_transparent);
                        imagecolortransparent($dst, $current_transparent);
                    }
                }
            } else { // 비율에 맞게 생성
                $dst = imagecreatetruecolor($dst_w, $dst_h);
                $bgcolor = imagecolorallocate($dst, 255, 255, 255); // 배경색

                if($size[2] == 3) {
                    $bgcolor = imagecolorallocatealpha($dst, 0, 0, 0, 127);
                    imagefill($dst, 0, 0, $bgcolor);
                    imagealphablending($dst, false);
                    imagesavealpha($dst, true);
                } else if($size[2] == 1) {
                    $palletsize = imagecolorstotal($src);
                    if($src_transparency >= 0 && $src_transparency < $palletsize) {
                        $transparent_color   = imagecolorsforindex($src, $src_transparency);
                        $current_transparent = imagecolorallocate($dst, $transparent_color['red'], $transparent_color['green'], $transparent_color['blue']);
                        imagefill($dst, 0, 0, $current_transparent);
                        imagecolortransparent($dst, $current_transparent);
                    } else {
                        imagefill($dst, 0, 0, $bgcolor);
                    }
                } else {
                    imagefill($dst, 0, 0, $bgcolor);
                }
            }
        } else {
            $dst = imagecreatetruecolor($dst_w, $dst_h);
            $bgcolor = imagecolorallocate($dst, 255, 255, 255); // 배경색

            //이미지 썸네일을 비율 유지하며 썸네일 생성합니다.
            if($src_w < $dst_w) {
                if($src_h >= $dst_h) {
                    if( $src_h > $src_w ){
                        $tmp_w = round(($dst_h * $src_w) / $src_h);
                        $dst_x = round(($dst_w - $tmp_w) / 2);
                        $dst_w = $tmp_w;
                    } else {
                        $dst_x = round(($dst_w - $src_w) / 2);
                        $src_h = $dst_h;
                        if( $dst_w > $src_w ){
                            $dst_w = $src_w;
                        }
                    }
                } else {
                    $dst_x = round(($dst_w - $src_w) / 2);
                    $dst_y = round(($dst_h - $src_h) / 2);
                    $dst_w = $src_w;
                    $dst_h = $src_h;
                }
            } else {
                if($src_h < $dst_h) {
                    if( $src_w > $dst_w ){
                        $tmp_h = round(($dst_w * $src_h) / $src_w);
                        $dst_y = round(($dst_h - $tmp_h) / 2);
                        $dst_h = $tmp_h;
                    } else {
                        $dst_y = round(($dst_h - $src_h) / 2);
                        $dst_h = $src_h;
                        $src_w = $dst_w;
                    }
                }
            }


            if($size[2] == 3) {
                $bgcolor = imagecolorallocatealpha($dst, 0, 0, 0, 127);
                imagefill($dst, 0, 0, $bgcolor);
                imagealphablending($dst, false);
                imagesavealpha($dst, true);
            } else if($size[2] == 1) {
                $palletsize = imagecolorstotal($src);
                if($src_transparency >= 0 && $src_transparency < $palletsize) {
                    $transparent_color   = imagecolorsforindex($src, $src_transparency);
                    $current_transparent = imagecolorallocate($dst, $transparent_color['red'], $transparent_color['green'], $transparent_color['blue']);
                    imagefill($dst, 0, 0, $current_transparent);
                    imagecolortransparent($dst, $current_transparent);
                } else {
                    imagefill($dst, 0, 0, $bgcolor);
                }
            } else {
                imagefill($dst, 0, 0, $bgcolor);
            }
        }

        imagecopyresampled($dst, $src, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);

        // sharpen 적용
        if($is_sharpen && $is_large) {
            $val = explode('/', $um_value);
            UnsharpMask($dst, $val[0], $val[1], $val[2]);
        }

        if($size[2] == 1) {
            imagegif($dst, $thumb_file);
        } else if($size[2] == 3) {
            $png_compress = 5;
            imagepng($dst, $thumb_file, $png_compress);
        } else {
            $jpg_quality = 90;

            imagejpeg($dst, $thumb_file, $jpg_quality);
        }

        chmod($thumb_file, 0644); // 추후 삭제를 위하여 파일모드 변경

        imagedestroy($src);
        imagedestroy($dst);

        return basename($thumb_file);
    }

    //셀렉트 박스 만들기
    public static function select_box($select_name, $value, $key, $selected_val='',$route_link='')
    {
        //카테고리 게시판 일때 사용
        //$select_name = 셀렉트 박스 이름
        //$value = 멘트
        //key = 키값
        //selected_val = 저장 된 값
        //route_link = onchange
        $value_cut = explode("@@",$value);
        $key_cut = explode("@@",$key);

        $select_disp = "<select name='{$select_name}' id='{$select_name}' {$route_link}>";
        if($route_link != ""){
            $select_disp .= "
                <option value='' >전체</option>
            ";
        }
        for($i = 0; $i < count($value_cut); $i++){
            $selected = "";
            if($key_cut[$i] == $selected_val) $selected = "selected";
            $select_disp .= "
                <option value='$key_cut[$i]' $selected>$value_cut[$i]</option>
            ";
        }

        $select_disp .= "</select>";

        return $select_disp;
    }

    //셀렉트 박스 skin 만들기
    public static function select_box_skin($select_name, $value, $selected_val='')
    {
        $select_disp = "<select name='{$select_name}' id='{$select_name}'>";

        for($i = 0; $i < count($value); $i++){
            $selected = "";
            if($value[$i] == $selected_val) $selected = "selected";
            $select_disp .= "
                <option value='$value[$i]' $selected>$value[$i]</option>
            ";
        }

        $select_disp .= "</select>";

        return $select_disp;
    }

    //게시물 삭제시 스마트 에디터 첨부 파일 까지 삭제 하기
    public static function editor_img_del($content, $editor_path)
    {
        //$content = 본문 내용
        //$editor_path = 저장된 스마트 에디터 첨부 경록
        preg_match_all("/<img[^>]*src=[\"']?([^>\"']+)[\"']?[^>]*>/i", $content, $matches);
        for($y = 0; $y < count($matches[1]); $y++){
            $tmp_cut = explode("/",$matches[1][$y]);
            $last_file_name = end($tmp_cut);
            $editor_img_del = $editor_path."/".$last_file_name;

            if (file_exists($editor_img_del)) {
                @unlink($editor_img_del); //이미지 삭제
            }
        }
        return true;
    }

    //디렉토리에 있는 하위 디렉토리 까지 전부 삭제
    function rmdir_ok($dir) {
        $dirs = dir($dir);
        while(false !== ($entry = $dirs->read())) {
            if(($entry != '.') && ($entry != '..')) {
                if(is_dir($dir.'/'.$entry)) {
                      $this->rmdir_ok($dir.'/'.$entry);
                } else {
                      @unlink($dir.'/'.$entry);
                }
            }
        }
        $dirs->close();
        @rmdir($dir);
    }

    //하위 카테고리가 있을시 하위 카테고리로 링크 걸리게(수정 해야함)
    public static function menu_page_link($db_results,$info)
    {
        $page_link = "";
        if(count($db_results) != 0){
            foreach($db_results as $db_result)
            {
                if($db_result->menu_page_type == "P"){  //페이지 타입
                    $page_link = route('defalut.index',$db_result->menu_name_en);
                }elseif($db_result->menu_page_type == "B"){ //게시판 타입
                    $page_link = route('board.index',$db_result->menu_name_en);
                }

                return $page_link;
            }
        }else{
            if($info->menu_page_type == "P"){  //페이지 타입
                $page_link = route('defalut.index',$info->menu_name_en);
            }elseif($info->menu_page_type == "B"){ //게시판 타입
                $page_link = route('board.index',$info->menu_name_en);
            }

            return $page_link;
        }
    }

    public static function menu_page_link2($info)
    {
        $page_link = "";
        if($info->menu_page_type == "P"){  //페이지 타입
            //$page_link = "/defalut_html/{$info->menu_name_en}/{$info->menu_id}";
            $page_link = route('defalut.index',$info->menu_name_en,$info->menu_id);
        }elseif($info->menu_page_type == "B"){ //게시판 타입
            $page_link = route('board.index',$info->menu_name_en);
            //$page_link = "/board/list/{$info->menu_name_en}/{$info->menu_id}";
        }else{  //상품 타입
            $page_link = route('item.index');
        }

        return $page_link;
    }


    /* 통계 관련 */
	// 쿠키변수값 얻음
	public static function get_cookie($cookie_name)
	{
		$cookie = md5($cookie_name);

		if (array_key_exists($cookie, $_COOKIE))
			return base64_decode($_COOKIE[$cookie]);
		else
			return "";
	}

	// 쿠키변수 생성
	public static function set_cookie($cookie_name, $value, $expire)
	{
		//setcookie(md5($cookie_name), base64_encode($value), time() + $expire, '/', $_SERVER["HTTP_HOST"]);
        setcookie(md5($cookie_name), base64_encode($value), time() + $expire, '/');
	}

	function ip_details($ip) {
		$json = $this::get_content("http://ipinfo.io/");
		$details = json_decode($json, true);
		return $details;
	}

    //통계 ip 접속 나라/지역 찾기에..
	function get_content($URL){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $URL);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}



    /* 쇼핑몰 관련 함수 */
    //환경 설정 리사이즈 체크
    public static function resize_chk()
    {
        //환경 설정 DB에서 이미지 리사이징 값이 있는 지 파악
        $setting_info = DB::table('shopsettings')->first();

        if(is_null($setting_info)){
            //리사이징 값이 없으면 리턴
            return false;
            exit;
        }else{
            if(is_null($setting_info->shop_img_width) || is_null($setting_info->shop_img_height)){
                return false;
                exit;
            }else{
                $img_resize['shop_img_width'] = $setting_info->shop_img_width;
                $img_resize['shop_img_height'] = $setting_info->shop_img_height;
            }
        }

        return $img_resize;
    }

    // 금액 표시
	public static function display_price($price, $tel_inq=false)
    {
        if ($tel_inq)
            $price = '전화문의';
        else
            $price = number_format($price, 0).'원';

        return $price;
    }

    // 상품이미지에 유형 아이콘 출력(211111 라디오 버튼으로 바뀜)
    public static function old_item_icon($item)
    {
        $icon = "<tr><td>";

        if ($item->item_type1 != 0)
            $icon .= '<span class="shop_icon shop_icon_1">NEW</span>';

        if ($item->item_type2 != 0)
            $icon .= '<span class="shop_icon shop_icon_2">BIG SALE</span>';

        if ($item->item_type3 != 0)
            $icon .= '<span class="shop_icon shop_icon_3">HOT</span>';

        if ($item->item_type4 != 0)
            $icon .= '<span class="shop_icon shop_icon_4">할인</span>';
        $icon .= "</td></tr>";

        return $icon;
    }

    // 상품이미지에 유형 아이콘 출력
    public static function item_icon($item)
    {
        $icon = "";
        switch($item->item_type1) {
            case 1:
                $icon = '
                <div class="new-icon">
                <p>NEW</p>
                </div>
                ';
                //$icon = 'NEW';
                break;
            case 2:
                $icon = '
                <div class="sale-icon">
                <p>SALE</p>
                </div>
                ';
                //$icon = 'SALE';
                break;
            case 3:
                $icon = '
                <div class="big-icon">
                <p>BIG SALE</p>
                </div>
                ';
                //$icon = 'BIG SALE';
                break;
            case 4:
                $icon = '
                <div class="hot-icon">
                <p>HOT</p>
                </div>
                ';
                //$icon = 'HOT';
                break;
            default:
                break;
        }

        return $icon;
    }

    //환경 설정 값
    public static function setting_infos()
    {
        $setting_info = DB::table('shopsettings')->first();

        if(is_null($setting_info)){
            //값이 없으면 리턴
            return false;
        }else{
            return $setting_info;
        }
    }

    public static function get_item_point($item, $sio_id='', $trunc=1)
    {
        //$trunc 절사 단위
        $item_point = 0;
        $item_price = $item->item_price;

        if($sio_id){
            $opts = DB::table('shopitemoptions')->select('sio_id', 'sio_price')->where([['item_code', $item->item_code],['sio_id', $sio_id],['sio_type','0'],['sio_use','1']])->first();
            if(is_null($opts)){
                return false;
            }else{
                if($opts->sio_id != ""){
                    $item_price += $opts->sio_price;
                }
            }
        }

        $item_point = floor(($item_price * ($item->item_point / 100) / $trunc)) * $trunc;
        return $item_point;
    }

    // 상품 선택 옵션
    public static function get_item_options($item_code, $subject, $is_div='', $is_first_option_title='')
    {
        if(!$item_code || !$subject) return false;
        $opts = DB::table('shopitemoptions')->where([['sio_type', 0],['item_code', $item_code],['sio_use','1']])->orderby('id', 'asc')->get();

        if(count($opts) == 0) return false;

        $str = '';
        $subj = explode(',', $subject);
        $subj_count = count($subj);

        if($subj_count > 1) {
            $options = array();
            $first_option_title = "";

            // 옵션항목 배열에 저장
            foreach($opts as $opt){
                $opt_id = explode(chr(30), $opt->sio_id);

                for($k=0; $k<$subj_count; $k++) {
                    if(! (isset($options[$k]) && is_array($options[$k])))
                        $options[$k] = array();

                    if(isset($opt_id[$k]) && $opt_id[$k] && !in_array($opt_id[$k], $options[$k]))
                        $options[$k][] = $opt_id[$k];
                }
            }

            // 옵션선택목록 만들기
            for($i=0; $i<$subj_count; $i++) {
                $opt = $options[$i];
                $opt_count = count($opt);
                $disabled = '';

                if($opt_count) {
                    $seq = $i + 1;
                    if($i > 0)
                        $disabled = ' disabled="disabled"';

                    if($is_div === 'div') {
                        //$str .= '<div class="get_item_options">'.PHP_EOL;
                        //$str .= '<label for="it_option_'.$seq.'" class="label-title">'.$subj[$i].'</label>'.PHP_EOL;
                    } else {
                        //$str .= '<tr>'.PHP_EOL;
                        //$str .= '<th><label for="it_option_'.$seq.'" class="label-title">'.$subj[$i].'</label></th>'.PHP_EOL;
                    }

                    $select = '<select id="it_option_'.$seq.'" class="it_option"'.$disabled.'>'.PHP_EOL;

                    $first_option_title = $is_first_option_title ? $subj[$i] : '옵션을 선택하세요';

                    $select .= '<option value="">'.$first_option_title.'</option>'.PHP_EOL;
                    for($k=0; $k<$opt_count; $k++) {
                        $opt_val = $opt[$k];
                        if(strlen($opt_val)) {
                            $select .= '<option value="'.$opt_val.'">'.$opt_val.'</option>'.PHP_EOL;
                        }
                    }
                    $select .= '</select>'.PHP_EOL;

                    if($is_div === 'div') {
                        $str .= $select.PHP_EOL;
                        //$str .= '</div>'.PHP_EOL;
                    } else {
                        $str .= $select.PHP_EOL;
                        //$str .= '</tr>'.PHP_EOL;
                    }
                }
            }
        }else{
            if($is_div === 'div') {
                //$str .= '<div class="get_item_options">'.PHP_EOL;
                //$str .= '<label for="it_option_1">'.$subj[0].'</label>'.PHP_EOL;
            } else {
                //$str .= '<tr>'.PHP_EOL;
                //$str .= '<th><label for="it_option_1">'.$subj[0].'</label></th>'.PHP_EOL;
            }

            $select = '<select id="it_option_1" class="it_option">'.PHP_EOL;
            $select .= '<option value="">옵션을 선택하세요</option>'.PHP_EOL;

            foreach($opts as $opt){
                if($opt->sio_price >= 0) $price = '&nbsp;&nbsp;+ '.number_format($opt->sio_price).'원';
                else $price = '&nbsp;&nbsp; '.number_format($opt->sio_price).'원';

                if($opt->sio_stock_qty < 1) $soldout = '&nbsp;&nbsp;[품절]';
                else $soldout = '';

                $select .= '<option value="'.$opt->sio_id.','.$opt->sio_price.','.$opt->sio_stock_qty.'">'.$opt->sio_id.$price.$soldout.'</option>'.PHP_EOL;
            }

            $select .= '</select>'.PHP_EOL;

            if($is_div === 'div') {
                $str .= $select.PHP_EOL;
                //$str .= '</div>'.PHP_EOL;
            } else {
                $str .= $select.PHP_EOL;
                //$str .= '</tr>'.PHP_EOL;
            }
        }

        return $str;
    }

    // 상품 추가옵션
    function get_item_supply($item_code, $subject, $is_div='', $is_first_option_title='')
    {
        if(!$item_code || !$subject) return false;

        $supplys = DB::table('shopitemoptions')->where([['sio_type', 1],['item_code', $item_code],['sio_use','1'],['sio_use','1']])->orderby('id', 'asc')->get();

        if(count($supplys) == 0) return false;

        $str = '';

        $subj = explode(',', $subject);
        $subj_count = count($subj);
        $options = array();

        // 옵션항목 배열에 저장
        foreach($supplys as $supply){
            $opt_id = explode(chr(30), $supply->sio_id);

            if($opt_id[0] && !array_key_exists($opt_id[0], $options))
                $options[$opt_id[0]] = array();

            if(strlen($opt_id[1])) {
                if($supply->sio_price >= 0)
                    $price = '&nbsp;&nbsp;+ '.number_format($supply->sio_price).'원';
                else
                    $price = '&nbsp;&nbsp; '.number_format($supply->sio_price).'원';

                $sio_stock_qty = $this->get_option_stock_qty($item_code, $supply->sio_id, $supply->sio_type);

                if($sio_stock_qty < 1)
                    $soldout = '&nbsp;&nbsp;[품절]';
                else
                    $soldout = '';

                $options[$opt_id[0]][] = '<option value="'.$opt_id[1].','.$supply->sio_price.','.$sio_stock_qty.'">'.$opt_id[1].$price.$soldout.'</option>';
            }
        }

        // 옵션항목 만들기
        for($i=0; $i<$subj_count; $i++) {
            $opt = (isset($subj[$i]) && isset($options[$subj[$i]])) ? $options[$subj[$i]] : array();
            $opt_count = count($opt);
            if($opt_count) {
                $seq = $i + 1;
                if($is_div === 'div') {
                    $str .= '<div class="get_item_supply">'.PHP_EOL;
                    $str .= '<label for="item_supply_'.$seq.'" class="label-title">'.$subj[$i].'</label>'.PHP_EOL;
                } else {
                    $str .= '<tr>'.PHP_EOL;
                    $str .= '<th><label for="item_supply_'.$seq.'">'.$subj[$i].'</label></th>'.PHP_EOL;
                }

                $first_option_title = $is_first_option_title ? $subj[$i] : '선택';

                $select = '<select id="item_supply_'.$seq.'" class="it_supply">'.PHP_EOL;
                $select .= '<option value="">'.$first_option_title.'</option>'.PHP_EOL;
                for($k=0; $k<$opt_count; $k++) {
                    $opt_val = $opt[$k];
                    if($opt_val) {
                        $select .= $opt_val.PHP_EOL;
                    }
                }
                $select .= '</select>'.PHP_EOL;

                if($is_div === 'div') {
                    $str .= '<span class="td_sit_sel">'.$select.'</span>'.PHP_EOL;
                    $str .= '</div>'.PHP_EOL;
                } else {
                    $str .= '<td class="td_sit_sel">'.$select.'</td>'.PHP_EOL;
                    $str .= '</tr>'.PHP_EOL;
                }
            }
        }

        return $str;
    }

    function is_soldout($item_code, $is_cache=false)
    {
        static $cache = array();

        $it_id = preg_replace('/[^a-z0-9_\-]/i', '', $item_code);
        $key = md5($item_code);

        if( $is_cache && isset($cache[$key]) ){
            return $cache[$key];
        }

        // 상품정보
        $item = $this->get_shop_item($item_code, $is_cache);

        if(count($item) == 0) return true;

        if($item[0]->item_soldout || $item[0]->item_stock_qty <= 0) return true;

        $count = 0;
        $soldout = false;

        // 상품에 선택옵션 있으면..
        $option_cnt = DB::table('shopitemoptions')->where([['item_code',$item_code],['sio_type','0']])->count();

        if($option_cnt > 0) {     //정상
            $option_gets = DB::table('shopitemoptions')->select('sio_id', 'sio_type', 'sio_stock_qty')->where([['item_code',$item_code],['sio_type','0'],['sio_use','1']])->get();

            $k = 0;
            foreach($option_gets as $option_get){
                // 옵션 재고수량
                $stock_qty = $this->get_option_stock_qty($item_code, $option_get->sio_id, $option_get->sio_type);

                if($stock_qty <= 0) $count++;

                $k++;
            }

            // 모든 선택옵션 품절이면 상품 품절
            if($k == $count) $soldout = true;
        }else{
            // 상품 재고수량
            $stock_qty = $this->get_item_stock_qty($item_code);

            if($stock_qty <= 0) $soldout = true;
        }

        $cache[$key] = $soldout;

        return $soldout;
    }

    public static function get_shop_item($item_code, $is_cache=false, $add_query='')
    {
        if($item_code != ""){
            $item = DB::select("select * from shopitems where item_code = '{$item_code}' $add_query ");
        }

        if( isset($item[0]->item_basic) ) {
            $item[0]->item_basic = $item[0]->item_basic;
        }

        if( ! isset($item[0]->item_code) ){
            $item[0]->item_code = '';
        }

        return $item;
    }

    // 상품의 재고 (창고재고수량 - 주문대기수량)
    public static function get_item_stock_qty($item_code)
    {
        $jaego = DB::table('shopitems')->select('item_stock_qty')->where('item_code',$item_code)->get();
        $jaego_cnt = (int)$jaego[0]->item_stock_qty;
        $daegi = 0;
/*
        // 재고에서 빼지 않았고 주문인것만
        $sct_qty = DB::table('shopcarts')->where([['item_code',$item_code], ['sio_id',''], ['sct_stock_use','0']])->whereRaw('sct_status in (\'주문\', \'입금\', \'준비\')')->sum('sct_qty');
        $daegi = (int)$sct_qty;

        return $jaego_cnt - $daegi;
*/
        return $jaego_cnt;
    }

    // 옵션의 재고 (창고재고수량 - 주문대기수량)
    public static function get_option_stock_qty($item_code, $sio_id, $type)
    {
        $jaego = DB::table('shopitemoptions')->select('sio_stock_qty')->where([['item_code',$item_code],['sio_id',$sio_id],['sio_type',$type],['sio_use','1']])->get();
        $jaego_cnt = (int)$jaego[0]->sio_stock_qty;
        $daegi = 0;
/*
        // 재고에서 빼지 않았고 주문인것만(주문완료 과정에서 재고 +,- 해주는 것으로 변경)
        $sct_qty = DB::table('shopcarts')->where([['item_code',$item_code], ['sio_id',$sio_id], ['sct_stock_use','0']])->whereRaw('sct_status in (\'주문\', \'입금\', \'준비\')')->sum('sct_qty');
        $daegi = (int)$sct_qty;

        return $jaego_cnt - $daegi;
*/
        //주문된 순간 재고 +,- 한다
        return $jaego_cnt;
    }

    //장바구니 키 생성
    function set_cart_id($direct)
    {
        if ($direct) {  //바로구매
            //$tmp_cart_id = session()->get('ss_cart_direct');
            $tmp_cart_id = $this->get_session('ss_cart_direct');
            if(!$tmp_cart_id) {
                $tmp_cart_id = $this->get_uniqid();
                //session()->put('ss_cart_direct', $tmp_cart_id);
                $this->set_session('ss_cart_direct', $tmp_cart_id);
            }
        }else{  //장바구니
            //$tmp_cart_id = session()->get('ss_cart_id');
            $tmp_cart_id = $this->get_session('ss_cart_id');

            if(!$tmp_cart_id) {
                $tmp_cart_id = $this->get_uniqid();
                //session()->put('ss_cart_id', $tmp_cart_id);
                $this->set_session('ss_cart_id', $tmp_cart_id);
            }
        }
/*
이부분 오류
        if(Auth::user()->user_id && $tmp_cart_id){
            $up_result = DB::table('shopcarts')->where([['user_id', Auth::user()->user_id], ['sct_direct','0'], ['sct_status','쇼핑']])->update(['od_id' => $tmp_cart_id]);
        }
*/
    }

    public static function get_uniqid()
    {
        DB::raw('LOCK TABLES shop_uniqid WRITE');
        while (1) {
            // 년월일시분초에 100분의 1초 두자리를 추가함 (1/100 초 앞에 자리가 모자르면 0으로 채움)
            $key = date('YmdHis', time()) . str_pad((int)((float)microtime()*100), 2, "0", STR_PAD_LEFT);

            //저장 처리
            $data = array(
                'uq_id' => $key,
                'uq_ip' => $_SERVER['REMOTE_ADDR'],
            );

            $create_result = shop_uniqids::create($data);
            $create_result->save();

            if($create_result) break; // 쿼리가 정상이면 빠진다.

            // insert 하지 못했으면 일정시간 쉰다음 다시 유일키를 만든다.
            usleep(10000); // 100분의 1초를 쉰다
        }

        DB::raw('UNLOCK TABLES');

        return $key;
    }

    function set_session($session_name, $value)
    {
        static $check_cookie = null;

        if( $check_cookie === null ){
            $cookie_session_name = session_name();
            if(! ($cookie_session_name && isset($_COOKIE[$cookie_session_name]) && $_COOKIE[$cookie_session_name]) && ! headers_sent() ){
                @session_regenerate_id(false);
            }

            $check_cookie = 1;
        }

        if (PHP_VERSION < '5.3.0')
            session_register($session_name);
        // PHP 버전별 차이를 없애기 위한 방법
        $$session_name = $_SESSION[$session_name] = $value;
    }

    // 세션변수값 얻음
    function get_session($session_name)
    {
        return isset($_SESSION[$session_name]) ? $_SESSION[$session_name] : '';
    }

    // 장바구니 금액 체크 $is_price_update 가 true 이면 장바구니 가격 업데이트한다.
    function before_check_cart_price($s_cart_id, $is_ct_select_condition=false, $is_price_update=false, $is_item_cache=false)
    {
        if( !$s_cart_id ){
            return;
        }

        $select_where_add = '';

        if( $is_ct_select_condition ){
            $select_where_add = " and sct_select = '0' ";
        }

        $cart_infos = DB::select("select * from shopcarts where od_id = '{$s_cart_id}' {$select_where_add} ");
        $check_need_update = false;

        foreach($cart_infos as $cart_info){
            if(!$cart_info->item_code) continue;

            $item_code = $cart_info->item_code;
            $item = $this->get_shop_item($item_code, $is_item_cache);

            $update_querys = array();

            if(!$item[0]->item_code) continue;

            if( $item[0]->item_price !== $cart_info->sct_price ){
                // 장바구니 테이블 상품 가격과 상품 테이블의 상품 가격이 다를경우
                $update_querys['sct_price'] = $item[0]->item_price;
            }

            if($cart_info->sio_id){
                $sio_infos = DB::table('shopitemoptions')->where([['item_code',$item_code],['sio_id',$cart_info->sio_id]])->get();

                $this_io_type = 0;
                if( $sio_infos[0]->sio_type ){
                    $this_io_type = $sio_infos[0]->sio_type;
                }

                if( $sio_infos[0]->sio_id && $sio_infos[0]->sio_price !== $cart_info->sio_price ){
                    // 장바구니 테이블 옵션 가격과 상품 옵션테이블의 옵션 가격이 다를경우
                    $update_querys['sio_price'] = $sio_infos[0]->sio_price;
                }

                // 포인트
                $compare_point = 0;
                $setting_info = $this->setting_infos();

                if($setting_info->company_use_point == 1) {
                    // DB 에 sio_type 이 1이면 상품추가옵션이며, 0이면 상품선택옵션이다
                    if($cart_info->sio_type == 0) {
                        $compare_point = $this->get_item_point($item[0], $cart_info->sio_id);
                    } else {
                        $compare_point = $item[0]->item_supply_point;
                    }

                    if($compare_point < 0)
                        $compare_point = 0;
                }

                if((int) $cart_info->sct_point !== (int) $compare_point){
                    // 장바구니 테이블 적립 포인트와 상품 테이블의 적립 포인트가 다를경우
                    $update_querys['sct_point'] = $compare_point;
                }

                if( $update_querys ){
                    $check_need_update = true;
                }

                // 장바구니에 담긴 금액과 실제 상품 금액에 차이가 있고, $is_price_update 가 true 인 경우 장바구니 금액을 업데이트 합니다.
                if( $is_price_update && $update_querys ){
                    $conditions = array();

                    foreach ($update_querys as $column => $value) {
                        $data[$column] = $value;  //배열에 추가 함
                    }

                    $update_result = DB::table('shopcarts')->where([['item_code', $item[0]->item_code], ['od_id',$s_cart_id], ['id',$cart_info->id]])->update($data);
                }
            }

            //각 상품 배송비 변경 되었을때(211028 추가)
            $baesong_price = DB::table('shopitems')->select('item_sc_price')->where('item_code',$item_code)->first();
            if($cart_info->item_sc_price != $baesong_price->item_sc_price){
                return false;
            }

            //기본 배송비가 변경 되었을때(211101 추가)
            $setting_info = DB::table('shopsettings')->select('de_send_cost')->first(); //기본 배송비 구하기
            if($cart_info->de_send_cost != $setting_info->de_send_cost){
                return false;
            }
        }

        // 장바구니에 담긴 금액과 실제 상품 금액에 차이가 있다면
        if( $check_need_update ){
            return false;
        }

        return true;
    }

    function get_item_image($item_code, $array_num)
    {
        if(!$item_code) return '';

        $item = $this->get_shop_item($item_code, true);

        $j = 0;
        $small_img_disp = "";
        for($i=1; $i<=10; $i++) {
            $item_img = "item_img".$i;

            if($item[0]->$item_img == "") continue;
            $j++;
            $item_img_cut = explode("@@",$item[0]->$item_img);

            if(count($item_img_cut) == 1) $item_img_disp = $item_img_cut[0];
            else $item_img_disp = $item_img_cut[$array_num];

            if($j == 1){
                //작은 이미지 출력
                $small_img_disp = "/data/shopitem/".$item_img_disp;
            }
        }

        return $small_img_disp;
    }

    // 상품별 배송비
    public static function get_item_sendcost($item_code, $price, $qty, $cart_id)
    {
        $ct = DB::table('shopcarts')->select('item_code', 'item_sc_type', 'item_sc_method', 'item_sc_price', 'item_sc_minimum', 'item_sc_qty')->where([['item_code', $item_code],['od_id',$cart_id]])->orderby('id', 'asc')->first();

        if(!$ct->item_code) return 0;

        if($ct->item_sc_price > 0){
            $sendcost = $ct->item_sc_price;
        }else{
            $sendcost = 0;
        }

        return $sendcost;
    }

    // 상품별 배송비
    public static function new_get_item_sendcost($cart_id, $price, $qty, $s_cart_id)
    {
        $ct = DB::table('shopcarts')->select('item_code', 'item_sc_type', 'item_sc_method', 'item_sc_price', 'item_sc_minimum', 'item_sc_qty')->where([['id', $cart_id],['od_id',$s_cart_id]])->orderby('id', 'asc')->first();

        if(!$ct->item_code) return 0;

        if($ct->item_sc_price > 0){
            $sendcost = $ct->item_sc_price * $qty;  //상품 갯수 만큼 배송비가 붙게 함(220121)
        }else{
            $sendcost = 0;
        }

        return $sendcost;
    }

    //장바구니 옵션 뿌리기
    function print_item_options($item_code, $cart_id)
    {
        $item_options = DB::table('shopcarts')->select('sct_option', 'sct_qty', 'sio_price')->where([['item_code', $item_code],['od_id',$cart_id]])->orderby('sio_type', 'asc')->orderby('id', 'asc')->get();

        $str = '';
        $i = '';
        foreach($item_options as $item_option){
            if($i == 0) $str .= '<ul>'.PHP_EOL;
            $price_plus = '';

            if($item_option->sio_price > 0) {
                $price_plus = '+';
                $str .= '<tr><td>옵션 : '.$item_option->sct_option.' '.$item_option->sct_qty.'개 ('.$price_plus.$this->display_price($item_option->sio_price).')</td></tr>'.PHP_EOL;
            }else{
                $str .= '<tr><td>'.$item_option->sct_option.' '.$item_option->sct_qty.'개'.'</td></tr>'.PHP_EOL;
            }
        }

        return $str;
    }

    //장바구니 옵션 뿌리기
    function new_print_item_options($id, $item_code, $cart_id)
    {
        $item_option = DB::table('shopcarts')->select('sct_option', 'sct_qty', 'sio_price')->where([['id', $id], ['item_code', $item_code], ['od_id',$cart_id]])->first();

        $str = '';
        $i = '';

        if($item_option->sio_price > 0) {
            $price_plus = '+';
            $str .= '<tr><td>옵션 : '.$item_option->sct_option.' '.$item_option->sct_qty.'개 ('.$price_plus.$this->display_price($item_option->sio_price).')</td></tr>'.PHP_EOL;
        }else{
            $str .= '<tr><td>'.$item_option->sct_option.' '.$item_option->sct_qty.'개'.'</td></tr>'.PHP_EOL;
        }

/*
        foreach($item_options as $item_option){
            if($i == 0) $str .= '<ul>'.PHP_EOL;
            $price_plus = '';

            if($item_option->sio_price > 0) {
                $price_plus = '+';
                $str .= '<tr><td>옵션 : '.$item_option->sct_option.' '.$item_option->sct_qty.'개 ('.$price_plus.$this->display_price($item_option->sio_price).')</td></tr>'.PHP_EOL;
            }else{
                $str .= '<tr><td>'.$item_option->sct_option.' '.$item_option->sct_qty.'개'.'</td></tr>'.PHP_EOL;
            }
        }


*/
        return $str;
    }


    // 배송비 구함
    function get_sendcost($cart_id, $selected=1)
    {
        $send_cost = 0;
        $total_price = 0;
        $total_send_cost = 0;
        $diff = 0;

        $scs = DB::table('shopcarts')->select('item_code')->where([['od_id',$cart_id], ['sct_send_cost','0'], ['sct_select',$selected]])->whereRaw('sct_status in (\'쇼핑\', \'주문\', \'입금\', \'준비\',\'부분취소\',\'상품취소\', \'배송\', \'완료\')')->distinct('item_code')->get();

        foreach ($scs as $sc){
            $sum = DB::select("select SUM(IF(sio_type = 1, (sio_price * sct_qty), ((sct_price + sio_price) * sct_qty))) as price, SUM(sct_qty) as qty from shopcarts where item_code = '{$sc->item_code}' and od_id = '$cart_id' and sct_status IN ( '쇼핑', '주문', '입금', '준비', '부분취소','상품취소', '배송', '완료' ) and sct_select = '{$selected}' ");

            $send_cost = $this->get_item_sendcost($sc->item_code, $sum[0]->price, $sum[0]->qty, $cart_id);

            if($send_cost > 0)
                $total_send_cost += $send_cost;
        }
        //return ($total_send_cost + $send_cost);
        return $total_send_cost;
    }

    // 장바구니 건수 검사
    public static function get_cart_count($cart_id)
    {
        $cnt = DB::table('shopcarts')->where('od_id', $cart_id)->count();
        return $cnt;
    }

    // 쿠폰번호 생성함수
    public static function get_coupon_id()
    {
        $len = 16;
        $chars = "ABCDEFGHJKLMNPQRSTUVWXYZ123456789";

        srand((double)microtime()*1000000);

        $i = 0;
        $str = '';

        while ($i < $len) {
            $num = rand() % strlen($chars);
            $tmp = substr($chars, $num, 1);
            $str .= $tmp;
            $i++;
        }

        $str = preg_replace("/([0-9A-Z]{4})([0-9A-Z]{4})([0-9A-Z]{4})([0-9A-Z]{4})/", "\\1-\\2-\\3-\\4", $str);

        return $str;
    }

    //회원 가입시 주어지는 포인트
    public static function user_point_chk($user_id, $po_content, $po_point, $po_use_point, $po_type, $po_write_id, $order_id)
    {
        $user_info = DB::table('users')->select('user_point')->where('user_id',$user_id)->first();  //사용자가 현재 가지고 있는 포인트

        //포인트 테이블에 저장
        $create_result = shoppoints::create([
            'user_id'       => $user_id,
            'po_content'    => $po_content,
            'po_point'      => $po_point,
            'po_use_point'  => $po_use_point,
            'po_user_point' => $user_info->user_point,
            'po_type'       => $po_type,
            'po_write_id'   => $po_write_id,
            'order_id'      => $order_id
        ])->exists();

        if($create_result){
            //회원 테이블 포인트 업뎃
            $total_point = $user_info->user_point + $po_point;
            $up_result = DB::table('users')->where('user_id', $user_id)->update(['user_point' => $total_point]);
        }

        return true;
    }

    // 주문요청기록 로그를 남깁니다.
    public function add_order_post_log($request, $msg='', $code='error'){

        if( empty($request) ) return;

        $post_data = base64_encode(serialize($request));
        $od_id = $this->get_session('ss_order_id');

        if( $code === 'delete' ){
            DB::table('shoppostlogs')->where([['oid', $od_id], ['user_id', Auth::user()->user_id],['ol_code','!=', 'error']])->orwhere('created_at','<', date('Y-m-d H:i:s', strtotime('-15 day', time())))->delete();
            return;
        }

        $create_result = shoppostlogs::create([
            'oid'       => $od_id,
            'user_id'   => Auth::user()->user_id,
            'post_data' => $post_data,
            'ol_code'   => $code,
            'ol_msg'    => addslashes($msg),
            'ol_ip'     => $_SERVER['REMOTE_ADDR'],
        ]);
        $create_result->save();

        if($create_result){
            DB::table('shoppostlogs')->where('created_at', '<', date('Y-m-d H:i:s', strtotime('-15 day', time())))->delete();
        }
    }

    //배송지 처리(배송지 테이블에)
    //ad_default = 기본 배송지 체크여부, ad_subject = 배송지명, ad_name = 이름, ad_tel = 전화번호, ad_hp = 핸드폰, ad_zip1 = 우편번호,
    //ad_addr1 = 주소, ad_addr2 = 상세주소, ad_addr3 = 참고항목, ad_jibeon = 지번(지번인지 도로명인지)
    public static function baesongji_process($ad_default, $ad_subject, $ad_name, $ad_tel, $ad_hp, $ad_zip1, $ad_addr1, $ad_addr2, $ad_addr3, $ad_jibeon){

        //기본 배송지 체크
        $baesongji_first_chk = DB::table('baesongjis')->where('user_id', Auth::user()->user_id)->count();
        if($baesongji_first_chk == 0){
            $up_result = DB::table('users')->where('user_id', Auth::user()->user_id)->update([
                'user_zip'          => $ad_zip1,
                'user_addr1'        => addslashes($ad_addr1),
                'user_addr2'        => addslashes($ad_addr2),
                'user_addr3'        => addslashes($ad_addr3),
                'user_addr_jibeon'  => $ad_jibeon,
            ]);

            $create_result = baesongjis::create([
                'user_id'       => Auth::user()->user_id,
                'ad_subject'    => addslashes($ad_subject),
                'ad_default'    => (int)$ad_default,
                'ad_name'       => addslashes($ad_name),
                'ad_tel'        => addslashes($ad_tel),
                'ad_hp'         => addslashes($ad_hp),
                'ad_zip1'       => $ad_zip1,
                'ad_addr1'      => addslashes($ad_addr1),
                'ad_addr2'      => addslashes($ad_addr2),
                'ad_addr3'      => addslashes($ad_addr3),
                'ad_jibeon'     => $ad_jibeon,
            ])->exists();

        }else{
            $baesongji_chk = DB::table('baesongjis')->where([['user_id', Auth::user()->user_id], ['ad_zip1', $ad_zip1], ['ad_addr1', $ad_addr1], ['ad_addr2', $ad_addr2]])->count();

            if(!is_null($ad_default)){
                //기본 배송지 체크시
                if($baesongji_chk == 0){
                    //같은 주소가 없을때
                    $up_result = DB::table('users')->where('user_id', Auth::user()->user_id)->update([
                        'user_zip'          => $ad_zip1,
                        'user_addr1'        => addslashes($ad_addr1),
                        'user_addr2'        => addslashes($ad_addr2),
                        'user_addr3'        => addslashes($ad_addr3),
                        'user_addr_jibeon'  => $ad_jibeon,
                    ]);

                    //기본 배송지 컬럼(ad_default) 전부 0으로 만듦
                    $update_default = DB::table('baesongjis')->where('user_id', Auth::user()->user_id)->update(['ad_default' => 0]);

                    $create_result = baesongjis::create([
                        'user_id'       => Auth::user()->user_id,
                        'ad_subject'    => addslashes($ad_subject),
                        'ad_default'    => (int)$ad_default,
                        'ad_name'       => addslashes($ad_name),
                        'ad_tel'        => addslashes($ad_tel),
                        'ad_hp'         => addslashes($ad_hp),
                        'ad_zip1'       => $ad_zip1,
                        'ad_addr1'      => addslashes($ad_addr1),
                        'ad_addr2'      => addslashes($ad_addr2),
                        'ad_addr3'      => addslashes($ad_addr3),
                        'ad_jibeon'     => $ad_jibeon,
                    ])->exists();
                }else{
                    //같은 주소가 있을때
                    $up_result = DB::table('users')->where('user_id', Auth::user()->user_id)->update([
                        'user_zip'          => $ad_zip1,
                        'user_addr1'        => addslashes($ad_addr1),
                        'user_addr2'        => addslashes($ad_addr2),
                        'user_addr3'        => addslashes($ad_addr3),
                        'user_addr_jibeon'  => $ad_jibeon,
                    ]);

                    //기본 배송지 컬럼(ad_default) 전부 0으로 만듦
                    $update_default = DB::table('baesongjis')->where('user_id', Auth::user()->user_id)->update(['ad_default' => 0]);

                    $update_result = DB::table('baesongjis')->where([['user_id', Auth::user()->user_id], ['ad_zip1', $ad_zip1], ['ad_addr1', $ad_addr1]])->update([
                        'ad_subject'    => addslashes($ad_subject),
                        'ad_default'    => (int)$ad_default,
                        'ad_name'       => addslashes($ad_name),
                        'ad_tel'        => addslashes($ad_tel),
                        'ad_hp'         => addslashes($ad_hp),
                        'ad_addr2'      => addslashes($ad_addr2),
                        'ad_addr3'      => addslashes($ad_addr3),
                        'ad_jibeon'     => $ad_jibeon,
                    ]);
                }
            }else{
                //기본 배송지 미체크시
                if($baesongji_chk == 0){
                    $create_result = baesongjis::create([
                        'user_id'       => Auth::user()->user_id,
                        'ad_subject'    => addslashes($ad_subject),
                        'ad_default'    => 0,
                        'ad_name'       => addslashes($ad_name),
                        'ad_tel'        => addslashes($ad_tel),
                        'ad_hp'         => addslashes($ad_hp),
                        'ad_zip1'       => $ad_zip1,
                        'ad_addr1'      => addslashes($ad_addr1),
                        'ad_addr2'      => addslashes($ad_addr2),
                        'ad_addr3'      => addslashes($ad_addr3),
                        'ad_jibeon'     => $ad_jibeon,
                    ])->exists();
                }else{
                    $update_result = DB::table('baesongjis')->where([['user_id', Auth::user()->user_id], ['ad_zip1', $ad_zip1], ['ad_addr1', $ad_addr1]])->update([
                        'ad_subject'    => addslashes($ad_subject),
                        //'ad_default'    => 0,
                        'ad_name'       => addslashes($ad_name),
                        'ad_tel'        => addslashes($ad_tel),
                        'ad_hp'         => addslashes($ad_hp),
                        'ad_addr2'      => addslashes($ad_addr2),
                        'ad_addr3'      => addslashes($ad_addr3),
                        'ad_jibeon'     => $ad_jibeon,
                    ]);
                }
            }
        }
    }

    public function baesongji_modify_process($id, $ad_default, $ad_subject, $ad_name, $ad_tel, $ad_hp, $ad_zip1, $ad_addr1, $ad_addr2, $ad_addr3, $ad_jibeon){
        if($ad_default == 1){
            $update_default = DB::table('baesongjis')->where('user_id', Auth::user()->user_id)->update(['ad_default' => 0]);

            $up_result = DB::table('users')->where('user_id', Auth::user()->user_id)->update([
                'user_zip'          => $ad_zip1,
                'user_addr1'        => addslashes($ad_addr1),
                'user_addr2'        => addslashes($ad_addr2),
                'user_addr3'        => addslashes($ad_addr3),
                'user_addr_jibeon'  => $ad_jibeon,
            ]);
        }else{
            $ad_default = 0;
/*
            $up_result = DB::table('users')->where('user_id', Auth::user()->user_id)->update([
                'user_zip'          => '',
                'user_addr1'        => '',
                'user_addr2'        => '',
                'user_addr3'        => '',
                'user_addr_jibeon'  => '',
            ]);
*/
        }

        $update_result = DB::table('baesongjis')->where([['user_id', Auth::user()->user_id], ['id', $id]])->update([
            'ad_subject'    => addslashes($ad_subject),
            'ad_default'    => $ad_default,
            'ad_name'       => addslashes($ad_name),
            'ad_tel'        => addslashes($ad_tel),
            'ad_hp'         => addslashes($ad_hp),
            'ad_zip1'       => $ad_zip1,
            'ad_addr1'      => addslashes($ad_addr1),
            'ad_addr2'      => addslashes($ad_addr2),
            'ad_addr3'      => addslashes($ad_addr3),
            'ad_jibeon'     => $ad_jibeon,
        ]);
    }

    //포인트 처리
    public function insert_point($user_id, $point, $content='', $po_type, $po_write_id=0, $order_id=0)
    {
        //$po_type = 적립금 지금 유형 : 1=>회원가입적립, 2=>상품 평가 적립, 3=>상품 평가 취소, 5=>평가단 평가 적립 ,6=>평가단 평가 취소, 7=>상품구매사용,8=>구매적립,9=>구매적립취소,10=>상품구매부분취소,11=>상품구매취소,12=>상품 포토 리뷰 적립, 13=>상품 포토 리뷰 취소, 14=>평가단 포토 리뷰 적립, 15=>평가단 포토 리뷰 취소 17=>지구랭 특별 적립, 18=>지구랭 특별 적립 취소
        //po_write_id = 적립금 지급 유형 글번호(구매평 글번호)

        // 포인트가 없다면 업데이트 할 필요 없음
        if ($point == 0) { return 0; }

        // 회원아이디가 없다면 업데이트 할 필요 없음
        if ($user_id == '') { return 0; }

        $user_info = DB::table('users')->select('user_id')->where('user_id', $user_id)->first(); //회원인지 검색

        if(!$user_info){ return 0; }

        $user_point = $this->get_point_sum($user_id);

        $po_user_point = $user_point + $point;

        //포인트 테이블에 저장
        $create_result = shoppoints::create([
            'user_id'       => $user_id,
            'po_content'    => $content,
            'po_point'      => $point,
            'po_use_point'  => 0,
            'po_user_point' => $user_point,
            'po_type'       => $po_type,
            'po_write_id'   => $po_write_id,
            'order_id'      => $order_id
        ])->exists();

        if($create_result){
            //회원 테이블 포인트 업뎃
            $user_point = $this->get_point_sum($user_id);
            $up_result = DB::table('users')->where('user_id', $user_id)->update(['user_point' => $user_point]);
        }
    }

    // 포인트 내역 합계
    public static function get_point_sum($user_id)
    {
        // 포인트합
        $sum = shoppoints::where('user_id', $user_id)->sum('po_point');
        return $sum;
    }

    //구매 상품 재고 정리
    public static function item_qty($order_id, $type)
    {
        $cart_infos = DB::table('shopcarts')->where('od_id', $order_id)->get();

        foreach($cart_infos as $cart_info){
            if($cart_info->sio_id != ""){
                //옵션 상품일때
                $itemoptions_info = DB::table('shopitemoptions')->where([['item_code', $cart_info->item_code], ['sio_id', $cart_info->sio_id]])->first();

                if($type == 'minus'){
                    $qty = (int)$itemoptions_info->sio_stock_qty - (int)$cart_info->sct_qty;
                }else{
                    $qty = (int)$itemoptions_info->sio_stock_qty + (int)$cart_info->sct_qty;
                }

                $up_result = DB::table('shopitemoptions')->where([['item_code', $cart_info->item_code], ['sio_id', $cart_info->sio_id]])->update(['sio_stock_qty' => $qty]);

                //재고 수량 입력칸 (item_stock_qty) 합쳐서 업데이트(211129 추가)
                $qty_info = DB::table('shopitemoptions')->select(DB::raw("SUM(sio_stock_qty) as sum_qty"))->where('item_code', $cart_info->item_code)->first();
                $up_item_stock_qty = DB::table('shopitems')->where('item_code', $cart_info->item_code)->update(['item_stock_qty' => $qty_info->sum_qty]);
            }else{
                //옵션 상품 아닐때
                $item_info = DB::table('shopitems')->where('item_code', $cart_info->item_code)->first();

                if($type == 'minus'){
                    $qty = (int)$item_info->item_stock_qty - (int)$cart_info->sct_qty;
                }else{
                    $qty = (int)$item_info->item_stock_qty + (int)$cart_info->sct_qty;
                }

                $up_result = DB::table('shopitems')->where('item_code', $cart_info->item_code)->update(['item_stock_qty' => $qty]);
            }
        }
    }

    //환불 금액 체크
    public static function payrefund_chk($user_id, $order_id, $cancel_request_amount)
    {
        $order_info = DB::table('shoporders')->where([['user_id',$user_id], ['order_id', $order_id]])->first();
        $tot_price = (int)$order_info->od_receipt_price - (int)$order_info->od_receipt_point;   //카드사 결제 금액(결제금액 - 포인트 사용)

        if($tot_price <= $cancel_request_amount){
            //카드사 결제 금액 보다 환불 금액이 크거나 같을때
            return false;
        }else{
            if($tot_price <= $order_info->od_refund_price){
                //카드사 결제 금액 보다 환불된 금액이 크거나 같을때
                return false;
            }else{
                $hap = $order_info->od_refund_price + $cancel_request_amount;
                if($tot_price < $hap){
                    //카드사 결제 금액 보다 기존 환불금액(부분환불) + 새로운 환불금액과 클때
                    return false;
                }else{
                    return true;
                }
            }
        }
    }

    //환불 금액 업데이트
    public static function payrefund_update($user_id, $order_id, $cancel_request_amount)
    {
        $order_info = DB::table('shoporders')->where([['user_id',$user_id], ['order_id', $order_id]])->first();

        $hap = $cancel_request_amount + $order_info->od_refund_price;

        $update_result = DB::table('shoporders')->where([['user_id',$user_id], ['order_id', $order_id]])->update([
            'od_refund_price'    => $hap,
        ]);
    }

    // 한글 요일
    public static function get_yoil($date, $full=0)
    {
        $arr_yoil = array ('일', '월', '화', '수', '목', '금', '토');

        $yoil = date("w", strtotime($date));
        $str = $arr_yoil[$yoil];
        if ($full) {
            $str .= '요일';
        }
        return $str;
    }

    public static function is_mobile()
    {
        $mobile_agent = 'phone|samsung|lgtel|mobile|[^A]skt|nokia|blackberry|BB10|android|sony';
        return preg_match('/'.$mobile_agent.'/i', $_SERVER['HTTP_USER_AGENT']);
    }

    public static function item_average($item_code)
    {
        $review_info = DB::table('review_saves')->where([['item_code', $item_code], ['temporary_yn', 'n'], ['review_blind', 'N']])->get();
        $review_cnt = $review_info->count();

        $review_sum = 0;
        $score1_sum = 0;
        $score2_sum = 0;
        $score3_sum = 0;
        $score4_sum = 0;
        $score5_sum = 0;
        $item_cal = 0;
        $item_average = 0;

        if($review_cnt > 0){
            $score1_sum = $review_info->sum('score1');
            $score1_cal = $score1_sum / $review_cnt;
            $avg_score1 = round($score1_cal, 2);

            $score2_sum = $review_info->sum('score2');
            $score2_cal = $score2_sum / $review_cnt;
            $avg_score2 = round($score2_cal, 2);

            $score3_sum = $review_info->sum('score3');
            $score3_cal = $score3_sum / $review_cnt;
            $avg_score3 = round($score3_cal, 2);

            $score4_sum = $review_info->sum('score4');
            $score4_cal = $score4_sum / $review_cnt;
            $avg_score4 = round($score4_cal, 2);

            $score5_sum = $review_info->sum('score5');
            $score5_cal = $score5_sum / $review_cnt;
            $avg_score5 = round($score5_cal, 2);

            $review_sum = $review_info->sum('average');
            $item_cal = $review_sum / $review_cnt;
            $item_average = round($item_cal, 2);

            //상품 테이블에 평균값 저장
            $up_result = DB::table('shopitems')->where('item_code', $item_code)->update([
                'avg_score1'    => $avg_score1,
                'avg_score2'    => $avg_score2,
                'avg_score3'    => $avg_score3,
                'avg_score4'    => $avg_score4,
                'avg_score5'    => $avg_score5,
                'item_average'  => $item_average,
                'review_cnt'    => (int)$review_cnt,
            ]);
        }
    }

    //각 항목 평균 값 구하기
    public static function item_each_average($item_code, $sca_id){
        $array_val = array();
        $review_sql = DB::table('review_saves')->where([['item_code', $item_code], ['temporary_yn', 'n'], ['review_blind', 'N']]);
        $review_cnt = $review_sql->count();
        $review_infos = $review_sql->get();
var_dump("RRRRRRRRRR===> ".$review_cnt);
exit;
        if($review_cnt > 0){
            $rating_item_info = DB::table('rating_item')->where('sca_id', $sca_id)->first();

            for($i = 1; $i <= 5; $i++){
                $item_name_tmp = 'item_name'.$i;
                $array_val['item_name'][$i] = $rating_item_info->$item_name_tmp;
                //직접 계산 방식 보다 shopitem 테이블에 각 평균을 저장 함(220127)
                //$score_sum[$i] = $review_sql->sum('score'.$i);
                //$score_avg[$i] = $score_sum[$i] / $review_cnt;
                //$array_val['score'][$i] = round($score_avg[$i], 2);
            }
        }

        return $array_val;
    }
}


