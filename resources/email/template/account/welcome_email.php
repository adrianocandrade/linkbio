<style>
    .t-button{
        padding: 15px 30px 15px 30px;
        font-size: 15px;
        font-weight: bold;
        color: #fff;
        background: #000;
        display: inline-block;
    }

    .bold{
        font-weight: bold;
    }

    .welcome-h1{
        font-size: 19px;
        font-family: sans-serif;
    }

    .paddding-middle{
        padding: 13px 0;
        margin: 0;
        display: block;
        font-family: sans-serif;
        font-size: 13px;
    }

    .useful-link{
        margin: 0;
    }

    .paddding-middle.link{
        color: #7e8ff5;
        text-decoration: underline;
        font-size: 12px;
    }
</style>
<tr>
    <td style="padding: 10px 30px 0;">
        <p style="font-size: 14px;"><?= __('Hey :user_name, thanks for signing up to :website_name. We are excited to have you join our platform. Enjoy the awesome features that comes with :website_name. Want to see even more? Upgrade Here.', ['user_name' => $user->name, 'website_name' => config('app.name')]) ?></p>


        <p class="useful-link" style="font-size: 17px; font-weight: bold; padding: 15px 0;"><?= __('Useful Links') ?></p>

        <p class="paddding-middle"><?= __("Here is the link to your bio page.", ['user_name' => "<b>$user->name</b>"]) ?></p>

        <p class="paddding-middle link" style="font-size: 13px;"><a href="<?= bio_url($user->id) ?>" class="url-url"><?= bio_url($user->id) ?></a></p>

        <p class="paddding-middle"><?= __("Looking for where to login? ") ?></p>

        <p class="paddding-middle link" style="font-size: 13px;"><a href="<?= route('user-login') ?>" class="url-url"><?= route('user-login') ?></a></p>

        <p class="useful-link" style="font-size: 17px; font-weight: bold; padding: 15px 0;"><?= __('What\'s next?') ?></p>

        <p style="font-size: 14px;"><?= __('Keep an eye on your inbox because we would be sending you tips on how to improve your bio page for max experience.') ?></p>

        <p class="paddding-middle link" style="font-size: 13px;"><a href="<?= route('pricing-index') ?>" class="url-url"><?= __('Checkout our pricing to get started.') ?></a></p>
</td>
</tr>