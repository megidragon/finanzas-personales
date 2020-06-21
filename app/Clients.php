<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Clients extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'full_name', 'birth_at', 'profile_image', 'user_id'
    ];

    /**
     * Obtiene el usuario al que pertenece el cliente
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    /**
     * Obtiene las categorias
     */
    public function categories()
    {
        return $this->hasMany('App\Categories', 'client_id');
    }
}
