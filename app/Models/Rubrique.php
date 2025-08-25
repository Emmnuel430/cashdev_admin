<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rubrique extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'plage_support',
        'tti_ttr',
        'preventif',
        'pieces_conso',
        'reporting',
    ];
}

