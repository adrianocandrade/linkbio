<?php

namespace Modules\Mix\Http\Controllers\Settings;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Mix\Http\Controllers\Base\Controller;
use Kutia\Larafirebase\Facades\Larafirebase;
use App\Models\BioPushNotification;
use App\Models\BioDevicetoken;

class PwaController extends Controller{
    public function pwa(){
        $app_icon_exists = file_exists(public_path('media/bio/pwa-app-icon/'. user('pwa.app_icon')));

        return view('mix::settings.sections.pwa', ['app_icon_exists' => $app_icon_exists]);
    }

    public function pwa_post(Request $request){
        $edit = \App\User::find($this->user->id);
        // Check if it's in plan
        if (!plan('settings.pwa')) {
            // Can change to a custom page later
            abort(404);
        }

        $putStorage = function($directory, $file) use ($edit){

            $filesystem = 'local';
            $pathinfo = pathinfo($file->getClientOriginalName());
            $name = slugify(ao($pathinfo, 'filename')) .'_'. strtolower(\Str::random(3)) .'.'. ao($pathinfo, 'extension');

            $put = \Storage::disk($filesystem)->putFileAs($directory, $file, $name);
            \Storage::disk($filesystem)->setVisibility($put, 'public');

            $put = basename($put);
            $upload = [
                'user' => $edit->id,
                'path' => "$directory/$put"
            ];

            \App\Models\UserUploadPath::create($upload);


            return $put;
        };


        $pwa = $edit->pwa ?? [];

        if (!empty($request->pwa) && is_array($request->pwa)) {
            foreach($request->pwa as $key => $value){
                $pwa[$key] = $value;
            }
        }

        if (!empty($app_icon = $request->app_icon)) {
            $request->validate([
                'app_icon' => 'image|mimes:png,webp,svg|max:2048',
            ]);

            if (!empty($previous_image = ao($edit->pwa, 'app_icon'))) {
                if(file_exists($path = public_path('media/bio/pwa-app-icon/'. $previous_image))){
                    unlink($path); 
                }
            }

            $imageName = $putStorage('media/bio/pwa-app-icon', $app_icon);
            $pwa['app_icon'] = $imageName;
        }

        $edit->pwa = $pwa;
        $edit->save();


        return back()->with('success', __('Saved Successfully'));
    }


    public function push(Request $request){
        if (!plan('settings.pwa_messaging')) {
            abort(404);
        }

        $rules = [
            'title' => 'required',
            'description' => 'required',
            //'link' => 'sometimes|url'
        ];

        $this->validate($request, $rules);
        $content = [
            'title' => $request->title,
            'body' => $request->description,
            'icon' => avatar($this->user->id),
        ];

        $content['click_action'] = bio_url($this->user->id);

        $device_tokens = BioDevicetoken::where('user', $this->user->id)->whereNotNull('device_token')->pluck('device_token')->toArray();


        $push = Larafirebase::fromArray($content)->sendNotification($device_tokens);
        $push = json_decode($push, true);

        $content['success'] = ao($push, 'success');
        $content['failure'] = ao($push, 'failure');

        $store = new BioPushNotification;
        $store->user = $this->user->id;
        $store->content = $content;
        $store->save();

        return back()->with('success', __('Notification sent successfully.', ['success' => ao($push, 'success'), 'failure' => ao($push, 'failure')]));
    }
}
