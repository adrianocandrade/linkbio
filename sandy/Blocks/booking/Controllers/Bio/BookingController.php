<?php

namespace Sandy\Blocks\booking\Controllers\Bio;

use App\Payments;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Sandy\Blocks\booking\Models\Booking;
use Illuminate\Contracts\Support\Renderable;
use Sandy\Blocks\booking\Helper\SandyBooking;
use Modules\Bio\Http\Controllers\Base\Controller;

class BookingController extends Controller{
   // use UserBioShop;

    public function index(){
        if (!plan('settings.block_booking', $this->bio->id)) {
            //abort(404);
        }

        // ✅ Filtrar por workspace_id se disponível
        $workspaceId = $this->workspace->id ?? null;
        $total_booking = Booking::where('user', $this->bio->id)
            ->when($workspaceId, function($query) use ($workspaceId) {
                return $query->where('workspace_id', $workspaceId);
            })
            ->count();


        $gallery = $this->gallery();

        return view('Blocks-booking::bio.index', ['gallery' => $gallery, 'total_booking' => $total_booking]);
    }

    public function success(){
        
        return view('Blocks-booking::bio.success');
    }

    public function validate_booking(Request $request){
        $sandybook = new SandyBooking($this->bio->id);
        $sxref = $request->get('sxref');
        // GET SPV FROM DB

        if (!$spv = Payments::is_paid($sxref)) {
            $redirect = $this->route('home');
            return redirect($redirect)->with('error', __('Unable to verify the payment.'));
        }

        $meta = $spv->meta;
        $date = Carbon::parse(ao($meta, 'date'))->format('Y-m-d');

        // ✅ Obter workspace_id do meta ou contexto do bio
        $workspaceId = ao($meta, 'workspace_id') ?? $this->workspace->id ?? null;

        $sandybook
        ->setServices(ao($meta, 'services'))
        ->setTime(ao($meta, 'time'))
        ->setDate($date)
        ->setCustomer(ao($meta, 'customer'))
        ->setWorkspaceId($workspaceId)
        ->save();

        //
        $redirect = $this->route('sandy-blocks-booking-success');

        return redirect($redirect);
    }

    
    private function gallery(){
        $link = '';
        $link_text = '';

        $return = [];

        $gallery = ao($this->bio->booking, 'gallery');

        if(!is_array($gallery)) $gallery = [];

        if(!empty($gallery)){
            foreach ($gallery as $key => $value) {
                $media = gs('media/booking', $value);


                $return[] = [
                    'id' => "box-$key",
                    'photo' => avatar($this->bio->id),
                    'name' => $this->bio->name,
                    'items' => [
                        [
                            'id'        => $key,
                            'type'      => 'photo',
                            'length'    => 5,
                            'src'       => $media,
                            'preview'   => $media,
                            'seen'      => false,
                        ]
                    ]
                ];
            }
        }


        return $return;
    }
}