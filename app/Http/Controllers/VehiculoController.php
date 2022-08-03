<?php

namespace App\Http\Controllers;

use App\Models\BitRegVehiculos;
use Illuminate\Http\Request;
use App\MetaFritterVerso\TablaFront;
use App\MetaFritterVerso\ColumnasFront;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VehiculoController extends Controller
{

    public function showAll()
    {
        return response()->json(BitRegVehiculos::all());
    }

    public function showOne($id)
    {
        return response()->json(BitRegVehiculos::find($id));
    }

    public function createRegVeh(Request $request)
    {

        $params = $request->all();
        $arr = $params['parametros'];
        $par ="";
        foreach ($arr as $value) {

            $par = $value;
            $field_name = ["stock"];
            $Camposinsert = ["stock" => $value]; //$this->getInserts($field_name, $value);
            $data = DB::table("bit_reg_vehiculos")->upsert($Camposinsert, ['id_reg_veh']);
            $idRegVeh = BitRegVehiculos::latest('id_reg_veh')->first();

            //$date = Carbon::parse('2022-08-02 10:11:00');
            $date = Carbon::now('America/Mexico_City');

            $this->insertLog($idRegVeh->id_reg_veh, "Por asignar", $date, "1", "", "", "", "");
        }

        return response()->json(["message" => "Creacion correcta", "status" => 201, "idRegVeh" => $idRegVeh->id_reg_veh,], 201);

        //        $this->validate($request->parametros, [
        //            'stock' => 'required'
        //        ]);
        //
        //        $data = BitRegVehiculos::create($request->all());
        //return response()->json($data, 201);
    }

    public function updateRegVeh(Request $request)
    {

        $params = $request->all();
        $arr = $params['parametros'];

        $idRegVeh = $arr['idRegVeh'];
        $valor = $arr['valor'];
        $campo = $arr['campo'];
        $CamposUpdatet = [$campo => $valor]; //$this->getInserts($field_name, $value);

        DB::table('bit_reg_vehiculos')
            ->where('id_reg_veh', $idRegVeh)
            ->update($CamposUpdatet);

        if ($campo == "vin") {
            return response()->json(["message" => "Update correcta", "status" => 201,], 201);
        } else {
            return response()->json(["message" => "Update correcta", "status" => 201,], 201);
        }
    }

    public function addPzaCambio(Request $request)
    {

        $params = $request->all();
        $arr = $params['parametros'];

        $idRegVeh = $arr['idRegVeh'];
        $nomPzaCambio = $arr['nomPzaCambio'];

        $Camposinsert = ['id_reg_veh' => $idRegVeh, 'tipo' => 'cambio', 'pieza' => $nomPzaCambio, 'estatus' => 'alta', 'id_user_registra' => '1'];
        $data = DB::table("bit_piezas")->upsert($Camposinsert, ['id_bit_piezas']);

        $sql = "SELECT  `bit_piezas`.`id_bit_piezas`,
  `bit_piezas`.`pieza`
FROM
  `bit_piezas`
WHERE
  `bit_piezas`.`id_reg_veh` = '$idRegVeh' AND 
  `bit_piezas`.`tipo` = 'cambio'";
        $registros = DB::select($sql);

        return response()->json(["message" => "Update correcta", "status" => 201, "registros" => $registros], 201);
    }

    public function addPzaRepar(Request $request)
    {

        $params = $request->all();
        $arr = $params['parametros'];

        $idRegVeh = $arr['idRegVeh'];
        $nomPzaRepar = $arr['nomPzaRepar'];

        $Camposinsert = ['id_reg_veh' => $idRegVeh, 'tipo' => 'reparacion', 'pieza' => $nomPzaRepar, 'estatus' => 'alta', 'id_user_registra' => '1'];
        $data = DB::table("bit_piezas")->upsert($Camposinsert, ['id_bit_piezas']);

        $sql = "SELECT  `bit_piezas`.`id_bit_piezas`,
  `bit_piezas`.`pieza`
FROM
  `bit_piezas`
WHERE
  `bit_piezas`.`id_reg_veh` = '$idRegVeh' AND 
  `bit_piezas`.`tipo` = 'reparacion'";
        $registros = DB::select($sql);

        return response()->json(["message" => "Update correcta", "status" => 201, "registros" => $registros], 201);
    }


    public function insertLog($idRegVeh, $estatus, $fecEstatus, $idUserReg, $idAsignado, $ResultInspeccion, $EntregadoA, $Comentario)
    {

        $Camposinsert0="";
        $fec_actual = $date = Carbon::now('America/Mexico_City'); //date("Y-m-d H:i:s");

        if ($estatus == "Asignado") {
            $Camposinsert = [
                "id_reg_veh" => $idRegVeh, "estatus" => $estatus, "fec_registro" => $fec_actual, "fec_estatus" => $fecEstatus,
                "id_usuario_registra" => $idUserReg, "comentario_estatus" => $Comentario, "id_asignado" => $idAsignado
            ];
        } else if ($estatus == "Inspeccionado") {
            $Camposinsert = [
                "id_reg_veh" => $idRegVeh, "estatus" => $estatus, "fec_registro" => $fec_actual, "fec_estatus" => $fecEstatus,
                "id_usuario_registra" => $idUserReg, "comentario_estatus" => $Comentario, "result_inspeccion" => $ResultInspeccion
            ];
        } else if ($estatus == "Entregado") {
            $Camposinsert = [
                "id_reg_veh" => $idRegVeh, "estatus" => $estatus, "fec_registro" => $fec_actual, "fec_estatus" => $fecEstatus,
                "id_usuario_registra" => $idUserReg, "comentario_estatus" => $Comentario, "entregado_a" => $EntregadoA
            ];
        } else {
            $Camposinsert = [
                "id_reg_veh" => $idRegVeh, "estatus" => $estatus, "fec_registro" => $fec_actual, "fec_estatus" => $fecEstatus,
                "id_usuario_registra" => $idUserReg, "comentario_estatus" => $Comentario
            ];
        }

        $data = DB::table("bit_log_estatus")->upsert($Camposinsert, ['id_log_estatus']);
        //return $data;
    }
}
