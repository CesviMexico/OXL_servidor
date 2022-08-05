<?php

namespace App\Http\Controllers;

use App\Models\BitEvidencia;
use Illuminate\Http\Request;
use App\MetaFritterVerso\TablaFront;
use App\MetaFritterVerso\ColumnasFront;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EvidenciaController extends Controller
{

   
    public function showBitEvidencias(Request $request)
    {
        
         $params = $request->all();
        $arr = $params['parametros'];

        $idRegVeh = $arr['idRegVeh'];
        $status = $arr['status'];
        
       $registros = DB::table('bit_evidencia')
            ->where('id_reg_veh', $idRegVeh)
            ->where('estatus_registro', $status)
            ->get(["id_bit_evidencia", "id_reg_veh", "evidencia"]);

        return response()->json(["message" => "Update correcta", "status" => 201, "registros" => $registros], 201);
    }

   
}
