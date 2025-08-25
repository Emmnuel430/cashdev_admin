<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* 
        Pour ajouter un seul (POSTMAN)
        {
  "key": "Popup accueil",
  "type": "file",
  "categorie": "general"
}

        */
        $settings = [
            ['key' => 'nom_du_site', 'value' => '', 'type' => 'text', 'categorie' => 'general'],
            ['key' => 'mot_de_fin', 'value' => '', 'type' => 'text', 'categorie' => 'general'],
            ['key' => 'popup_accueil', 'value' => '', 'type' => 'file', 'categorie' => 'general'],

            ['key' => 'logo', 'value' => '', 'type' => 'file', 'categorie' => 'logo'],
            ['key' => 'logo2', 'value' => '', 'type' => 'file', 'categorie' => 'logo'],

            ['key' => 'email', 'value' => '', 'type' => 'text', 'categorie' => 'contact'],
            ['key' => 'emplacement', 'value' => '', 'type' => 'text', 'categorie' => 'contact'],
            ['key' => 'localisation', 'value' => '', 'type' => 'text', 'categorie' => 'contact'],
            ['key' => 'telephone', 'value' => '', 'type' => 'text', 'categorie' => 'contact'],
            ['key' => 'telephone_2', 'value' => '', 'type' => 'text', 'categorie' => 'contact'],

            ['key' => 'facebook', 'value' => '', 'type' => 'text', 'categorie' => 'reseaux'],
            ['key' => 'twitter', 'value' => '', 'type' => 'text', 'categorie' => 'reseaux'],
            ['key' => 'instagram', 'value' => '', 'type' => 'text', 'categorie' => 'reseaux'],
            ['key' => 'youtube', 'value' => '', 'type' => 'text', 'categorie' => 'reseaux'],
            ['key' => 'tiktok', 'value' => '', 'type' => 'text', 'categorie' => 'reseaux'],
            ['key' => 'linkedin', 'value' => '', 'type' => 'text', 'categorie' => 'reseaux'],
            ['key' => 'whatsapp', 'value' => '', 'type' => 'text', 'categorie' => 'reseaux'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }

}
