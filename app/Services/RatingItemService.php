<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\RatingItem;
use App\Helpers\Custom\PageSet; //페이지 함수

/**
 * Class RatingItemService
 * @package App\Services
 */
class RatingItemService
{   
    public function __construct(RatingItem $ratingItem)
    {
        //$this->middleware('auth');
        $this->ratingItem = $ratingItem;
    }

    //항목들 보여주기
    public function getList($request){

        // $pageNum     = $request->input('page');
        // $writeList   = 10;  //페이지당 글수
        // $pageNumList = 10; //블럭당 페이지수

        //$tb_name = "shopitems";
        //$type = 'shopitems';
        //$cate = "";

        $page = $request->input('page');
        //페이지 구하기
        $pageScale  = 1;  //한페이지당 라인수
        $blockScale = 1; //출력할 블럭의 갯수(1,2,3,4... 갯수)

        if($page != "" || $page != null)
        {
            $start_num = $pageScale * ($page - 1);

        }else{

            $page = 1;
            $start_num = 0;

        }

       

        //검색 처리
        $ca_id    = $request->input('ca_id');
        //$item_search    = $request->input('item_search');
        $keyword  = $request->input('keyword');

        //검색 selectbox 만들기 2차 카테만 가져오게 설정
        $search_selectboxs = DB::table('shopcategorys')->whereRaw('LENGTH(sca_id) = 4')->orderby('sca_id','ASC')->orderby('sca_rank','DESC')->get();

        //결과 값 가져오기
        if(($keyword != "" || $keyword != null) && ($ca_id == "" || $ca_id == null)){
            $rating_items = $this->ratingItem->whereRaw("CONCAT(item_name1,item_name2, item_name3, item_name4, item_name5) like '%$keyword%'")->orderby('id', 'desc');
        }else if(($keyword == "" || $keyword == null) && ($ca_id != "" || $ca_id != null)){
            $rating_items = $this->ratingItem->where('sca_id', $ca_id)->orderby('id', 'desc');
        }else if(($keyword != "" || $keyword != null) && ($ca_id != "" || $ca_id != null)){
            $rating_items = $this->ratingItem->where('sca_id', $ca_id)->whereRaw("CONCAT(item_name1,item_name2, item_name3, item_name4, item_name5) like '%$keyword%'")->orderby('id', 'desc');
        }else{
            $rating_items = $this->ratingItem->orderby('id', 'desc');
        }
        
        $ratingList = $rating_items;

        $total_record   = 0;
        $total_record   = $ratingList->count(); //총 게시물 수
        $total_page     = ceil($total_record / $pageScale);
        $total_page     = $total_page == 0 ? 1 : $total_page;

        $rating_items_rows = $ratingList->orderby('id', 'desc')->offset($start_num)->limit($pageScale)->get();

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
        
        return view('adm.rating_item.rating_item_list',[
            'rating_items_rows' => $rating_items_rows,
            'ca_id' => $ca_id,
            //'rating_items' =>$rating_items,
            'search_selectboxs' => $search_selectboxs,
            'keyword' => $keyword,
            'pnPage' => $pnPage,
        ]);
    }

    //단계 별 카테고리 항목 가져오기
    public function getShopCate($step, $flag = 0, $str_cut = 0){

        $rs = $step * 2;

        // $result = DB::table('shopcategorys')->select('sca_id', 'sca_name_kr', 'sca_name_en')
        // ->where('sca_display','Y')->whereRaw('length(sca_id) = '.$rs)->orderby('sca_id', 'ASC')->get();
        if($flag == 0){
            $result = DB::table('shopcategorys')->select('sca_id', 'sca_name_kr', 'sca_name_en')
            ->where('sca_display','Y')->whereRaw('length(sca_id) = '.$rs)->orderby('sca_id', 'ASC')->get();
        }else{
            if($rs == 2){
                $result = DB::table('shopcategorys')->select('sca_id', 'sca_name_kr', 'sca_name_en')
                ->where('sca_display','Y')->whereRaw('length(sca_id) = 2')->orderby('sca_id', 'ASC')->get();
            }else{
                $result = DB::table('shopcategorys')->select('sca_id', 'sca_name_kr', 'sca_name_en')->
                where([['sca_display','Y'],['sca_id','like',$str_cut.'%']])->whereRaw('length(sca_id) = '.$rs)->orderby('sca_id', 'ASC')->get();
            }
        }
        
        return $result;
    }

    //정량 평가 항목 저장 함수
    public function create_rating($request){

        $create_result = $this->ratingItem->create([

            'sca_id' => $request->last_choice_ca_id,
            'item_name1' => $request->item_name1,
            'item_name2' => $request->item_name2,
            'item_name3' => $request->item_name3,
            'item_name4' => $request->item_name4,
            'item_name5' => $request->item_name5,

        ]);

        //return view('admRating.index');
        if($create_result){
            return redirect()->route('admRating.index')->with('alert_messages', '저장을 완료했습니다.');
        }else{
            return redirect()->route('admRating.index')->with('alert_messages', '오류 발생 다시 시도해주세요!');
        }
        
    }

    //정량 평가 항목 수정 뷰 반환
    public function modi_view($id){

        $result = $this->ratingItem->find($id);

        $ca_id = $result->sca_id;

         //1단계 가져옴
        $one_str_cut = substr($ca_id,0,2);
        //dd($one_str_cut);
        //$one_step_infos = $this->getShopCate(1, 1,$one_str_cut);
        $one_step_infos = $this->getShopCate(1, 1);
        //2단계 가져옴
        $two_str_cut = substr($ca_id,0,4);
        //$two_step_infos = $this->getShopCate(2, 1,$two_str_cut);
        $two_step_infos = $this->getShopCate(2, 1,$one_str_cut);

        return view('adm.rating_item.rating_item_modi',[
            'ca_id'             => $ca_id,
            'one_step_infos'    => $one_step_infos,
            'two_step_infos'    => $two_step_infos,
            'one_str_cut'       => $one_str_cut,
            'two_str_cut'       => $two_str_cut,
            'result'            => $result,
        ]);
    
    }

    //정량 평가 항목 수정 진행 함수
    public function modi_rating($request, $id){

        $result = $this->ratingItem->find($id);
        //카테고리 값이 변경 되었을 경우 db안에 같은 값이 있는지 확인이 필요하다.
        if($result->sca_id != $request->last_choice_ca_id){

            $find_sca_id = $this->ratingItem->where('sca_id', $request->last_choice_ca_id)->first();

            if(!empty($find_sca_id)){
                return redirect()->route('admRating.modi_view', $id)->with('alert_messages', '중복된 카테고리입니다 다시 시도해 주세요.');
            }
        }

        $update_result = $result->update([
            'sca_id' => $request->last_choice_ca_id,
            'item_name1' => $request->item_name1,
            'item_name2' => $request->item_name2,
            'item_name3' => $request->item_name3,
            'item_name4' => $request->item_name4,
            'item_name5' => $request->item_name5,
            'updated_at' => now(),
        ]);

        if($update_result){
            return redirect()->route('admRating.index')->with('alert_messages', '수정을 완료했습니다.');
        }else{
            //오류가 있을 경우
            return redirect()->route('admRating.index')->with('alert_messages', '오류 발생 다시 시도해주세요!');
        }
        
    }
}
