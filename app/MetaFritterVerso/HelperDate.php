<?php

namespace App\MetaFritterVerso;

use Exception;
class HelperDate
{
    /**
     * Suma un número de dias habiles (positivo) a una fecha
     * Se salta los dias festivos del mismo año 
     * (cuidado con el cambio de año)
     * Formato de fecha: yyyy-mm-dd
     *
     * @param string $fecha
     * @param int    $dias
     *
     * @return string
     */
    public static function sumarDiasHabiles($fecha, $dias)
    {
        if ($dias < 0) {
            return null;
        }
        $reales = 0;
        for ($n = 1; $n <= $dias; $n++) {
            do {
                $reales++;
                $fecha = HelperDate::sumarDiasNaturales($fecha, 1);
                $wd    = HelperDate::getDayOfWeek($fecha);
                /* Es mayor que el viernes o es festivo */
            } while ($wd  == 6  || $wd  == 0  || 
                     in_array($fecha, self::getDiasFetivos()));
        }
        return ($fecha);
    }
    /**
     * Devuelve los días festivos
     * @return array
     */
    public static function getDiasFetivos()
    {
        return ['2022-09-16', '2022-11-21'];
    }
    
    /**
     * Devuelve el día de la semana
     *     0: "Domingo"
     *     1:  "Lunes"
     *     2:  "Martes"
     *     3:  "Miércoles"
     *     4:  "Jueves"
     *     5:  "Viernes"
     *     6:  "Sábado"
     *
     * @param string $fecha
     *
     * @return string
     */
    public static function getDayOfWeek($fecha)
    {
        $fecha = strtotime($fecha);
        return date('w', $fecha);
    }
    
     /**
     * Suma N días naturales a una fecha.
     * Formato de fecha: yyyy-mm-dd
     *
     * @param string $fecha
     * @param int    $dias
     *
     * @return string
     */
     public static function sumarDiasNaturales($fecha, $dias)
    {
        if ($dias < 0) {
            return '';
        }
        $dateArray = explode("-", $fecha);
        $sd = $dias;
        while ($sd > 0) {
            if ($sd <= date("t", mktime(0, 0, 0,
                                        $dateArray[ 1 ],
                                        1,
                                        $dateArray[ 0 ])
                            ) - $dateArray[ 2 ]) {
                $dateArray[ 2 ] = $dateArray[ 2 ] + $sd;
                $sd = 0;
            } else {
                $sd  = $sd - ( date( "t", mktime(0, 0, 0,
                                                $dateArray[ 1 ],
                                                1,
                                                $dateArray[ 0 ])
                                   ) - $dateArray[ 2 ]);
                $dateArray[ 2 ] = 0;
                if ($dateArray[ 1 ] < 12) {
                    $dateArray[ 1 ]++;
                } else {
                    $dateArray[ 1 ] = 1;
                    $dateArray[ 0 ]++;
                }
            }
        }
        $sDia = '00'.$dateArray[ 2 ];
        $sDia = substr($sDia, -2);
        $sMes = '00'.$dateArray[ 1 ];
        $sMes = substr($sMes, -2);
        return $dateArray[ 0 ].'-'.$sMes.'-'.$sDia;
    }
}

