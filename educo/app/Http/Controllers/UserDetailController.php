<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Chapter;
use App\Models\Company;
use App\Models\Course;
use App\Models\Participation;
use App\Models\Profile;
//use App\Models\UserHasCertificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Element;

class UserDetailController extends Controller
{
    public function index(){
        $user = Auth::user();
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
        /*$c = UserHasCertificate::where('user_id', $user->id)->get();
        foreach($c as $certificate){
            $certificates[] = Certificate::where('id', $certificate->certificate_id);
        }*/
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
            'activeCourses'=> $activeCourses
        ];
        return view('pages.user.detail', $data);
    }

    public function editInfoIndex(){
    $company = Company::where('id', Auth::user()->company_id)->first();
        $data = [
            'company' => $company,
        ];
        return view('pages.user.editInfo', $data);
    }

    public function editInfoStore(Request $request){
        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->age = $request->age;
        $user->country = $request->country;
        $user->degree = $request->degree;
        $user->update();
        return $this->index();
    }

    public function completeInfoIndex(){
        return view('pages.user.detail');
    }
}
