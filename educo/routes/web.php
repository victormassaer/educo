<?php

use App\Http\Controllers\ExpertDashboardController;
use App\Http\Controllers\UserDetailController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});



Route::group([
    'middleware' => ['auth']
], function(){
    //USER DASHBOARD
    Route::get('/dashboard', function () {return view('pages.user.dashboard');})->name('dashboard');

    //EXPERT DASHBOARD
    Route::get('/expert/dashboard',[ExpertDashboardController::class, 'index'])->name('expert.dashboard.index');

    //USER DETAIL PAGE
    Route::get('/user/detail',[UserDetailController::class, 'index'])->name('user.detail.index');
    Route::get('/user/detail/edit',[UserDetailController::class, 'editInfoIndex'])->name('user.detail.edit.index');
    Route::post('/user/detail/edit',[UserDetailController::class, 'editInfoStore'])->name('user.detail.edit.store');
    Route::get('/user/detail/complete',[UserDetailController::class, 'completeInfoStore'])->name('user.detail.complete.index');
    }
);

require __DIR__.'/auth.php';
