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
        <p style="font-size: 14px; padding: 15px 0;"><?= __('Hi :name, We are excited to have you join :website. To begin exploring the awesome features our platform has to offer, please take a moment to activate your account by taping the “Activate” button below.', ['name' => '<b>'. $user->name .'</b>', 'website' => config('app.name')]) ?></p>
        

         <a href="<?= route('user-activate-email', $user->emailToken ?? '') ?>" style="background-color:#000;border-radius:0;color:#ffffff;display:block;font-size:15px;text-align:center;text-decoration:none;text-transform: uppercase; padding: 15px 30px 15px 30px;"><?= __('Activate') ?></a>


         <p style="padding: 15px 0; font-size: 13px;"><?= __('Click or copy the link below to activate your account.') ?></p>

         <p style="margin-top: 10px;"><?= __('Or') ?></p>

         <p style="padding: 15px 0; font-size: 14px;"><a href="<?= route('user-activate-email', $user->emailToken ?? '') ?>"><?= route('user-activate-email', $user->emailToken ?? '') ?></a></p>

    </td>
</tr>