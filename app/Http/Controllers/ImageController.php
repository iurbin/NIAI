<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    //
    public function store(Request $request)
    {
        $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');

            // Return JSON instead of a view redirect
            return response()->json([
                'success' => 'Imagen cargada exitosamente!',
                'image_url' => asset('storage/' . $imagePath)
            ]);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }
}
