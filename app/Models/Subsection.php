<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subsection extends Model
{
    protected $fillable = [
        'section_id',      // ID de la section parente
        'title',           // Titre (ex: nom d’un service ou projet)
        'subtitle',        // Sous-titre optionnel
        'content',         // Description ou texte long
        'image',           // Image à afficher
        'icon',           // Icone à afficher
        'button_text',     // Bouton optionnel
        'button_link',     // Lien du bouton
        'order',           // Position dans la section
        'extras',          // Données supplémentaires au format JSON
    ];

    protected $casts = [
        'extras' => 'array',
        'date' => 'date',
        'prix' => 'decimal:2',
    ];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
