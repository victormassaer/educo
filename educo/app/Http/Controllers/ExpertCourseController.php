<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ExpertCourseController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    // GET New Course Page
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

    // GET Edit Course Page
    public function editCourse(Request $request)
    {
        $course_id = $request->course_id;
        $course = null;
        if (isset($course_id)) {
            $course = Course::with(array('chapters' => function ($query) {
                $query->orderBy('order', 'ASC');
            }, 'chapters.elements' => function ($query) {
                $query->orderBy('order', 'ASC');
            }))->find($course_id);
        }
        $data["course"] = $course;
        return view('pages.expert.edit-course', $data);
    }

    // POST Create new course request
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

    // POST Update course request
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

    // POST Update course order
    public function updateCourseOrder(Request $request)
    {
        $bodyContent = $request->getContent();
        $content = json_decode($bodyContent, true);
        $order = $content['order'];
        foreach ($order as $key => $item) {
            $chapter = Chapter::find($item);
            $chapter->order = $key;
            $chapter->save();
        }
        return $content;
    }
}
