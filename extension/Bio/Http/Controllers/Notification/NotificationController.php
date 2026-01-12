<?php

namespace Modules\Bio\Http\Controllers\Notification;

use Illuminate\Http\Request;
use Modules\Bio\Http\Controllers\Base\Controller;
use App\Models\BioDevicetoken;

class NotificationController extends Controller{

    public function save_token(Request $request){

        if ($token = BioDevicetoken::where('device_token', $request->token)->where('user', $this->bio->id)->first()) {
            return false;
        }

        $save = new BioDevicetoken;
        $save->device_token = $request->token;
        $save->user = $this->bio->id;
        $save->save();

    }
}