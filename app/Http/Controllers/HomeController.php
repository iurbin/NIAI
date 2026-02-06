<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use Illuminate\Support\Facades\DB;
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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $notas = Nota::paginate(15);
        $total_notas = $notas->count();
        
        return view('welcome', compact('notas', 'total_notas'));
    }
    public function dashboard()
    {
        return view('home');
    }
}
