<?php

namespace Modules\Bio\Http\Controllers\Tip;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Bio\Http\Controllers\Base\Controller;
use Sandy\Segment\Segments;
use App\Models\BioApp;
use App\Models\Block;
use App\Models\Highlight;
use App\Traits\YettiPayment;
use App\Models\YettiSpv;

class TipController extends Controller{
    use YettiPayment;
    public function tip(Request $request){

        $amount = str_replace(',', '', $request->amount);
        $amount = (int) $amount;
        $validator = \Validator::make(['amount' => $amount], [
            'amount' => 'required|min:1|numeric'
        ]);
        $validator->validate();


        if (!\Auth::check()) {
            return back()->with('error', __('Please login to continue.'));
        }

        $sxref = \Wallet::sxref();
        $callback = \Bio::route($this->bio->id, 'user-bio-pay-tip-callback', ['sxref' => $sxref]);

        $item = [
            'name' => __('Sending Tip'),
            'description' => __('Sending tip of :amount to :page', ['amount' => $request->amount, 'page' => $this->bio->name])
        ];

        $meta = [
            'bio_id' => $this->bio->id,
            'item' => $item
        ];

        $data = [
            'method' => \Wallet::payment_option($this->bio->id),
            'price' => $amount,
            'callback' => $callback,
            'currency' => \Wallet::get('default_currency', $this->bio->id)
        ];
        return $this->create_payment($this->bio->id, $sxref, $data, $meta);
    }

    public function callback(Request $request){
        $sxref = $request->get('sxref');
        // GET SPV FROM DB
        if (!$spv = YettiSpv::where('sxref', $sxref)->first()) {
            abort(404);
        }

        // Send Email - FIX

        $return = \Bio::route($this->bio->id, 'user-bio-home');

        return redirect($return)->with('payment_success', ['item' => ao($spv->meta, 'item'), 'response' => __('You have successfully paid :page', ['page' => $this->bio->name])]);
    }
}