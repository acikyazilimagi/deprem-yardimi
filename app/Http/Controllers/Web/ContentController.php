<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class ContentController extends Controller
{
    public function index()
    {
        $url = 'https://raw.githubusercontent.com/alpaylan/afetbilgi.com/main/data/all.combined.1.json';
        $json = file_get_contents($url);
        $data = json_decode($json, true);
        $options = $data['options'];

        foreach ($options as $option) {
            $menu_name = $option['name_tr'] ?? $option['name'];
            $menu_slug = str_replace(' ', '-', strtolower($menu_name));
            $menu_slug = str_replace(['ı', 'ğ', 'ü', 'ş', 'ö', 'ç'], ['i', 'g', 'u', 's', 'o', 'c'], $menu_slug);
            $menu_slug = str_replace(['İ', 'Ğ', 'Ü', 'Ş', 'Ö', 'Ç'], ['i', 'g', 'u', 's', 'o', 'c'], $menu_slug);
            $menus[] = [
                'name' => $menu_name,
                'slug' => $menu_slug,
            ];
        }

        return view('content.index', compact('menus'));
    }

    public function geciciBarinma()
    {
        $url = 'https://raw.githubusercontent.com/alpaylan/afetbilgi.com/main/data/all.combined.1.json';
        $json = file_get_contents($url);

        $data = json_decode($json, true);
        $options = $data['options'];

        $geciciBarinma = $options[0]['value']['options'];

        return view('content.gecici-barinma-alanlari', compact('geciciBarinma'));
    }
}
