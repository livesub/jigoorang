<?php

namespace App\Http\Controllers\adm\rating_item;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\RatingItem;
use App\Services\RatingItemService;
use App\Http\Requests\RatingItemRequest;

class AdmRatingItemController extends Controller
{
    public function __construct(RatingItemService $ratingItemService)
    {
        //$this->middleware('auth');
        $this->ratingItemService = $ratingItemService;
    }

    //리스트 뷰 반환
    public function index(Request $request){

        return $rating_items = $this->ratingItemService->getList($request);

        //return view('adm.rating_item.rating_item_list',['rating_items' =>$rating_items]);
    }

    //생성 뷰 반환
    public function create_view(Request $request){

        $ca_id = $request->input('sca_id');

        //1단계 가져옴
        //$one_step_infos = DB::table('shopcategorys')->select('sca_id', 'sca_name_kr', 'sca_name_en')->where('sca_display','Y')->whereRaw('length(sca_id) = 2')->orderby('sca_id', 'ASC')->get();
        $one_step_infos = $this->ratingItemService->getShopCate(1);
        //2단계 가져옴
        //$two_step_infos = DB::table('shopcategorys')->select('sca_id', 'sca_name_kr', 'sca_name_en')->where('sca_display','Y')->whereRaw('length(sca_id) = 4')->orderby('sca_id', 'ASC')->get();
        $two_step_infos = $this->ratingItemService->getShopCate(2);
        return view('adm.rating_item.rating_item_create',[
            'ca_id'             => $ca_id,
            'one_step_infos'    => $one_step_infos,
            'two_step_infos'    => $two_step_infos,
        ]);
    }

    //생성 함수
    public function create_rating(RatingItemRequest $request){
        
        return $this->ratingItemService->create_rating($request);
        
    }

    //수정 뷰 반환
    public function modi_view($id){

        //$id = $request->input('id');
        
        return $this->ratingItemService->modi_view($id);
    }

    //수정 함수
    public function modi_rating(Request $request, $id){

        return $this->ratingItemService->modi_rating($request, $id);

    }
}
