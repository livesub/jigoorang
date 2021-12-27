<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\findIdPwController;
use App\Http\Controllers\exp\expController;
use App\Http\Controllers\sms\aligoSmsController;
use App\Http\Controllers\auth\socialLoginController;
use App\Http\Controllers\auth\JoinController;
use App\Http\Controllers\member\MyPageInfoController;

use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|


 */
/*
if (App::environment('local')) {
    URL::forceScheme('https');
}
 */
/*
Route::get('/', [
    'as' => 'main.index',
    'uses' => 'App\Http\Controllers\MainController@index',
]);

Route::get('/home', [
    'as' => 'home.index',
    'uses' => 'App\Http\Controllers\MainController@index',
]);
 */

/** 체험단 미리 오픈을 위해 라우터 변경(나중에 위에로 변경)-211207 */

Route::get('/', [
    'as' => 'main.index',
    'uses' => 'App\Http\Controllers\exp\expController@index',
]);


Route::get('/list', [expController::class, 'index'])->name('exp.list');


/* 로그인이 되지 않은 페이지에 접근 했을시에 로그인 페이지로 이동 */
Route::get('login', [
    'as' => 'login',
    'uses' => 'App\Http\Controllers\auth\LoginController@index',
]);

/* 다국어 변환 */
Route::get('multilingual/{type}', [
    'as' => 'multilingual',
    'uses' => 'App\Http\Controllers\Multilingual_session@store',
]);

/*
Route::get('{locale}', function ($locale) {
    App::setLocale($locale);
    return view('auth/login');
});
*/

/* 사용자 등록 */
Route::get('auth/join', [
    'as' => 'join.create_agree',  //form 같은 곳에서 {{ route('join.store') }}  쓰기 위해
    'uses' => 'App\Http\Controllers\auth\JoinController@index_agree_view',
]);

Route::get('auth/join/{agree}', [
    'as' => 'join.create',  //form 같은 곳에서 {{ route('join.store') }}  쓰기 위해
    'uses' => 'App\Http\Controllers\auth\JoinController@index',
])->where('agree', '[YN]');

Route::post('auth/join', [
    'as' => 'join.store',
    'uses' => 'App\Http\Controllers\auth\JoinController@store',
]);

/* 이메일 인증 리턴 */
Route::get('auth/confirm/{code}',[
    'as' => 'join.confirm',
    'uses' => 'App\Http\Controllers\auth\JoinController@confirm',
]);

/* 사용자 로그인 */
Route::get('auth/login', [
    'as' => 'login.index',
    'uses' => 'App\Http\Controllers\auth\LoginController@index',
]);

Route::post('auth/login', [
    'as' => 'login.store',
    'uses' => 'App\Http\Controllers\auth\LoginController@store',
]);

/* 사용자 아웃 */
Route::get('auth/logout', [
    'as' => 'logout.destroy',
    'uses' => 'App\Http\Controllers\auth\LoginController@destroy',
]);

/* 비번 찾기 */
Route::get('auth/pwchange', [
    'as' => 'pwchange.index',
    'uses' => 'App\Http\Controllers\auth\PwchangeController@index',
]);

Route::post('auth/pwchange', [
    'as' => 'pwchange.store',
    'uses' => 'App\Http\Controllers\auth\PwchangeController@store',
]);

/*비밀번호 변경 리턴 */
Route::get('auth/reset/{token}', [
    'as' => 'reset.index',
    'uses' => 'App\Http\Controllers\auth\ResetController@index',
]);

Route::post('auth/reset', [
    'as' => 'reset.store',
    'uses' => 'App\Http\Controllers\auth\ResetController@store',
]);

/** 고객센터 */
Route::get('customer_center', [
    'as' => 'customer_center',
    'uses' => 'App\Http\Controllers\center\CenterController@index',
]);

/* 로그인 사용자만 볼수 있는 페이지를 group 로 묶는다 */
Route::group(['middleware' => ['auth']], function () {
    /* 마이페이지 */
    Route::get('member/mypage', [
        'as' => 'mypage.index',
        'uses' => 'App\Http\Controllers\member\MypageController@index',
    ]);

    Route::post('member/mypage', [
        'as' => 'mypage.pw_change',
        'uses' => 'App\Http\Controllers\member\MypageController@pw_change',
    ]);

    Route::post('member/infosave', [
        'as' => 'mypage.infosave',
        'uses' => 'App\Http\Controllers\member\InfosaveController@store',
    ]);

    //type = member_id = 순번
    Route::get('filedown/{type}', [
        'as' => 'filedown',
        'uses' => 'App\Http\Controllers\FiledownController@store',
    ]);

    //탈퇴 하기
    Route::get('member/withdraw_page', [
        'as' => 'mypage.withdraw_page',
        'uses' => 'App\Http\Controllers\member\MypageController@withdraw_page',
    ]);

    Route::post('member/withdraw', [
        'as' => 'mypage.withdraw',
        'uses' => 'App\Http\Controllers\member\MypageController@withdraw',
    ]);

    //회원정보수정 뷰 반환 라우트
    Route::get('member/member_info', [MyPageInfoController::class, 'index'])->name('member_info_index');

    //비밀번호 변경 라우트
    Route::post('member/update_pw',[MyPageInfoController::class, 'update_pw'])->name('member_info_update_pw');

    //핸드폰번호 변경 라우트
    Route::post('member/update_phone_number',[MyPageInfoController::class, 'update_phone_number'])->name('member_info_update_phone_number');

    //회원정보수정 라우트
    Route::post('member/update_member',[MyPageInfoController::class, 'update_member'])->name('member_info_update_member');


    //mypage 체험단 리뷰 관련
    Route::get('member/review_possible_list', [
        'as' => 'mypage.review_possible_list',
        'uses' => 'App\Http\Controllers\member\ReviewPossibleController@index',
    ]);

    //(평가단)
    Route::get('member/ajax_review_possible_list', [
        'as' => 'mypage.ajax_review_possible_list',
        'uses' => 'App\Http\Controllers\member\ReviewPossibleController@ajax_review_possible_list',
    ]);

    //쇼핑몰
    Route::get('member/ajax_review_shop_list', [
        'as' => 'mypage.ajax_review_shop_list',
        'uses' => 'App\Http\Controllers\member\ReviewPossibleController@ajax_review_shop_list',
    ]);

    //mypage 구매 리뷰 작성
    Route::get('member/review_possible_shopwrite', [
        'as' => 'mypage.review_possible_shopwrite',
        'uses' => 'App\Http\Controllers\member\ReviewPossibleController@review_possible_shopwrite',
    ]);

    //mypage 체험단 리뷰 작성
    Route::get('member/review_possible_expwrite', [
        'as' => 'mypage.review_possible_expwrite',
        'uses' => 'App\Http\Controllers\member\ReviewPossibleController@review_possible_expwrite',
    ]);

    //mypage 체험단 리뷰 작성 저장처리
    Route::post('member/review_possible_save', [
        'as' => 'mypage.review_possible_save',
        'uses' => 'App\Http\Controllers\member\ReviewPossibleController@review_possible_save',
    ]);

    //mypage 체험단 리뷰 작성 수정 처리
    Route::post('member/review_possible_modi_save', [
        'as' => 'mypage.review_possible_modi_save',
        'uses' => 'App\Http\Controllers\member\ReviewPossibleController@review_possible_modi_save',
    ]);

    //mypage 체험단 리뷰 이미지 삭제 처리
    Route::post('member/review_possible_img_del', [
        'as' => 'mypage.ajax_review_possible_img_del',
        'uses' => 'App\Http\Controllers\member\ReviewPossibleController@ajax_review_possible_img_del',
    ]);

    //mypage 체험단 내가쓴 리뷰
    Route::get('member/review_my_list', [
        'as' => 'mypage.review_my_list',
        'uses' => 'App\Http\Controllers\member\ReviewPossibleController@review_my_list',
    ]);

    //mypage 체험단 내가쓴 리뷰(평가단)
    Route::get('member/ajax_review_my_exp_list', [
        'as' => 'mypage.ajax_review_my_exp_list',
        'uses' => 'App\Http\Controllers\member\ReviewPossibleController@ajax_review_my_exp_list',
    ]);

    //mypage 체험단 내가쓴 리뷰(쇼핑몰)
    Route::get('member/ajax_review_my_shop_list', [
        'as' => 'mypage.ajax_review_my_shop_list',
        'uses' => 'App\Http\Controllers\member\ReviewPossibleController@ajax_review_my_shop_list',
    ]);

    //mypage wish(하트) - 응원하기
    Route::get('member/wish_list', [
        'as' => 'mypage.wish_list',
        'uses' => 'App\Http\Controllers\member\WishController@index',
    ]);

    //mypage 평가단 신청 결과 확인
    Route::get('member/exp_app_list', [
        'as' => 'mypage.exp_app_list',
        'uses' => 'App\Http\Controllers\member\ReviewPossibleController@exp_app_list',
    ]);

    //mypage 포인트 누적 현황
    Route::get('member/user_point_list', [
        'as' => 'mypage.user_point_list',
        'uses' => 'App\Http\Controllers\member\UserPointController@index',
    ]);

    //mypage 포인트 사용 현황
    Route::get('member/user_use_point_list', [
        'as' => 'mypage.user_use_point_list',
        'uses' => 'App\Http\Controllers\member\UserPointController@user_use_point_list',
    ]);

    //mypage 1:1 문의
    Route::get('member/qna_list', [
        'as' => 'mypage.qna_list',
        'uses' => 'App\Http\Controllers\member\QnaController@index',
    ]);

    Route::get('member/qna_write', [
        'as' => 'mypage.qna_write',
        'uses' => 'App\Http\Controllers\member\QnaController@qna_write',
    ]);

    Route::post('member/qna_write', [
        'as' => 'mypage.qna_write_save',
        'uses' => 'App\Http\Controllers\member\QnaController@qna_write_save',
    ]);

    Route::get('member/qna_view', [
        'as' => 'mypage.qna_view',
        'uses' => 'App\Http\Controllers\member\QnaController@qna_view',
    ]);
 });

/* 이메일 확인 리턴(외부에서 접속 해야 하기에 밖으로 뺌) */
Route::get('email/{token}', [
    'as' => 'email.sendconfirm.index',
    'uses' => 'App\Http\Controllers\email\SendconfirmController@index',
]);


/*** 프론트 게시판 관리 */
Route::get('board/list/{tb_name}', [  //게시판 리스트
    'as' => 'board.index',
    'uses' => 'App\Http\Controllers\board\BoardController@index',
]);

Route::post('board/list/choice_del', [  //게시판 리스트 에서 관리자 선택 삭제
    'as' => 'board.choice_del',
    'uses' => 'App\Http\Controllers\board\BoardController@choice_del',
]);

Route::get('board/write/{tb_name}', [  //게시판 글쓰기
    'as' => 'board.create',
    'uses' => 'App\Http\Controllers\board\BoardController@create',
]);

Route::post('board/write/', [  //게시판 글쓰기 저장
    'as' => 'board.store',
    'uses' => 'App\Http\Controllers\board\BoardController@store',
]);

Route::get('board/view/{tb_name}', [  //게시판 view
    'as' => 'board.show',
    'uses' => 'App\Http\Controllers\board\BoardController@show',
]);

Route::get('board/secret/{tb_name}', [  //게시판 비밀글 처리
    'as' => 'board.secret',
    'uses' => 'App\Http\Controllers\board\BoardController@secret',
]);

Route::post('board/secretpw/', [  //게시판 비밀글 처리
    'as' => 'board.secretpw',
    'uses' => 'App\Http\Controllers\board\BoardController@secretpw',
]);

Route::post('board/downloadfile/', [  //게시판 첨부파일 다운로드 처리
    'as' => 'board.downloadfile',
    'uses' => 'App\Http\Controllers\board\BoardController@downloadfile',
]);

Route::get('board/reply/{tb_name}/{ori_num}', [  //게시판 답글 쓰기
    'as' => 'board.reply',
    'uses' => 'App\Http\Controllers\board\BoardController@reply',
]);

Route::post('board/replysave/{tb_name}', [  //게시판 답글 저장
    'as' => 'board.replysave',
    'uses' => 'App\Http\Controllers\board\BoardController@replysave',
]);

Route::get('board/modify/{tb_name}/{ori_num}', [  //게시판 수정
    'as' => 'board.modify',
    'uses' => 'App\Http\Controllers\board\BoardController@modify',
]);

Route::post('board/modifysave/{tb_name}', [  //게시판 수정 저장
    'as' => 'board.modifysave',
    'uses' => 'App\Http\Controllers\board\BoardController@modifysave',
]);

Route::post('board/delete/{tb_name}', [  //게시판 삭제 처리
    'as' => 'board.deletesave',
    'uses' => 'App\Http\Controllers\board\BoardController@deletesave',
]);

Route::post('board/commemt/{tb_name}', [  //게시판 댓글 처리
    'as' => 'board.commentsave',
    'uses' => 'App\Http\Controllers\board\BoardController@commentsave',
]);

Route::post('board/commemtreply/{tb_name}', [  //게시판 댓글에 답글 처리
    'as' => 'board.commemtreplysave',
    'uses' => 'App\Http\Controllers\board\BoardController@commemtreplysave',
]);

Route::post('board/commemtmodify/{tb_name}', [  //게시판 댓글 수정 처리
    'as' => 'board.commemtmodifysave',
    'uses' => 'App\Http\Controllers\board\BoardController@commemtmodifysave',
]);

Route::post('board/commemtdelete/{tb_name}', [  //게시판 댓글 삭제 처리
    'as' => 'board.commemtdelete',
    'uses' => 'App\Http\Controllers\board\BoardController@commemtdelete',
]);

Route::get('terms_use', [  //이용약관
    'as' => 'terms_use',
    'uses' => 'App\Http\Controllers\info\InfoController@terms_use',
]);

Route::get('privacy', [  //개인정보
    'as' => 'privacy',
    'uses' => 'App\Http\Controllers\info\InfoController@privacy',
]);


/*** 프론트 메뉴 관리 */
//일반 페이지(html) 처리
//Route::get('/defalut_html/{pg_name}/{pg_code}', [
Route::get('/defalut_html/{pg_name}', [
    'as' => 'defalut.index',
    'uses' => 'App\Http\Controllers\defalut\Defalut_htmlController@index',
]);

//상품 페이지 일때 처리
Route::get('/item/item_page', [
    'as' => 'item.index',
    'uses' => 'App\Http\Controllers\item\ItemController@index',
]);


/*** 소셜 로그인 관련 ***/
Route::get('social/{provider}', [
    'as' => 'social.login',
    'uses' => 'App\Http\Controllers\auth\socialLoginController@redirect',
]);

Route::get('social/callback/{provider}', [
    'uses' => 'App\Http\Controllers\auth\socialLoginController@callback',
]);

//소셜로그인 인증 후 저장 라우트
Route::post('social_save_member', [socialLoginController::class, 'save_member'])->name('social_save_member');

//아이디 및 비밀번호 찾기 관련
Route::get('/findIdPWView', [findIdPwController::class, 'findIdPwView'])->name('findIdPwView');

//아이디 찾기 ajax 라우트
Route::post('/findId', [findIdPwController::class, 'findId'])->name('findId');

//비밀번호 링크 ajax 라우트
Route::post('/sendPwChange', [findIdPwController::class, 'sendPwChangeLink'])->name('sendPwChangeLinkView');

//시간이 제한된 라우트 제작
Route::get('/sendPwChange/{code}', function (Request $request, $code) {


    if(!$request->hasValidSignature()){
        //기간이 지났을 경우의 처리 또는 없거나 -> 잉여 단축url 삭제
        //abort(401);
        return redirect()->route('short_url_delete');
        //return redirect()->route('main.index')->with('alert_messages', __('auth.failed_to_limit_time'));
    }else{
        //제대로 확인이 되었을 경우 확인
        return view('auth.pwchange_sign', compact('code'));
    }
})->name('sendPwChangeLinkPro');

Route::post('/resetPw', [findIdPwController::class, 'update_pw_service'])->name('resetPw');

//문자인증 관련 테스트 라우트
Route::get('/test_certification', [aligoSmsController::class, 'test_certification'])->name('test_certification');

//문자 인증 관련 라우트
Route::post('/certification_send', [aligoSmsController::class, 'auth_certification'])->name('auth_certification');

//문자내역관련 테스트 라우트
Route::get('/get_list_from_id', [aligoSmsController::class, 'get_sms_list'])->name('get_sms_list');

//체험단 관련 라우트 그룹
Route::prefix('exp')->group(base_path('routes/exp.php'));

//단축 URL관련
Route::get('/short_url/{code}', [findIdPwController::class, 'shortenLink'])->name('short_url');

//단축 URL삭제 관련
Route::get('/short_url/delete/success', [findIdPwController::class, 'delete_short_url'])->name('short_url_delete');

//이메일 중복 확인 관련 테스트 라우트
Route::get('/test/email/{email}', [JoinController::class, 'email_certification_test'])->name('test_email');
Route::post('/check/email', [JoinController::class, 'email_certification'])->name('check_email');

//제한시간 지났을 경우 페이지 라우트
Route::get('/pwChange/failed_time_limit', [findIdPwController::class, 'move_time_limit_page'])->name('failed_time_limit');

/*** 관리자 페이지 접근 ***/
//route에서 관리자 분리
//app/Providers/RouteServiceProvider.php    //설정
//app/Http/Kernel.php   //설정
Route::prefix('adm')->group(base_path('routes/adm.php'));

/*** 관리자 페이지 쇼핑몰 접근 ***/
Route::prefix('adm/shop')->group(base_path('routes/admshop.php'));

/*** 프론트 쇼핑몰 접근 ***/
Route::prefix('shop')->group(base_path('routes/shop.php'));

//관리자 페이지 체험단 관련 라우트
Route::prefix('adm/exp')->group(base_path('routes/admExp.php'));

//관리자 페이지 정량 평가 라우트
Route::prefix('adm/rating')->group(base_path('routes/admRatingItem.php'));

//대체 라우트 지정(설정된 라우트가 없을 경우 해당 메시지를 alert으로 보여주고 메인으로 이동)
//위치를 제일 마지막에 두어야 모든 라우트에 대해 반응가능
Route::fallback(function () {
    //return redirect()->route('main.index')->with('alert_messages', __('auth.failed_to_limit_time'));
    return redirect()->route('main.index');
});
