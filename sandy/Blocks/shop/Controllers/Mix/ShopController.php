<?php

namespace Sandy\Blocks\shop\Controllers\Mix;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Mix\Http\Controllers\Base\Controller;
use Sandy\Blocks\shop\Models\Product;
use Sandy\Blocks\shop\Models\ProductOrder;
use Carbon\Carbon;

class ShopController extends Controller
{
    public function index(Request $request){
        $workspaceId = session('active_workspace_id');
        $products = Product::where('workspace_id', $workspaceId)->orderBy('position', 'ASC')->orderBy('id', 'ASC')->get();
        $sales = $this->sales_analytics($request);

        return view('Blocks-shop::mix.index', ['products' => $products, 'sales' => $sales]);
    }


    public function sort(Request $request){
        foreach($request->data as $key) {
            $key['id'] = (int) $key['id'];
            $key['position'] = (int) $key['position'];
            $update = Product::find($key['id']);
            $update->position = $key['position'];
            $update->save();
        }
    }
    
    public function sales_analytics($request){
        $start_date = Carbon::now(settings('others.timezone'))->subDays(30)->format('Y-m-d');
        $end_date = Carbon::now(settings('others.timezone'))->format('Y-m-d');

        // Query
        if (!empty($request->get('start_date'))) {
            if (validate_date_string($request->get('start_date'))) {
                $start_date = Carbon::parse($request->get('start_date'));
            }
        }

        if (!empty($request->get('end_date'))) {
            if (validate_date_string($request->get('end_date'))) {
                $end_date = Carbon::parse($request->get('end_date'));
            }
        }

        $end_date = Carbon::parse($end_date)->addDays(1)->format('Y-m-d');

        $workspaceId = session('active_workspace_id');
        $query_payments = ProductOrder::whereBetween('created_at', [$start_date, $end_date])->where('workspace_id', $workspaceId)->get();

        // Payments
        $payments = [];

        // Loop Payments
        foreach ($query_payments as $item) {
            $date = Carbon::parse($item->created_at)->toFormattedDateString();
            if (!array_key_exists($date, $payments)) {
                $payments[$date] = [
                    'payments' => 0,
                    'earnings' => 0
                ];
            }

            if (array_key_exists($date, $payments)) {
                $payments[$date]['payments']++;
                $payments[$date]['earnings'] += $item->price;
            }
        }
        $payments = get_chart_data($payments);

        // Total Earnings
        $workspaceId = session('active_workspace_id');
        $totalEarningsModels = ProductOrder::where('workspace_id', $workspaceId)->get();
        $totalEarnings = 0;

        foreach ($totalEarningsModels as $item) {
            $totalEarnings = (float) ($totalEarnings + $item->price);
        }

        return ['payments' => $payments, 'totalEarnings' => $totalEarnings];
    }
}
