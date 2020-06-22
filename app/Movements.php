<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movements extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 
        'description', 
        'amount', 
        'type', 
        'category_id',
        'client_id',
        'currency_id',
        'created_at'
    ];

    protected $hidden = ['client_id'];

    /**
     * Relacion a categoria
     */
    public function category()
    {
        return $this->belongsTo('App\Categories', 'category_id');
    }

    /**
     * Relacion a cliente
     */
    public function client()
    {
        return $this->belongsTo('App\Clients', 'client_id');
    }

    /**
     * Relacion a moneda
     */
    public function currency()
    {
        return $this->belongsTo('App\Currencies', 'currency_id');
    }

    /**
     * Scope para datos del cliente
     */
    public function scopeOwnedByClient($query, $client_id)
    {
        return $query->where('client_id', $client_id);
    }
}
