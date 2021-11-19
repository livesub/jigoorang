<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\adm\rating_item\AdmRatingItemController;

Route::group(['middleware' => 'is.admin'], function () {
    //리스트 라우트
    Route::get('/', [AdmRatingItemController::class, 'index'])->name('admRating.index');

    //생성 뷰 반환 라우트
    Route::get('/item/create', [AdmRatingItemController::class, 'create_view'])->name('admRating.create_view');

    //db저장 라우트
    Route::post('/item/create', [AdmRatingItemController::class, 'create_rating'])->name('admRating.create');

    //수정 뷰 반환 라우트
    Route::get('/item/modi/{id}', [AdmRatingItemController::class, 'modi_view'])->name('admRating.modi_view');

    //db수정 라우트
    Route::post('/item/modi/{id}', [AdmRatingItemController::class, 'modi_rating'])->name('admRating.modi');
});