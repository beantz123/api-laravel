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
        'stock'
    ];

    public $timestamps = false; // Desativa os timestamps
    
}
