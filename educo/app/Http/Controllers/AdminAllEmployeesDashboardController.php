<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAllEmployeesDashboardController extends Controller
{
    public function index(){
        $user = Auth::user();
        $company = Company::where('id', $user->company_id)->first();
        $employees = User::where('company_id', $user->company_id)->get();
        $data = [
            'employees' => $employees,
            'company' => $company,
        ];
        return view('pages.companyAdmin.allEmployeesDashboard', $data);
    }
}
