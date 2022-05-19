<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\ProfileHasSkill;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminRolesDashboardController extends Controller
{
    public function index(){
        $user = Auth::user();
        $profiles = Profile::where('company_id', $user->company_id)->get();
        $skillsPerProfile= [];
        foreach($profiles as $profile){
            $profileHasSkills = ProfileHasSkill::where('profile_id', $profile->id)->get();
            $skills = [];
            foreach($profileHasSkills as $profileHasSkill){
                $skills[] = Skill::where('id', $profileHasSkill->skill_id)->get();
            }
            $skillsPerProfile[] = $skills;
            $skills = [];
        }
        $data = [
            'profiles' => $profiles
        ];

        return view('pages.companyAdmin.rolesDashboard', $data);
    }
}
