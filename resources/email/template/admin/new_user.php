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
        <h1 class="welcome-h1" style="font-size: 14px;"><?= __('A new user registration just occurred.') ?></h1>

        <p class="useful-link" style="font-size: 15px; font-weight: bold; padding: 25px 0 0 0; margin: 0;"><?= __('User:') ?></p>

        <p class="paddding-middle"><?= __("Email - :email", ['email' => $user->email]) ?></p>
        <p class="paddding-middle"><?= __("Username - :username", ['username' => $user->username]) ?></p>
        
        <p style="font-size: 14px; padding-top: 15px;"></p>
</td>
</tr>