<?php

namespace App\Http\Controllers;

use App\Models\CatTalleres;
use Illuminate\Http\Request;
use App\MetaFritterVerso\TablaFront;
use App\MetaFritterVerso\ColumnasFront;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Talleres extends Controller
{

   
    public function showCatTalleres(Request $request)
    {
        
        $data = CatTalleres::where("estatus", 'alta')->get();
                
        $response = [
            "status" => 200,
            "status_info" => "alta",
            "data" => json_decode($data),
            "message" => "Info showStatus",           
        ];
        return response()->json($response, 200);
    }

   
}
