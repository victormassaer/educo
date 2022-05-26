<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Course;
use App\Models\Participation;
use App\Models\Profile;
use App\Models\User;
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
        $certificates = $user->certificate;
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
}
