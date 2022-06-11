<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Company;
use App\Models\Course;
use App\Models\Participation;
use App\Models\Profile;
use App\Models\User;
use App\Models\UserHasCertificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminUserDetailPageController extends Controller
{
    public function index($id){
        $user = User::where('id', $id)->first();
        $company = Company::where('id', $user->company_id)->firstOrFail();
        $profile = Profile::where('id', $user->profile_id)->firstOrFail();

        $participations = $user->participation;
        $mandatoryParticipations = Participation::where([
            ['user_id', '=', $user->id],
            ['mandatory', '=', 1]
        ])->get();
        $personalParticipations = Participation::where([
            ['user_id', '=', $user->id],
            ['mandatory', '=', 0]
        ])->get();


        $courses = [];
        $mandatoryCourses = [];
        $personalCourses = [];
        $chapters = [];
        $certificates = [];
        $c = UserHasCertificate::where('user_id', $user->id)->get();
        foreach($c as $certificate){
            $certificates[] =Certificate::where('id', $certificate->certificate_id)->first();
        }
        $activeCourses = [];
        foreach($participations as $participation){
            $course = Course::where('id', $participation->course_id)->first();
            $courses[] = $course;
            $chapters[] = $course->chapters;
        }

        foreach($mandatoryParticipations as $participation){
            $course = Course::where('id', $participation->course_id)->first();
            $mandatoryCourses[] = $course;
        }

        foreach($personalParticipations as $participation){
            $course = Course::where('id', $participation->course_id)->first();
            $personalCourses[] = $course;
        }

        foreach($participations as $participation){
            $course = Course::where('id', $participation->course_id)->first();
            $totalChapters = $course->number_of_chapters;
            if($participation->total_completed != $totalChapters){
                $activeCourses[] = $course;
            }
        }

        $data = [
            'company' => $company,
            'profile' => $profile,
            'chapters' => $chapters,
            'courses' => $courses,
            'mandatoryCourses' => $mandatoryCourses,
            'personalCourses' => $personalCourses,
            'certificates' => $certificates,
            'user' => $user,
            'activeCourses' => $activeCourses
        ];
        return view('pages.companyAdmin.userDetailPage', $data);
    }

    public function allActivity($id){
        $user = User::where('id', $id)->first();
        $company = Company::where('id', $user->company_id)->firstOrFail();
        $profile = Profile::where('id', $user->profile_id)->firstOrFail();

        $participations = $user->participation;

        $courses = [];
        $chapters = [];
        foreach($participations as $participation){
            $course = Course::where('id', $participation->course_id)->first();
            $courses[] = $course;
            $chapters[] = $course->chapters;
        }

        foreach($participations as $participation){
            $course = Course::where('id', $participation->course_id)->first();
            $totalChapters = $course->number_of_chapters;

        }

        $data = [
            'company' => $company,
            'profile' => $profile,
            'chapters' => $chapters,
            'courses' => $courses,
            'user' => $user,
        ];

        return view('pages.companyAdmin.allUserActivity', $data);
    }

    public function allMandatoryCourses($id){
        $user = User::where('id', $id)->first();

        $participations = $user->participation;
        $mandatoryParticipations = Participation::where([
            ['user_id', '=', $user->id],
            ['mandatory', '=', 1]
        ])->get();

        $courses = [];
        $mandatoryCourses = [];
        foreach($participations as $participation){
            $course = Course::where('id', $participation->course_id)->first();
            $courses[] = $course;
            $chapters[] = $course->chapters;
        }

        foreach($mandatoryParticipations as $participation){
            $course = Course::where('id', $participation->course_id)->first();
            $mandatoryCourses[] = $course;
        }

        $data = [
            'courses' => $courses,
            'mandatoryCourses' => $mandatoryCourses,
            'user' => $user,
        ];
        return view('pages.companyAdmin.allMandatoryCourses', $data);
    }

    public function allPersonalCourses($id){
        $user = User::where('id', $id)->first();

        $participations = $user->participation;
        $personalParticipations = Participation::where([
            ['user_id', '=', $user->id],
            ['mandatory', '=', 0]
        ])->get();

        $courses = [];
        $personalCourses = [];
        foreach($participations as $participation){
            $course = Course::where('id', $participation->course_id)->first();
            $courses[] = $course;
            $chapters[] = $course->chapters;
        }

        foreach($personalParticipations as $participation){
            $course = Course::where('id', $participation->course_id)->first();
            $personalCourses[] = $course;
        }

        $data = [
            'personalCourses' => $personalCourses,
            'user' => $user,
        ];
        return view('pages.companyAdmin.allPersonalCourses', $data);
    }
}
