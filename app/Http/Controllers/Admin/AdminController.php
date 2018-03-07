<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    // Display a landing page for active clients.
    public function index()
    {
        $user = auth()->user();
        $users = User::all();
        return view('app.index', compact('user', 'users'));
    }
}
