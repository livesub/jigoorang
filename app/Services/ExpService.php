<?php

namespace App\Services;

use App\Models\ExpList;
use App\Helpers\Custom\PageSet; //페이지 함수

//파일 관련 퍼사드 추가
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use Illuminate\Support\Facades\Auth;    //인증
use Illuminate\Support\Facades\DB;
use App\Models\items;    //상품 모델 정의
use Validator;  //체크
use App\Models\categorys; 
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

        if($request->exp_main_image == '' || $request->exp_main_image == null){

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
    public function set_page($page, $flag = 0){

        $pageScale  = 1;  //한페이지당 라인수
        $blockScale = 1; //출력할 블럭의 갯수(1,2,3,4... 갯수)

        if($page != "")
        {
            $start_num = $pageScale * ($page - 1);
        }else{
            $page = 1;
            $start_num = 0;
        }

        if($flag == 0){
            $expList = ExpList::latest();
        }else{
            $expList = ExpList::where('exp_date_end', '>=', now())->where('exp_date_start', '<=', now())->latest();
        }
        

        $total_record   = 0;
        $total_record   = $expList->count(); //총 게시물 수
        $total_page     = ceil($total_record / $pageScale);
        $total_page     = $total_page == 0 ? 1 : $total_page;

        $expList_rows = $expList->orderby('id', 'desc')->offset($start_num)->limit($pageScale)->get();

        $tailarr = array();
        //$tailarr['AA'] = 'AA';    //고정된 전달 파라메터가 있을때 사용
        //$tailarr['bb'] = 'bb';

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

        Storage::disk('public')->delete('exp_list/'.$result_exp->main_image_name);

        $result_exp->delete();

    }

    //상품검색 팝업관련 함수
    public function exp_popup($request){

        //$Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $pageNum     = $request->input('page');
        $writeList   = 20;  //페이지당 글수
        $pageNumList = 20; //블럭당 페이지수

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

        return $result;
    }
}
