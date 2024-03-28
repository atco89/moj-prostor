<?php

use App\Http\Controllers\Auth\RefreshTokenController;
use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\Auth\SignOutController;
use App\Http\Controllers\Auth\SignUpController;
use App\Http\Controllers\Category\DeleteCategoryController;
use App\Http\Controllers\Category\FetchAllCategoriesController;
use App\Http\Controllers\Category\FetchCategoryController;
use App\Http\Controllers\Category\StoreCategoryController;
use App\Http\Controllers\Category\UpdateCategoryController;
use App\Http\Controllers\Space\DeleteSpaceController;
use App\Http\Controllers\Space\FetchAllSpacesController;
use App\Http\Controllers\Space\FetchSpaceController;
use App\Http\Controllers\Space\Review\DeleteSpaceReviewController;
use App\Http\Controllers\Space\Review\FetchAllSpaceReviewsController;
use App\Http\Controllers\Space\Review\FetchSpaceReviewController;
use App\Http\Controllers\Space\Review\StoreSpaceReviewController;
use App\Http\Controllers\Space\Review\UpdateSpaceReviewController;
use App\Http\Controllers\Space\StoreSpaceController;
use App\Http\Controllers\Space\UpdateSpaceController;
use App\Http\Controllers\User\DeleteUserController;
use App\Http\Controllers\User\FetchAllUsersController;
use App\Http\Controllers\User\FetchUserController;
use App\Http\Controllers\User\StoreUserController;
use App\Http\Controllers\User\UpdateUserController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function (): void {
    Route::post('sign-up', SignUpController::class)->name('register');
    Route::post('sign-in', SignInController::class)->name('login');
    Route::post('refresh', RefreshTokenController::class)->name('refresh');
    Route::post('sign-out', SignOutController::class)->name('logout');
    Route::get('verification', RefreshTokenController::class)->name('verification.verify');
});

Route::as('category.')->prefix('category')->group(function (): void {
    Route::post('', StoreCategoryController::class)
        ->name('store')
        ->middleware('auth.role:admin');
    Route::get('', FetchAllCategoriesController::class)
        ->name('all')
        ->middleware('auth.role:admin,user');

    Route::as('item.')->prefix('{categoryUid}')->group(function (): void {
        Route::get('', FetchCategoryController::class)
            ->name('show')
            ->middleware('auth.role:admin');
        Route::patch('', UpdateCategoryController::class)
            ->name('update')
            ->middleware('auth.role:admin');
        Route::delete('', DeleteCategoryController::class)
            ->name('delete')
            ->middleware('auth.role:admin');
    });
});

Route::as('space.')->prefix('space')->group(callback: function (): void {
    Route::post('', StoreSpaceController::class)
        ->name('store')
        ->middleware('auth.role:admin,user');
    Route::get('', FetchAllSpacesController::class)
        ->name('all')
        ->middleware('auth.role:admin,user');

    Route::as('item.')->prefix('{spaceUid}')->group(callback: function (): void {
        Route::get('', FetchSpaceController::class)
            ->name('show')
            ->middleware('auth.role:admin,owner');
        Route::patch('', UpdateSpaceController::class)
            ->name('update')
            ->middleware('auth.role:admin,owner');
        Route::delete('', DeleteSpaceController::class)
            ->name('delete')
            ->middleware('auth.role:admin,owner');

        Route::as('review.')->prefix('review')->group(callback: function (): void {
            Route::post('', StoreSpaceReviewController::class)
                ->name('store')
                ->middleware('auth.role:admin,user');
            Route::get('', FetchAllSpaceReviewsController::class)
                ->name('all')
                ->middleware('auth.role:admin,user');

            Route::as('item.')->prefix('{spaceReviewUid}')->group(callback: function (): void {
                Route::get('', FetchSpaceReviewController::class)
                    ->name('show')
                    ->middleware('auth.role:admin,owner');
                Route::patch('', UpdateSpaceReviewController::class)
                    ->name('update')
                    ->middleware('auth.role:admin,owner');
                Route::delete('', DeleteSpaceReviewController::class)
                    ->name('delete')
                    ->middleware('auth.role:admin,owner');
            });
        });
    });
});

Route::as('user.')->prefix('user')->group(function (): void {
    Route::post('', StoreUserController::class)
        ->name('store')
        ->middleware('auth.role:admin');
    Route::get('', FetchAllUsersController::class)
        ->name('all')
        ->middleware('auth.role:admin');

    Route::as('item.')->prefix('{userUid}')->group(function (): void {
        Route::get('', FetchUserController::class)
            ->name('show')
            ->middleware('auth.role:admin,owner');
        Route::patch('', UpdateUserController::class)
            ->name('update')
            ->middleware('auth.role:admin,owner');
        Route::delete('', DeleteUserController::class)
            ->name('delete')
            ->middleware('auth.role:admin,owner');
    });
});
