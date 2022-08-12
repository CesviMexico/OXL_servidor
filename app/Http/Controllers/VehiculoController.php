<?php

namespace App\Http\Controllers;

use App\Models\BitRegVehiculos;
use Illuminate\Http\Request;
use App\MetaFritterVerso\TablaFront;
use App\MetaFritterVerso\ColumnasFront;
use App\MetaFritterVerso\HelperDate;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VehiculoController extends Controller {

    public function showAll() {
        return response()->json(BitRegVehiculos::all());
    }

    public function showOne($id) {
        return response()->json(
                        BitRegVehiculos::join('cat_tipo_danio', 'bit_reg_vehiculos.id_tipo_danio', '=', 'cat_tipo_danio.id_tipo_danio', 'left outer')
                                ->select('bit_reg_vehiculos.*', 'cat_tipo_danio.dias_habiles')
                                ->find($id)
        );
    }

    public function showStatus(Request $request) {
        //$params = $request->only(['_s']);
        $params = $request->all();
        $estatus = $params['_s'];
        $perfil = $params['perfil'];
        $UsrLoging = $params['UsrLoging'];
        
         $orderBy = [
            "por_asignar" => "fec_registro",
            "asignado" => "fec_asignado",
            "ingresado" => "fec_ingreso",
            "inspeccionado" => "fec_ingreso",
            "terminado" => "fec_terminado",
            "entregado" => "fec_entrega",
            "cancelado" => "fec_registro",
            "historico" => "fec_ingreso",
        ];
         
        $idTaller = DB::table('cat_usuario')->where('usuario', $UsrLoging)->where('estatus', 'alta')->get(['id_taller']);
        $idTaller = $idTaller[0]->id_taller;

        $date_actual = Carbon::now('America/Mexico_City');
        $data = [];

        if ($estatus === "historico") {

            if ($perfil == 'taller') {
                $data = BitRegVehiculos::join('cat_talleres', 'bit_reg_vehiculos.id_taller_asignado', '=', 'cat_talleres.id_taller', 'left outer')
                        ->join('cat_tipo_danio', 'bit_reg_vehiculos.id_tipo_danio', '=', 'cat_tipo_danio.id_tipo_danio', 'left outer')
                        ->select('bit_reg_vehiculos.*', 'cat_talleres.nombre_taller', 'cat_tipo_danio.tipo_danio',
                                DB::raw("TIMESTAMPDIFF(SECOND, bit_reg_vehiculos.fec_registro,'" . $date_actual . "' )AS time_por_asignado"),
                                DB::raw("TIMESTAMPDIFF(SECOND, bit_reg_vehiculos.fec_asignado,'" . $date_actual . "' )AS time_asignado"),
                                DB::raw("TIMESTAMPDIFF(SECOND, bit_reg_vehiculos.fec_ingreso,'" . $date_actual . "' )AS time_ingreso"),
                                DB::raw("TIMESTAMPDIFF(SECOND, bit_reg_vehiculos.fec_terminado,'" . $date_actual . "' )AS time_termino"),
                                DB::raw("if(bit_reg_vehiculos.estatus = 'por_asignar', 'Por asignar', "
                                        . "if(bit_reg_vehiculos.estatus = 'ingresado', 'En taller',  "
                                        . "   CONCAT(UCASE(LEFT(bit_reg_vehiculos.estatus, 1)), 
                             LCASE(SUBSTRING(bit_reg_vehiculos.estatus, 2)))  )) as estatus_historico")
                        )
                        ->where("bit_reg_vehiculos.estatus", "<>", 'cancelado')
                        ->where("bit_reg_vehiculos.id_taller_asignado", $idTaller)
                        ->orderBy($orderBy[$estatus], 'DESC')
                        ->get();
            } else {
                $data = BitRegVehiculos::join('cat_talleres', 'bit_reg_vehiculos.id_taller_asignado', '=', 'cat_talleres.id_taller', 'left outer')
                        ->join('cat_tipo_danio', 'bit_reg_vehiculos.id_tipo_danio', '=', 'cat_tipo_danio.id_tipo_danio', 'left outer')
                        ->select('bit_reg_vehiculos.*', 'cat_talleres.nombre_taller', 'cat_tipo_danio.tipo_danio',
                                DB::raw("TIMESTAMPDIFF(SECOND, bit_reg_vehiculos.fec_registro,'" . $date_actual . "' )AS time_por_asignado"),
                                DB::raw("TIMESTAMPDIFF(SECOND, bit_reg_vehiculos.fec_asignado,'" . $date_actual . "' )AS time_asignado"),
                                DB::raw("TIMESTAMPDIFF(SECOND, bit_reg_vehiculos.fec_ingreso,'" . $date_actual . "' )AS time_ingreso"),
                                DB::raw("TIMESTAMPDIFF(SECOND, bit_reg_vehiculos.fec_terminado,'" . $date_actual . "' )AS time_termino"),
                                DB::raw("if(bit_reg_vehiculos.estatus = 'por_asignar', 'Por asignar', "
                                        . "if(bit_reg_vehiculos.estatus = 'ingresado', 'En taller',  "
                                        . "   CONCAT(UCASE(LEFT(bit_reg_vehiculos.estatus, 1)), 
                             LCASE(SUBSTRING(bit_reg_vehiculos.estatus, 2)))  )) as estatus_historico")
                        )
                        ->where("bit_reg_vehiculos.estatus", "<>", 'cancelado')
                        ->orderBy($orderBy[$estatus], 'DESC')
                        ->get();
            }
        } else {

            if ($perfil == 'taller') {
                $data = BitRegVehiculos::join('cat_talleres', 'bit_reg_vehiculos.id_taller_asignado', '=', 'cat_talleres.id_taller', 'left outer')
                        ->join('cat_tipo_danio', 'bit_reg_vehiculos.id_tipo_danio', '=', 'cat_tipo_danio.id_tipo_danio', 'left outer')
                        ->select('bit_reg_vehiculos.*', 'cat_talleres.nombre_taller', 'cat_tipo_danio.tipo_danio',
                                DB::raw("TIMESTAMPDIFF(SECOND, bit_reg_vehiculos.fec_registro,'" . $date_actual . "' )AS time_por_asignado"),
                                DB::raw("TIMESTAMPDIFF(SECOND, bit_reg_vehiculos.fec_asignado,'" . $date_actual . "' )AS time_asignado"),
                                DB::raw("TIMESTAMPDIFF(SECOND, bit_reg_vehiculos.fec_ingreso,'" . $date_actual . "' )AS time_ingreso"),
                                DB::raw("TIMESTAMPDIFF(SECOND, bit_reg_vehiculos.fec_terminado,'" . $date_actual . "' )AS time_termino")
                        )
                        ->where("bit_reg_vehiculos.estatus", $estatus)
                        ->where("bit_reg_vehiculos.id_taller_asignado", $idTaller)
                        ->orderBy($orderBy[$estatus], 'DESC')
                        ->get();
            } else {
                $data = BitRegVehiculos::join('cat_talleres', 'bit_reg_vehiculos.id_taller_asignado', '=', 'cat_talleres.id_taller', 'left outer')
                        ->join('cat_tipo_danio', 'bit_reg_vehiculos.id_tipo_danio', '=', 'cat_tipo_danio.id_tipo_danio', 'left outer')
                        ->select('bit_reg_vehiculos.*', 'cat_talleres.nombre_taller', 'cat_tipo_danio.tipo_danio',
                                DB::raw("TIMESTAMPDIFF(SECOND, bit_reg_vehiculos.fec_registro,'" . $date_actual . "' )AS time_por_asignado"),
                                DB::raw("TIMESTAMPDIFF(SECOND, bit_reg_vehiculos.fec_asignado,'" . $date_actual . "' )AS time_asignado"),
                                DB::raw("TIMESTAMPDIFF(SECOND, bit_reg_vehiculos.fec_ingreso,'" . $date_actual . "' )AS time_ingreso"),
                                DB::raw("TIMESTAMPDIFF(SECOND, bit_reg_vehiculos.fec_terminado,'" . $date_actual . "' )AS time_termino")
                        )
                        ->where("bit_reg_vehiculos.estatus", $estatus)
                        ->orderBy($orderBy[$estatus], 'DESC')
                        ->get();
            }
        }



        for ($i = 0; $i < sizeof($data); $i++) {
            $countData = DB::table('bit_log_estatus')->where('id_reg_veh', $data[$i]['id_reg_veh'])->where('estatus', 'inspeccionado')->count();
            $data[$i]['count_status'] = $countData;

            //if ($estatus != 'por_asignar') {
                $registros = DB::table('bit_piezas')
                        ->where('id_reg_veh', $data[$i]['id_reg_veh'])
                        //->where('tipo', "cambio")
                        ->where('estatus', "alta")
                        ->get(["pieza", "tipo"]);

                $pza_cam = "";
                $pza_rep = "";
                $tot_pza_cam = 0;
                $tot_pza_rep = 0;
                foreach ($registros as $pieza) {
                    if ($pieza->tipo == 'cambio') {
                        $pza_cam .= $pieza->pieza . " - ";
                        $tot_pza_cam++;
                    } else if ($pieza->tipo == 'reparacion') {
                        $pza_rep .= $pieza->pieza . " - ";
                        $tot_pza_rep++;
                    }
                }

                $data[$i]['tot_pza_cambio'] = $tot_pza_cam;
                $data[$i]['tot_pza_repar'] = $tot_pza_rep;
                $data[$i]['pza_cambio'] = $pza_cam;
                $data[$i]['pza_reparacion'] = $pza_rep;
            //}
        }


        //$data = [];
        //cesvi olx taller
        $tipo_columnas = [
            "por_asignar" => ColumnasFront::columnasTablaPorAsignar($perfil),
            "asignado" => ColumnasFront::columnasTablaAsignados($perfil),
            "ingresado" => ColumnasFront::columnasTablaEnTaller($perfil),
            "inspeccionado" => ColumnasFront::columnasTablaEnTaller($perfil),
            "terminado" => ColumnasFront::columnasTablaTerminados($perfil),
            "entregado" => ColumnasFront::columnasTablaEntregados($perfil),
            "cancelado" => ColumnasFront::columnasTablaCancelados($perfil),
            "historico" => ColumnasFront::columnasTablaHistorico($perfil),
        ];
        $titulo = [
            "por_asignar" => "Por Asignar",
            "asignado" => "Asignados",
            "ingresado" => "En taller",
            "inspeccionado" => "Inspección",
            "terminado" => "Terminados",
            "entregado" => "Entregados",
            "cancelado" => "Cancelados",
            "historico" => "Historico",
        ];
        $columnas = $tipo_columnas[$estatus];
        $columns = TablaFront::getColumns($columnas);
        $title_table = $titulo[$estatus];
        $response = [
            "status" => 200,
            "data" => $data,
            "columns" => $columns,
            "message" => "Información actualizada",
            "props_table" => TablaFront::getPropsTable($title_table),
            "type" => "success",
        ];
        return response()->json($response, 200);
    }

    public function createRegVeh(Request $request) {
        $params = $request->all();
        $arr = $params['parametros'];

        $stock = $arr['stock'];
        $CountStock = DB::table('bit_reg_vehiculos')->where('stock', $stock)->where('estatus', '<>', 'cancelado')->count();

        if ($CountStock == '0') {
            $date = Carbon::now('America/Mexico_City');
            $Camposinsert = ["stock" => $stock, "fec_registro" => $date]; //$this->getInserts($field_name, $value);
            DB::table("bit_reg_vehiculos")->upsert($Camposinsert, ['id_reg_veh']);
            $idRegVeh = BitRegVehiculos::latest('id_reg_veh')->first();
            //$date = Carbon::parse('2022-08-02 10:11:00');
            $this->insertLog($idRegVeh->id_reg_veh, "por_asignar", $date, "1", "", "", "", "");
            return response()->json(["message" => "Creacion correcta", "status" => 201, "idRegVeh" => $idRegVeh->id_reg_veh, "CountStock" => $CountStock], 201);
        } else {
            return response()->json(["message" => "El Stock ya existe", "status" => 201, "idRegVeh" => '0', "CountStock" => $CountStock], 201);
        }



        //$data = BitRegVehiculos::create($request->all());
    }

    public function updateRegVeh(Request $request) {
        $params = $request->all();
        $arr = $params['parametros'];

        $idRegVeh = $arr['idRegVeh'];
        $valor = $arr['valor'];
        $campo = $arr['campo'];

        $motivo = "";
        $CamposUpdatet = []; //$this->getInserts($field_name, $value);

        if ($campo == "estatus" && $valor == 'cancelado') {
            $motivo = $arr['motivo'];
            $CamposUpdatet = [$campo => $valor, 'motivo_cancelacion' => $motivo]; //$this->getInserts($field_name, $value);
        } else {
            $CamposUpdatet = [$campo => $valor]; //$this->getInserts($field_name, $value);
        }


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
//        } else if ($campo == "id_tipo_danio") {
//
//            return response()->json(["message" => "Update correcta", "status" => 201, "fecPromesa" => $fecPromesa], 201);
        } else if ($campo == "estatus") {

            $fecEstatus = Carbon::now('America/Mexico_City');
            $idUserReg = "1";
            $this->insertLog($idRegVeh, $valor, $fecEstatus, $idUserReg, "", "", "", $motivo);
            
            return response()->json(["message" => "Update correcta", "status" => 201,], 201);
        } else {
            return response()->json(["message" => "Update correcta", "status" => 201,], 201);
        }
    }

    public function addPzaCambio(Request $request) {
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

    public function addPzaRepar(Request $request) {
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

    public function WSVInPlusCat(Request $request) {
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

    public function deletPza(Request $request) {
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

    public function addFiles(Request $request) {
        if ($request->file('file_vehiculo')->isValid()) {
            $params = $request->all();
            $idRegVeh = $params['idRegVeh'];
            $estatus = $params['estatus'];
            $extension = $request->file('file_vehiculo')->getClientOriginalExtension();
            $now = Carbon::now()->format('Ymd_His');
            $fileName = $estatus . "_" . uniqid() . "_" . $now . "." . $extension;
            $destinationPath = getcwd() . "/images/vehiculos/" . $idRegVeh . "/";
            $request->file('file_vehiculo')->move($destinationPath, $fileName);

            $Camposinsert = ["id_reg_veh" => $idRegVeh, "tipo" => "fotografia", "estatus_registro" => $estatus, "id_user_registra" => "1", "evidencia" => $fileName]; //$this->getInserts($field_name, $value);
            DB::table("bit_evidencia")->upsert($Camposinsert, ['id_bit_evidencia']);
        }

        return response()->json(["message" => "Upload correcto", "status" => 201, "path" => $destinationPath, "filename" => $fileName, 
            "isValido"=> $request->file('file_vehiculo')], 201);
    }

    public function deletefiles(Request $request) {

        $params = $request->all();
        $arr = $params['parametros'];

        $fileName = $arr['file'];
        $idRegVeh = $arr['idRegVeh'];

        $res = DB::table('bit_evidencia')->where('evidencia', $fileName)->where('id_reg_veh', $idRegVeh)->delete();

        return response()->json(["message" => "Upload correcto", "status" => 201, "res" => $res], 201);
    }

    public function insertLog($idRegVeh, $estatus, $fecEstatus, $idUserReg, $idAsignado, $ResultInspeccion, $EntregadoA, $Comentario) {
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

    public function WSVinPlus($cadena) {

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

    public function AsignacionTaller(Request $request) {
        $params = $request->all();
        $arr = $params['parametros'];

        $idRegVeh = $arr['idRegVeh'];
        $idTallerAsignado = $arr['idTaller'];

        $estatus = "asignado";
        $fecEstatus = Carbon::now('America/Mexico_City');
        $idUserReg = "1";

        $CamposUpdatet = ["estatus" => $estatus, "fec_asignado" => $fecEstatus, "id_taller_asignado" => $idTallerAsignado];
        $res = DB::table('bit_reg_vehiculos')
                ->where('id_reg_veh', $idRegVeh)
                ->update($CamposUpdatet);

        $this->insertLog($idRegVeh, $estatus, $fecEstatus, $idUserReg, $idTallerAsignado, "", "", "");

        return response()->json(["message" => "Upload correcto", "status" => 201, "res" => $res], 201);
    }

    public function IngresoVehTaller(Request $request) {
        $params = $request->all();
        $arr = $params['parametros'];

        $idRegVeh = $arr['idRegVeh'];
        $dateTimeSelect = $arr['dateTimeSelect'];

        $estatus = "ingresado";
        $fecEstatus = $dateTimeSelect; //Carbon::now('America/Mexico_City');
        $idUserReg = "1";
        
        
        
        ///////////
        
        $valor = DB::table('bit_reg_vehiculos')
                ->where('id_reg_veh', $idRegVeh)              
                ->get(["id_tipo_danio"]);
        
            $valor = $valor[0]->id_tipo_danio;
            $DiasH = DB::table('cat_tipo_danio')->where('id_tipo_danio', $valor)->where('estatus', 'alta')->get(['dias_habiles']);
            $DiasH = $DiasH[0]->dias_habiles;
//            $fecactual = Carbon::now('America/Mexico_City')->format('Y-m-d');
//            $DThoy =Carbon::now('America/Mexico_City')->format('H-i-s');
            
            $arrayFech = explode(" ", $dateTimeSelect);
            $fecactual = $arrayFech[0];
            $DThoy = $arrayFech[1];
            $fecPromesa = HelperDate::sumarDiasHabiles($fecactual, $DiasH);
            $fecPromesa = $fecPromesa ." ".$DThoy;
                   
        //////////
        

        $CamposUpdatet = ["estatus" => $estatus, "fec_ingreso" => $fecEstatus, "fec_promesa" => $fecPromesa];
        $res = DB::table('bit_reg_vehiculos')
                ->where('id_reg_veh', $idRegVeh)
                ->update($CamposUpdatet);

        $this->insertLog($idRegVeh, $estatus, $fecEstatus, $idUserReg, "", "", "", "");

        return response()->json(["message" => "Upload correcto", "status" => 201, "res" => $res, "DiasH" =>$DiasH, "id_tipo"=>$valor, "fecPromesa" => $fecPromesa, "fecactual" => $fecactual], 201);
    }

    public function InspeccionCalidad(Request $request) {
        $params = $request->all();
        $arr = $params['parametros'];

        $idRegVeh = $arr['idRegVeh'];
        $dateTimeSelect = $arr['dateTimeSelect'];
        $resultadoSelec = $arr['resultadoSelec'];
        $fecEstatus = $dateTimeSelect; //Carbon::now('America/Mexico_City');
        $estatus = "";
        $idUserReg = "1";

        if ($resultadoSelec == "no_aprobado") {
            $estatus = "ingresado";
            $this->insertLog($idRegVeh, "inspeccionado", $fecEstatus, $idUserReg, "", $resultadoSelec, "", "");
        } else {
            $estatus = "terminado";
            $this->insertLog($idRegVeh, "inspeccionado", $fecEstatus, $idUserReg, "", $resultadoSelec, "", "");
            $CamposUpdatet = ["estatus" => $estatus, "fec_terminado" => $fecEstatus];
            $res = DB::table('bit_reg_vehiculos')
                    ->where('id_reg_veh', $idRegVeh)
                    ->update($CamposUpdatet);
            $this->insertLog($idRegVeh, $estatus, $fecEstatus, $idUserReg, "", "", "", "");
        }


        return response()->json(["message" => "Upload correcto", "status" => 201, "res" => "ok"], 201);
    }

    public function Entregado(Request $request) {
        $params = $request->all();
        $arr = $params['parametros'];

        $idRegVeh = $arr['idRegVeh'];
        $dateTimeSelect = $arr['dateTimeSelect'];
        $entregadoA = $arr['entregadoA'];

        $fecEstatus = $dateTimeSelect; //Carbon::now('America/Mexico_City');
        $estatus = "entregado";
        $idUserReg = "1";

        $CamposUpdatet = ["estatus" => $estatus, "fec_entrega" => $fecEstatus, "entregado_a" => $entregadoA];
        $res = DB::table('bit_reg_vehiculos')
                ->where('id_reg_veh', $idRegVeh)
                ->update($CamposUpdatet);
        $this->insertLog($idRegVeh, $estatus, $fecEstatus, $idUserReg, "", "", $entregadoA, "");

        return response()->json(["message" => "Upload correcto", "status" => 201, "res" => "ok"], 201);
    }

    public function PruebaFechas() {

        $hoy = Carbon::now('America/Mexico_City')->format('Y-m-d');
        $DThoy =Carbon::now('America/Mexico_City')->format('H-i-s');
        echo $fecactual = $hoy;
        echo " - -  - - - - ";
        $Dias = DB::table('cat_tipo_danio')->where('id_tipo_danio', '1')->where('estatus', 'alta')->get(['dias_habiles']);
        echo $DiasHab = $Dias[0]->dias_habiles;
        echo " - - ";
        $fecPromesa = HelperDate::sumarDiasHabiles($fecactual, $DiasHab);
        echo $fecPromesa;
        echo " ----- ";
        echo $feP = date("d-m-Y", strtotime($fecPromesa)) ." ".$DThoy;
        
      //  echo HelperDate::getDayOfWeek('2022-08-13');
    }

    public function catalogosFormularios(Request $request) {

        $catTipoDanio = DB::table('cat_tipo_danio')
                ->where('estatus', "alta")
                ->get();

        return response()->json(["message" => "Update correcta", "status" => 201, "catTipoDanio" => $catTipoDanio], 201);
    }

    public function getListasPiezas(Request $request) {
        $params = $request->all();
        $arr = $params['parametros'];
        $idRegVeh = $arr['idRegVeh'];

        $regpzascambio = DB::table('bit_piezas')
                ->where('id_reg_veh', $idRegVeh)
                ->where('tipo', "cambio")
                ->where('estatus', "alta")
                ->get(["id_bit_piezas", "pieza"]);
        
         $regpzasrepar = DB::table('bit_piezas')
                ->where('id_reg_veh', $idRegVeh)
                ->where('tipo', "reparacion")
                ->where('estatus', "alta")
                ->get(["id_bit_piezas", "pieza"]);
         
         $files = DB::table('bit_evidencia')
                 ->select(
                        DB::raw(" bit_evidencia.id_bit_evidencia AS uid"), 
                        DB::raw(" bit_evidencia.evidencia AS name"),
                        DB::raw(" 'done' AS status"),
                        DB::raw(" 'ok' AS response"),
                        DB::raw(" bit_evidencia.evidencia AS url")
                        )
                ->where('id_reg_veh', $idRegVeh)
                ->where('estatus_registro', "por_asignar")
                ->get();
         
         

        return response()->json(["message" => "Update correcta", "status" => 201, "pzascambio" => $regpzascambio,  "pzasrepar" => $regpzasrepar, 'files' => $files], 201);
    }

}
