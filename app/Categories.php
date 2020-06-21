<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categories extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'client_id'
    ];

    /**
     * Obtiene el usuario al que pertenece el cliente
     */
    public function clients()
    {
        return $this->belongsTo('App\Clients');
    }
}
