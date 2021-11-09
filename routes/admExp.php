<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\findIdPwController;
use App\Http\Controllers\exp\expController;
use App\Http\Controllers\sms\aligoSmsController;
use App\Http\Controllers\auth\socialLoginController;
use Illuminate\Http\Request;
//컨트롤러 추가
use App\Http\Controllers\adm\exp\AdmExpController;

Route::get('/', [AdmExpController::class, 'index'])->name('adm_exp_index');

Route::get('/exp_create', [AdmExpController::class, 'view_create'])->name('adm_exp_view_create');