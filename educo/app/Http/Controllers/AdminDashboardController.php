<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Participation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPUnit\TextUI\XmlConfiguration\Logging\TestDox\Text;

class AdminDashboardController extends Controller
{
    public function index(){
        $user = Auth::user();
        $employees = User::where('company_id', $user->company_id)->get();
        $company = Company::where('id', $user->company_id)->first();
        $participationsPerUser = [];
        $allParticipations = [];
        $activeParticipations = [];
        $inactiveParticipations = [];
        $activeEmployees = [];
        $inactiveEmployees = [];
        $participationsUserId = [];
        foreach($employees as $employee){
            $participationsPerUser[] = Participation::where('user_id', $employee->id)->get();
        }
        foreach($participationsPerUser as $participation){
            foreach($participation as $p){
                $allParticipations[] = $p;
            }
        }
        $checkDate = now()->subDays(30);
        foreach($allParticipations as $participation){
            if($participation->updated_at > $checkDate){
                $activeParticipations[] = $participation;
                $activeUser = User::where('id', $participation->user_id)->first();
                if(!in_array($activeUser, $inactiveEmployees)){
                    $activeEmployees[] = $activeUser;
                }
            }else{
                $inactiveParticipations[] = $participation;
                $inactiveUser = User::where('id', $participation->user_id)->first();
                if(!in_array($inactiveUser, $inactiveEmployees) && !in_array($inactiveUser, $activeEmployees)){
                    $inactiveEmployees[] = $inactiveUser;
                }
            }
        }
        foreach($allParticipations as $participation){
            $participationsUserId[] = $participation->user_id;
        }
        foreach($employees as $employee){
            if(!in_array($employee->id, $participationsUserId)){
                $inactiveEmployees[] = $employee;
            }
        }
        $data = [
            'company' => $company,
            'employees' => $employees,
            'inactiveEmployees' => $inactiveEmployees,
            'activeEmployees' => $activeEmployees,
        ];

        return view('pages.companyAdmin.companyAdminDashboard', $data);
    }
}
