<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PragmaRX\Google2FA\Google2FA;
use App\Models\User;

class TwoFactorController extends Controller
{
    public function index()
    {
        if (!session()->has('2fa:user:id')) {
            return redirect('/auth/login');
        }

        return view('auth.2fa');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required',
        ]);

        if (!session()->has('2fa:user:id')) {
            return redirect('/auth/login');
        }

        $userId = session()->get('2fa:user:id');
        $user = User::find($userId);

        if (!$user) {
             return redirect('/auth/login');
        }

        $google2fa = new Google2FA();
        
        // Add window to prevent sync issues (1 = 30s before/after)
        $valid = $google2fa->verifyKey($user->google2fa_secret, $request->code, 1);

        if ($valid) {
            auth()->login($user);
            session()->forget('2fa:user:id');
            
            if (function_exists('logActivity')) {
                logActivity($user->email, 'Login', __('Successful Login (2FA)'));
            }
            
            // Check for plan (logic copied/adapted from LoginController)
            if (!$this->checkPlan($user)) {
                return redirect()->route('user-mix-no-plan')->with('success', __('No plan found.'));
            }

            return redirect()->route('user-mix');
        }

        return back()->with('error', __('Invalid code.'));
    }

    protected function checkPlan($user)
    {
        // Re-use logic from LoginController logic (simplified)
        // Ideally this should be a service or helper
        if (!$plan_user = \App\Models\PlansUser::where('user_id', $user->id)->first()) {
            $plan = \App\Models\Plan::where('defaults', 1)->where('status', 1)->where('price_type', 'free')->first();

            if ($plan && function_exists('ActivatePlan')) {
                ActivatePlan($user->id, $plan->id, null);
                return true;
            }
            return false;
        }
        return true;
    }
}
