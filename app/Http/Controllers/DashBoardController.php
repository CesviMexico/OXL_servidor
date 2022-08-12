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
        
      $regEstatus = DB::select("SELECT 
sum(if( `bit_reg_vehiculos`.`estatus` = 'por_asignar',1,0)) as por_asignar,
sum(if( `bit_reg_vehiculos`.`estatus` = 'asignado',1,0)) as asignado,
sum(if( `bit_reg_vehiculos`.`estatus` = 'ingresado',1,0)) as ingresado,
sum(if( `bit_reg_vehiculos`.`estatus` = 'terminado',1,0)) as terminado,
sum(if( `bit_reg_vehiculos`.`estatus` = 'entregado',1,0)) as entregado
FROM
  `bit_reg_vehiculos`");
      
      $promTimeEstatus = DB::select("select 
ROUND(AVG(tmp.time_asignacion),0) as time_asignacion,
ROUND(AVG(tmp.time_ingreso),0) as time_ingreso,
ROUND(AVG(tmp.time_reparacion),0) as time_reparacion,
ROUND(AVG(tmp.time_entrega),0) as time_entrega,
ROUND(AVG(tmp.time_estadia),0) as time_estadia
from
(
SELECT 
  `bit_reg_vehiculos`.`id_reg_veh`,
  `bit_reg_vehiculos`.`stock`,
  TIMESTAMPDIFF(MINUTE, bit_reg_vehiculos.fec_registro, `bit_reg_vehiculos`.`fec_asignado` )AS time_asignacion,
  TIMESTAMPDIFF(MINUTE, bit_reg_vehiculos.fec_asignado, `bit_reg_vehiculos`.`fec_ingreso` )AS time_ingreso,
  TIMESTAMPDIFF(MINUTE, bit_reg_vehiculos.fec_ingreso, `bit_reg_vehiculos`.`fec_terminado` )AS time_reparacion,
  TIMESTAMPDIFF(MINUTE, bit_reg_vehiculos.fec_terminado, `bit_reg_vehiculos`.`fec_entrega` )AS time_entrega,
  TIMESTAMPDIFF(MINUTE, bit_reg_vehiculos.fec_ingreso, `bit_reg_vehiculos`.`fec_entrega` )AS time_estadia
FROM
  `bit_reg_vehiculos`
WHERE
  `bit_reg_vehiculos`.`estatus` = 'entregado') as tmp");

      $porcTipoDanio = DB::select("SELECT 
`cat_tipo_danio`.`id_tipo_danio` ,
 `cat_tipo_danio`.`tipo_danio`,
 count(`bit_reg_vehiculos`.`id_reg_veh`) AS `t_Reg` 
FROM
  `cat_tipo_danio`
  LEFT OUTER JOIN `bit_reg_vehiculos` ON (`cat_tipo_danio`.`id_tipo_danio` = `bit_reg_vehiculos`.`id_tipo_danio`) and
   (`bit_reg_vehiculos`.`estatus` = 'entregado' )
WHERE
   `cat_tipo_danio`.`estatus` = 'alta'
GROUP BY
  `cat_tipo_danio`.`id_tipo_danio`");

       
      
        return response()->json(["message" => "Update correcta", "status" => 201, "regEstatus" => $regEstatus, 'promTimeEstatus'=>$promTimeEstatus, "porcTipoDanio" => $porcTipoDanio], 201);
    }

}
