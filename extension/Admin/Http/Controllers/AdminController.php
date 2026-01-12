<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\User;
use App\Models\PlanPayment;
use App\Models\Visitor;
use App\Models\PendingPlan;
use App\Models\Plan;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(){
        $analytics = $this->analytics();

        return view('admin::index', ['analytics' => $analytics]);
    }


    private function analytics(){
        // Analytics
        $analytics = [];

        $currency = settings('payment.currency');

        // Init required variables
        $startOfWeek = Carbon::now(settings('others.timezone'))->subDay()->startOfWeek()->toDateString();

        // Start of month
        $startOfMonth = Carbon::now(settings('others.timezone'))->startOfMonth()->toDateString();

        // Get New Users
        $newusers = User::where('created_at', '>=', $startOfWeek)
                    ->limit(5)
                    ->orderBy('id', 'DESC')
                    ->get();


        // Count Users
        $count_users = User::count();


        // Get Top Users
        $topUsers = Visitor::topUsers();
        $topUsers = array_slice($topUsers, 0, 5);

        // Get User of the month Users
        $user_of_the_month = Visitor::topUsers();
        $user_of_the_month = array_slice($user_of_the_month, 0, 1);


        // New Payments
        $newPayments = PlanPayment::where('created_at', '>=', $startOfMonth)->limit(5)->orderBy('id', 'DESC')->get();

        // Pending
        $pending_plan = PendingPlan::where('status', 0)->count();

        // This Months earnings
        $thisMonthsEarningsModels = PlanPayment::where('created_at', '>=', $startOfMonth)->get();
        $thisMonthsEarnings = 0;

        foreach ($thisMonthsEarningsModels as $item) {
            $thisMonthsEarnings = ($thisMonthsEarnings + $item->price);
        }

        // This Months earnings
        $totalEarningsModels = PlanPayment::get();
        $totalEarnings = 0;

        foreach ($totalEarningsModels as $item) {
            $totalEarnings = ($totalEarnings + $item->price);
        }


        // PaymentsCount
        $payments_count = PlanPayment::count();

        // PaymentsCount
        $plans_count = Plan::count();

        //
        $analytics = ['count_users' => $count_users, 'newusers' => $newusers, 'topUsers' => $topUsers, 'newPayments' => $newPayments, 'pending_plan' => $pending_plan, 'thisMonthsEarnings' => $thisMonthsEarnings, 'totalEarnings' => $totalEarnings, 'payments_count' => $payments_count, 'plans_count' => $plans_count, 'user_of_the_month' => $user_of_the_month];

        // Return analytics
        return $analytics;
    }
}
