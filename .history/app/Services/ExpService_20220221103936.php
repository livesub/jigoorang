<?php

namespace App\Services;

use App\Models\ExpList;
use App\Helpers\Custom\PageSet; //페이지 함수

//파일 관련 퍼사드 추가
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use \Carbon\Carbon;
use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use Illuminate\Support\Facades\Auth;    //인증
use Illuminate\Support\Facades\DB;
use App\Models\items;    //상품 모델 정의
use Validator;  //체크
use App\Models\categorys;
use App\Models\shopitems;
use App\Models\ExpApplicationList;
/**
 * Class ExpService
 * @package App\Services
 */
class ExpService
{
    //저장 관련 함수
    public function exp_save($request){

        $result = ExpList::create([

            'title' => $request->exp_title,
            'main_image_name' =>$request->exp_main_image,
            'main_image_ori_name' =>$request->exp_main_ori_image,
            'item_id' => $request->exp_item_code,
            'item_name' => $request->exp_item_name,
            'exp_date_start' => $request->exp_date_start,
            'exp_date_end' => $request->exp_date_end,
            'exp_review_start' => $request->exp_review_start,
            'exp_review_end' => $request->exp_review_end,
            'exp_release_date' => $request->exp_release_date,
            'exp_content' => $request->exp_content,
            'exp_limit_personnel' => $request->exp_limit_personnel,

        ])->exists();

        return $result;
    }

    //수정 관련 함수
    public function exp_modi($request, $id){

        $expList = ExpList::find($id);

        //if($request->exp_main_image == '' || $request->exp_main_image == null){
        if($request->file_chk == "" || $request->file_chk == null){
            $result = $expList->update([

                'title' => $request->exp_title,
                'item_id' => $request->exp_item_code,
                'item_name' => $request->exp_item_name,
                'exp_date_start' => $request->exp_date_start,
                'exp_date_end' => $request->exp_date_end,
                'exp_review_start' => $request->exp_review_start,
                'exp_review_end' => $request->exp_review_end,
                'exp_release_date' => $request->exp_release_date,
                'exp_content' => $request->exp_content,
                'exp_limit_personnel' => $request->exp_limit_personnel,
                'updated_at' => now(),
            ]);

        }else{
            $result = $expList->update([

                'title' => $request->exp_title,
                'main_image_name' => $request->exp_main_image,
                'main_image_ori_name' => $request->exp_main_ori_image,
                'item_id' => $request->exp_item_code,
                'item_name' => $request->exp_item_name,
                'exp_date_start' => $request->exp_date_start,
                'exp_date_end' => $request->exp_date_end,
                'exp_review_start' => $request->exp_review_start,
                'exp_review_end' => $request->exp_review_end,
                'exp_release_date' => $request->exp_release_date,
                'exp_content' => $request->exp_content,
                'exp_limit_personnel' => $request->exp_limit_personnel,
                'updated_at' => now(),

            ]);

        }

        return $result;
    }

    //view에 보여줄 페이징 함수
    //$flag를 통해 회원단과 관리자단에서 보여주는 기준을 다르게 표현 1이 있을 경우 회원단 날짜가 지난 체험단은 보여주지 않음
    public function set_page($page, $flag = 0, $ca_id, $exp_date_start, $keyword){
        $pageScale  = 10;  //한페이지당 라인수
        $blockScale = 1; //출력할 블럭의 갯수(1,2,3,4... 갯수)

        if($page != "")
        {
            $start_num = $pageScale * ($page - 1);
        }else{
            $page = 1;
            $start_num = 0;
        }
        //날짜 지정
        $date = Carbon::now()->format('Y-m-d');


        $expList = DB::table('exp_list as a')
            ->select('a.*','b.sca_id', 'b.item_code')
            ->leftjoin('shopitems as b', function($join) {
                    $join->on('a.item_id', '=', 'b.id');
                });

        if($flag == 0){
            if($exp_date_start != ""){
                //$expList = ExpList::where('exp_date_start', '<=', $date)->latest();
                $expList = $expList->where('exp_date_start', '<=', $date);
            }

            if($ca_id != ""){
                //$expList = $expList->where('b.sca_id', '=', $ca_id);
                $expList = $expList->where('b.sca_id', 'like', $ca_id.'%');
            }

            if($keyword != ""){
                $expList = $expList->where('a.title', 'like', '%'.$keyword.'%');
            }

            //$expList = ExpList::where('exp_date_start', '<=', $date)->latest();
        }else{
            //$expList = ExpList::where('exp_date_end', '>=', $date)->where('exp_date_start', '<=', $date)->latest();
            //모집기간 종료일 까지는 리스트가 살아 있는 대신 신청을 못하고, 평가 가능 기간 종료일일 때는 리스트에서 사라진다.
            $expList = $expList->where('a.exp_review_end', '>=', $date)->where('a.exp_date_start', '<=', $date)->latest();
            //$expList = ExpList::where('exp_review_end', '>=', $date)->where('exp_date_start', '<=', $date)->latest();
        }

        $total_record   = 0;
        $total_record   = $expList->count(); //총 게시물 수
        $total_page     = ceil($total_record / $pageScale);
        $total_page     = $total_page == 0 ? 1 : $total_page;

        $expList_rows = $expList->orderby('id', 'desc')->offset($start_num)->limit($pageScale)->get();

        $tailarr = array();
        $tailarr['ca_id'] = $ca_id;
        $tailarr['exp_date_start'] = $exp_date_start;
        $tailarr['keyword'] = $keyword;


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

        if($flag == 0){
            return view('adm.exp.exp_list',[
                'expAllLists'   => $expList_rows,
                'ca_id'         => $ca_id,
                'exp_date_start' => $exp_date_start,
                'keyword' => $keyword,
                'pnPage'        => $pnPage,
            ]);
        }else{
            return view('exp.exp_list',[
                'expAllLists'   => $expList_rows,
                'pnPage'        => $pnPage,
            ]);
        }

        //return view('adm.exp.exp_list', compact('expAllLists'));
    }

    //체험단 삭제 관련
    public function exp_delete($id){

        $result_exp = ExpList::find($id);

        //Storage::disk('public')->delete('exp_list/'.$result_exp->main_image_name);
        //파일 삭제
        if(File::exists(public_path('data/exp_list/'.$result_exp->main_image_name))){

            File::delete(public_path('data/exp_list/'.$result_exp->main_image_name));
        }

        $editor_path = 'data/exp_list/editor/';
        //스마트 에디터 파일 삭제
        CustomUtils::editor_img_del($result_exp->exp_content, $editor_path);

        $result_exp->delete();

    }

    //상품검색 팝업관련 함수
    public function exp_popup($request){

        //$Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $pageNum     = $request->input('page');
        $writeList   = 20;  //페이지당 글수
        $pageNumList = 10; //블럭당 페이지수

        $tb_name = "shopitems";
        $type = 'shopitems';
        $cate = "";

        //검색 selectbox 만들기
        $search_selectboxs = DB::table('shopcategorys')->orderby('sca_id','ASC')->orderby('sca_rank','DESC')->get();

        //검색 처리
        $ca_id          = $request->input('ca_id');
        $item_search    = $request->input('item_search');
        $keyword        = $request->input('keyword');

        if($item_search == "") $item_search = "item_name";

        $search_caid_sql = "";
        if(!is_null($ca_id)){
            $search_caid_sql = " AND a.sca_id like '{$ca_id}%' ";
        }

        $search_sql = "";
        if($item_search != ""){
            //$search_sql = " AND a.sca_id = b.sca_id {$search_caid_sql} AND a.sca_id LIKE '{$cate_search}%' AND a.{$item_search} LIKE '%{$keyword}%' ";
            $search_sql = " AND a.sca_id = b.sca_id {$search_caid_sql} AND a.{$item_search} LIKE '%{$keyword}%' ";
        }else{
            //$search_sql .= " AND a.sca_id = b.sca_id {$search_caid_sql} AND a.{$item_search} LIKE '%{$keyword}%' ";
            $search_sql = " AND a.sca_id = b.sca_id {$search_caid_sql} ";
        }

        $page_control = CustomUtils::page_function('shopitems',$pageNum,$writeList,$pageNumList,$type,$tb_name,$ca_id,$item_search,$keyword);

        $item_infos = DB::select("select a.*, b.sca_id from shopitems a, shopcategorys b where a.item_del = 'N' {$search_sql} order by a.id DESC, a.item_rank ASC limit {$page_control['startNum']}, {$writeList} ");

        $pageList = $page_control['preFirstPage'].$page_control['pre1Page'].$page_control['listPage'].$page_control['next1Page'].$page_control['nextLastPage'];

        $setting_info = CustomUtils::setting_infos();

        return view('adm.exp.item_search',[
            'ca_id'             => $ca_id,
            'item_infos'        => $item_infos,
            'virtual_num'       => $page_control['virtual_num'],
            'totalCount'        => $page_control['totalCount'],
            'pageNum'           => $page_control['pageNum'],
            'pageList'          => $pageList,
            'item_search'       => $item_search,
            'keyword'           => $keyword,
            'search_selectboxs' => $search_selectboxs,
            'de_ment_change'    => stripslashes($setting_info->de_ment_change),
        ]);

    }

    //상세보기 관한 정보 반환
    public function detail_view($id){

        $result = ExpList::find($id);

        if(!empty($result)){
            //카테고리 찾기
            $shopitems = shopitems::find($result->item_id);
            //dd($shopitems->sca_id);

            $result->sca_id = $shopitems->sca_id;
            //dd($result->sca_id);
        }else{
            $result = "";
        }

        return $result;
    }

    //신청단 정보 테이블 저장 함수
    public function exp_form_save($request){

        $result = ExpApplicationList::create([

            'user_id' => $request->user_id,
            'exp_id' => $request->exp_id,
            'item_id' => $request->item_id,
            'sca_id' => $request->sca_id,
            'ad_name' => $request->ad_name,
            'ad_hp'   => $request->ad_hp,
            'ad_zip1' => $request->ad_zip1,
            'ad_addr1' => $request->ad_addr1,
            'ad_addr2' => $request->ad_addr2,
            'ad_addr3' => $request->ad_addr3,
            'ad_jibeon' => $request->ad_jibeon,
            'shipping_memo' => $request->shipping_memo,
            'reason_memo' => $request->reason_memo,
            'promotion_yn' => $request->promotion_agree,
            'user_name' => $request->user_name,

        ])->exists();

        return $result;
    }
}
