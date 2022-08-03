<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BitRegVehiculos extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bit_reg_vehiculos';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_reg_veh';
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'stock', 'vin', 'marca','modelo','anio','color','tipo_danio', 
        'estatus', 'id_user_registra','id_taller_asignado','fec_asignado',
        'fec_ingreso','fec_inspeccion', 'result_inspeccion', 'fec_entrega', 'entregado_a'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
}
