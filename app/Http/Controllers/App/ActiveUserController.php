<?php

namespace App\Http\Controllers\App;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ActiveUserController extends Controller
{
    // Display a landing page for active clients.
    public function index()
    {
        $user = \Auth::user();
        return view('app.index')->with(['user' => $user]);
    }
}
