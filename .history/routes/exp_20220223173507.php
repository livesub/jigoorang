<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\findIdPwController;
use App\Http\Controllers\exp\expController;
use App\Http\Controllers\sms\aligoSmsController;
use App\Http\Controllers\auth\socialLoginController;
use Illuminate\Http\Request;

//리스트 뷰 반환 라우트
//Route::get('/list', [expController::class, 'index'])->name('exp.list');

//상세보기 뷰 반환 라우트
Route::get('/list/detail/{id}', [expController::class, 'view_detail'])->name('exp.list.detail');

//신청 form 뷰 반환 라우트
Route::get('/list/form/{id}', [expController::class, 'view_form'])->name('exp.list.form');

//신청 form 저장 라우트
Route::post('/list/form/create', [expController::class, 'exp_form_save'])->name('exp.list.form_create');