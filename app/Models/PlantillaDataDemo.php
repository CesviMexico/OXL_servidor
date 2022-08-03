<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlantillaDataDemo extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'plantilla_data_demo';
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'gender', 'ip_address', 'double', 'fecha', 'fechaTime'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
}
