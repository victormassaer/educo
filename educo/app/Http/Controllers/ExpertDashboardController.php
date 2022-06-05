<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Course;
use App\Models\Element;
use App\Models\Question;
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

    // New Course Page
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

    public function editCourse(Request $request)
    {
        $course_id = $request->course_id;
        $course = null;
        if (isset($course_id)) {
            $course = Course::with('chapters', 'chapters.elements')->find($course_id);
        }
        $data["course"] = $course;
        return view('pages.expert.edit-course', $data);
    }

    public function newCourseSection(Request $request)
    {
        $course_id = $request->course_id;
        $course = null;
        if (isset($course_id)) {
            $course = Course::find($course_id);
        }
        $section_id = $request->section_id;
        $chapter = null;
        if (!isset($section_id)) {
            $chapter = new Chapter();
            $chapter->title = "";
            $chapter->course_id = $course_id;
            $chapter->save();
        } else {
            $chapter = Chapter::with('elements', 'elements.video')->find($section_id);
        }
        $data["course"] = $course;
        $data['chapter'] = $chapter;
        return view('pages.expert.new-course-section', $data);
    }
    public function editCourseSection(Request $request)
    {
        $course_id = $request->course_id;
        $course = null;
        if (isset($course_id)) {
            $course = Course::find($course_id);
        }
        $section_id = $request->section_id;
        $chapter = Chapter::with('elements', 'elements.video')->find($section_id);
        $data['chapter'] = $chapter;
        $data["course"] = $course;
        $data['edit'] = true;
        return view('pages.expert.edit-course-section', $data);
    }

    public function newCourseElement(Request $request)
    {
        $task_id = $request->task_id;
        $video_id = $request->video_id;
        $section_id = $request->section_id;
        $element_id = $request->element_id;
        $chapter = $course = $element = $video_element = $video =  $task = null;
        if (isset($section_id)) {
            $chapter = Chapter::with('course')->find($section_id);
            $course = $chapter->course;
        }
        if (isset($element_id)) {
            $element = Element::with('chapter', 'chapter.course')->find($element_id);
            $chapter = $element->chapter;
            $course = $chapter->course;
        }
        if (isset($task_id)) {
            $task = Task::with('element', 'questions')->find($task_id);
            $element = $task->element;
        }
        if (isset($video_id)) {
            $video = Video::with('element')->find($video_id);
            $element = $video->element;
            $video_element = Vimeo::request($video->url, ['per_page' => 1], 'GET');
        }
        $data['element'] = $element;
        $data['task'] = $task;
        $data['video'] = $video;
        $data['video_element'] = $video_element;
        $data["course"] = $course;
        $data['chapter'] = $chapter;
        return view('pages.expert.new-course-element', $data);
    }

    public function editCourseElement(Request $request)
    {
        $step = $request->step;
        $course_id = $request->course_id;
        $video_id = $request->video_id;
        $task_id = $request->task_id;
        $element_id = $request->element_id;
        $course = null;
        if (isset($course_id)) {
            $course = Course::find($course_id);
        }
        $element = null;
        if (isset($element_id)) {
            $element = Element::find($request->element_id);
        }
        $section_id = $request->section_id;
        $chapter = null;
        if (isset($section_id)) {
            $chapter = Chapter::find($section_id);
        }
        if (isset($task_id)) {
            $task = Task::with('element', 'questions')->find($task_id);
            $data['task'] = $task;
        }
        if (isset($video_id)) {
            $video = Video::with('element')->find($video_id);
            $video_element = Vimeo::request($video->url, ['per_page' => 1], 'GET');
            $data['video'] = $video;
            $data['video_element'] = $video_element;
        }
        $data["course"] = $course;
        $data['chapter'] = $chapter;
        $data['element'] = $element;
        return view('pages.expert.edit-course-element', $data);
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
        $course->img = null;
        if ($request->hasFile("thumbnail")) {
            $destination_path = 'public/images/course_thumbnails';
            $file = $request->file('thumbnail');
            $filename = uniqid() . "_course_thumbnails_" . $file->getClientOriginalName();
            $request->file('thumbnail')->storeAs($destination_path, $filename);
            $course->img = 'images/course_thumbnails/' . $filename;
        }
        $course->save();
        return redirect()->route('expert.dashboard.edit-course', ['course_id' => $course->id, 'step' => '2']);
    }

    public function updateCourse(Request $request, $course_id)
    {
        $course = Course::find($course_id);
        $course->title = $request->input('title');
        $course->description = $request->input('description');
        $course->difficulty = $request->input('difficulty');
        if ($request->hasFile('thumbnail')) {
            $destination_path = 'public/images/course_thumbnails';
            $file = $request->file('thumbnail');
            $filename = uniqid() . "_course_thumbnails_" . $file->getClientOriginalName();
            $request->file('thumbnail')->storeAs($destination_path, $filename);
            $course->img = 'images/course_thumbnails/' . $filename;
        };
        $course->save();
        return redirect()->route('expert.dashboard.edit-course', ['course_id' => $course->id, 'step' => '2']);
    }

    public function createNewCourseSection(Request $request)
    {
        $section_id = $request->input('section_id');
        $course_id = $request->input('course_id');
        $chapter = Chapter::find($section_id);
        $chapter->title = $request->input('title');
        $chapter->course_id = $course_id;
        $chapter->save();
        return redirect()->route('expert.dashboard.edit-course', ['course_id' => $course_id, 'step' => '2']);
    }

    public function updateCourseSection(Request $request, $section_id)
    {
        $course_id = $request->input('course_id');
        $chapter = Chapter::find($section_id);
        $chapter->title = $request->input('title');
        $chapter->course_id = $course_id;
        $chapter->save();
        return redirect()->route('expert.dashboard.edit-course', ['course_id' => $course_id, 'step' => '2']);
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
        $element->task_id = 0;
        $element->video_id = 0;
        $element->save();
        if ($type === "video") {
            $video = new Video();
            $video->element_id = $element->id;
            $video->url = "";
            $video->save();
            $element->video_id = $video->id;
            $element->save();
            return redirect()->route('expert.dashboard.new-course-element', ['course_id' => $course_id, 'section_id' => $chapter_id, 'element_id' => $element->id, 'video_id' => $video->id, 'step' => '2']);
        } elseif ($type === "task") {
            $task = new Task();
            $task->element_id = $element->id;
            $task->save();
            $element->task_id = $task->id;
            $element->save();
            return redirect()->route('expert.dashboard.new-course-element', ['course_id' => $course_id, 'section_id' => $chapter_id, 'element_id' => $element->id, 'task_id' => $task->id, 'step' => '2']);
        };
    }
    public function updateCourseElement(Request $request, $element_id)
    {
        $element = Element::with('chapter', 'chapter.course')->find($element_id);
        $element->title = $request->input('title');
        $element->description = $request->input('description');
        $element->save();
        $type = $element->type;
        if ($type === "video") {
            $video = Video::find($element->video_id);
            return redirect()->route('expert.dashboard.edit-course-element', ['course_id' => $element->chapter->course->id, 'section_id' => $element->chapter->id, 'element_id' => $element->id, 'video_id' => $video->id, 'step' => '2']);
        } elseif ($type === "task") {
            $task = Task::find($element->task_id);
            return redirect()->route('expert.dashboard.edit-course-element', ['course_id' => $element->chapter->course->id, 'section_id' => $element->chapter->id, 'element_id' => $element->id, 'task_id' => $task->id, 'step' => '2']);
        };
    }

    public function createNewElementVideo(Request $request)
    {
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
        return redirect()->route('expert.dashboard.new-course-element', ['element_id' => $element_id, 'video_id' => $video->id, 'step' => '3']);
    }
    public function updateElementVideo(Request $request)
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
        return redirect()->route('expert.dashboard.edit-course-element', ['course_id' => $course_id, 'element_id' => $element_id, 'section_id' => $section_id, 'video_id' => $video->id, 'step' => '3']);
    }
    public function createNewElementTask(Request $request)
    {

        $bodyContent = $request->getContent();
        $content = json_decode($bodyContent, true);
        $question = new Question();
        $question->task_id = $content['task_id'];
        $question->question = $content['question'];
        $question->options = serialize($content['values']);
        $question->answer = $content["answer"];
        $question->save();

        return $content;
    }
}
