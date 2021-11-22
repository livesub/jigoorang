<?php

use Illuminate\Support\Facades\Route;


/** 쇼핑몰 프론트 **/
/*
Route::get('/', function () {
    dd(Auth::user());
});
*/

Route::get('/', [
    'as' => 'index',
    'uses' => 'App\Http\Controllers\shop\ShopMainController@index',
]);

//상품 리스트 페이지 처리
Route::get('/sitem', [
    'as' => 'sitem',
    'uses' => 'App\Http\Controllers\shop\ItemController@index',
]);

//상품 리스트 페이지 처리
Route::get('/sitemdetail', [
    'as' => 'sitemdetail',
    'uses' => 'App\Http\Controllers\shop\ItemController@sitemdetail',
]);

//상품 리스트 페이지 이미지 변환 처리
Route::get('/sitemdetail_img', [
    'as' => 'ajax_big_img_change',
    'uses' => 'App\Http\Controllers\shop\ItemController@ajax_big_img_change',
]);

//상품 리스트 선택 옵션 처리
Route::get('/sitemdetail_option', [
    'as' => 'ajax_option_change',
    'uses' => 'App\Http\Controllers\shop\ItemController@ajax_option_change',
]);

//wish 처리
Route::get('/sitemdetail_wish', [
    'as' => 'ajax_wish',
    'uses' => 'App\Http\Controllers\shop\ShopWishController@ajax_wish',
]);

//장바구니, 바로구매 처리
Route::post('/cartprocess', [
    'as' => 'ajax_cart_register',
    'uses' => 'App\Http\Controllers\shop\CartController@ajax_cart_register',
]);

//장바구니
Route::get('/cart', [
    'as' => 'cartlist',
    'uses' => 'App\Http\Controllers\shop\CartController@cartlist',
]);

//장바구니
Route::post('/cart', [
    'as' => 'ajax_choice_option_modify',
    'uses' => 'App\Http\Controllers\shop\CartController@ajax_choice_option_modify',
]);

//주문서
Route::get('/orderform', [
    'as' => 'orderform',
    'uses' => 'App\Http\Controllers\shop\OrderController@orderform',
]);

//배송지 처리
Route::get('/baesongji', [
    'as' => 'ajax_baesongji',
    'uses' => 'App\Http\Controllers\shop\BaesongjiController@ajax_baesongji',
]);

//배송지 등록 입력
Route::get('/baesongji_process', [
    'as' => 'ajax_baesongji_regi',
    'uses' => 'App\Http\Controllers\shop\BaesongjiController@ajax_baesongji_register',
]);

//배송지 등록 저장
Route::post('/baesongji_save', [
    'as' => 'ajax_baesongji_save',
    'uses' => 'App\Http\Controllers\shop\BaesongjiController@ajax_baesongji_save',
]);

//배송지 수정
Route::get('/baesongji_modify', [
    'as' => 'ajax_baesongji_modify',
    'uses' => 'App\Http\Controllers\shop\BaesongjiController@ajax_baesongji_modify',
]);

//배송지 수정 저장
Route::post('/baesongji_modify_save', [
    'as' => 'ajax_baesongji_modify_save',
    'uses' => 'App\Http\Controllers\shop\BaesongjiController@ajax_baesongji_modify_save',
]);

//기본 배송지 변경
Route::get('/baesongji_change', [
    'as' => 'ajax_baesongji_change',
    'uses' => 'App\Http\Controllers\shop\BaesongjiController@ajax_baesongji_change',
]);

//배송지 삭제
Route::post('/baesongji_del', [
    'as' => 'ajax_baesongji_del',
    'uses' => 'App\Http\Controllers\shop\BaesongjiController@ajax_baesongji_delete',
]);

//추가 배송비
Route::post('/ordersendcost', [
    'as' => 'ajax_ordersendcost',
    'uses' => 'App\Http\Controllers\shop\BaesongjiController@ajax_ordersendcost',
]);

//무통장 입금(은행명 등 호출)
Route::get('/orderbank', [
    'as' => 'ajax_orderbank',
    'uses' => 'App\Http\Controllers\shop\OrderController@ajax_orderbank',
]);

//재고체크
Route::get('/orderstock', [
    'as' => 'ajax_orderstock',
    'uses' => 'App\Http\Controllers\shop\OrderController@ajax_orderstock',
]);

//결제 전 검증을 위한 임시 테이블 저장
Route::post('/ordertemp', [
    'as' => 'ajax_ordertemp',
    'uses' => 'App\Http\Controllers\shop\OrderController@ajax_ordertemp',
]);

//결제 검증 하기
Route::post('/ordercomfirm', [
    'as' => 'ajax_ordercomfirm',
    'uses' => 'App\Http\Controllers\shop\OrderController@ajax_ordercomfirm',
]);

//결제 취소
Route::post('/orderpaycancel', [
    'as' => 'ajax_orderpaycancel',
    'uses' => 'App\Http\Controllers\shop\OrderController@ajax_orderpaycancel',
]);

//결제 하기
Route::post('/orderpayment', [
    'as' => 'orderpayment',
    'uses' => 'App\Http\Controllers\shop\OrderController@orderpayment',
]);

//주문상세내역
Route::get('/orderview', [
    'as' => 'orderview',
    'uses' => 'App\Http\Controllers\shop\OrderController@orderview',
]);
