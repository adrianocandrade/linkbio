<?php

namespace Sandy\Blocks\booking\Controllers\Mix;

use Illuminate\Http\Request;
use Sandy\Blocks\booking\Models\Booking;
use Illuminate\Contracts\Support\Renderable;
use Modules\Mix\Http\Controllers\Base\Controller;
use Sandy\Blocks\booking\Models\BookingWorkingBreak;

class DashboardController extends Controller
{
    public function dashboard(){
        return view('Blocks-booking::mix.dashboard');
    }

    
    public function settings(){
        $workspaceId = session('active_workspace_id');
        $breaks = BookingWorkingBreak::where('user', $this->user->id)
            ->when($workspaceId, function ($query) use ($workspaceId) {
                return $query->where('workspace_id', $workspaceId);
            })
            ->get();
        return view('Blocks-booking::mix.settings', ['breaks' => $breaks]);
    }

    public function calendar_view(Request $request){
        $workspaceId = session('active_workspace_id');
        $booking = Booking::where('user', $this->user->id)
            ->where('id', $request->booking_id)
            ->when($workspaceId, function ($query) use ($workspaceId) {
                return $query->where('workspace_id', $workspaceId);
            })
            ->first();
        
        if (!$booking) abort(404);

        return view('Blocks-booking::mix.booking.view', ['booking' => $booking]);
    }

    public function calendar(){
        return view('Blocks-booking::mix.calendar');
    }

    public function change_booking_status(Request $request){
        $workspaceId = session('active_workspace_id');
        $booking = Booking::where('user', $this->user->id)
            ->where('id', $request->booking_id)
            ->when($workspaceId, function ($query) use ($workspaceId) {
                return $query->where('workspace_id', $workspaceId);
            })
            ->first();
        
        if (!$booking) abort(404);

        $booking->appointment_status = $request->status;
        $booking->update();

        // Send Notification

        return back()->with('success', __('Booking updated.'));
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
