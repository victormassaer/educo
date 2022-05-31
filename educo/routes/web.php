<?php

use App\Http\Controllers\AdminAllEmployeesDashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminRolesDashboardController;
use App\Http\Controllers\AdminUserDetailPageController;
use App\Http\Controllers\ExpertDashboardController;
use Illuminate\Support\Facades\Artisan;
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

Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});


Route::group([
    'middleware' => ['auth']
], function(){
    //USER DASHBOARD
    Route::get('/dashboard', function () {return view('pages.user.dashboard');})->name('dashboard');

        //EXPERT DASHBOARD
        Route::get('/expert/dashboard', [ExpertDashboardController::class, 'index'])->name('expert.dashboard.index');
        Route::get('/expert/new-course', [ExpertDashboardController::class, 'newCourse'])->name('expert.dashboard.new-course');
        Route::post('/expert/new-course/create', [ExpertDashboardController::class, 'createNewCourse'])->name('expert.dashboard.create-new-course');
        Route::get('/expert/new-course/new-section', [ExpertDashboardController::class, 'newCourseSection'])->name('expert.dashboard.new-course-section');
        Route::post('/expert/new-course/new-section/create', [ExpertDashboardController::class, 'createNewCourseSection'])->name('expert.dashboard.create-new-course-section');
        Route::post('/expert/new-course/new-section/update/{section_id}', [ExpertDashboardController::class, 'updateNewCourseSection'])->name('expert.dashboard.update-new-course-section');
        Route::get('/expert/new-course/new-section/new-element', [ExpertDashboardController::class, 'newCourseElement'])->name('expert.dashboard.new-course-element');
        Route::post('/expert/new-course/new-section/new-element/create', [ExpertDashboardController::class, 'createNewCourseElement'])->name('expert.dashboard.create-new-course-element');
        Route::post('/expert/new-course/new-section/new-element/video/create', [ExpertDashboardController::class, 'createNewElementVideo'])->name('expert.dashboard.create-new-element-video');

        //EXPERT DASHBOARD
        Route::get('/expert/dashboard',[ExpertDashboardController::class, 'index'])->name('expert.dashboard.index');

        //USER DETAIL PAGE
        Route::get('/user/detail',[UserDetailController::class, 'index'])->name('user.detail.index');
        Route::get('/user/detail/edit',[UserDetailController::class, 'editInfoIndex'])->name('user.detail.edit.index');
        Route::post('/user/detail/edit',[UserDetailController::class, 'editInfoStore'])->name('user.detail.edit.store');
        Route::get('/user/detail/complete',[UserDetailController::class, 'completeInfoStore'])->name('user.detail.complete.index');

        //ADMIN DASHBOARD
        Route::get('/companyAdmin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard.index');
        Route::get('/companyAdmin/userDetail/{id}/index', [AdminUserDetailPageController::class, 'index'])->name('admin.userDetail.index');
        Route::get('/companyAdmin/userDetail/{id}/allActivity', [AdminUserDetailPageController::class, 'allActivity'])->name('admin.userDetail.allActivity');
        Route::get('/companyAdmin/profiles', [AdminRolesDashboardController::class, 'index'])->name('admin.profiles.index');
        Route::get('/companyAdmin/employees/index', [AdminAllEmployeesDashboardController::class, 'index'])->name('admin.employees.index');
        }
);

require __DIR__.'/auth.php';
