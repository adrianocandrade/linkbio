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
        <h1 class="welcome-h1" style="font-size: 16px;"><?= __('Sad to see you leave! 🥺') ?></h1>

        <p style="font-size: 14px;"><?= __('Hey :user, We are here to inform you your :plan plan has expired and you would miss out on the features below. You can login to renew your plan & continue to enjoy these features.', ['user' => '<b>'. $user->name .'</b>', 'plan' => '<b>'. GetPlan('name', $plan) .'</b>']) ?></p>

        <?php
            $skeleton = getOtherResourceFile('plan');
            foreach ($skeleton as $key => $value) {
                if (ao(GetPlan('settings', $plan), $key)) {
                    echo  '<p><b>'. ao($value, 'name') .'</b></p>';
                }
            }
        ?>
        
        <p style="font-size: 14px; padding-top: 15px;"></p>
         <a href="<?= route('user-login') ?>" style="background-color:#000;border-radius:0;color:#ffffff;display:block;font-size:15px;text-align:center;text-decoration:none;text-transform: uppercase; padding: 15px 30px 15px 30px;"><?= __('Login!') ?></a>
        <p style="font-size: 14px; padding-top: 15px;"></p>
</td>
</tr>