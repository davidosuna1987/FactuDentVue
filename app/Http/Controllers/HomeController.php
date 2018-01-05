<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //\Alert::success('¡La factura se ha actualizado correctamente!', '¡Hecho!')->persistent('OK');
        return redirect()->route('home');
        if(auth()->user()->isGod() or auth()->user()->isAdmin()) return view('app.clinics.create');
        return view('app.index');
    }
}
