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
        <h1 class="welcome-h1" style="font-size: 16px;"><?= __('Welcome aboard. 🎉') ?></h1>

        <p style="font-size: 14px;"><?= __('Hey :user, you’re a :plan member now. You know what that means? You now have access to the following features:', ['user' => '<b>'. $user->name .'</b>', 'plan' => '<b>'. GetPlan('name', $plan) .'</b>']) ?></p>

        <?php
            $skeleton = getOtherResourceFile('plan');
            foreach ($skeleton as $key => $value) {
                if (ao(GetPlan('settings', $plan), $key)) {
                    echo  '<p><b>'. ao($value, 'name') .'</b></p>';
                }
            }
        ?>

        <p class="useful-link" style="font-size: 17px; font-weight: bold; padding: 15px 0;"><?= __('Useful Links') ?></p>

        <p class="paddding-middle"><?= __("Looking for where to login?") ?></p>
        <p class="paddding-middle link" style="font-size: 13px;"><a href="<?= route('user-login') ?>" class="url-url"><?= route('user-login') ?></a></p>
        
        <p style="font-size: 14px; padding-top: 15px;"></p>
</td>
</tr>