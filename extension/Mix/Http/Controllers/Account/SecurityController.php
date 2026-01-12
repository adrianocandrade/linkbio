<?php

namespace Modules\Mix\Http\Controllers\Account;

use Illuminate\Http\Request;
use Modules\Mix\Http\Controllers\Base\Controller;
use PragmaRX\Google2FA\Google2FA;

class SecurityController extends Controller
{
    /**
     * Show 2FA Settings
     */
    public function index()
    {
        $user = auth()->user();
        $google2fa = new Google2FA();
        
        $data = [
            'user' => $user,
            'secret' => $user->google2fa_secret,
            'QR_Url' => null
        ];

        if (!$user->google2fa_enabled) {
            // Generate secret if not exists
            if (empty($user->google2fa_secret)) {
                $user->google2fa_secret = $google2fa->generateSecretKey();
                $user->save();
            }

            // Generate the QR code URL (otpauth://...)
            $data['QR_Url'] = $google2fa->getQRCodeUrl(
                config('app.name'),
                $user->email,
                $user->google2fa_secret
            );
            
            $data['secret'] = $user->google2fa_secret;
        }

        return view('mix::account.security.index', $data);
    }

    /**
     * Enable 2FA
     */
    public function enable(Request $request)
    {
        $user = auth()->user();
        $google2fa = new Google2FA();

        $request->validate([
            'verify-code' => 'required',
        ]);

        $valid = $google2fa->verifyKey($user->google2fa_secret, $request->get('verify-code'));

        if ($valid) {
            $user->google2fa_enabled = 1;
            $user->save();
            
            // Log activity
            if (function_exists('logActivity')) {
                logActivity($user->email, 'Security', 'Enabled 2FA');
            }

            return redirect()->back()->with('success', __('Two-Factor Authentication has been enabled successfully.'));
        }

        return redirect()->back()->with('error', __('Invalid verification code. Please try again.'));
    }

    /**
     * Disable 2FA
     */
    public function disable(Request $request)
    {
        $request->validate([
            'current-password' => 'required',
        ]);
        
        $user = auth()->user();
        
        if (!\Hash::check($request->get('current-password'), $user->password)) {
            return redirect()->back()->with('error', __('Your password does not match.'));
        }

        $user->google2fa_enabled = 0;
        $user->google2fa_secret = null; // Optional: clear secret
        $user->save();

        // Log activity
        if (function_exists('logActivity')) {
            logActivity($user->email, 'Security', 'Disabled 2FA');
        }

        return redirect()->back()->with('success', __('Two-Factor Authentication has been disabled.'));
    }
}
