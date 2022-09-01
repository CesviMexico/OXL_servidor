<?php

namespace App\Http\Controllers;

use App\Models\BitRegVehiculos;
use Illuminate\Http\Request;
use App\MetaFritterVerso\TablaFront;
use App\MetaFritterVerso\ColumnasFront;
use App\MetaFritterVerso\HelperDate;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashBoardController extends Controller {

    public function getInfoGeneralReport(Request $request) {
        $params = $request->all();
        $arr = $params['parametros'];
        $idTaller = $arr['talleresSelect'];
        
        $fecIni = "";
        $fecFin = "";
        if($arr['dateTimeSelect'][0] != "" && $arr['dateTimeSelect'][1] != ""){
            $fecIni = $arr['dateTimeSelect'][0]." 00:00:00";
            $fecFin = $arr['dateTimeSelect'][1]." 23:59:59";
        }
        

        $condicion = "";
        if ($idTaller != '') {
            $condicion = " and `bit_reg_vehiculos`.`id_taller_asignado` = '$idTaller'  ";
        }
        $regEstatus = [];

        if ($fecIni != "" and $fecFin != "") {
                    $regEstatus = DB::select("select 
COALESCE(sum(if( `temp`.`estatus` = 'por_asignar',1,0)),0)  as por_asignar,
COALESCE(sum(if( `temp`.`estatus` = 'asignado',1,0)),0) as asignado,
COALESCE(sum(if( `temp`.`estatus` = 'ingresado',1,0)),0) as ingresado,
COALESCE(sum(if( `temp`.`estatus` = 'terminado',1,0)),0) as terminado,
COALESCE(sum(if( `temp`.`estatus` = 'entregado',1,0)),0) as entregado,
COALESCE(sum(if( `temp`.`estatus` = 'entregado'  and temp.`fec_terminado` < temp.`fec_promesa` ,1,0)),0) as t_cumpli_fecprom
from 
(
SELECT  
  `bit_log_estatus`.`id_reg_veh`,
  `bit_log_estatus`.`estatus`,
  `bit_log_estatus`.`fec_estatus`,
  bit_reg_vehiculos.`fec_terminado` ,
  bit_reg_vehiculos.`fec_promesa`
FROM
  `bit_log_estatus`
   INNER JOIN `bit_reg_vehiculos` ON (`bit_log_estatus`.`id_reg_veh` = `bit_reg_vehiculos`.`id_reg_veh`)
   WHERE  `bit_reg_vehiculos`.`estatus` <>  'baja' and 
   `bit_log_estatus`.`estatus` <> 'inspeccionado' and
  `bit_log_estatus`.`fec_estatus` BETWEEN '$fecIni' and '$fecFin' and 
  `bit_log_estatus`.`fec_estatus` = (select max(tblog.fec_estatus) from bit_log_estatus as tblog where tblog.id_reg_veh =  `bit_log_estatus`.`id_reg_veh` ) $condicion
  group by 
  `bit_log_estatus`.`id_reg_veh`
  order by 
   `bit_log_estatus`.`id_reg_veh` ) as temp  ");
                    
        } else {
            $regEstatus = DB::select("SELECT 
COALESCE(sum(if( `bit_reg_vehiculos`.`estatus` = 'por_asignar',1,0)),0)  as por_asignar,
COALESCE(sum(if( `bit_reg_vehiculos`.`estatus` = 'asignado',1,0)),0) as asignado,
COALESCE(sum(if( `bit_reg_vehiculos`.`estatus` = 'ingresado',1,0)),0) as ingresado,
COALESCE(sum(if( `bit_reg_vehiculos`.`estatus` = 'terminado',1,0)),0) as terminado,
COALESCE(sum(if( `bit_reg_vehiculos`.`estatus` = 'entregado',1,0)),0) as entregado,
COALESCE(sum(if( `bit_reg_vehiculos`.`estatus` = 'entregado'  and bit_reg_vehiculos.`fec_terminado` < bit_reg_vehiculos.`fec_promesa` ,1,0)),0) as t_cumpli_fecprom
FROM
  `bit_reg_vehiculos` WHERE  `bit_reg_vehiculos`.`estatus` <>  'baja'  $condicion ");
        }





        $promTimeEstatus = DB::select("select 
COALESCE(ROUND(AVG(tmp.time_asignacion),0),0) as time_asignacion,
COALESCE(ROUND(AVG(tmp.time_ingreso),0),0) as time_ingreso,
COALESCE(ROUND(AVG(tmp.time_reparacion),0),0) as time_reparacion,
COALESCE(ROUND(AVG(tmp.time_entrega),0),0) as time_entrega,
COALESCE(ROUND(AVG(tmp.time_estadia),0),0) as time_estadia
from
(
SELECT 
 COALESCE(`bit_reg_vehiculos`.`id_reg_veh`,0) as id_reg_veh,
  COALESCE(`bit_reg_vehiculos`.`stock`,0) as stock,
  COALESCE(TIMESTAMPDIFF(MINUTE, bit_reg_vehiculos.fec_registro, `bit_reg_vehiculos`.`fec_asignado` ),0) AS time_asignacion,
  COALESCE(TIMESTAMPDIFF(MINUTE, bit_reg_vehiculos.fec_asignado, `bit_reg_vehiculos`.`fec_ingreso` ),0) AS time_ingreso,
  COALESCE(TIMESTAMPDIFF(MINUTE, bit_reg_vehiculos.fec_ingreso, `bit_reg_vehiculos`.`fec_terminado` ),0) AS time_reparacion,
  COALESCE(TIMESTAMPDIFF(MINUTE, bit_reg_vehiculos.fec_terminado, `bit_reg_vehiculos`.`fec_entrega` ),0) AS time_entrega,
  COALESCE(TIMESTAMPDIFF(MINUTE, bit_reg_vehiculos.fec_ingreso, `bit_reg_vehiculos`.`fec_entrega` ),0) AS time_estadia
FROM
  `bit_reg_vehiculos`
WHERE
  `bit_reg_vehiculos`.`estatus` = 'entregado'  $condicion  ) as tmp");

        $porcTipoDanio = DB::select("SELECT 
`cat_tipo_danio`.`id_tipo_danio` ,
 `cat_tipo_danio`.`tipo_danio`,
 count(`bit_reg_vehiculos`.`id_reg_veh`) AS `t_Reg` 
FROM
  `cat_tipo_danio`
  LEFT OUTER JOIN `bit_reg_vehiculos` ON (`cat_tipo_danio`.`id_tipo_danio` = `bit_reg_vehiculos`.`id_tipo_danio`) and
   (`bit_reg_vehiculos`.`estatus` <> 'cancelado' )
WHERE
 `bit_reg_vehiculos`.`estatus` <>  'baja' and 
   `cat_tipo_danio`.`estatus` = 'alta' $condicion
GROUP BY
  `cat_tipo_danio`.`id_tipo_danio`");

        return response()->json(["message" => "Update correcta", "status" => 201, "regEstatus" => $regEstatus, 'promTimeEstatus' => $promTimeEstatus, "porcTipoDanio" => $porcTipoDanio, "fecIni"=>$fecIni, "fecFin"=>$fecFin], 201);
    }

}
