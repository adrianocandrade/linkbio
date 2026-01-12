<style>
    .t-button{
        padding: 15px 30px 15px 30px;
        font-size: 15px;
        font-weight: bold;
        color: #fff;
        background: #000;
        display: inline-block;
    }
    .welcome-h1{
        font-size: 14px;
        font-family: sans-serif;
    }
    .paddding-middle{
        padding: 5px 0;
        margin: 0;
        display: block;
        font-family: sans-serif;
        font-size: 13px;
    }
</style>
<tr>
    <td style="padding: 10px 30px 0;">
        <h1 class="welcome-h1" style="font-size: 16px;"><?= __('Leaving already? 🤔') ?></h1>

        <p style="font-size: 14px;"><?= __('Hi :user, this is to let your know your plan will soon expiry. Login below to renew your plan so you dont miss out on what our pro plan offers.', ['user' => '<b>'. $user->name .'</b>', 'plan' => '<b>'. GetPlan('name', $plan) .'</b>']) ?></p>

         <a href="<?= route('user-login') ?>" style="background-color:#000;border-radius:0;color:#ffffff;display:block;font-size:15px;text-align:center;text-decoration:none;text-transform: uppercase; padding: 15px 30px 15px 30px;"><?= __('Login!') ?></a>
        <p style="font-size: 14px; padding-top: 15px;"></p>
</td>
</tr>