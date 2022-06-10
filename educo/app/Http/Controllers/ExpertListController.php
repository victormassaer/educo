<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ExpertListController extends Controller
{
    public function index(){
        $experts = User::where('role_id', 2)->get();
        $data = [
            'experts' => $experts,
        ];
        return view('pages.user.expertList', $data);
    }
}
