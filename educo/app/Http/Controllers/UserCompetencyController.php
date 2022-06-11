<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserCompetencyController extends Controller
{
    public function index()
    {
        $user = User::with('userHasSkills', 'participation', 'userHasCertificate', 'userHasCertificate.certificate', 'userHasSkills.skill', 'userHasSkills.skill.coursesHasSkill', 'userHasSkills.skill.coursesHasSkill.course')->find(Auth::id());
        $data['user'] = $user;
        $data['certificates'] = $user->userHasCertificate;
        return view('pages.user.competencyProfile', $data);
    }
}
