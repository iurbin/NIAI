<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use App\Models\Stat;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    //
    
    public function getbycity(Request $request)
    {
        $notas = Nota::where('location', 'like', '%'.$request->input('city').'%')->paginate(15);
        //return $notas;
        return view('partials.notasbycity', compact('notas'))->render();
    }
    public function getcities()
    {   
        
        $sql ="SELECT 
                    cl.name, 
                    cl.coords,
                    cl.country,
                    COUNT(*) as total_notes
                FROM 
                    notas n
                INNER JOIN 
                    city_locations cl 
                ON 
                    cl.name = TRIM(SUBSTRING_INDEX(n.location, ',', 1))
                GROUP BY 
                    cl.name, 
                    cl.country, 
                    cl.coords";
        $cities_from_db = DB::select($sql);
        $cities = [];
        foreach ($cities_from_db as $city) {
            $row = [
                'name' => $city->name, 
                'country'=>$city->country, 
                'coords'=> json_decode($city->coords),
                'total_notas'=> $city->total_notes 
                ];
            $cities[] = $row;
        }

        return $cities;
    }
}
