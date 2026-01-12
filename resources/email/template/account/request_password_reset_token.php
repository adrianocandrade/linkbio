<style>
    .t-button{
        padding: 15px 30px 15px 30px;
        font-size: 15px;
        font-weight: bold;
        color: #fff;
        background: #000;
        display: inline-block;
    }
</style>
<tr>
    <td style="padding: 10px 30px 0;">
        <p style="font-size: 14px; padding: 15px 0;"><?= __('Hey :name, did you request a password reset from :website_name? This email contains a password reset link that will help you change your password. If you did not make the request, please ignore this email.', ['name' => $user->name, 'website_name' => config('app.name')]) ?></p>

         <a href="<?= route('user-login-reset-pw', $token ?? '') ?>" style="background-color:#000;border-radius:15px;color:#ffffff;display:block;font-size:15px;text-align:center;text-decoration:none;text-transform: uppercase; padding: 15px 30px 15px 30px;"><?= __('Reset') ?></a>


         <p style="margin-top: 10px;"><?= __('Or simply copy and paste this link in a secure browser to activate your account.') ?></p>

         <p style="padding: 15px 0; font-size: 14px;"><a href="<?= route('user-login-reset-pw', $token ?? '') ?>"><?= route('user-login-reset-pw', $token ?? '') ?></a></p>

    </td>
</tr>