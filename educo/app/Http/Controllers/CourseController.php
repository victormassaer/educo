<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Company;
use App\Models\Course;
use App\Models\MandatoryCourse;
use App\Models\Participation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function detail($id){
        $course = Course::where('id', $id)->first();
        $expert = User::where('id', $course->instructor_id)->first();

        $chapters = Chapter::where('course_id', $id)->get();
        $data = [
            'course' => $course,
            'expert' => $expert,
            'chapters' => $chapters,
        ];
        return view('pages.course.detail', $data);
    }

    public function participate($id){
        $profile = Auth::user()->profile;
        $company = Company::where('id',  Auth::user()->company_id)->first();
        $mandatoryCourse = MandatoryCourse::where([
            ['course_id', '=', $id],
            ['company_id', '=', $company->id],
            ['profile_id', '=', $profile->id],
        ])->first();
        $course = Course::where('id', $id)->first();
        $participation = new Participation();
        $participation->course_id = $id;
        $participation->user_id = Auth::user()->id;
        $participation->start_time = now();
        $participation->total_completed = 0;
        if($mandatoryCourse){
            $participation->mandatory = 1;
        }else{
            $participation->mandatory = 0;
        }
        $participation->save();

        return redirect()->route('dashboard');
    }
}
