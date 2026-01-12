<?php

namespace Sandy\Blocks\shop\Controllers\Bio;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Bio\Http\Controllers\Base\Controller;
use Sandy\Blocks\shop\Models\StoreSetting;
use Sandy\Blocks\shop\Traits\UserBioShop;
use Sandy\Blocks\shop\Models\Product;
use Sandy\Blocks\shop\Models\ProductOption;
use Sandy\Blocks\shop\Models\ProductReview;

class ProductController extends Controller{
    use UserBioShop;

    public function single(Request $request){
        if (!plan('settings.block_shop', $this->bio->id)) {
            abort(404);
        }
        
        // Get workspace_id from bio's default workspace
        $workspace = \App\Models\Workspace::where('user_id', $this->bio->id)
            ->where('is_default', 1)
            ->first();
        
        if (!$workspace) {
            abort(404, 'No workspace found');
        }
        
        if (!$product = Product::where('id', $request->id)->where('workspace_id', $workspace->id)->first()) {
            abort(404);
        }


        $has_order = $this->has_purchased($this->bio->id, $product->id);

        $user_orders = $this->user_orders($this->bio->id, $product->id);

        $variant = ProductOption::where('product_id', $product->id)->where('workspace_id', $workspace->id)->orderBy('position', 'ASC')->orderBy('id', 'DESC')->get();
        $review = ProductReview::where('workspace_id', $workspace->id)->where('product_id', $product->id)->orderBy('id', 'DESC')->get();

        return view('Blocks-shop::bio.product.single', ['product' => $product, 'variant' => $variant, 'has_order' => $has_order, 'review' => $review, 'user_orders' => $user_orders]);
    }

    public function post_review(Request $request){
        // Get workspace_id from bio's default workspace
        $workspace = \App\Models\Workspace::where('user_id', $this->bio->id)
            ->where('is_default', 1)
            ->first();
        
        if (!$workspace) {
            abort(404, 'No workspace found');
        }
        
        if (!$product = Product::where('workspace_id', $workspace->id)->where('id', $request->id)->first()) {
            abort(404);
        }

        if (!$has_order = $this->has_purchased($this->bio->id, $request->id)) {
            return back()->with('info', __('Please purchase this product to leave a review.'));
        }

        if (!$user = \Auth::user()) {
            return back()->with('info', __('Login to continue'));
        }

        $request->validate([
            'review' => 'max:500'
        ]);

        if (ProductReview::where('workspace_id', $workspace->id)->where('reviewer_id', $user->id)->where('product_id', $product->id)->first()) {
            return back()->with('error', __('Cannot repost another review.'));
        }

        $review = new ProductReview;
        $review->user = $this->bio->id;
        $review->workspace_id = $workspace->id;
        $review->reviewer_id = $user->id;
        $review->product_id = $product->id;
        $review->rating = $request->rating;
        $review->review = $request->review;
        $review->save();


        return back()->with('success', __('Review submitted.'));
    }
}