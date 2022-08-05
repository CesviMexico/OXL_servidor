<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BitEvidencia extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bit_evidencia';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_bit_evidencia';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_reg_veh', 'tipo', 'estatus_registro', 'evidencia', 'id_user_registra'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
}
