<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use File;

class TranslationController extends Controller{
    public function languages(){
       // Get current translation locale
       $locale = config('app.locale');

       // Get all translations files
       $path = resource_path('lang');
       // Languages array
       $languages = File::files($path);

       // Vairable function of files with return false if error
       $info = function($file, $key = null) {
            $file = pathinfo($file);

            // Add language array in config
            app('config')->set('lang-temp', $file);

            // Get Filename
            $langname = app('config')->get('lang-temp.filename');

            // Get path of current language file
            $path = resource_path("lang/$langname.json");

            // Get count of inner languages
            if (file_exists($path)) {
                $getCount = file_get_contents($path);
                if (isJson($getCount)) {
                    $getCount = json_decode($getCount, true);

                    if (is_array($getCount)) {
                        $count = count($getCount);

                        app('config')->set('lang-temp.count-lang', $count);
                    }
                }
            }

            // Return config values
            $key = !empty($key) ? '.'.$key : null;
            return app('config')->get('lang-temp'. $key);
       };

       // View the page with array's

       return view('admin::translation.lang', ['languages' => $languages, 'info' => $info]);
    }

    public function deleteLanguage($lang){
        // Path of language
        $path = resource_path("lang/$lang.json");
        
        // Check if file exists
        if (!file_exists($path)) {
            abort(404);
        }

        // Remove translation
        unlink($path);
        
        // Return back with success
        return back()->with('success', __('Saved Successfully'));
    }

    public function duplicateLanguage($lang){
        // Path of language
        $path = resource_path("lang/$lang.json");
        // Get all translations files
        $newpath = resource_path("lang/".$lang."_copy.json");
        // Check if file exists
        if (!file_exists($path)) {
            abort(404);
        }

        // Duplicate
        File::copy($path, $newpath);
        // Return back with success
        return back()->with('success', __('Saved Successfully'));
    }

    public function newLanguage(Request $request){
        $name = $request->name;
        $name = slugify($name, '_');
        // Path of language
        $path = resource_path("lang/$name.json");
        // Check if file exists
        if (file_exists($path)) {
            back()->with('error', __('Language exists'));
        }

        // Create language
        file_put_contents($path, '{}');

        // Return back with success
        return back()->with('success', __('Saved Successfully'));
    }


    // View & post translations
    public function viewLang($lang, Request $request){
        // Get all translations files
        $path = resource_path('lang');
        // Languages array
        $languages = File::files($path);
        // Path of language
        $path = resource_path("lang/$lang.json");

        // Search for array
        $query = $request->get('query');

        // Check if file exists
        if (!file_exists($path)) {
            abort(404);
        }

        // Get translations values
        $values = file_get_contents($path);
        $values = json_decode($values, true);

        $input = preg_quote($query, '~'); // don't forget to quote input string!

        if (!empty($query)) {
            $values = preg_grep_keys_values('~' . $input . '~i', $values);
        }

        // Sort array's
        $values = !empty($values) ? array_reverse($values, true) : $values;

        // View the page
        return view('admin::translation.view', ['values' => $values, 'lang' => $lang, 'languages' => $languages]);
    }


    public function postTrans($type, $language, Request $request){
        // Path of language
        $path = resource_path("lang/$language.json");
        // Verify Type
        if (!in_array($type, ['new', 'edit', 'edit_lang', 'delete', 'set_as_main', 'multi_delete'])) {
            abort(404);
        }

        // Check if language exists
        if (!file_exists($path)) {
            abort(404);
        }
        // Get translations values
        $values = file_get_contents($path);
        $values = json_decode($values, true);

        //
        switch ($type) {
            case 'set_as_main':
                $update = [
                    'APP_LOCALE' => $language,
                ];
                env_update($update);

                // Return back with success
                return back()->with('success', __('Saved Successfully'));
            break;

            case 'edit_lang':
                $newName = $request->newName;
                $newName = slugify($newName, '_');
                $newLocation = resource_path("lang/$newName.json");

                // Check if new name exists
                if (file_exists($newLocation)) {
                    return back()->with('error', __('File name already exists'));
                }

                // Change name
                File::move($path, $newLocation);

                // Check if active and change to new active language
                if (config('app.APP_LOCALE') == $language) {
                    env_update(['APP_LOCALE' => $newName]);
                }

                // Return to new location with success
                return redirect()->route('admin-view-translation', $newName)->with('success', __('Saved Successfully'));
            break;

            case 'multi_delete':
                // Loop actions
                if (!empty($request->action)) {
                    foreach($_POST['action'] as $key => $value){
                        // Check if array exists
                        if (array_key_exists($value, $values)) {
                            unset($values[$value]);
                        }
                    }
                }

                // Turn array to json
                $new = json_encode($values);

                // Add array's to json
                file_put_contents($path, $new);

                return ['response' => 'success'];
            break;
            case 'new':
                // Check if array exists
                if (array_key_exists($request->previous, $values)) {
                    // return if previous doesnt exists
                    return back()->with('error', __('Previous value exists'));   
                }

                // Add new and previous values
                $values[$request->previous] = $request->new;

                // Turn array to json
                $new = json_encode($values);

                // Add array's to json
                file_put_contents($path, $new);

                // Return back with success
                return back()->with('success', __('Saved Successfully'));
            break;
            
            case 'edit':
                // Check if array exists
                if (!array_key_exists($request->previous, $values)) {
                    // return if previous doesnt exists
                    return back()->with('error', __('Previous value doesnt exists'));   
                }

                // Unset previous array
                unset($values[$request->previous]);

                // Add new array
                $values[$request->previous] = $request->new;

                // Turn array to json
                $new = json_encode($values);

                // Add array's to json
                file_put_contents($path, $new);

                // Return back with success
                return back()->with('success', __('Saved Successfully'));
            break;

            case 'delete':
                // Check if array exists
                if (!array_key_exists($request->previous, $values)) {
                    // return if previous doesnt exists
                    return back()->with('error', __('Previous value doesnt exists'));   
                }

                // Unset previous array
                unset($values[$request->previous]);

                // Turn array to json
                $new = json_encode($values);

                // Add array's to json
                file_put_contents($path, $new);

                // Return back with success
                return back()->with('success', __('Saved Successfully'));
            break;
        }

    }
}