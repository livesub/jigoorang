<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\adm\rating_item\AdmRatingItemController;

Route::group(['middleware' => 'is.admin'], function () {
    Route::get('/', [AdmRatingItemController::class, 'index'])->name('admRating.index');

    Route::get('/item/create', [AdmRatingItemController::class, 'create_view'])->name('admRating.create_view');

    Route::post('/item/create', [AdmRatingItemController::class, 'create_rating'])->name('admRating.create');

    Route::get('/item/modi/{id}', [AdmRatingItemController::class, 'modi_view'])->name('admRating.modi_view');

    Route::post('/item/modi/{id}', [AdmRatingItemController::class, 'modi_rating'])->name('admRating.modi');
});