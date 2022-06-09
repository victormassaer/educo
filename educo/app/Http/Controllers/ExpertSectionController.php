<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Course;
use App\Models\Element;
use Illuminate\Http\Request;


class ExpertSectionController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    // GET New Section page
    public function newCourseSection(Request $request)
    {
        $course_id = $request->course_id;
        $course = null;
        if (isset($course_id)) {
            $course = Course::with(array(
                'chapters' => function ($query) {
                    $query->orderBy('order', 'ASC');
                }
            ))->find($course_id);
        }
        $section_id = $request->section_id;
        $chapter = null;
        if (!isset($section_id)) {
            $chapter = new Chapter();
            $chapter->title = "";
            $chapter->course_id = $course_id;
            $chapter->order = count($course->chapters);
            $chapter->save();
        } else {
            $chapter = Chapter::with(array(
                'elements' => function ($query) {
                    $query->orderBy('order', 'ASC');
                }, 'elements.video'
            ))->find($section_id);
        }
        $data["course"] = $course;
        $data['chapter'] = $chapter;
        return view('pages.expert.new-course-section', $data);
    }

    // GET Edit Section page
    public function editCourseSection(Request $request)
    {
        $course_id = $request->course_id;
        $course = null;
        if (isset($course_id)) {
            $course = Course::find($course_id);
        }
        $section_id = $request->section_id;
        $chapter = Chapter::with(array(
            'elements' => function ($query) {
                $query->orderBy('order', 'ASC');
            }, 'elements.video'
        ))->find($section_id);
        $data['chapter'] = $chapter;
        $data["course"] = $course;
        $data['edit'] = true;
        return view('pages.expert.edit-course-section', $data);
    }

    // POST Create new Section
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

    // POST Update section
    public function updateCourseSection(Request $request, $section_id)
    {
        $course_id = $request->input('course_id');
        $chapter = Chapter::find($section_id);
        $chapter->title = $request->input('title');
        $chapter->course_id = $course_id;
        $chapter->save();
        return redirect()->route('expert.dashboard.edit-course', ['course_id' => $course_id, 'step' => '2']);
    }

    // POST Delete section
    public function deleteCourseSection(Request $request, $section_id)
    {
        $course_id = $request->input('course_id');
        Chapter::find($section_id)->delete();
        $course = Course::with(array(
            'chapters' => function ($query) {
                $query->orderBy('order', 'ASC');
            }
        ))->find($course_id);
        foreach ($course->chapters as $key => $chapter) {
            $chapter = Chapter::find($chapter->id);
            $chapter->order = $key;
            $chapter->save();
        };
        return redirect()->route('expert.dashboard.edit-course', ['course_id' => $course_id, 'step' => '2']);;
    }

    // POST Update section order
    public function updateCourseSectionOrder(Request $request)
    {
        $bodyContent = $request->getContent();
        $content = json_decode($bodyContent, true);
        $order = $content['order'];
        foreach ($order as $key => $item) {
            $chapter = Element::find($item);
            $chapter->order = $key;
            $chapter->save();
        }
        return $content;
    }
}
