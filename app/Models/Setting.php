<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'key',     // ex: site_name, logo, email...
        'value',   // texte ou chemin fichier
        'type',    // 'text' ou 'file'
        'categorie'

    ];
}
