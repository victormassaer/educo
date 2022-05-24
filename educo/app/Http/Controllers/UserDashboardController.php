<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function getAll()
    {
        return view('pages.user.dashboard', ['courses' => Course::all()]);
    }
}
