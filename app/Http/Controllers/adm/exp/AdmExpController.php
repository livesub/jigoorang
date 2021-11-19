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
        //$page = 0;
        //$expAllLists = $this->expList->latest()->paginate(1);
        $exp_directory = "data/exp_list/editor";
        //setcookie('dir', public_path());
        setcookie('directory', $exp_directory, (time() + 10800),"/"); //일단 3시간 잡음(3*60*60)

        return $this->expService->set_page($page);
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
            mkdir($path, 0777, true);
        }

        if(!is_dir($exp_directory)){
            mkdir($exp_directory, 0777, true);
        }

        return view('adm.exp.exp_create');
    }

    //체험단 저장 (서비스 클래스에 위임)
    public function view_save(ExpListRequest $request){
        //파일은 request 통해 확인하고 저장한 뒤에 DB이용 것들은 서비스 클래스에 위임 한다.

        $fileName = "";
        $path = "";

        //(파일이 현재 존재하는지 확인하는데 더하여, isValid 메소드를 사용하여 업로드된 파일에 아무런 문제가 없는지 확인할 수 있다.)
        if($request->file('exp_main_image')->isValid()){
            //$fileName = time().'_'.$request -> file('exp_main_image') -> getClientOriginalName();
            //$path = $request -> file('exp_main_image') -> storeAs('public/exp_list', $fileName);
            $path = 'data/exp_list/';     //첨부물 저장 경로
            $attachment_result = CustomUtils::attachment_save($request -> file('exp_main_image'),$path); //위의 패스로 이미지 저장됨
            // $request->file->move(public_path('board_file'), $fileName);

        }else{
            return false;
        }
        
        $request->exp_main_image = $attachment_result[1];

        //서비스 클래스에 위임
        $this->expService->exp_save($request);

        return redirect()->route('adm_exp_index')->with('alert_messages', "등록이 완료되었습니다.");
    }

    //수정 페이지 반환 함수
    public function view_restore($id){

        $result_expList = $this->expList->find($id);

        return view('adm.exp.exp_modi', compact('result_expList'));
    }

    //실제 DB 수정 관련 함수
    public function view_modi(ExpListRequest $request, $id){

        //파일이 있는지 여부 파악
        if($request->hasFile('exp_main_image')){
            
            $path = 'data/exp_list/';     //첨부물 저장 경로
            $attachment_result = CustomUtils::attachment_save($request -> file('exp_main_image'),$path); //위의 패스로 이미지 저장됨
            // $fileName = time().'_'.$request -> file('exp_main_image') -> getClientOriginalName();
            // $path = $request -> file('exp_main_image') -> storeAs('public/exp_list', $fileName);
            // $request->file->move(public_path('board_file'), $fileName);
            $result_exp = $this->expList->find($id);
            //업데이트 전에 이전 파일 삭제
            //Storage를 이용하면 storage/public 까지가 경로로 된다. 그래서 거기에 알맞게 경로를 지정해주면 된다.
            //즉 이 삭제 파일 경로는 storage/public/exp_list/파일이름이 된다.
            //Storage::disk('public')->delete('exp_list/'.$result_exp->main_image_name);

            if(File::exists(public_path('data/exp_list/'.$result_exp->main_image_name))){

                File::delete(public_path('data/exp_list/'.$result_exp->main_image_name));
            }

            $request->exp_main_image = $attachment_result[1];

        }

        $this->expService->exp_modi($request, $id);

        return redirect()->route('adm_exp_index')->with('alert_messages', "수정이 완료되었습니다.");
    }

    //체험단 삭제 DB 저장
    public function delete_expList($id){

        $this->expService->exp_delete($id);

        return redirect()->route('adm_exp_index')->with('alert_messages', '삭제가 완료되었습니다.');
    }

    //체험단 등록 시 상품검색관련 라우트
    public function popup_for_search_item(Request $request){

        return $this->expService->exp_popup($request);
        //return view('adm.exp.item_search');

    }
}
