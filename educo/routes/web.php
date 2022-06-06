<?php

use App\Http\Controllers\AdminAllEmployeesDashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminRolesDashboardController;
use App\Http\Controllers\AdminUserDetailPageController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ExpertDashboardController;
use App\Http\Controllers\ExpertDetailController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\UserDetailController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserDashboardController;

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


Route::group(
    [
        'middleware' => ['auth']
    ],
    function () {
        //USER DASHBOARD
        Route::get('/dashboard', [UserDashboardController::class, 'getAll'])->name('dashboard');
        Route::get('/dashboard/active/{id}', [UserDashboardController::class, 'getActive'])->name('dashboard.active');
        Route::get('/dashboard/obligated/{id}', [UserDashboardController::class, 'getObligated'])->name('dashboard.obligated');
        Route::get('/dashboard/finished/{id}', [UserDashboardController::class, 'getFinished'])->name('dashboard.finished');

        Route::group([
            'middleware' => ['checkExpert']
        ], function () {
            //EXPERT DASHBOARD
            Route::get('/expert/dashboard', [ExpertDashboardController::class, 'index'])->name('expert.dashboard.index');
            Route::get('/expert/new-course', [ExpertDashboardController::class, 'newCourse'])->name('expert.dashboard.new-course');
            Route::post('/expert/new-course/create', [ExpertDashboardController::class, 'createNewCourse'])->name('expert.dashboard.create-new-course');
            Route::get('/expert/edit-course', [ExpertDashboardController::class, 'editCourse'])->name('expert.dashboard.edit-course');
            Route::post('/expert/course/order/update/{course_id}', [ExpertDashboardController::class, 'updateCourseOrder'])->name('expert.dashboard.update-course-order');
            Route::post('/expert/course/update/{course_id}', [ExpertDashboardController::class, 'updateCourse'])->name('expert.dashboard.update-course');
            Route::get('/expert/edit-course/new-section', [ExpertDashboardController::class, 'newCourseSection'])->name('expert.dashboard.new-course-section');
            Route::post('/expert/edit-course/new-section/create', [ExpertDashboardController::class, 'createNewCourseSection'])->name('expert.dashboard.create-new-course-section');
            Route::get('/expert/edit-course/edit-section', [ExpertDashboardController::class, 'editCourseSection'])->name('expert.dashboard.edit-course-section');
            Route::post('/expert/course/section/update/{section_id}', [ExpertDashboardController::class, 'updateCourseSection'])->name('expert.dashboard.update-course-section');
            Route::post('/expert/course/section/order/update/{section_id}', [ExpertDashboardController::class, 'updateCourseSectionOrder'])->name('expert.dashboard.update-course-section-order');
            Route::get('/expert/edit-course/edit-section/new-element', [ExpertDashboardController::class, 'newCourseElement'])->name('expert.dashboard.new-course-element');
            Route::get('/expert/edit-course/edit-section/edit-element', [ExpertDashboardController::class, 'editCourseElement'])->name('expert.dashboard.edit-course-element');
            Route::post('/expert/edit-course/edit-section/new-element/create', [ExpertDashboardController::class, 'createNewCourseElement'])->name('expert.dashboard.create-new-course-element');
            Route::post('/expert/course/section/element/update/{element_id}', [ExpertDashboardController::class, 'updateCourseElement'])->name('expert.dashboard.update-course-element');
            Route::post('/expert/new-course/new-section/new-element/video/create', [ExpertDashboardController::class, 'createNewElementVideo'])->name('expert.dashboard.create-new-element-video');
            Route::post('/expert/course/section/element/video/update/{video_id}', [ExpertDashboardController::class, 'updateElementVideo'])->name('expert.dashboard.update-element-video');
            Route::post('/expert/edit-course/edit-section/new-element/task/create', [ExpertDashboardController::class, 'createNewElementTask'])->name('expert.dashboard.create-new-element-task');
            Route::post('/expert/course/section/element/task/order/update/{task_id}', [ExpertDashboardController::class, 'updateTaskOrder'])->name('expert.dashboard.update-task=order');

            //EXPERT DASHBOARD
            Route::get('/expert/dashboard', [ExpertDashboardController::class, 'index'])->name('expert.dashboard.index');
            Route::get('/expert/detail/{id}', [ExpertDetailController::class, 'index'])->name('expert.detail.index');
        });

        //USER DETAIL PAGE
        Route::get('/user/detail', [UserDetailController::class, 'index'])->name('user.detail.index');
        Route::get('/user/detail/edit', [UserDetailController::class, 'editInfoIndex'])->name('user.detail.edit.index');
        Route::post('/user/detail/edit', [UserDetailController::class, 'editInfoStore'])->name('user.detail.edit.store');
        Route::get('/user/detail/complete', [UserDetailController::class, 'completeInfoStore'])->name('user.detail.complete.index');

        Route::group([
            'middleware' => ['checkRole']
        ], function () {
            //ADMIN DASHBOARD
            Route::get('/companyAdmin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard.index');
            Route::get('/companyAdmin/userDetail/{id}/index', [AdminUserDetailPageController::class, 'index'])->name('admin.userDetail.index');
            Route::get('/companyAdmin/userDetail/{id}/allActivity', [AdminUserDetailPageController::class, 'allActivity'])->name('admin.userDetail.allActivity');
            Route::get('/companyAdmin/userDetail/{id}/allMandatoryCourses', [AdminUserDetailPageController::class, 'allMandatoryCourses'])->name('admin.userDetail.allMandatoryCourses');
            Route::get('/companyAdmin/userDetail/{id}/allPersonalCourses', [AdminUserDetailPageController::class, 'allPersonalCourses'])->name('admin.userDetail.allPersonalCourses');
            Route::get('/companyAdmin/profiles', [AdminRolesDashboardController::class, 'index'])->name('admin.profiles.index');
            Route::get('/companyAdmin/profiles/{id}/detail', [AdminRolesDashboardController::class, 'detail'])->name('admin.profiles.detail');
            Route::get('/companyAdmin/employees/index', [AdminAllEmployeesDashboardController::class, 'index'])->name('admin.employees.index');
        });

        //COURSES
        Route::get('/course/detail/{id}', [CourseController::class, 'detail'])->name('course.detail');
        Route::get('/course/participate/{id}', [CourseController::class, 'participate'])->name('course.participation');
        Route::get('/course/next/{elementId}/{chapterId}', [CourseController::class, 'nextElement'])->name('course.nextElement');
    }
);

require __DIR__ . '/auth.php';
