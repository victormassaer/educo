<?php

use App\Http\Controllers\AdminAllEmployeesDashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminRolesDashboardController;
use App\Http\Controllers\AdminUserDetailPageController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ExpertDashboardController;
use App\Http\Controllers\ExpertDetailController;
use App\Http\Controllers\ExpertListController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\UserDetailController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\ExpertCourseController;
use App\Http\Controllers\ExpertSectionController;
use App\Http\Controllers\ExpertElementController;
use App\Http\Controllers\UserCompetencyController;

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
        Route::get('/dashboard/recommended/{id}', [UserDashboardController::class, 'getRecommended'])->name('dashboard.recommended');


        Route::get('/competention-profile', [UserCompetencyController::class, 'index'])->name('dashboard.competency');

        Route::group([
            'middleware' => ['checkExpert']
        ], function () {
            //EXPERT DASHBOARD
            Route::get('/expert/dashboard', [ExpertDashboardController::class, 'index'])->name('expert.dashboard.index');
            // Course routes
            Route::get('/expert/new-course', [ExpertCourseController::class, 'newCourse'])->name('expert.dashboard.new-course');
            Route::get('/expert/edit-course', [ExpertCourseController::class, 'editCourse'])->name('expert.dashboard.edit-course');
            Route::post('/expert/new-course/create', [ExpertCourseController::class, 'createNewCourse'])->name('expert.dashboard.create-new-course');
            Route::post('/expert/course/update/{course_id}', [ExpertCourseController::class, 'updateCourse'])->name('expert.dashboard.update-course');
            Route::post('/expert/course/order/update/{course_id}', [ExpertCourseController::class, 'updateCourseOrder'])->name('expert.dashboard.update-course-order');
            // Section routes
            Route::get('/expert/edit-course/new-section', [ExpertSectionController::class, 'newCourseSection'])->name('expert.dashboard.new-course-section');
            Route::get('/expert/edit-course/edit-section', [ExpertSectionController::class, 'editCourseSection'])->name('expert.dashboard.edit-course-section');
            Route::post('/expert/edit-course/new-section/create', [ExpertSectionController::class, 'createNewCourseSection'])->name('expert.dashboard.create-new-course-section');
            Route::post('/expert/course/section/update/{section_id}', [ExpertSectionController::class, 'updateCourseSection'])->name('expert.dashboard.update-course-section');
            Route::post('/expert/course/section/delete/{section_id}', [ExpertSectionController::class, 'deleteCourseSection'])->name('expert.dashboard.delete-course-section');
            Route::post('/expert/course/section/order/update/{section_id}', [ExpertSectionController::class, 'updateCourseSectionOrder'])->name('expert.dashboard.update-course-section-order');
            // Element routes
            Route::get('/expert/edit-course/edit-section/new-element', [ExpertElementController::class, 'newCourseElement'])->name('expert.dashboard.new-course-element');
            Route::get('/expert/edit-course/edit-section/edit-element', [ExpertElementController::class, 'editCourseElement'])->name('expert.dashboard.edit-course-element');
            Route::post('/expert/edit-course/edit-section/new-element/create', [ExpertElementController::class, 'createNewCourseElement'])->name('expert.dashboard.create-new-course-element');
            Route::post('/expert/course/section/element/update/{element_id}', [ExpertElementController::class, 'updateCourseElement'])->name('expert.dashboard.update-course-element');
            Route::post('/expert/course/section/element/delete/{element_id}', [ExpertElementController::class, 'deleteCourseElement'])->name('expert.dashboard.delete-course-element');
            Route::post('/expert/new-course/new-section/new-element/video/create', [ExpertElementController::class, 'createNewElementVideo'])->name('expert.dashboard.create-new-element-video');
            Route::post('/expert/course/section/element/video/update/{video_id}', [ExpertElementController::class, 'updateElementVideo'])->name('expert.dashboard.update-element-video');
            Route::post('/expert/edit-course/edit-section/new-element/task/create', [ExpertElementController::class, 'createNewElementTask'])->name('expert.dashboard.create-new-element-task');
            Route::post('/expert/course/section/element/task/order/update/{task_id}', [ExpertElementController::class, 'updateTaskOrder'])->name('expert.dashboard.update-task-order');
            Route::post('/expert/course/section/element/task/question/delete/{question_id}', [ExpertElementController::class, 'deleteTaskQuestion'])->name('expert.dashboard.delete-task-question');

            //EXPERT DASHBOARD
            Route::get('/expert/dashboard', [ExpertDashboardController::class, 'index'])->name('expert.dashboard.index');
        });

        //USER DETAIL PAGE
        Route::get('/user/detail', [UserDetailController::class, 'index'])->name('user.detail.index');
        Route::get('/user/detail/edit', [UserDetailController::class, 'editInfoIndex'])->name('user.detail.edit.index');
        Route::post('/user/detail/edit', [UserDetailController::class, 'editInfoStore'])->name('user.detail.edit.store');
        Route::get('/user/detail/complete', [UserDetailController::class, 'completeInfoStore'])->name('user.detail.complete.index');

        Route::get('/expert/detail/{id}', [ExpertDetailController::class, 'index'])->name('expert.detail.index');
        Route::get('/expert/list', [ExpertListController::class, 'index'])->name('expert.list.index');

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
        Route::get('/course/next/{elementId}/{chapterId}', [CourseController::class, 'nextStep'])->name('next.step.course');
    }
);

require __DIR__ . '/auth.php';
