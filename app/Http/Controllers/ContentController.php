<?php

namespace App\Http\Controllers;

class ContentController extends Controller
{
    public function index()
    {
        $url = 'https://raw.githubusercontent.com/alpaylan/afetbilgi.com/main/data/all.combined.1.json';
        $json = file_get_contents($url);
        $data = json_decode($json, true);
        $options = $data['options'];

        foreach ($options as $option) {
            //get name or name_tr
            $menu_name = $option['name_tr'] ?? $option['name'];
            //create slug
            $menu_slug = str_replace(' ', '-', strtolower($menu_name));
            //turkish characters to latin characters
            $menu_slug = str_replace(['ı', 'ğ', 'ü', 'ş', 'ö', 'ç'], ['i', 'g', 'u', 's', 'o', 'c'], $menu_slug);
            //capital turkish characters to latin characters
            $menu_slug = str_replace(['İ', 'Ğ', 'Ü', 'Ş', 'Ö', 'Ç'], ['i', 'g', 'u', 's', 'o', 'c'], $menu_slug);
            //create menu array
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

        //All data from gecici barinma
        $geciciBarinma = $options[0]['value']['options'];

        return view('content.gecici-barinma-alanlari', compact('geciciBarinma'));
    }
}
