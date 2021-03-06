<?php

use Illuminate\Support\Facades\Route;

//쇼핑몰 관련
/* 로그인 사용자만 볼수 있는 페이지를 group 로 묶는다(관리자) */
Route::group(['middleware' => 'is.admin'], function () {    //미들웨어로 만들어서 관리자 가 아니먄 튕기게 한다
    /*** 환경 설정 */
    Route::get('setting', [       //환경 설정
        'as' => 'shop.setting.index',
        'uses' => 'App\Http\Controllers\adm\shop\setting\AdmShopSettingController@index',
    ]);

    Route::post('setting', [       //환경 설정 저장
        'as' => 'shop.setting.savesetting',
        'uses' => 'App\Http\Controllers\adm\shop\setting\AdmShopSettingController@savesetting',
    ]);

    /*** 분류 관리 */
    Route::get('scate', [       //카테고리 리스트
        'as' => 'shop.cate.index',
        'uses' => 'App\Http\Controllers\adm\shop\category\AdmShopCategoryController@index',
    ]);

    Route::get('scate_create', [      //1단계 카테고리 등록 페이지
        'as' => 'shop.cate.create',
        'uses' => 'App\Http\Controllers\adm\shop\category\AdmShopCategoryController@catecreate',
    ]);

    Route::post('scate_createsave', [      //1단계 카테고리 등록 페이지
        'as' => 'shop.cate.createsave',
        'uses' => 'App\Http\Controllers\adm\shop\category\AdmShopCategoryController@createsave',
    ]);

    Route::get('scate_add', [       //카테고리 추가 페이지
        'as' => 'shop.cate.cate_add',
        'uses' => 'App\Http\Controllers\adm\shop\category\AdmShopCategoryController@cate_add',
    ]);

    Route::post('scate_downloadfile', [  //카테고리 이미지 다운로드
        'as' => 'shop.cate.scate_downloadfile',
        'uses' => 'App\Http\Controllers\adm\shop\category\AdmShopCategoryController@downloadfile',
    ]);


    Route::post('scate_add_save', [      //카테고리 추가
        'as' => 'shop.cate.cate_add_save',
        'uses' => 'App\Http\Controllers\adm\shop\category\AdmShopCategoryController@cate_add_save',
    ]);

    Route::get('scate_modi', [      //카테고리 수정
        'as' => 'shop.cate.cate_modi',
        'uses' => 'App\Http\Controllers\adm\shop\category\AdmShopCategoryController@cate_modi',
    ]);

    Route::post('scate_modi_save', [     //카테고리 수정
        'as' => 'shop.cate.cate_modi_save',
        'uses' => 'App\Http\Controllers\adm\shop\category\AdmShopCategoryController@cate_modi_save',
    ]);

    Route::get('scate_delete', [    //카테고리 삭제
        'as' => 'shop.cate.cate_delete',
        'uses' => 'App\Http\Controllers\adm\shop\category\AdmShopCategoryController@cate_delete',
    ]);

    Route::get('scate_rank_choice', [    //랭킹 출력 유무
        'as' => 'shop.cate.ajax_rank_choice',
        'uses' => 'App\Http\Controllers\adm\shop\category\AdmShopCategoryController@ajax_rank_choice',
    ]);


/*** 상품 관리 */
    Route::get('sitem_list', [    //상품 관리 리스트
        'as' => 'shop.item.index',
        'uses' => 'App\Http\Controllers\adm\shop\item\AdmShopItemController@index',
    ]);

    Route::get('sitemcreate', [      //상품 등록 페이지
        'as' => 'shop.item.create',
        'uses' => 'App\Http\Controllers\adm\shop\item\AdmShopItemController@create',
    ]);

    Route::post('sitemselect', [     //상품 카테고리 ajax
        'as' => 'shop.cate.ajax_select',
        'uses' => 'App\Http\Controllers\adm\shop\item\AdmShopItemController@ajax_select',
    ]);

    Route::post('sitemcreate', [     //상품 선택 등록
        'as' => 'shop.item.createsave',
        'uses' => 'App\Http\Controllers\adm\shop\item\AdmShopItemController@createsave',
    ]);

    Route::post('sitemoption', [     //상품 옵션 선택
        'as' => 'shop.item.ajax_itemoption',
        'uses' => 'App\Http\Controllers\adm\shop\item\AdmShopItemController@ajax_itemoption',
    ]);

    Route::post('sitemsupply', [     //상품 추가 옵션 선택(ajax)
        'as' => 'shop.item.ajax_itemsupply',
        'uses' => 'App\Http\Controllers\adm\shop\item\AdmShopItemController@ajax_itemsupply',
    ]);

    Route::post('sitemchoice_del', [  //상품 선택 삭제
        'as' => 'shop.item.choice_del',
        'uses' => 'App\Http\Controllers\adm\shop\item\AdmShopItemController@choice_del',
    ]);

    Route::get('sitemmodify', [  //상품 수정 페이지
        'as' => 'shop.item.modify',
        'uses' => 'App\Http\Controllers\adm\shop\item\AdmShopItemController@modify',
    ]);

    Route::post('sitemmodify_option', [  //기존 저장된 상품 옵션 가져 오기(ajax)
        'as' => 'shop.item.ajax_modi_itemoption',
        'uses' => 'App\Http\Controllers\adm\shop\item\AdmShopItemController@ajax_modi_itemoption',
    ]);

    Route::post('sitemmodify_supply', [  //기존 저장된 추가 상품 옵션 가져 오기(ajax)
        'as' => 'shop.item.ajax_modi_itemsupply',
        'uses' => 'App\Http\Controllers\adm\shop\item\AdmShopItemController@ajax_modi_itemsupply',
    ]);

    Route::post('sitemmodifysave', [  //상품 수정 등록
        'as' => 'shop.item.modifysave',
        'uses' => 'App\Http\Controllers\adm\shop\item\AdmShopItemController@modifysave',
    ]);

    Route::post('sitemdownloadfile', [  //상품 이미지 다운로드
        'as' => 'shop.item.downloadfile',
        'uses' => 'App\Http\Controllers\adm\shop\item\AdmShopItemController@downloadfile',
    ]);

    //추가 배송비 관리 리스트
    Route::get('sendcostlist', [
        'as' => 'shop.sendcost.index',
        'uses' => 'App\Http\Controllers\adm\shop\sendcost\SendcostController@index',
    ]);

    //추가 배송비 관리 등록
    Route::post('sendcostlist', [
        'as' => 'shop.sendcost.ajax_regi_sendcost',
        'uses' => 'App\Http\Controllers\adm\shop\sendcost\SendcostController@ajax_regi_sendcost',
    ]);

    //추가 배송비 관리 선택 삭제
    Route::post('sendcostdel', [
        'as' => 'shop.sendcost.ajax_del_sendcost',
        'uses' => 'App\Http\Controllers\adm\shop\sendcost\SendcostController@ajax_del_sendcost',
    ]);

    //추가 배송비 관리 수정
    Route::get('sendcostmodi', [
        'as' => 'shop.sendcost.ajax_modi_sendcost',
        'uses' => 'App\Http\Controllers\adm\shop\sendcost\SendcostController@ajax_modi_sendcost',
    ]);

/*** 주문 관리 */
    Route::get('orderlist', [
        'as' => 'orderlist',
        'uses' => 'App\Http\Controllers\adm\shop\order\OrderController@index',
    ]);

    Route::get('orderdetail', [
        'as' => 'orderdetail',
        'uses' => 'App\Http\Controllers\adm\shop\order\OrderController@orderdetail',
    ]);

    //입력수량 취소 처리
    Route::post('orderqtyprocess', [
        'as' => 'ajax_orderqtyprocess',
        'uses' => 'App\Http\Controllers\adm\shop\order\OrderController@ajax_orderqtyprocess',
    ]);

    //교환 처리
    Route::post('return_process', [
        'as' => 'ajax_return_process',
        'uses' => 'App\Http\Controllers\adm\shop\order\OrderController@ajax_return_process',
    ]);

    //상품 취소 처리
    Route::post('orderitemprocess', [
        'as' => 'ajax_orderitemprocess',
        'uses' => 'App\Http\Controllers\adm\shop\order\OrderController@ajax_orderitemprocess',
    ]);

    //입력 수량 취소
    Route::post('admorderqtypaycancel', [
        'as' => 'ajax_admorderqtypaycancel',
        'uses' => 'App\Http\Controllers\adm\shop\order\OrderController@ajax_admorderqtypaycancel',
    ]);

    //상품 수량 취소
    Route::post('admorderitempaycancel', [
        'as' => 'ajax_admorderitempaycancel',
        'uses' => 'App\Http\Controllers\adm\shop\order\OrderController@ajax_admorderitempaycancel',
    ]);

    //부분 취소 없애고 전체 취소로 개발 변경(220208)
    Route::post('itemspaycancel', [
        'as' => 'ajax_itemspaycancel',
        'uses' => 'App\Http\Controllers\adm\shop\order\OrderController@ajax_itemspaycancel',
    ]);

    //주문상세 상점메모처리
    Route::post('ajax_shop_memo', [
        'as' => 'ajax_shop_memo',
        'uses' => 'App\Http\Controllers\adm\shop\order\OrderController@ajax_shop_memo',
    ]);

    //주문상세 주소변경처리
    Route::post('ajax_addr_change', [
        'as' => 'ajax_addr_change',
        'uses' => 'App\Http\Controllers\adm\shop\order\OrderController@ajax_addr_change',
    ]);

    /* 체험단 관리 */


});

