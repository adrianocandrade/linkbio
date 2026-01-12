<?php

namespace Modules\Mix\Http\Controllers;

use App\Email;
use App\Blocks;
use App\Payments;
use Carbon\Carbon;
use App\Models\Block;
use App\Models\Highlight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Support\Renderable;
use Modules\Mix\Http\Controllers\Base\Controller;


class MixController extends Controller
{
    
    public function index(Request $request){
        $workspaceId = session('active_workspace_id');
        
        // ✅ Segurança: Sempre validar que workspace da sessão pertence ao usuário
        if ($workspaceId) {
            $workspace = \App\Models\Workspace::where('id', $workspaceId)
                ->where('user_id', $this->user->id)
                ->where('status', 1) // ✅ Verificar status ativo
                ->first();
            
            if (!$workspace) {
                // Workspace inválida na sessão (possível manipulação), resetar
                session()->forget('active_workspace_id');
                $workspaceId = null;
            }
        }
        
        // Ensure we have a valid workspace context
        if (!$workspaceId) {
             $default = \App\Models\Workspace::where('user_id', $this->user->id)
                 ->where('status', 1) // ✅ Apenas workspaces ativas
                 ->orderBy('created_at', 'asc')
                 ->first();
             if ($default) {
                 $workspaceId = $default->id;
                 session(['active_workspace_id' => $workspaceId]);
             }
        }

        // Get active workspace
        $activeWorkspace = \App\Models\Workspace::where('id', $workspaceId)
            ->where('user_id', $this->user->id)
            ->where('status', 1) // ✅ Verificar status ativo
            ->first();

        $blocks = Block::where('user', $this->user->id)
                ->where('workspace_id', $workspaceId)
                ->orderBy('position', 'ASC')
                ->orderBy('id', 'DESC')
                ->get();
        $highlights = Highlight::where('user', $this->user->id)
                ->where('workspace_id', $workspaceId)
                ->get();
        $socials = \App\User::ordered_social($this->user->id);
        $products_chart = $this->products_chart();
        $visitor_chart = $this->profile_visits();

        return view('mix::index', [
            'socials' => $socials, 
            'blocks' => $blocks, 
            'highlights' => $highlights, 
            'products_chart' => $products_chart, 
            'visitor_chart' => $visitor_chart,
            'active_workspace' => $activeWorkspace
        ]);
    }


    public function profile_visits(){
        $workspaceId = session('active_workspace_id');
        
        // ✅ Segurança: Validar workspace da sessão
        if ($workspaceId) {
            $workspace = \App\Models\Workspace::where('id', $workspaceId)
                ->where('user_id', $this->user->id)
                ->where('status', 1)
                ->first();
            
            if (!$workspace) {
                $workspaceId = null;
            }
        }
        $start_date = Carbon::now(settings('others.timezone'))->startOfMonth()->toDateString();
        $end_date = Carbon::now(settings('others.timezone'))->endOfMonth()->toDateString();
        
        $visitorsQuery = \App\Models\Visitor::where('user', $this->user->id);
        if ($workspaceId) {
            $visitorsQuery->where('workspace_id', $workspaceId);
        }
        $visitors = $visitorsQuery->get();
        
        // Views
        $getviews = [];
        $views = 0;
        $unique = 0;

        $thisMonthViews = 0;
        foreach ($visitors as $item) {
            $unique++;
            $views += $item->views;
        }

        $getviews = [
            'visits' => $views,
            'unique' => $unique,
        ];


        $start_of_year = \Carbon\Carbon::now()->startOfYear()->toDateString();
        $visitors_this_yearQuery = \App\Models\Visitor::where('user', $this->user->id)
            ->whereBetween('created_at', [$start_date, $end_date]);
        if ($workspaceId) {
            $visitors_this_yearQuery->where('workspace_id', $workspaceId);
        }
        $visitors_this_year = $visitors_this_yearQuery->get();

        $current_month = \Carbon\CarbonPeriod::create($start_date, $end_date);


        // Get This Year Views
        
        $visitors = [];
        
        foreach ($current_month as $key => $value) {
            $date = $value->toFormattedDateString();
            if (!array_key_exists($date, $visitors)) {
                $visitors[$date] = [
                    'visits' => 0,
                    'unique' => 0,
                ];
            }
        }

        foreach ($visitors_this_year as $item) {
            $date = Carbon::parse($item->created_at)->toFormattedDateString();
            if (!empty($date) && !array_key_exists($date, $visitors)) {
                $visitors[$date] = [
                    'visits' => 0,
                    'unique' => 0,
                ];
            }

            if (array_key_exists($date, $visitors)) {
                $visitors[$date]['unique']++;
                $visitors[$date]['visits'] += $item->views;
            }
            $thisMonthViews += $item->views;
        }
        $visitors = get_chart_data($visitors);

        
        return ['visitors' => $visitors, 'views' => $views, 'thisMonthViews' => $thisMonthViews];
    }


    public function products_chart(){
        if(!Blocks::has('shop')){
            return [];
        }

        $start_date = Carbon::now(settings('others.timezone'))->startOfMonth()->toDateString();
        $end_date = Carbon::now(settings('others.timezone'))->endOfMonth()->toDateString();

        $end_date = Carbon::parse($end_date)->addDays(1)->format('Y-m-d');

        $query_payments = \Sandy\Blocks\shop\Models\ProductOrder::whereBetween('created_at', [$start_date, $end_date])->where('user', $this->user->id)->get();

        // Payments
        $payments = [];
        
        $current_month = \Carbon\CarbonPeriod::create($start_date, $end_date);

        foreach ($current_month as $key => $value) {
            $date = $value->toFormattedDateString();
            if (!array_key_exists($date, $payments)) {
                $payments[$date] = [
                    'payments' => 0,
                    'earnings' => 0
                ];
            }
        }

        // Loop Payments

        foreach ($query_payments as $item) {
            $date = Carbon::parse($item->created_at)->toFormattedDateString();
            if (array_key_exists($date, $payments)) {
                $payments[$date]['payments']++;
                $payments[$date]['earnings'] += $item->price;
            }
        }

        $payments = get_chart_data($payments);
        // Total Earnings
        $totalEarningsModels = \Sandy\Blocks\shop\Models\ProductOrder::where('user', $this->user->id)->get();
        $totalEarnings = 0;

        foreach ($totalEarningsModels as $item) {
            $totalEarnings = (float) ($totalEarnings + $item->price);
        }

        
        $totalEarningsModels = \Sandy\Blocks\shop\Models\ProductOrder::whereBetween('created_at', [$start_date, $end_date])->where('user', $this->user->id)->get();
        $totalEarningsMonth = 0;

        foreach ($totalEarningsModels as $item) {
            $totalEarningsMonth = (float) ($totalEarningsMonth + $item->price);
        }

        return ['payments' => $payments, 'totalEarnings' => $totalEarnings, 'totalEarningsMonth' => $totalEarningsMonth];
    }
}
