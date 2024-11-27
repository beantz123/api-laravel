<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produtos extends Model
{
    use HasFactory;

    /* falando pra models produtos os campos que ela pode prencher */
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'data_de_fabricação',
        'data_de_vencimento'
    ];

    //ignorar colunas nas retornos
    protected $hidden = ['created_at', 'updated_at'];

    public $timestamps = false; // Desativa os timestamps
    
}
