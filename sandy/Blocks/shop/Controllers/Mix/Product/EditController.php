<?php

namespace Sandy\Blocks\shop\Controllers\Mix\Product;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Mix\Http\Controllers\Base\Controller;
use Sandy\Blocks\shop\Models\Product;
use Sandy\Blocks\shop\Models\ProductOption;

class EditController extends Controller
{
    public function edit($id){
        if (!$product = Product::where('user', $this->user->id)->where('id', $id)->first()) {
            abort(404);
        }


        $variant = ProductOption::where('product_id', $product->id)->where('user', $this->user->id)->orderBy('position', 'ASC')->orderBy('id', 'DESC')->get();

        return view('Blocks-shop::mix.product.edit', ['product' => $product, 'variant' => $variant]);
    }

    public function post($id, Request $request){
        if (!$product = Product::where('user', $this->user->id)->where('id', $id)->first()) {
            abort(404);
        }

        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'seo.page_description' => 'max:400',
            'seo.page_name' => 'max:55'
        ]);

        $banner = sandy_upload_modal_upload($request, 'media/shop/banner', '2048', $this->user->id, $product->banner);


        $stock = $product->stock_settings;

        if (!empty($stock_loop = $request->stock)) {
            foreach ($stock_loop as $key => $value) {
                $stock[$key] = $value;
            }
        }

        $seo = $product->seo;

        if (!empty($seo_loop = $request->seo)) {
            foreach ($seo_loop as $key => $value) {
                $seo[$key] = $value;
            }
        }

        $files = $product->files;

        if ($downloadables = $this->downloadables($request)) {
            $files[] = $downloadables;
        }


        $extra = [];

        foreach ($request->extra as $key => $value) {
            $extra[$key] = $value;
        }

        $product->name = $request->name;
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

        $product->update();



        return back()->with('success', __('Product updated successfully.'));
    }
    public function delete($id){
        if (!$product = Product::where('user', $this->user->id)->where('id', $id)->first()) {
            abort(404);
        }

        if (!empty(ao($product->banner, 'upload')) && mediaExists('media/shop/banner', ao($product->banner, 'upload'))) {
            \UserStorage::remove('media/shop/banner', ao($product->banner, 'upload')); 
        }



        $options = ProductOption::where('product_id', $product->id)->delete();

        $product->delete();


        return redirect()->route('sandy-blocks-shop-mix-view')->with('info', __('Product has been removed.'));
    }


    public function delete_file($id, $file, Request $request){
        if (!$product = Product::where('user', $this->user->id)->where('id', $id)->first()) {
            abort(404);
        }

        $files = $product->files;

        if (!is_array($files) && !in_array($file, $files)) {
            return back()->with('error', __('Invalid product file. Please try again.'));
        }


        if (mediaExists('media/shop/downloadables', $file)) {
            storageDelete('media/shop/downloadables', $file);

            foreach ($files as $key => $value) {
                if ($file == $value) {
                    unset($files[$key]);
                }
            }

            $product->files = $files;
            $product->update();
            return back()->with('success', __('File deleted successfully.'));
        }


        return back()->with('error', __('File not found.'));
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
