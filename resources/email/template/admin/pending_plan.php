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
        <p class="welcome-h1" style="font-size: 14px;"><?= __('Manual Payment.') ?></p>

        <p style="font-size: 14px;"><?= __(':user just submitted a request for manual Payment purchasing :plan Plan. Head over to the admin dashboard to see proof and activate plan.', ['user' => '<b>'. $user->name .'</b>', 'plan' => '<b>'. GetPlan('name', $plan) .'</b>']) ?></p>

        <p class="paddding-middle"><?= __("Login For More Info.") ?></p>
        <p class="paddding-middle link" style="font-size: 13px;"><a href="<?= route('user-login') ?>" class="url-url"><?= route('user-login') ?></a></p>
        
        <p style="font-size: 14px; padding-top: 15px;"></p>
</td>
</tr>