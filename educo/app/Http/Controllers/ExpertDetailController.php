<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;

class ExpertDetailController extends Controller
{
    public function index($id){
        $expert = User::where('id', $id)->first();
        $courses = Course::where('instructor_id', $id)->get();
        $data = [
            'expert' => $expert,
            'courses' => $courses,
        ];
        return view('pages.expert.detail', $data);
    }
}
