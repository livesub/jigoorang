<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\findIdPwController;
use App\Http\Controllers\exp\expController;
use App\Http\Controllers\sms\aligoSmsController;
use App\Http\Controllers\auth\socialLoginController;
use Illuminate\Http\Request;
//컨트롤러 추가
use App\Http\Controllers\adm\exp\AdmExpController;
use App\Http\Controllers\adm\exp\AdmRatingItemController;

Route::group(['middleware' => 'is.admin'], function () {

    //리스트 페이지
    Route::get('/', [AdmExpController::class, 'index'])->name('adm_exp_index');

    //생성 페이지 라우트
    Route::get('/exp_create', [AdmExpController::class, 'view_create'])->name('adm_exp_view_create');

    //생성 DB저장 라우트
    Route::post('/exp_create', [AdmExpController::class, 'view_save'])->name('adm_exp_view_save');

    //수정 페이지 라우트
    Route::get('/exp_modi/{id}', [AdmExpController::class, 'view_restore'])->name('adm_exp_view_restore');

    //수정 DB저장 라우트
    Route::post('/exp_modi/{id}', [AdmExpController::class, 'view_modi'])->name('adm_exp_view_modi');

    //삭제 페이지 라우트
    Route::get('/exp_delete/{id}', [AdmExpController::class, 'delete_expList'])->name('adm_exp_view_delete');

    //체험단 등록 상품 검색 관련 라우트
    Route::get('/exp_popup_for_search_item', [AdmExpController::class, 'popup_for_search_item'])->name('adm_exp_popup_for_search_item');


    //체험단 승인
    Route::get('approve', [
        'as' => 'adm.approve.index',
        'uses' => 'App\Http\Controllers\adm\exp\AdmExpApproveController@index',
    ]);

    //체험단 승인 저장
    Route::post('approve', [
        'as' => 'adm.approve.approve_ok',
        'uses' => 'App\Http\Controllers\adm\exp\AdmExpApproveController@approve_ok',
    ]);

    Route::get('exceldown', [
        'as' => 'adm.exceldown',
        'uses' => 'App\Http\Controllers\ExceldownController@excel_down',
    ]);

});