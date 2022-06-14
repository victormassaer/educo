<?php

namespace App\Http\Controllers;

use App\Models\User;

class AdminUserCompetencyController extends Controller
{
    public function index($userId)
    {
        $user = User::with('userHasSkills', 'participation', 'userHasCertificate', 'userHasCertificate.certificate', 'userHasSkills.skill', 'userHasSkills.skill.coursesHasSkills', 'userHasSkills.skill.coursesHasSkills.course')->find($userId);
        $data['user'] = $user;
        $data['certificates'] = $user->userHasCertificate;
        return view('pages.user.competencyProfile', $data);
    }
}
