<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Company;
use App\Models\Course;
use App\Models\Profile;
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
        $courses = [];
        $chapters = [];
        $certificates = $user->certificate;
        foreach($participations as $key => $participation){
            $course = Course::where('id', $participation->course_id)->first();
            $courses[] = $course;
            $chapters[] = $course->chapters;
        }
        $data = [
            'company' => $company,
            'profile' => $profile,
            'chapters' => $chapters,
            'courses' => $courses,
            'certificates' => $certificates,
        ];
        return view('pages.user.detail', $data);
    }

    public function editInfoIndex(){
        return view('pages.user.editInfo');
    }

    public function editInfoStore(Request $request){
        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->update();
        return view('pages.user.detail');
    }

    public function completeInfoIndex(){
        return view('pages.user.detail');
    }
}
