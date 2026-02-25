<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $estado = Auth::user()->estado;
        if ($estado == 1) {
            // $sql = DB::select('select count(*) as total from usuario where tipo=1');
            // return view('home')->with('sql', $sql);
            return view('home');
        } else {
            session()->invalidate();
            session()->regenerateToken();
            return back()->with('mensaje', 'CUENTA ELIMINADA: esta cuenta se ha eliminado, consulte con el administrador');
        }
    }
}
