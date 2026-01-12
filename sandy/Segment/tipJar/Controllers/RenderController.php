<?php

namespace Sandy\Segment\tipJar\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Element\Render as Controller;
use App\Payments;
use App\Models\Elementdb;
use App\Models\TipCollection;

class RenderController extends Controller{

    function __construct(){
        parent::__construct();
    }

    public function render(){
        return view("App-$this->name::render");
    }


    public function TipUser($slug, Request $request){
        $amount = str_replace(',', '', $request->amount);
        $validator = \Validator::make(['amount' => $amount, 'email' => $request->email, 'payment_type' => $request->payment_type], [
            'amount' => 'required|min:1|numeric',
            'email' => 'required|email',
            'payment_type' => 'required'

        ]);
        $validator->validate();

        $sxref = \Bio::sxref();
        $method = ao($this->bio->payments, 'default');
        $callback = route('sandy-app-tipJar-tip-user-callback', ['slug' => $this->element->slug, 'sxref' => $sxref]);

        $item = [
            'name' => __('Tip Jar'),
            'description' => __('Tipped :page', ['page' => $this->bio->name]),
            'processing_description' => __('Sending a tip of :amount to :page', ['amount' => $request->amount, 'page' => $this->bio->name]),
            'processed_description' => __('Just tipped you <strong>:amount</strong>', ['amount' => $request->amount, 'page' => $this->bio->name])
        ];

        $info = [
            'note' => $request->note
        ];

        $meta = [
            'bio_id' => $this->bio->id,
            'workspace_id' => $this->workspace->id ?? null, // Capture workspace ID
            'item' => $item,
            'info' => $info
        ];

        $data = [
            'method' => $method,
            'email' => $request->email,
            'price' => $amount,
            'callback' => $callback,
            'currency' => ao($this->bio->payments, 'currency')
        ];



        if ($request->payment_type == 'recurring') {
            $meta['payment_mode'] = [
                'type' => 'recurring',
                'interval' => 'month',
                'title' => __('Monthly tip of :price to :page', ['page' => $this->bio->name, 'website' => config('app.name'), 'price' => $request->amount . ao($this->bio->payments, 'currency')]),
                'id' => md5("spv_recurring_id.{$this->element->id}.{$this->bio->id}.{$amount}")
            ];
        }

        $keys = user("payments.$method", $this->bio->id);

        $create = (new Payments)->create($sxref, $data, $keys, $meta);

        // Return the gateway
        return $create;
    }


    public function tipUserCallback($slug, Request $request){
        $sxref = $request->get('sxref');
        // GET SPV FROM DB

        if (!$spv = Payments::is_paid($sxref)) {
            $redirect = \Bio::route($this->bio->id, 'home');
            return redirect($redirect)->with('error', __('Unable to verify the payment.'));
        }

        $tip = new TipCollection;
        $tip->user = $this->bio->id;
        $tip->element_id = $this->element->id;
        $tip->is_private = 1;
        $tip->amount = $spv->price;
        $tip->currency = $spv->currency;
        $tip->info = ao($spv->meta, 'info');

        $tip->save();

        // INTEGRATION: AUDIENCE SERVICE
        try {
            $workspaceId = ao($spv->meta, 'workspace_id') ?? 
                          (isset($this->workspace) ? $this->workspace->id : null) ?? 
                          (\App\Models\Workspace::where('user_id', $this->bio->id)->where('is_default', 1)->first()->id ?? null);

            $audienceService = app(\Modules\Mix\Services\AudienceService::class);
            $contact = $audienceService->createOrUpdateContact([
                'workspace_id' => $workspaceId,
                'user_id' => $this->bio->id,
                'name' => $spv->email ?? $request->email, // Using email as name fallback
                'email' => $spv->email ?? $request->email, 
                'source' => 'tipjar',
                'source_id' => $tip->id,
            ]);

            $audienceService->recordInteraction(
                $contact->id,
                'tip',
                'created',
                $spv->price
            );
        } catch (\Exception $e) {
            \Log::error('Audience Integration Error (TipJar): ' . $e->getMessage());
        }

        return redirect()->route('sandy-app-tipJar-render', ['slug' => $slug])->with('success', __('User has been tipped successfully.'));
    }
}