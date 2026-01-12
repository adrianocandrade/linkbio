<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Linkertrack;
use App\Models\Linker;

class UpdateDBController extends Controller{
    public function update(Request $request){
        $key = $request->get('key');
        
        try {
            \Artisan::call('sandy:update_database');
            echo "Updated successfully.";
        }catch(\Exception $e) {
            return $e->getMessage();
        }


        if (url()->previous() !== $request->fullUrl() && url()->previous() !== url('/')) {
            return back()->with('success', __('Updated successfully'));
        }
    }
}
