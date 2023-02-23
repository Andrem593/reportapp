<?php

namespace App\Models;

use App\Traits\VuePaginate;
use Illuminate\Database\Eloquent\Model;

class tienda extends Model
{
    use VuePaginate;
    protected $table = 'tiendas';
    protected $fillable = ['tienda', 'provincia', 'ciudad', 'estado'];
    public $timestamps = false;
}
