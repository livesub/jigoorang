<?php
#############################################################################
#
#		파일이름		:		MenuController.php
#		파일설명		:		프론트 메뉴 control
#		저작권			:		저작권은 제작자에 있지만 누구나 사용합니다.
#		제작자			:		김영섭
#		최초제작일	    :		2021년 08월 23일
#		최종수정일		:		2021년 08월 23일
#
###########################################################################-->

namespace App\Http\Controllers\menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Helpers\Custom\CustomUtils; //사용자 공동 함수
use Illuminate\Support\Facades\DB;
use App\Models\menuses;    //메뉴 모델 정의

class MenuController extends Controller
{
    public function menu_list()
    {
        $Messages = CustomUtils::language_pack(session()->get('multi_lang'));

        $one_step_infos = DB::table('menuses')->where('menu_display','Y')->whereRaw('length(menu_id) = 2')->orderby('menu_rank', 'DESC')->get();   //정보 읽기

        $customutils = new CustomUtils();

        return view('menu.menulist',[
            'one_step_infos'    => $one_step_infos,
            'customutils'       => $customutils,
        ]);
    }
}
