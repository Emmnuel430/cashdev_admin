<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomBlock extends Model
{
    protected $fillable = [
        'section_id',      // ID de la section parente
        'block_type',      // Type de composant dynamique (form_contact, map…)
        'config',          // Configuration JSON du bloc
    ];

    protected $casts = [
        'config' => 'array',
    ];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
