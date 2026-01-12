<?php

namespace Sandy\Blocks\booking\Controllers\Mix;

use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Modules\Mix\Http\Controllers\Base\Controller;
use Sandy\Blocks\booking\Models\BookingWorkingBreak;

class SettingsController extends Controller
{
    public function tree(Request $request){
        if($request->tree == 'settings') abort(404);

        if(!method_exists($this, $request->tree)){
            abort(404);
        }


        return $this->{$request->tree}($request);
    }


    public function general_settings($request){
        
        $booking = $this->user->booking;
        if(!empty($settings_loop = $request->settings)){
            foreach ($settings_loop as $key => $value) {
                $booking[$key] = $value;
            }
        }

        $this->user->booking = $booking;
        $this->user->update();


        return back()->with('success', __('Settings updated successfully.'));
    }


    public function add_break($request){
        
        $request->validate([
            'date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        $back = function(){
            return back()->with('success', __('Saved Successfully'));
        };
        
        $workspaceId = session('active_workspace_id');
        
        $save = function($date) use ($request, $workspaceId){
            $start_time = hour2min($request->start_time);
            $end_time = hour2min($request->end_time);
            $time = implode('-', [$start_time, $end_time]);
            
            $break = new BookingWorkingBreak;
            $break->user = $this->user->id;
            $break->workspace_id = $workspaceId;  // ✅ Adicionar workspace_id
            $break->date = $date;
            $break->time = $time;
            $break->save();

            return $break;
        };

        $breaks = explode(',', $request->date);
        if(!empty($breaks[1])){
            
            $period = CarbonPeriod::create($breaks[0], $breaks[1]);

            foreach ($period as $d) {
                $save($d->format('Y-m-d'));
            }

            return $back();
        }

        
        $save($breaks[0]);
        return $back();
    }

    public function remove_break($request){
        $breaks = json_decode($request->breaks);
        $workspaceId = session('active_workspace_id');

        BookingWorkingBreak::where('user', $this->user->id)
            ->when($workspaceId, function ($query) use ($workspaceId) {
                return $query->where('workspace_id', $workspaceId);
            })
            ->whereIn('id', $breaks)
            ->delete();

        return back()->with('success', __('Break deleted.'));
    }


    public function edit_working_hours($request){
        $weekdays = $this->user->booking;
        if(!empty($weekdays_loop = $request->weekday)){
            foreach ($weekdays_loop as $key => $value) {
                $value['from'] = hour2min($value['from']);
                $value['to'] = hour2min($value['to']);
                $weekdays['workhours'][$key] = $value;
            }
        }

        $this->user->booking = $weekdays;
        $this->user->update();


        return back()->with('success', __('Working hour saved successfully.'));
    }



    public function setting_post(Request $request){
        $user = $this->user;

        $store = $user->settings;


        if (!empty($store_loop = $request->store)) {
            foreach ($store_loop as $key => $value) {
                $store['store'][$key] = $value;
            }
        }


        $user->settings = $store;
        $user->update();

        return back()->with('success', __('Store settings updated successfully.'));
    }
}
