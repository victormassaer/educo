<?php

use App\Http\Controllers\ExpertDashboardController;
use App\Http\Controllers\UserDashboardController;
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
    Route::get('/dashboard', [UserDashboardController::class, 'getAll'])->name('dashboard');
    Route::get('/dashboard/active/{id}', [UserDashboardController::class, 'getActive'])->name('dashboard.active');
    Route::get('/dashboard/obligated', [UserDashboardController::class, 'getObligated'])->name('dashboard.obligated');
    Route::get('/dashboard/finished', [UserDashboardController::class, 'getFinished'])->name('dashboard.finished');

    //EXPERT DASHBOARD
    Route::get('/expert/dashboard',[ExpertDashboardController::class, 'index'])->name('expert.dashboard.index');
    }
);

require __DIR__.'/auth.php';
