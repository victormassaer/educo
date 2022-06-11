<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseHasSkill;
use App\Models\MandatoryCourse;
use App\Models\Participation;
use App\Models\Skill;
use App\Models\User;
use App\Models\UserHasSkill;
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
        $user = Auth::user();
        $profile_id = $user->profile_id;
        $company_id = $user->company_id;

        $mandatoryCourses = MandatoryCourse::where([
            ['profile_id', '=', $profile_id],
            ['company_id', '=', $company_id],
        ])->get('course_id');

        $mandatory = [];

        foreach ($mandatoryCourses as $mandatoryCourse) {
            $id = $mandatoryCourse->course_id;
            $mandatory [] = Course::where('id', $id)->first();
        }

        $data = [
            'user' => $user,
            'mandatoryCourses' => $mandatory,
        ];

        return view('pages.user.obligatedDashboard', $data);
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

    public function getRecommended()
    {
        $user = Auth::user();
        $user_id = $user->id;

        $getSkills = UserHasSkill::where('user_id', $user_id)->get();
        $skills = [];

        $coursePerSkill = [];
        $allCourses = [];

        $courseScores = [];

        foreach ($getSkills as $skill) {
            $skills [] = $skill;
        }

        foreach ($skills as $skill) {
            $coursePerSkill[] = CourseHasSkill::where('skill_id', $skill->id)->get('course_id');
        }

        foreach ($coursePerSkill as $course) {
            foreach($course as $c) {
                $allCourses[]= $c;
            }
        }

        foreach ($allCourses as $course) {
            $tmp = array_keys($allCourses, $course);
            $cnt = count($tmp);
            $courseScores [] = [ $cnt, $course ];
            $courseScoresUnique = array_unique($courseScores, SORT_REGULAR);
            asort($courseScoresUnique);
        }

        $recommendedCourseIds = array_reverse($courseScoresUnique);

        foreach ($recommendedCourseIds as $recommendedCourseId) {
            $course_id = array_slice($recommendedCourseId, 1);
            $id = $course_id[0]->course_id;
            $recommendedCourses [] = Course::where('id', $id)->first();
        }

        $data = [
            'user' => $user,
            'recommendedCourses' => $recommendedCourses
        ];

        return view('pages.user.recommendedDashboard', $data);
    }
}