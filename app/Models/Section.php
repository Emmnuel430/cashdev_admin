<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = [
        'page_id',         // ID de la page parente
        'type',            // Type de bloc (hero, grid, carousel, etc.)
        'variant',         // Variante d’affichage (ex: minimal, split…)
        'title',           // Titre de la section
        'subtitle',        // Sous-titre
        'content',         // Texte principal (facultatif)
        'button_text',     // Libellé du bouton
        'button_link',     // Lien du bouton
        'image',           // Image principale
        'image_side',      // Image spécifique pour side
        'order',           // Ordre d’affichage dans la page
        'is_active',       // Affichée ou non
        'settings',        // Données JSON : couleurs, alignement, etc.
    ];

    protected $casts = [
        'settings' => 'array',
        'is_active' => 'boolean',
    ];

    // Relations
    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function subsections()
    {
        return $this->hasMany(Subsection::class)->orderBy('order');
    }

    public function customBlocks()
    {
        return $this->hasMany(CustomBlock::class);
    }
}
