<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Course;
use App\Models\Element;
use App\Models\Question;
use App\Models\Video;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Vimeo\Laravel\Facades\Vimeo;

class ExpertElementController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

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
            $task = Task::with(array('element', 'questions' => function ($query) {
                $query->orderBy('order', 'ASC');
            }))->find($task_id);
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
            $task = Task::with(array('element', 'questions' => function ($query) {
                $query->orderBy('order', 'ASC');
            }))->find($task_id);
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


    public function createNewCourseElement(Request $request)
    {
        $course_id = $request->input('course_id');
        $chapter_id = $request->input('chapter_id');
        $chapter = Chapter::with('elements')->find($chapter_id);
        $type = $request->input('type');
        $element = new Element();
        $element->order = count($chapter->elements);
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
            return redirect()->route('expert.dashboard.edit-course-element', ['course_id' => $course_id, 'section_id' => $chapter_id, 'element_id' => $element->id, 'task_id' => $task->id, 'step' => '2']);
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

    public function deleteCourseElement(Request $request, $element_id)
    {
        $course_id = $request->input('course_id');
        $section_id = $request->input('section_id');
        Element::find($element_id)->delete();
        $section = Chapter::with(array(
            'elements' => function ($query) {
                $query->orderBy('order', 'ASC');
            }
        ))->find($section_id);
        foreach ($section->elements as $key => $element) {
            $element = Element::find($element->id);
            $element->order = $key;
            $element->save();
        };
        return redirect()->route('expert.dashboard.edit-course-section', ['course_id' => $course_id, 'section_id' => $section_id]);;
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
        $task = Task::with('questions')->find($content['task_id']);
        $question = new Question();
        $question->task_id = $content['task_id'];
        $question->order = count($task->questions);
        $question->question = $content['question'];
        $question->options = serialize($content['values']);
        $question->answer = $content["answer"];
        $question->save();

        return $content;
    }

    public function updateTaskOrder(Request $request)
    {
        $bodyContent = $request->getContent();
        $content = json_decode($bodyContent, true);
        $order = $content['order'];
        foreach ($order as $key => $item) {
            $chapter = Question::find($item);
            $chapter->order = $key;
            $chapter->save();
        }
        return $content;
    }

    public function deleteTaskQuestion(Request $request, $question_id)
    {
        $course_id = $request->input('course_id');
        $section_id = $request->input('section_id');
        $element_id = $request->input('element_id');
        $task_id = $request->input('task_id');
        Question::find($question_id)->delete();
        $task = Task::with(array(
            'questions' => function ($query) {
                $query->orderBy('order', 'ASC');
            }
        ))->find($task_id);
        foreach ($task->questions as $key => $question) {
            $question = Question::find($question->id);
            $question->order = $key;
            $question->save();
        };
        return redirect()->route('expert.dashboard.edit-course-element', ['course_id' => $course_id, 'section_id' => $section_id, 'element_id' => $element_id, 'task_id' => $task_id, 'step' => '2']);;
    }
}
