<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\findIdPwController;
use App\Http\Controllers\exp\expController;
use App\Http\Controllers\sms\aligoSmsController;
use App\Http\Controllers\auth\socialLoginController;
use Illuminate\Http\Request;

Route::get('/list', [expController::class, 'index'])->name('exp.list');

Route::get('/list/detail/{id}', [expController::class, 'view_detail'])->name('exp.list.detail');


Route::get('/list/form/{id}', [expController::class, 'view_form'])->name('exp.list.form');

Route::post('/list/form/create', [expController::class, 'exp_form_save'])->name('exp.list.form_create');