<?php

namespace Modules\Admin\Http\Controllers\Plugins;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Plugins;
use App\Payments;

class PaymentsController extends Controller{
    public $dir = 'sandy/Payments';

    public function payments(){
        $payments = new Payments;
        $payments = $payments->getInstalledMethods();
        
        // Save array without error
        $getItem = function($array, $key){
            app('config')->set('array-temp', $array);
            $key = !empty($key) ? '.'.$key : null;
            return app('config')->get('array-temp'. $key);
        };

        // Return view
        return view('admin::plugins.payments', ['payments' => $payments, 'getItem' => $getItem]);
    }

    public function paymentsUpload(Request $request){
        $payments = new Payments;

        // Validate the request
        $request->validate([
            'archive' => 'required|file|mimes:zip',
        ]);

        $is_payment = function($path){

            try {
                $zipper = new \Madnest\Madzipper\Madzipper;
                $archive_get_config = $zipper->make($path)->listFiles("~config.php~");
                $archive_config_content = $zipper->make($path)->getFileContent($archive_get_config[0]);
                $zipper->close();

                $config_array = json_to_array($archive_config_content);
                if (!ao($config_array, 'is_payment')) {
                    unlink($path);

                    return ['status' => false, 'message' => 'Archive is not a valid payment method.'];
                }
            } catch (\Exception $e) {
                return ['status' => false, 'message' => $e->getMessage()];
            }


            return ['status' => true, 'message' => 'Proceed.'];
        };
        // Folder location
        $location = $this->dir;

        $archiveName = $request->file('archive')->getClientOriginalName();

        // Move to folder
        $request->archive->move(base_path($location), $archiveName);
        $path = base_path("$location/$archiveName");
        // Unzip the file
        try {
            $payment_check = $is_payment($path);
            
            if (!ao($payment_check, 'status')) {
                return back()->with('error', ao($payment_check, 'message'));
            }

            $zipper = new \Madnest\Madzipper\Madzipper;
            $zipper->make($path)->extractTo(base_path($location));
            $zipper->close();
            // Unlink the file
            unlink($path);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        // Return back
        return back()->with('success', __("Payment method uploaded successfully."));
    }

    public function delete(Request $request){
        //

        if (file_exists($path = base_path("$this->dir/$request->plugin"))) {

            try {
                \File::deleteDirectory($path);
            } catch (\Exception $e) {
                return back()->with('error', $e->getMessage());
            }
            // Return back
            return back()->with('success', __("Payment method deleted."));
        }
        
        // Return back
        
        return back()->with('error', __("Could not find payment method."));
    }
}
