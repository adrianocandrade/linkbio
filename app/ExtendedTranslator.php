<?php

namespace App;
use Illuminate\Translation\Translator;

class ExtendedTranslator extends Translator{
    public function get($key, array $replace = [], $locale = null, $fallback = true){
        $trans = parent::get($key, $replace, $locale, $fallback);
        // Path of language


        if (settings('others.copy_trans')) {
            $path = resource_path("lang/default.json");
            if (file_exists($path)) {
                $values = file_get_contents($path);
                $values = json_decode($values, true);

                if (!array_key_exists($key, $values)) {
                    $values[$key] = $key;
                }
                $new = json_encode($values);

                // Add array's to json
                file_put_contents($path, $new);
            }
        }


        return $trans;
    }
}
