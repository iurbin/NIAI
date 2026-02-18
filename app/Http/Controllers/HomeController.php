<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use App\Models\Stat;
use App\Models\Forum;
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
        $notas = Nota::orderBy('id','asc')->paginate(15);
        $total_notas = $notas->count();
        $alcance_total = Stat::where('label','Alcance')->sum('value');
        $vistas_total = Stat::where('label','Vistas')->sum('value');

        //foros
        $total_comentarios = Stat::where('label','Comentarios')->where('item_type','forum_data')->sum('value');
        
        $foros = Forum::orderBy('position','asc')->paginate(5);
        $total_foros = $foros->count();
        
        return view('welcome', compact('notas', 'total_notas','alcance_total','vistas_total', 'foros', 'total_comentarios', 'total_foros'));
    }
    public function dashboard()
    {
        return view('home');
    }
}
