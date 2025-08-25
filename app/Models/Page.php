<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',           // Titre de la page (ex: Accueil)
        'subtitle',        // Sous-titre visible ou en background
        'slug',            // URL unique (ex: accueil)
        'template',        // Gabarit de la page (default, pleine_largeur…)
        'order',           // Ordre d’apparition dans le menu
        'is_active',       // Affichée ou non sur le site
        'seo',             // Données SEO : meta_title, meta_description…
    ];

    protected $casts = [
        'seo' => 'array',
        'is_active' => 'boolean',
    ];

    // Relations
    public function sections()
    {
        return $this->hasMany(Section::class)->orderBy('order');
    }
}
