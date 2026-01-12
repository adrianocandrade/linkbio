<?php

namespace Sandy\Blocks\shop\Controllers\Mix\Product;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Mix\Http\Controllers\Base\Controller;
use Sandy\Blocks\shop\Models\Product;

class CreateController extends Controller
{
    public function new(){
        return view('Blocks-shop::mix.product.new');
    }

    public function create_block(){
        if (!Product::where('user', $this->user->id)->get()->isEmpty() && !\App\Models\Block::where('user', $this->user->id)->where('block', 'shop')->first()) {

            $data = [
                'blocks' => [
                    'all_product' => 1
                ]
            ];

            \Blocks::create_block_sections($this->user->id, 'shop', $data);
        }
    }

    public function post(Request $request){
        $request->validate([
            'name' => 'required',
            'description' => 'required'
        ]);

        $banner = sandy_upload_modal_upload($request, 'media/shop/banner', '2048', $this->user->id);


        $stock = [];

        if (!empty($stock_loop = $request->stock)) {
            foreach ($stock_loop as $key => $value) {
                $stock[$key] = $value;
            }
        }

        $seo = [];

        if (!empty($seo_loop = $request->seo)) {
            foreach ($seo_loop as $key => $value) {
                $seo[$key] = $value;
            }
        }

        $files = [];
        if ($downloadables = $this->downloadables($request)) {
            $files[] = $downloadables;
        }

        $extra = [];

        foreach ($request->extra as $key => $value) {
            $extra[$key] = $value;
        }


        $product = new Product;
        $product->name = $request->name;
        $product->user = $this->user->id;
        $product->workspace_id = session('active_workspace_id');
        $product->description = $request->description;
        $product->price_type = $request->price_type;
        $product->comparePrice = $request->compare_price;
        $product->price = $request->price;
        $product->banner = $banner;
        $product->productType = $request->productType;
        $product->seo = $seo;

        $product->files = $files;

        $product->stock = $request->product_stock;
        $product->stock_settings = $stock;

        $product->extra = $extra;


        $product->save();

        $this->create_block();



        return redirect()->route('sandy-blocks-shop-mix-view')->with('success', __('Product added successfully.'));
    }

    private function downloadables($request){
        $size = (int) '10';
        $size = "{$size}000";
        $formats = 'jpeg,png,jpg,gif,svg,mp4,mp3,mov,ogg,avi,zip';

        if (empty($request->downloadable_files)) {
            return false;
        }

        // Validate image
        $request->validate([
            'downloadable_files' => 'required|mimes:'. $formats .'|max:'. $size,
        ]);

        $pathinfo = pathinfo($request->file('downloadable_files')->getClientOriginalName());
        $filename = slugify(ao($pathinfo, 'filename'));
        $name = $filename .'_'. strtolower(\Str::random(3)) .'.'. ao($pathinfo, 'extension');

        $file = \UserStorage::putAs('media/shop/downloadables', $request->downloadable_files, $name, $this->user->id);

        // Return image name
        return $file;
    }
}
