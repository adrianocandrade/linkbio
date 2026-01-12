<?php

namespace Modules\Bio\Http\Traits;
use Illuminate\Http\Request;
use App\Traits\UserBioInfo;
use App\Models\StoreSetting;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;
use App\Models\CoursesOrder;

trait Courses {
    
    public function sales_analytics($request){
    	if (!$auth = \Auth::user()) {
    		return false;
    	}

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

        $query_payments = CoursesOrder::whereBetween('created_at', [$start_date, $end_date])->where('user', $auth->id)->get();

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
        $totalEarningsModels = CoursesOrder::where('user', $auth->id)->get();
        $totalEarnings = 0;

        foreach ($totalEarningsModels as $item) {
            $totalEarnings = (float) ($totalEarnings + $item->price);
        }

        return ['payments' => $payments, 'totalEarnings' => $totalEarnings];
    }
}