<?php

namespace App\Http\Controllers;

use App\Models\Forum;
use App\Models\Stat;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redirect;


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
        return view('forum.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validatedData = $request->validate([
            'link' => 'required',
            'forum_title' => 'required',
            'position' => 'required',
            'state' => 'required'
        ]);

        // 2. Create a new instance of the model and fill it with validated data
        $post = Forum::create($validatedData);
        
        $stat_id = $request['stat_id'];
        $stat_title = $request['stat_title'];
        $stat_value = $request['stat_value'];
        $stat_comparative = $request['stat_comparative'];
        $i = 0;
        
        if($stat_title):
            foreach ($stat_title as $stat) {
                
                    $stat = new Stat([
                        'label' => $stat,
                        'value' => $stat_value[$i],
                        'increase' => $stat_comparative[$i],
                        'item_type' => 'forum_data',
                    ]);

                    $post->stats()->save($stat);

                    
                
                $i++;
            }
            
        endif;
        // 4. Redirect the user or return a response
        return redirect()->route('forum.index');
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
        return view('forum.edit',compact('forum'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Forum $forum)
    {
        //
        $validatedData = $request->validate([
            'link' => 'required',
            'forum_title' => 'required',
            'position' => 'required',
            'state' => 'required'
        ]);

        // 2. Create a new instance of the model and fill it with validated data
        $forum->update($validatedData);

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
                        'item_type' => 'forum_data',
                    ]);

                    $forum->stats()->save($stat);
                endif;
                $i++;
            }
        endif;
        $items_to_delete = $request['items_to_delete'];
        if($items_to_delete){
            $deleted = Stat::destroy($items_to_delete);
        }
        


        // 4. Redirect the user or return a response
        return redirect()->route('forum.index');
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
