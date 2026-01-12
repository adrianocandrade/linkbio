<?php

namespace Sandy\Plugins\awsconnect\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Modules\Admin\Http\Controllers\Base\Controller;
use Route;
use Aws\S3\S3Client;
use Illuminate\Http\File;

class AdminViewController extends Controller{
    public function edit(){
        return view('Plugin-awsconnect::edit');
    }

    public function testCon(){
        $filesystem = 's3';

        $name = 'test-con.png';
        if (!file_exists($path = public_path('assets/image/others/default-sandy-skeleton.png'))) {
            return back()->with('error', __('Test file not found'));
        }

        try {
            $put = \Storage::disk($filesystem)->putFileAs('/', new File($path), $name);
            \Storage::disk($filesystem)->setVisibility($put, 'public');
        } catch (\Exception $e) {
            my_log($e->getMessage());

            return back()->with('error', $e->getMessage());
        }


        return back()->with('success', __('Connection successful'));
    }

    public function post(Request $request){

        // Loop & post env
        if (!empty($request->env)) {
            $env = [];
            foreach ($request->env as $key => $value) {
                $env[$key] = $value;
            }

            env_update($env);
        }

        return back()->with('success', __('Saved Successfully'));
    }
}