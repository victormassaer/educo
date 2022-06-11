<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserCompetencyController extends Controller
{
    public function index()
    {
        $user = User::with('userHasSkills', 'participation', 'userHasSkills.skill', 'userHasSkills.skill.coursesHasSkill', 'userHasSkills.skill.coursesHasSkill.course')->find(Auth::id());
        $data['user'] = $user;
        return view('pages.user.competencyProfile', $data);
    }
}
