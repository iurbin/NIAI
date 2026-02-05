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
        $notas = Nota::where('location', 'like', '%'.$request->input('city').'%')->paginate();
        return $notas;
    }
    public function getcities(Request $request)
    {   
        $country = $request->input('country'); 
        $sql ="SELECT 
                    cl.name, 
                    cl.coords,
                    COUNT(*) as total_notes
                FROM 
                    notas n
                INNER JOIN 
                    city_locations cl 
                ON 
                    cl.name = TRIM(SUBSTRING_INDEX(n.location, ',', 1))
                where
                    n.location like '%".$country."%'
                GROUP BY 
                    cl.name, 
                    cl.coords";
        $cities = DB::select($sql);
       

        return $cities;  
    }
}
