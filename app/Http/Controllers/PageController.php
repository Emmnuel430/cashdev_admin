<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Subsection;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use HTMLPurifier;
use HTMLPurifier_Config;

class PageController extends Controller
{
    // Création complète : page + sections + sous-sections
    public function store(Request $request)
    {

        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);
        DB::beginTransaction();

        try {

            $order = Page::max('order') + 1;
            // Création de la page sans image principale
            $page = Page::create([
                'title' => $request->title,
                'subtitle' => $request->subtitle,
                'template' => $request->template,
                'slug' => Str::slug($request->title),
                'order' => $order,
                'is_active' => $request->boolean('is_active'),
                'seo' => $request->seo ?? null,
            ]);

            $pageId = $page->id;

            // // Image principale
            // if ($request->hasFile('main_image')) {
            //     $mainImagePath = $request->file('main_image')->store("pages/page_$pageId/main", 'public');
            //     $page->update(['main_image' => $mainImagePath]);
            // }

            // Sections
            foreach ($request->input('sections', []) as $i => $sectionData) {
                // Images section
                $sectionImagePath = null;
                $sectionImageMobilePath = null;

                if ($request->hasFile("sections.$i.image")) {
                    $sectionImagePath = $request->file("sections.$i.image")->store("pages/page_$pageId/sections", 'public');
                }
                if ($request->hasFile("sections.$i.image_side")) {
                    $sectionImageMobilePath = $request->file("sections.$i.image_side")->store("pages/page_$pageId/sections/mobile", 'public');
                }

                $cleanSectionHtml = $purifier->purify($sectionData['content'] ?? null);

                $section = $page->sections()->create([
                    'title' => $sectionData['title'] ?? null,
                    'subtitle' => $sectionData['subtitle'] ?? null,
                    'type' => $sectionData['type'] ?? 'hero',
                    'variant' => $sectionData['variant'] ?? null,
                    'content' => $cleanSectionHtml,
                    'button_text' => $sectionData['button_text'] ?? null,
                    'button_link' => $sectionData['button_link'] ?? null,
                    'image' => $sectionImagePath,
                    'image_side' => $sectionImageMobilePath,
                    'order' => $sectionData['order'] ?? 0,
                    'is_active' => (bool) ($sectionData['is_active'] ?? true),
                    'settings' => $sectionData['settings'] ?? null,
                ]);

                // Sous-sections (si présentes)
                foreach ($sectionData['subsections'] ?? [] as $j => $subData) {
                    $subImagePath = null;
                    if ($request->hasFile("sections.$i.subsections.$j.image")) {
                        $subImagePath = $request->file("sections.$i.subsections.$j.image")->store("pages/page_$pageId/subsections", 'public');
                    }

                    $cleanHtml = $purifier->purify($subData['content'] ?? '');
                    $section->subsections()->create([
                        'title' => $subData['title'] ?? null,
                        'subtitle' => $subData['subtitle'] ?? null,
                        'content' => $cleanHtml,
                        'icon' => $subData['icon'] ?? '',
                        'image' => $subImagePath,
                        'button_text' => $subData['button_text'] ?? null,
                        'button_link' => $subData['button_link'] ?? null,
                        'order' => $subData['order'] ?? 0,
                        'extras' => $subData['extras'] ?? null,
                    ]);
                }

                // Custom blocks (si présents)
                foreach ($sectionData['custom_blocks'] ?? [] as $block) {
                    $section->customBlocks()->create([
                        'block_type' => $block['block_type'],
                        'config' => $block['config'] ?? [],
                    ]);
                }
            }

            $page->touch();
            DB::commit();

            return response()->json(['message' => 'Page créée avec succès'], 201);

        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    // Mise à jour d’une page complète (sections & sous-sections comprises)
    public function update(Request $request, $id)
    {
        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);
        DB::beginTransaction();

        try {
            \Log::info('Sections reçues :', ['sections' => $request->input('sections')]);

            $page = Page::with('sections.subsections')->findOrFail($id);
            $pageId = $page->id;

            // Mise à jour des données principales de la page
            $data = $request->only(['title', 'subtitle', 'template', 'order', 'seo']);
            $data['slug'] = Str::slug($request->title);

            // Si is_active est présent, on le met à jour. Sinon, on ne touche pas.
            if ($request->has('is_active')) {
                $data['is_active'] = $request->boolean('is_active');
            }

            $page->update($data);

            $sectionIdsToKeep = [];
            $subsectionIdsToKeep = [];

            foreach ($request->input('sections', []) as $i => $sectionData) {
                $section = isset($sectionData['id'])
                    ? $page->sections()->where('id', $sectionData['id'])->first()
                    : null;

                // Gestion image section + mobile
                $sectionImagePath = $section->image ?? null;
                $sectionImageMobilePath = $section->image_side ?? null;

                if ($request->input("sections.$i.delete_image") === "1" && $sectionImagePath) {
                    Storage::disk('public')->delete($sectionImagePath);
                    $sectionImagePath = null;
                }

                if ($request->input("sections.$i.delete_image_side") === "1" && $sectionImageMobilePath) {
                    Storage::disk('public')->delete($sectionImageMobilePath);
                    $sectionImageMobilePath = null;
                }

                if ($request->hasFile("sections.$i.image")) {
                    if ($sectionImagePath)
                        Storage::disk('public')->delete($sectionImagePath);
                    $sectionImagePath = $request->file("sections.$i.image")->store("pages/page_$pageId/sections", 'public');
                }

                if ($request->hasFile("sections.$i.image_side")) {
                    if ($sectionImageMobilePath)
                        Storage::disk('public')->delete($sectionImageMobilePath);
                    $sectionImageMobilePath = $request->file("sections.$i.image_side")->store("pages/page_$pageId/sections/mobile", 'public');
                }

                $cleanSectionHtml = $purifier->purify($sectionData['content'] ?? null);

                $sectionAttributes = [
                    'title' => $sectionData['title'] ?? null,
                    'subtitle' => $sectionData['subtitle'] ?? null,
                    'type' => $sectionData['type'] ?? 'hero',
                    'variant' => $sectionData['variant'] ?? null,
                    'content' => $cleanSectionHtml,
                    'button_text' => $sectionData['button_text'] ?? null,
                    'button_link' => $sectionData['button_link'] ?? null,
                    'image' => $sectionImagePath,
                    'image_side' => $sectionImageMobilePath,
                    'order' => $sectionData['order'] ?? 0,
                    'is_active' => (bool) ($sectionData['is_active'] ?? true),
                    'settings' => $sectionData['settings'] ?? null,
                ];

                if ($section) {
                    $section->update($sectionAttributes);
                } else {
                    $section = $page->sections()->create($sectionAttributes);
                }

                $sectionIdsToKeep[] = $section->id;

                // -- Sous-sections
                foreach ($sectionData['subsections'] ?? [] as $j => $subData) {
                    $sub = isset($subData['id'])
                        ? $section->subsections()->where('id', $subData['id'])->first()
                        : null;

                    $subImagePath = $sub->image ?? null;

                    if ($request->input("sections.$i.subsections.$j.delete_image") === "1" && $subImagePath) {
                        Storage::disk('public')->delete($subImagePath);
                        $subImagePath = null;
                    }

                    if ($request->hasFile("sections.$i.subsections.$j.image")) {
                        if ($subImagePath)
                            Storage::disk('public')->delete($subImagePath);
                        $subImagePath = $request->file("sections.$i.subsections.$j.image")->store("pages/page_$pageId/subsections", 'public');
                    }

                    $cleanHtml = $purifier->purify($subData['content'] ?? '');
                    $subAttributes = [
                        'title' => $subData['title'] ?? null,
                        'subtitle' => $subData['subtitle'] ?? null,
                        'content' => $cleanHtml,
                        'icon' => $subData['icon'] ?? '',
                        'image' => $subImagePath,
                        'button_text' => $subData['button_text'] ?? null,
                        'button_link' => $subData['button_link'] ?? null,
                        'order' => $subData['order'] ?? 0,
                        'extras' => $subData['extras'] ?? null,
                    ];

                    if ($sub) {
                        $sub->update($subAttributes);
                    } else {
                        $sub = $section->subsections()->create($subAttributes);
                    }

                    $subsectionIdsToKeep[] = $sub->id;
                }

                // -- Blocs personnalisés
                foreach ($sectionData['custom_blocks'] ?? [] as $block) {
                    $section->customBlocks()->updateOrCreate(
                        ['block_type' => $block['block_type']],
                        ['config' => $block['config'] ?? []]
                    );
                }
            }

            // Suppression des sections non conservées
            $page->sections()->whereNotIn('id', $sectionIdsToKeep)->each(function ($section) {
                if ($section->image)
                    Storage::disk('public')->delete($section->image);
                if ($section->image_side)
                    Storage::disk('public')->delete($section->image_side);

                $section->subsections->each(function ($sub) {
                    if ($sub->image)
                        Storage::disk('public')->delete($sub->image);
                    $sub->delete();
                });

                $section->delete();
            });

            // Suppression explicite de sous-sections
            if ($request->has('deleted_subsections')) {
                foreach ($request->input('deleted_subsections') as $deletedId) {
                    $sub = Subsection::find($deletedId);
                    if ($sub) {
                        if ($sub->image)
                            Storage::disk('public')->delete($sub->image);
                        $sub->delete();
                    }
                }
            }

            $page->touch();
            DB::commit();
            return response()->json(['message' => 'Page mise à jour avec succès']);

        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function showAccueil()
    {
        return Page::with([
            'sections' => function ($query) {
                $query->select('id', 'page_id', 'title');
            }
        ])
            ->where('slug', 'accueil')
            ->first();
    }


    // Liste des pages avec relations
    public function index()
    {
        return Page::with(['sections.subsections'])
            ->orderByRaw('`order` IS NULL, `order` ASC') // 👈 NULLs à la fin
            // ->where('is_active', true)
            ->get();
    }

    // Juste afficher une liste des pages (leger)
    public function listPublic()
    {
        return Page::where('is_active', true)
            ->select('id', 'title', 'slug', 'template', 'order')
            ->orderBy('order')
            ->get();
    }

    // Suppression complète
    public function destroy($id)
    {
        $page = Page::findOrFail($id);
        // Supprimer le dossier entier
        Storage::disk('public')->deleteDirectory("pages/page_{$page->id}");
        $page->delete();
        return response()->json(['message' => 'Page supprimée avec succès', 'status' => "deleted"]);
    }

    // Afficher une page par slug (pour le front)
    public function getBySlug($slug)
    {
        $page = Page::with('sections.subsections')->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
        return response()->json($page);
    }

    public function getByTemplate(Request $request)
    {
        $template = $request->input('template');

        if (!$template) {
            return response()->json(['error' => 'Template is required'], 400);
        }

        $page = Page::with(['sections.subsections'])
            ->where('template', $template)
            ->where('is_active', true)
            ->first();

        if (!$page) {
            return response()->json(['error' => 'Page not found'], 404);
        }

        return response()->json($page);
    }


    // Afficher une page par id (pour le front)
    public function get($id)
    {
        $page = Page::with('sections.subsections')->findOrFail($id);
        return response()->json($page);
    }

}
