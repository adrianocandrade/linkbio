<?php

namespace Modules\Install\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;

class DatabaseController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function database(){
        return view('install::steps.database');
    }


    public function database_save(Request $request){
        $request->validate([
            'database_host' => 'required',
            'database_port' => 'required',
            'database_name' => 'required',
            'database_username' => 'required',
            //'database_password' => 'required'
        ]);


        $database = [
            'DB_HOST' => $request->database_host,
            'DB_PORT' => $request->database_port,
            'DB_DATABASE' => $request->database_name,
            'DB_USERNAME' => $request->database_username,
            'DB_PASSWORD' => $request->database_password
        ];


        env_update($database);


        return redirect()->route('install-steps-database-migrate');

    }

    public function database_migrate(){
        $pdo = db_con();
        if (!$pdo) {
            return redirect()->route('install-steps-database')->with('error', __('Could not connect with database, please check your credentials.'));
        }

        try {
            Artisan::call('migrate', ["--force" => true]);
            Artisan::call('db:seed', ['--force' => true]);
            Artisan::call('key:generate', ["--force"=> true]);
        }catch(\Exception $e) {
            return redirect()->route('install-steps-database')->with('error', $e->getMessage());
        }

        return view('install::steps.database-migrate');
    }
}
