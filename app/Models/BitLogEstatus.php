<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BitLogEstatus extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bit_log_estatus';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_log_estatus';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_reg_veh', 'estatus', 'fec_registro', 'fec_estatus', 'id_usuario_registra', 'id_asignado', 'result_inspeccion', 'entregado_a', 'comentario_estatus'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
}
