<?php

namespace Modules\Install\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class InstallController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $requirements = $this->server_requirements();
        $writable = $this->check_writeable();
        $passed = true;


        foreach ($requirements as $key => $value) {
            if (!$value['result']) {
                $passed = false;
            }
        }
        foreach ($writable as $key => $value) {
            if (!$value['result']) {
                $passed = false;
            }
        }
        return view('install::index', ['requirements' => $requirements, 'passed' => $passed, 'writable' => $writable]);
    }

    public function finalize(){

        return view('install::steps.finalize');
    }


    public function server_requirements(){
        $result = [
            'PHP Version' => [
                'result'        => version_compare(PHP_VERSION, 7.2, '>'),
                'message'  => 'You need at least PHP v7.2.5.',
                'current'       => PHP_VERSION
            ],
            'PDO' => [
                'result'        => defined('PDO::ATTR_DRIVER_NAME'),
                'message'  => 'PHP PDO extension is required.',
                'current'       => defined('PDO::ATTR_DRIVER_NAME') ? 'Enabled' : 'Not enabled'
            ],
            'Mbstring' => [
                'result'        => extension_loaded('mbstring'),
                'message'  => 'PHP mbstring extension is required.',
                'current'       => extension_loaded('mbstring') ? 'Enabled' : 'Not enabled'
            ],
            'Intl' => [
                'result'        => extension_loaded('intl'),
                'message'  => 'PHP intl extension is required.',
                'current'       => extension_loaded('intl') ? 'Enabled' : 'Not enabled'
            ],
            'Fileinfo' => [
                'result'        => extension_loaded('fileinfo'),
                'message'  => 'PHP fileinfo extension is required.',
                'current'       => extension_loaded('fileinfo') ? 'Enabled' : 'Not enabled'
            ],
            'OpenSSL' => [
                'result'        => extension_loaded('openssl'),
                'message'  => 'PHP openssl extension is required.',
                'current'       => extension_loaded('openssl') ? 'Enabled' : 'Not enabled'
            ],
            'GD' => [
                'result'        => extension_loaded('gd'),
                'message'  => 'GD extension is required.',
                'current'       => extension_loaded('gd') ? 'Enabled' : 'Not enabled'
            ],
            'Curl' => [
                'result'        => extension_loaded('curl'),
                'message'  => 'PHP curl extension is required.',
                'current'       => extension_loaded('curl') ? 'Enabled' : 'Not enabled'
            ],

            'Zip' => [
                'result'        => class_exists('ZipArchive'),
                'message'  => 'PHP ZipArchive extension is required.',
                'current'       => class_exists('ZipArchive') ? 'Enabled' : 'Not enabled'
            ],
        ];

        $allPass = array_filter($result, function($item) {
            return !$item['result'];
        });

        return $result;
    }


    protected function check_writeable(){
        $directories = [
            '',
            'storage',
            'bootstrap',
            'bootstrap/cache',
            'storage/app',
            'storage/logs',
            'storage/framework',
            'sandy'
        ];

        $results = [];

        foreach ($directories as $directory) {
            $path = rtrim(base_path($directory), '/');
            $writable = is_writable($path);
            $dir = !empty($directory) ? $directory : 'root';
            $result = ['path' => $path, 'result' => $writable, 'writable' => $writable ? 'writable' : 'not writable', 'dir' => $dir, 'message' => 'This folder is writable.'];


            if ( ! $writable) {
                $result['message'] = is_dir($path) ?
                    'Make this directory writable by giving it 0755 or 0777 permissions via file manager.' :
                    'Make this directory writable by giving it 644 permissions via file manager.';
            }

            $results[] = $result;
        }

        $files = [
            '.htaccess',
            'bootstrap/app.php',
            'public/.htaccess'
        ];

        if ( ! $this->fileExistsAndNotEmpty('.env')) {
            $results[] = [
                'path' => base_path(),
                'result' => false,
                'writable'  => 'not writable',
                'message' => "Make sure <strong>.env</strong> file has been uploaded properly to the directory above and is writable.",
            ];
        }

        foreach ($files as $file) {
            $results[] = [
                'path' => base_path($file),
                'result' => $this->fileExistsAndNotEmpty($file),
                'writable' => $this->fileExistsAndNotEmpty($file) ? 'writable' : 'not writable',
                'dir' => $file,
                'message' => (!is_writable($file) ? "Make sure <strong>$file</strong> file has been uploaded properly to your server and is writable." : 'This file is writable.')
            ];
        }

        $allPass = array_filter($results, function($item) {
            return !$item['result'];
        });
        return $results;
    }

    protected function fileExistsAndNotEmpty($path){
        $filePath = base_path($path);
        $writable = is_writable($filePath);
        $content = $writable ? trim(file_get_contents($filePath)) : '';
        return $writable && strlen($content);
    }
}
