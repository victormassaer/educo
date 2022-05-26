<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Participation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function getAll()
    {
        $user = Auth::user();

        $data = [
            'user' => $user,
            'courses' => Course::all(),
        ];

        return view('pages.user.dashboard', $data);
    }

    public function getActive()
    {
        $user = Auth::user();
        $participations = Participation::where('user_id', $user->id)->get();
        $activeCourses = [];

        foreach ( $participations as $participation){
            $course = Course::where('id', $participation->course_id)->first();
            $totalChapters = $course->number_of_chapters;
            if($participation->total_completed != $totalChapters){
                $activeCourses[] = $course;
            }
        }

        $data = [
            'user' => $user,
            'activeCourses' => $activeCourses
        ];

        return view('pages.user.activeDashboard', $data);
    }

    public function getObligated()
    {
        return view('pages.user.obligatedDashboard', ['courses' => Course::all()]);
    }

    public function getFinished()
    {
        $user = Auth::user();
        $participations = Participation::where('user_id', $user->id)->get();
        $finishedCourses = [];

        foreach ( $participations as $participation){
            $course = Course::where('id', $participation->course_id)->first();
            $totalChapters = $course->number_of_chapters;
            if($participation->total_completed === $totalChapters){
                $finishedCourses[] = $course;
            }
        }

        $data = [
            'user' => $user,
            'finishedCourses' => $finishedCourses
        ];

        return view('pages.user.finishedDashboard', $data);
    }
}
