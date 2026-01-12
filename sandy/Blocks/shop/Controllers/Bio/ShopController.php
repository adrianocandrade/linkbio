<?php

namespace Sandy\Blocks\shop\Controllers\Bio;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Bio\Http\Controllers\Base\Controller;
//use App\Traits\UserBioShop;
use Sandy\Blocks\shop\Models\Product;

class ShopController extends Controller{
   // use UserBioShop;

    public function shop(){
        if (!plan('settings.block_shop', $this->bio->id)) {
            abort(404);
        }
        
        $products = Product::where('user', $this->bio->id)->get();
        return view('Blocks-shop::bio.index', ['products' => $products]);
    }
}