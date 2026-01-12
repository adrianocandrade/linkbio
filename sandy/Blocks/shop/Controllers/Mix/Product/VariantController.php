<?php

namespace Sandy\Blocks\shop\Controllers\Mix\Product;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Mix\Http\Controllers\Base\Controller;
use Sandy\Blocks\shop\Models\Product;
use Sandy\Blocks\shop\Models\ProductOption;

class VariantController extends Controller{
    public function create(Request $request){
        if (!$product = Product::where('user', $this->user->id)->where('id', $request->product_id)->first()) {
            abort(404);
        }

        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'amount' => 'required|numeric',
            'quantity' => 'nullable|numeric'
        ]);


        $variant = new ProductOption;
        $variant->user = $this->user->id;
        $variant->product_id = $request->product_id;
        $variant->name = $request->name;
        $variant->description = $request->description;
        $variant->price = $request->amount;
        $variant->stock = $request->quantity;
        $variant->save();


        return back()->with('success', __('Variant saved successfully.'));
    }

    public function edit(Request $request){
        if (!$variant = ProductOption::where('user', $this->user->id)->where('id', $request->variant_id)->first()) {
            abort(404);
        }

        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'amount' => 'required|numeric',
            'quantity' => 'nullable|numeric'
        ]);

        $variant->name = $request->name;
        $variant->description = $request->description;
        $variant->price = $request->amount;
        $variant->stock = $request->quantity;
        $variant->update();

        return back()->with('success', __('Variant updated successfully.'));
    }

    public function sort(Request $request){
     foreach($request->data as $key) {
        $key['id'] = (int) $key['id'];
        $key['position'] = (int) $key['position'];
        $update = ProductOption::find($key['id']);
        $update->position = $key['position'];
        $update->save();
     }
    }

    public function delete($id, Request $request){
        if (!$variant = ProductOption::where('user', $this->user->id)->where('id', $id)->first()) {
            abort(404);
        }

        $variant->delete();

        return back()->with('success', __('Variant deleted successfully.'));
    }
}
