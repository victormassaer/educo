<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Course;
use App\Models\Element;
use App\Models\Video;
use Illuminate\Http\Request;
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
        return view('pages.expert.dashboard', $data);
    }
    public function newCourse(Request $request)
    {
        $course_id = $request->course_id;
        $course = null;
        if (isset($course_id)) {
            $course = Course::with('chapters', 'chapters.elements')->find($course_id);
        }
        $data["course"] = $course;
        return view('pages.expert.new-course', $data);
    }

    public function newCourseSection(Request $request)
    {
        $course_id = $request->course_id;
        $course = null;
        if (isset($course_id)) {
            $course = Course::find($course_id);
        }
        $chapter = new Chapter();
        $chapter->title = "";
        $chapter->course_id = $course_id;
        $chapter->save();
        $data["course"] = $course;
        $data['chapter'] = $chapter;
        return view('pages.expert.new-course-section', $data);
    }

    public function newCourseElement(Request $request)
    {
        $course_id = $request->course_id;
        $course = null;
        if (isset($course_id)) {
            $course = Course::find($course_id);
        }
        $section_id = $request->section_id;
        $chapter = null;
        if (isset($section_id)) {
            $chapter = Chapter::find($section_id);
        }
        $data["course"] = $course;
        $data['chapter'] = $chapter;
        return view('pages.expert.new-course-element', $data);
    }

    public function createNewCourse(Request $request)
    {
        $course = new Course();
        $course->title = $request->input('title');
        $course->description = $request->input('description');
        $course->difficulty = $request->input('difficulty');
        $course->draft = true;
        $course->instructor_id = Auth::id();
        $course->number_of_chapters = 0;
        $course->save();
        return redirect()->route('expert.dashboard.new-course', ['course_id' => $course->id, 'step' => '2']);
    }

    public function createNewCourseSection(Request $request)
    {
        $course_id = $request->input('course_id');
        $chapter = new Chapter();
        $chapter->title = $request->input('title');
        $chapter->course_id = $course_id;
        $chapter->save();
        return redirect()->route('expert.dashboard.new-course', ['course_id' => $course_id, 'step' => '2']);
    }

    public function createNewCourseElement(Request $request)
    {
        $chapter_id = $request->input('chapter_id');
        $type = $request->input('type');
        $element = new Element();
        $element->chapter_id = $chapter_id;
        $element->title = $request->input('title');
        $element->description = $request->input('description');
        $element->type = $type;
        $element->video_id = 0;
        $element->task_id = 0;

        $element->save();
        $video = null;
        if ($type === "video") {
            $video = new Video();
            $video->element_id = $element->id;
            $video->url = "https://vimeo.com";
            $video->save();
        } elseif ($type === "task") {
        };
        return redirect()->route('expert.dashboard.new-course-element', ['section_id' => $chapter_id, 'element_id' => $element->id, 'video_id' => $video->id, 'step' => '2']);
    }
}
