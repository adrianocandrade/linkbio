<?php

namespace Sandy\Blocks\booking\Controllers\Bio;

use App\Payments;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Sandy\Blocks\booking\Helper\Time;
use Sandy\Blocks\booking\Models\Booking;
use Illuminate\Contracts\Support\Renderable;
use Sandy\Blocks\booking\Helper\SandyBooking;
use Modules\Bio\Http\Controllers\Base\Controller;

class BookingsController extends Controller{


    public function bookings(Request $request){
        $timeClass = new Time($this->bio->id);
        $auth = \Auth::user();
        
        $day_id = Carbon::now()->format('j');
        $date = Carbon::now();

        if (!empty($request->get('date'))) {
            $day_id = $request->get('date');
            $date = Carbon::parse($request->get('date'));

            $day_id = $date->format('j');
        }

        $date = Carbon::parse($date->format('Y-m-') . $day_id);

        // ✅ Filtrar por workspace_id se disponível
        // ✅ OTIMIZAÇÃO: Usar eager loading para evitar queries N+1 ao acessar relações
        $workspaceId = $this->workspace->id ?? null;
        $appointments = Booking::where('user', $this->bio->id)
            ->where('payee_user_id', $auth->id)
            ->when($workspaceId, function($query) use ($workspaceId) {
                return $query->where('workspace_id', $workspaceId);
            })
            ->orderBy('id', "DESC")
            ->whereDate('date', $date->toDateString())
            ->get();


        return view('Blocks-booking::bio.bookings.index', ['appointments' => $appointments]);
    }

    public function view(Request $request){
        // ✅ Filtrar por workspace_id se disponível
        $workspaceId = $this->workspace->id ?? null;
        $bookingQuery = Booking::where('user', $this->bio->id)
            ->where('id', $request->booking_id);
        
        if ($workspaceId) {
            $bookingQuery->where('workspace_id', $workspaceId);
        }
        
        if(!$booking = $bookingQuery->first()) abort(404);

        
        return view('Blocks-booking::bio.bookings.view', ['booking' => $booking]);
    }
}