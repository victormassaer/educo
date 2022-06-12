<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Participation;
use Illuminate\Support\Facades\Auth;


class ExpertDashboardController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $courses = Course::where("instructor_id", $user->id)->get();
        $data['courses'] = $courses;
        $data['participations'] = Participation::all();
        return view('pages.expert.dashboard', $data);
    }
}
