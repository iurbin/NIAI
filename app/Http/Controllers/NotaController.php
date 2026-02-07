<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use App\Models\Stat;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class NotaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notas = Nota::paginate(15);
        return view('notas.index', compact('notas'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('notas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'link' => 'required',
            'title' => 'required',
            'cover' => 'required',
            'extract' => 'required',
            'location' => 'required'    
        ]);

        // 2. Create a new instance of the model and fill it with validated data
        $post = Nota::create($validatedData);

        
        // 4. Redirect the user or return a response
        return redirect()->route('notas.index', $post->id)
                         ->with('success', 'Publicación creada exitosamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Nota $nota)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Nota $nota)
    {
        //
        return view('notas.edit',compact('nota'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Nota $nota)
    {
        $validatedData = $request->validate([
            'link' => 'required',
            'title' => 'required',
            'cover' => 'required',
            'extract' => 'required',
            'location' => 'required'    
        ]);
        // 2. Create a new instance of the model and fill it with validated data
        $nota->update($validatedData);
        $stat_id = $request['stat_id'];
        $stat_title = $request['stat_title'];
        $stat_value = $request['stat_value'];
        $stat_comparative = $request['stat_comparative'];
        $i = 0;
        if($stat_title):
            foreach ($stat_title as $stat) {
                if($stat_id[$i]=='0')://avoid duplicates when saving nota and not editing stats
                    $stat = new Stat([
                        'label' => $stat,
                        'value' => $stat_value[$i],
                        'increase' => $stat_comparative[$i],
                        'item_type' => 'nota_data',
                    ]);

                    $nota->stats()->save($stat);
                endif;
                $i++;


                
            }
        endif;
        
        return redirect()->route('notas.index', $nota)
                         ->with('success', 'Publicación actualizada exitosamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Nota $nota)
    {
        $nota->delete();

        return redirect()->route('notas.index')->with('success', 'Publicacion eliminada correctamente');
    }
}
