<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Course;
use App\Models\CourseHasSkill;
use App\Models\Skill;
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
        $skills = Skill::all();
        $data["course"] = $course;
        $data["skills"] = $skills;
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
        $skills = Skill::all();
        $courseHasSkills = CourseHasSkill::where('course_id', '=', $course_id)->get();
        $data["course"] = $course;
        $data["skills"] = $skills;
        $data["courseHasSkills"] = $courseHasSkills;
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
        $skills = explode(",", $request->skillIds);
        foreach ($skills as $key => $skill) {
            $courseHasSkill = new CourseHasSkill();
            $courseHasSkill->course_id = $course->id;
            $courseHasSkill->skill_id = $skill;
            $courseHasSkill->save();
        }
        $newSkills =  explode(",", $request->new_skills);
        foreach ($newSkills as $key => $skill) {
            $newSkill = new Skill();
            $newSkill->title = $skill;
            $newSkill->description =  "";
            $newSkill->save();
            $courseHasSkill = new CourseHasSkill();
            $courseHasSkill->course_id = $course->id;
            $courseHasSkill->skill_id = $newSkill->id;
            $courseHasSkill->save();
        }
        return redirect()->route('expert.dashboard.edit-course', ['course_id' => $course->id, 'step' => '2']);
    }

    // POST Update course request
    public function updateCourse(Request $request, $course_id)
    {
        $course = Course::with('courseHasSkills')->find($course_id);
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
        $skills = explode(",", $request->skillIds);

        foreach ($course->courseHasSkills as $key => $courseSkill) {
            if (!in_array(strval($courseSkill->skill_id), $skills)) {
                CourseHasSkill::where('id', '=', $courseSkill->id)->where('course_id', '=', $course->id)->delete();
            };
        }
        if ($request->skillIds !== null) {
            foreach ($skills as $key => $skill) {
                $courseHasSkill = CourseHasSkill::where('skill_id', '=', $skill)->where('course_id', '=', $course->id)->get();
                if (count($courseHasSkill) === 0) {
                    $courseHasSkill = new CourseHasSkill();
                    $courseHasSkill->course_id = $course->id;
                    $courseHasSkill->skill_id = $skill;
                    $courseHasSkill->save();
                }
            }
        }

        if ($request->new_skills !== null) {
            $newSkills =  explode(",", $request->new_skills);
            foreach ($newSkills as $key => $skill) {
                $newSkill = new Skill();
                $newSkill->title = $skill;
                $newSkill->description =  "";
                $newSkill->save();
                $courseHasSkill = new CourseHasSkill();
                $courseHasSkill->course_id = $course->id;
                $courseHasSkill->skill_id = $newSkill->id;
                $courseHasSkill->save();
            }
        }

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
