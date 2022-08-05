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

    public function showStatus(Request $request)
    {
        $params = $request->only(['_s']);
        $estatus = $params['_s'];
        //$data = BitRegVehiculos::where("estatus", $estatus)->get();
        $data = [];
        //cesvi olx taller
        $tipo_columnas = [
            "por_asignar" => ColumnasFront::columnasTablaPorAsignar(),
        ];
        $columnas = $tipo_columnas[$estatus];
        $columns = TablaFront::getColumns($columnas);
        $title_table = "Por asignar";
        $response = [
            "status" => 200,
            "status_info" => $params['_s'],
            "data" => $data,
            "columns" => $columns,
            "message" => "Info Actualizada",
            "props_table" => TablaFront::getPropsTable($title_table),
            "type" => "success"
        ];
        return response()->json($response, 200);
    }

    public function createRegVeh(Request $request)
    {
        $params = $request->all();
        $arr = $params['parametros'];
        foreach ($arr as $value) {
            $Camposinsert = ["stock" => $value]; //$this->getInserts($field_name, $value);
            DB::table("bit_reg_vehiculos")->upsert($Camposinsert, ['id_reg_veh']);
            $idRegVeh = BitRegVehiculos::latest('id_reg_veh')->first();

            //$date = Carbon::parse('2022-08-02 10:11:00');
            $date = Carbon::now('America/Mexico_City');

            $this->insertLog($idRegVeh->id_reg_veh, "Por asignar", $date, "1", "", "", "", "");
        }

        return response()->json(["message" => "Creacion correcta", "status" => 201, "idRegVeh" => $idRegVeh->id_reg_veh,], 201);
        //$data = BitRegVehiculos::create($request->all());
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

            $responseWSVin = $this->WSVinPlus("vin:$valor,tp:2,mr:,md:");
            $chechVin = '0';
            if ($responseWSVin != 'cURL_Error') {
                $VINPlus = json_decode($responseWSVin);
                $chechVin = $VINPlus;
                $CamposUpdatet2 = [];
                if ($VINPlus->RESULTADO == '1') {
                    $CamposUpdatet2 = ["marca" => $VINPlus->MARCA, "modelo" => $VINPlus->MODELO, "anio" => $VINPlus->ANO]; //$this->getInserts($field_name, $value);                   
                } else {
                    $CamposUpdatet2 = ["marca" => "", "modelo" => "", "anio" => ""];
                }
                DB::table('bit_reg_vehiculos')
                    ->where('id_reg_veh', $idRegVeh)
                    ->update($CamposUpdatet2);
            }


            return response()->json(["message" => "Update correcta", "status" => 201, "chechVin" => $chechVin], 201);
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
        DB::table("bit_piezas")->upsert($Camposinsert, ['id_bit_piezas']);

        $registros = DB::table('bit_piezas')
            ->where('id_reg_veh', $idRegVeh)
            ->where('tipo', "cambio")
            ->where('estatus', "alta")
            ->get(["id_bit_piezas", "pieza"]);

        return response()->json(["message" => "Update correcta", "status" => 201, "registros" => $registros], 201);
    }

    public function addPzaRepar(Request $request)
    {
        $params = $request->all();
        $arr = $params['parametros'];

        $idRegVeh = $arr['idRegVeh'];
        $nomPzaRepar = $arr['nomPzaRepar'];

        $Camposinsert = ['id_reg_veh' => $idRegVeh, 'tipo' => 'reparacion', 'pieza' => $nomPzaRepar, 'estatus' => 'alta', 'id_user_registra' => '1'];
        DB::table("bit_piezas")->upsert($Camposinsert, ['id_bit_piezas']);

        $registros = DB::table('bit_piezas')
            ->where('id_reg_veh', $idRegVeh)
            ->where('tipo', "reparacion")
            ->where('estatus', "alta")
            ->get(["id_bit_piezas", "pieza"]);

        return response()->json(["message" => "Update correcta", "status" => 201, "registros" => $registros], 201);
    }

    public function WSVInPlusCat(Request $request)
    {
        $params = $request->all();
        $arr = $params['parametros'];

        $catalogo = $arr['catalogo'];
        $tveh = $arr['tveh'];
        $marca = $arr['marca'];
        $modelo = $arr['modelo'];
        $idRegVeh = $arr['idRegVeh'];

        $data = "";
        if ($catalogo == 'marca') {
            $data = "vin:,tp:$tveh,mr:,md:";
        } elseif ($catalogo == 'modelo') {
            $data = "vin:,tp:$tveh,mr:$marca,md:";

            $CamposUpdatet = ["marca" => $marca]; //$this->getInserts($field_name, $value);
            DB::table('bit_reg_vehiculos')
                ->where('id_reg_veh', $idRegVeh)
                ->update($CamposUpdatet);
        } elseif ($catalogo == 'anio') {
            $data = "vin:,tp:$tveh,mr:$marca,md:$modelo";
            $CamposUpdatet = ["modelo" => $modelo]; //$this->getInserts($field_name, $value);
            DB::table('bit_reg_vehiculos')
                ->where('id_reg_veh', $idRegVeh)
                ->update($CamposUpdatet);
        }


        $responseWSVin = $this->WSVinPlus($data);
        $responseWSVin = json_decode($responseWSVin);
        return response()->json(["message" => "Consulta correcta", "status" => 201, "responseWSVin" => $responseWSVin], 201);
    }

    public function deletPza(Request $request)
    {
        $params = $request->all();
        $arr = $params['parametros'];

        $idBitPiezas = $arr['idBitPiezas'];
        $tipo = $arr['tipo'];
        $idRegVeh = $arr['idRegVeh'];

        $CamposUpdatet = ["estatus" => "baja"]; //$this->getInserts($field_name, $value);
        DB::table('bit_piezas')
            ->where('id_bit_piezas', $idBitPiezas)
            ->update($CamposUpdatet);

        //DB::table('bit_piezas')->where('id_bit_piezas', $idBitPiezas)->delete();


        $registros = DB::table('bit_piezas')
            ->where('id_reg_veh', $idRegVeh)
            ->where('tipo', $tipo)
            ->where('estatus', "alta")
            ->get(["id_bit_piezas", "pieza"]);

        return response()->json(["message" => "Update correcta", "status" => 201, "registros" => $registros], 201);
    }

    public function addFiles(Request $request)
    {
        if ($request->file('file_vehiculo')->isValid()) {
            $params = $request->all();
            $idRegVeh = $params['idRegVeh'];
            $estatus = $params['estatus'];
            $extension = $request->file('file_vehiculo')->getClientOriginalExtension();
            $now = Carbon::now()->format('Ymd_His');
            $fileName = $estatus . "_" . uniqid() . "_" . $now . "." . $extension;
            $destinationPath = getcwd() . "\\images\\vehiculos\\" . $idRegVeh . "\\";
            $request->file('file_vehiculo')->move($destinationPath, $fileName);

            $Camposinsert = ["id_reg_veh" => $idRegVeh, "tipo" => "fotografia", "estatus_registro" => $estatus, "id_user_registra" => "1", "evidencia" => $fileName]; //$this->getInserts($field_name, $value);
            DB::table("bit_evidencia")->upsert($Camposinsert, ['id_bit_evidencia']);
        }

        return response()->json(["message" => "Upload correcto", "status" => 201, "path" => $destinationPath, "filename" => $fileName], 201);
    }

    public function deletefiles(Request $request)
    {

        $params = $request->all();
        $arr = $params['parametros'];

        $fileName = $arr['file'];
        $idRegVeh = $arr['idRegVeh'];

        $res =  DB::table('bit_evidencia')->where('evidencia', $fileName)->where('id_reg_veh', $idRegVeh)->delete();

        return response()->json(["message" => "Upload correcto", "status" => 201, "res" => $res], 201);
    }


    public function insertLog($idRegVeh, $estatus, $fecEstatus, $idUserReg, $idAsignado, $ResultInspeccion, $EntregadoA, $Comentario)
    {
        $fec_actual = Carbon::now('America/Mexico_City'); //date("Y-m-d H:i:s");
        if ($estatus == "asignado") {
            $Camposinsert = [
                "id_reg_veh" => $idRegVeh, "estatus" => $estatus, "fec_registro" => $fec_actual, "fec_estatus" => $fecEstatus,
                "id_usuario_registra" => $idUserReg, "comentario_estatus" => $Comentario, "id_asignado" => $idAsignado
            ];
        } else if ($estatus == "inspeccionado") {
            $Camposinsert = [
                "id_reg_veh" => $idRegVeh, "estatus" => $estatus, "fec_registro" => $fec_actual, "fec_estatus" => $fecEstatus,
                "id_usuario_registra" => $idUserReg, "comentario_estatus" => $Comentario, "result_inspeccion" => $ResultInspeccion
            ];
        } else if ($estatus == "entregado") {
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
        DB::table("bit_log_estatus")->upsert($Camposinsert, ['id_log_estatus']);
        //return $data;
    }

    public function WSVinPlus($cadena)
    {

        $autenticacion = base64_encode("aolx:tgr652");
        //$data = base64_encode("vin:JM1BN1V34J1155231,tp:2,mr:,md:");
        $data = base64_encode($cadena);
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://cesvimexico.com.mx/vinplus/ws_olx/cat/?data=" . $data,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "authorization: Basic " . $autenticacion
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL_Error";
        } else {
            return $response;
        }
    }
    
    public function AsignacionTaller(Request $request){
        $params = $request->all();
        $arr = $params['parametros'];

        $idRegVeh = $arr['idRegVeh'];
        $idTallerAsignado = $arr['idTaller'];
        
        $estatus = "asignado";
        $fecEstatus =  Carbon::now('America/Mexico_City');
        $idUserReg = "1";
        
         $CamposUpdatet = ["estatus" => $estatus, "fec_asignado"=> $fecEstatus, "id_taller_asignado"=>$idTallerAsignado ]; 
         $res = DB::table('bit_reg_vehiculos')
            ->where('id_reg_veh', $idRegVeh)
            ->update($CamposUpdatet);
         
        
        $this->insertLog($idRegVeh, $estatus, $fecEstatus, $idUserReg, $idTallerAsignado, "", "", "");
             
         return response()->json(["message" => "Upload correcto", "status" => 201, "res" => $res], 201);
        
    }
    
     public function IngresoVehTaller(Request $request){
        $params = $request->all();
        $arr = $params['parametros'];

        $idRegVeh = $arr['idRegVeh'];
        $dateTimeSelect = $arr['dateTimeSelect'];
        
        $estatus = "ingresado";
        $fecEstatus =  $dateTimeSelect;//Carbon::now('America/Mexico_City');
        $idUserReg = "1";
        
         $CamposUpdatet = ["estatus" => $estatus, "fec_ingreso"=> $fecEstatus ]; 
         $res = DB::table('bit_reg_vehiculos')
            ->where('id_reg_veh', $idRegVeh)
            ->update($CamposUpdatet);
         
        
        $this->insertLog($idRegVeh, $estatus, $fecEstatus, $idUserReg, "", "", "", "");
             
         return response()->json(["message" => "Upload correcto", "status" => 201, "res" => $res], 201);
        
    }
    
}
