<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Course;
use App\Models\Element;
use App\Models\Video;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Vimeo\Laravel\Facades\Vimeo;

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
        $section_id = $request->section_id;
        if (!$section_id) {
            $chapter = new Chapter();
            $chapter->title = "";
            $chapter->course_id = $course_id;
            $chapter->save();
            $data['chapter'] = $chapter;
        } else {
            $chapter = Chapter::with('elements', 'elements.video')->find($section_id);
            $data['chapter'] = $chapter;
        }

        $data["course"] = $course;
        $data['chapter'] = $chapter;
        return view('pages.expert.new-course-section', $data);
    }

    public function newCourseElement(Request $request)
    {
        $step = $request->step;
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

        if ($step === '3') {
            $video = Vimeo::request($request->video_path, ['per_page' => 1], 'GET');
            $data['video'] = $video;
            $element = Element::find($request->element_id);
            $data['element'] = $element;
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
        $destination_path = 'public/images/course_thumbnails';
        $file = $request->file('thumbnail');
        $filename = uniqid() . "_course_thumbnails_" . $file->getClientOriginalName();
        $request->file('thumbnail')->storeAs($destination_path, $filename);
        $course->img = 'images/course_thumbnails/' . $filename;
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

    public function updateNewCourseSection(Request $request, $section_id)
    {
        $course_id = $request->input('course_id');
        $chapter = Chapter::find($section_id);
        $chapter->title = $request->input('title');
        $chapter->course_id = $course_id;
        $chapter->save();
        return redirect()->route('expert.dashboard.new-course', ['course_id' => $course_id, 'step' => '2']);
    }

    public function createNewCourseElement(Request $request)
    {
        $course_id = $request->input('course_id');
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
            $video->url = "";
            $video->save();
            return redirect()->route('expert.dashboard.new-course-element', ['course_id' => $course_id, 'section_id' => $chapter_id, 'element_id' => $element->id, 'video_id' => $video->id, 'step' => '2']);
        } elseif ($type === "task") {
            $task = new Task();
            $task->element_id = $element->id;
            return redirect()->route('expert.dashboard.new-course-element', ['course_id' => $course_id, 'section_id' => $chapter_id, 'element_id' => $element->id, 'task_id' => $task->id, 'step' => '2']);
        };
    }

    public function createNewElementVideo(Request $request)
    {
        $course_id = $request->input('course_id');
        $section_id = $request->input('section_id');
        $element_id = $request->input('element_id');
        $destination_path = 'public/videos';
        $file = $request->file('video');
        $filename = uniqid() . "_vimeo_" . $file->getClientOriginalName();
        $path = $request->file('video')->storeAs($destination_path, $filename);
        $path = Storage::path('public/videos/' . $filename);
        $uri = Vimeo::upload($path, array('name' => $filename));
        Storage::delete('public/videos/' . $filename);

        $video = Element::find($element_id)->video;
        $video->url = $uri;
        $video->save();
        return redirect()->route('expert.dashboard.new-course-element', ['course_id' => $course_id, 'element_id' => $element_id, 'section_id' => $section_id, 'step' => '3', 'video_path' => $uri]);
    }
}
