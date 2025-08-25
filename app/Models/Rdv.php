<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rdv extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_nom',
        'client_prenom',
        'client_email',
        'client_tel',

        'commentaires',
        'date_prise_rdv',
    ];
}
