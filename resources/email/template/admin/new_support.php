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
        <h1 class="welcome-h1" style="font-size: 17px;"><?= __('New support request.') ?></h1>


        <p style="padding-bottom: 18px; padding-top: 15px;"><?= __('Subject') ?> - "<?= $subject ?>"</p>
        <p><?= __('Description') ?> - "<?= $description ?>"</p>


        <p style="padding-top: 50px;"><?= __('From: email - :user_email, name - :user_name', ['user_email' => $user->email, 'user_name' => $user->name]) ?></p>

        <p style="padding-top: 50px;"><?= __('Login to your admin dashboard to respond to this support ticket.') ?></p>

        <p style="font-size: 14px; padding-top: 15px;"></p>
</td>
</tr>