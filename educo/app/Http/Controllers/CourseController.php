<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Chapter;
use App\Models\Company;
use App\Models\Course;
use App\Models\Element;
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

        $participation = Participation::where([
            ['course_id', '=', $id],
            ['user_id', '=', Auth::user()->id],
        ])->first();

        if($participation){
            $chapters = Chapter::where('course_id', $id)->get();
            //$skills = //HIER DE SKILLS VAN DE COURSE UIT MODEL COURSEHASSKILL EN DB TABLE
            $activeChapter = Chapter::where([
                ['course_id', '=', $id],
                ['order', '=', $participation->total_completed],
            ])->first();
            if($activeChapter){
                $elements = Element::where('chapter_id', $activeChapter->id)->get();
                $activeElement =Element::where([
                    ['chapter_id', '=', $activeChapter->id],
                    ['order', '=', $participation->finished_element],
                ])->first();
            }else{
                $activeElement = [];
            }
        }else{
            $chapters = [];
            $activeChapter = [];
            $activeElement = [];
        }

        $data = [
            'course' => $course,
            'expert' => $expert,
            'chapters' => $chapters,
            'participation' => $participation,
            'activeChapter' => $activeChapter,
            'activeElement' => $activeElement,
        ];
        if($participation){
            if($participation->total_completed != $course->number_of_chapters){
                return view('pages.course.detail', $data);
            }
       }else{
            return view('pages.course.finished', $data);
        }

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

    public function nextStep($elementId, $chapterId){
        $elements = Element::where('chapter_id', $chapterId)->get();
        $currentElement = Element::where('id', $elementId)->first();

        $currentChapter = Chapter::where('id', $chapterId)->first();
        $chapters = Chapter::where('course_id', $currentChapter->course_id)->get();
        $course = Course::where('id', $currentChapter->course_id)->first();
        $expert = User::where('id', $course->instructor_id)->first();
        $participation = Participation::where([
            ['course_id', '=', $currentChapter->course_id],
            ['user_id', '=', Auth::user()->id],
        ])->first();

        if(count($elements) != $currentElement->order+1){
            $nextElement = Element::where([
                ['chapter_id', '=', $chapterId],
                ['order', '=', $currentElement->order+1],
            ])->first();
            $participation->finished_element = $nextElement->order;
            $participation->update();

            return $this->detail($course->id);
        }elseif(count($chapters) != $currentChapter->order+1){
            $nextChapter = Chapter::where([
                ['course_id', '=', $currentChapter->course_id],
                ['order', '=', $currentChapter->order+1],
            ])->first();
            $participation->finished_element = 0;
            $participation->total_completed = $nextChapter->order;
            $participation->updated_at = now();
            $participation->update();
            return $this->detail($course->id);
            //VOLGEND CHAPTER INLADEN
        }else{
           $participation->finished_element = $currentElement->order;
           $participation->total_completed = $course->number_of_chapters;
           $participation->updated_at = now();
           $participation->update();

           $certificate = new Certificate();
           $certificate->user_id = Auth::user()->id;
           $certificate->date_acquired = now();
           $certificate->skill_id = now(); //HIER NOG SKILLS OPHALEN UIT COURSE HAS SKILLS TABLE!
           $certificate->title = now(); //VANWAAR KOMT TITEL?

            $data = [
                'course' => Course::where('id', $currentChapter->course_id)->first(),
            ];
            return $this->detail($course->id);
        }
    }

}
