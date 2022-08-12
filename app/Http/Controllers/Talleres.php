<?php

namespace App\Http\Controllers;

use App\Models\CatTalleres;
use Illuminate\Http\Request;
use App\MetaFritterVerso\TablaFront;
use App\MetaFritterVerso\ColumnasFront;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Talleres extends Controller {

    public function showCatTalleres(Request $request) {

        $data = CatTalleres::where("estatus", 'alta')->get();

        $response = [
            "status" => 200,
            "status_info" => "alta",
            "data" => json_decode($data),
            "message" => "Info showStatus",
        ];
        return response()->json($response, 200);
    }

    public function addTallere(Request $request) {
        $params = $request->all();
        $arr = $params['parametros'];

        $nombre_taller = $arr['nombre_taller'];
        $direccion = $arr['direccion'];
        
        $link_maps = $arr['link_maps'];
        $coordenadas = $arr['coordenadas'];
        $contacto = $arr['contacto'];
        $estatus = $arr['estatus'];
        $id_taller_detalle = $arr['id_taller_detalle'];
        $cve_cia = $arr['cve_cia'];

        $Camposinsert = ['nombre_taller' => $nombre_taller, 'direccion' => $direccion, 'link_maps' => $link_maps, 'coordenadas' => $coordenadas, 
                         'contacto' => $contacto, 'estatus' =>  $estatus  , 'id_taller_detalle' =>  $id_taller_detalle  , 'cve_cia' => $cve_cia];
        $registros = DB::table("cat_talleres")->upsert($Camposinsert, ['id_taller']);

        return response()->json(["message" => "Update correcta", "status" => 201, "registros" => $registros], 201);
    }
    
     public function updteTalleres(Request $request) {
        $params = $request->all();
        $arr = $params['parametros'];

        $id_taller_detalle = $arr['id_taller_detalle'];
        $campo = $arr['campo'];
        $valor = $arr['valor'];

        $CamposUpdatet = [$campo => $valor]; //$this->getInserts($field_name, $value);
        $registros = DB::table('cat_talleres')
                ->where('id_taller_detalle', $id_taller_detalle)
                ->update($CamposUpdatet);

        //DB::table('bit_piezas')->where('id_bit_piezas', $idBitPiezas)->delete();


            return response()->json(["message" => "Update correcta", "status" => 201, "registros" => $registros], 201);
       
     }

}
