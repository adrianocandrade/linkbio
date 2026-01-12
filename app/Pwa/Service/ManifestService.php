<?php
/**
 * Created by PhpStorm.
 * User: Silvio Leite
 * Date: 22/08/2018
 * Time: 19:13
 */

namespace App\Pwa\Service;


class ManifestService
{
    public function init()
    {
        $basicManifest =  [
            'name' => config('sandypwa.manifest.name'),
            'short_name' => config('sandypwa.manifest.short_name'),
            'start_url' => config('sandypwa.manifest.start_url'),
            'display' => config('sandypwa.manifest.display'),
            'theme_color' => config('sandypwa.manifest.theme_color'),
            'background_color' => config('sandypwa.manifest.background_color'),
            'orientation' =>  config('sandypwa.manifest.orientation'),
            'status_bar' =>  config('sandypwa.manifest.status_bar'),
            'splash' =>  config('sandypwa.manifest.splash'),
        ];

        foreach (config('sandypwa.manifest.icons') as $size => $file) {
            $fileInfo = pathinfo(strip_param_from_url(ao($file, 'path'), ['width', 'height']));
            $basicManifest['icons'][] = [
                'src' => ao($file, 'path'),
                'type' => 'image/' . ao($fileInfo, 'extension'),
                'sizes' => $size,
                'purpose' => ao($file, 'purpose')
            ];
        }

        if (config('sandypwa.manifest.shortcuts')) {
            foreach (config('sandypwa.manifest.shortcuts') as $shortcut) {

                if (array_key_exists("icons", $shortcut)) {
                    $fileInfo = pathinfo($shortcut['icons']['src']);
                    $icon = [
                        'src' => $shortcut['icons']['src'],
                        'type' => 'image/' . $fileInfo['extension'],
                        'purpose' => $shortcut['icons']['purpose']
                    ];
                } else {
                    $icon = [];
                }

                $basicManifest['shortcuts'][] = [
                    'name' => trans($shortcut['name']),
                    'description' => trans($shortcut['description']),
                    'url' => $shortcut['url'],
                    'icons' => [
                        $icon
                    ]
                ];
            }
        }

        foreach (config('sandypwa.manifest.custom') as $tag => $value) {
             $basicManifest[$tag] = $value;
        }
        return $basicManifest;
    }

}
