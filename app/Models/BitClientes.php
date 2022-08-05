<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BitClientes extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bit_clientes';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_cliente';
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'status'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
}