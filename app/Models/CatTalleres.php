<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatTalleres extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cat_talleres';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_taller';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre_taller', 'direccion', 'link_maps', 'coordenadas', 'contacto', 'estatus'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
}
