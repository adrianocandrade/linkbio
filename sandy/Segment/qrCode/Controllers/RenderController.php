<?php

namespace Sandy\Segment\qrCode\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Element\Render as Controller;
use App\Payments;
use App\Models\Elementdb;

class RenderController extends Controller{
    function __construct(){
        parent::__construct();
    }

    public function render(){
        $qr = \QrCode::size(500)->format('png')->generate(ao($this->element->content, 'url'));

        $qr = base64_encode($qr);
        return view("App-$this->name::render", ['qrCode' => $qr]);
    }
}