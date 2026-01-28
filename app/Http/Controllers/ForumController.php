<?php

namespace App\Http\Controllers;

use App\Models\Forum;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ForumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $items = Forum::paginate(15);
        return view('forum.index', compact('items'));
    }
 
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validatedData = $request->validate([
            'title' => 'required',
            'value' => 'required',
            '' => '',
        ]);

        // 2. Create a new instance of the model and fill it with validated data
        $post = Nota::create($validatedData);

        
        // 4. Redirect the user or return a response
        return Redirect::back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Forum $forum)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Forum $forum)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Forum $forum)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Forum $forum)
    {
        //
         $forum->delete();

        return Redirect::back();
    }
}
