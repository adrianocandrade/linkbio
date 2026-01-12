<?php

namespace Modules\Mix\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Mix\Http\Controllers\Base\Controller;

class AccountController extends Controller
{
    /**
     * Display account dashboard
     */
    public function index()
    {
        $user = auth()->user();
        return view('mix::account.index', compact('user'));
    }
    
    /**
     * Show profile edit form
     */
    public function profile()
    {
        $user = $this->user;
        $countries = getCountries();
        
        return view('mix::account.sections.profile', ['countries' => $countries]);
    }
    
    /**
     * Update profile
     */
    public function profilePost(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$this->user->id,
        ]);
        
        $user = \App\User::find($this->user->id);
        $user->name = $request->name;
        $user->email = $request->email;
        
        if ($request->filled('country')) {
            $user->country = $request->country;
        }
        
        $user->save();
        
        return back()->with('success', __('Profile updated successfully'));
    }
    
    /**
     * Show payment methods
     */
    public function method()
    {
        $payment = new \App\Payments;
        $payments = $payment->getInstalledMethods();

        // Save array without error
        $getItem = function($array, $key){
            app('config')->set('array-temp', $array);
            $key = !empty($key) ? '.'.$key : null;
            return app('config')->get('array-temp'. $key);
        };

        unset($payments['manual']);

        return view('mix::account.sections.method', ['payments' => $payments, 'getItem' => $getItem]);
    }
    
    /**
     * Show plan history
     */
    public function planHistory()
    {
        $history = \App\Models\PlanPayment::where('user', $this->user->id)->orderBy('id', 'DESC')->get();
        
        return view('mix::account.sections.plan-history', ['history' => $history]);
    }
    
    /**
     * Show authentication activities
     */
    public function authactivity()
    {
        $activity = \App\Models\Authactivity::where('user', $this->user->id)
            ->orderBy('id', 'DESC')
            ->get()
            ->groupBy(function($type) {
                return $type->type;
            })
            ->toArray();
        
        asort($activity);
        
        $activity = json_decode(json_encode($activity));
        
        return view('mix::account.sections.activities', ['activity' => $activity]);
    }
    
    /**
     * Show password change form
     */
    public function password()
    {
        return view('mix::account.sections.password');
    }
    
    /**
     * Update password
     */
    public function passwordPost(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);
        
        if (!\Hash::check($request->old_password, $this->user->password)) {
            return back()->with('error', __('Current password is incorrect'));
        }
        
        $user = \App\User::find($this->user->id);
        $user->password = \Hash::make($request->password);
        $user->save();
        
        return back()->with('success', __('Password updated successfully'));
    }
    
    /**
     * Delete user account
     */
    public function deleteAccount(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);
        
        if (!\Hash::check($request->password, $this->user->password)) {
            return back()->with('error', __('Password is incorrect'));
        }
        
        // Use backup service to delete account
        $backupService = new \App\Services\UserBackupService();
        $backupService->deleteUserAccount($this->user->id);
        
        // Logout
        \Auth::logout();
        
        return redirect('/')->with('success', __('Account deleted successfully'));
    }
}
