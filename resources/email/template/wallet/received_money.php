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
.currency-payment {
display: flex;
}
.currency-value{
font-weight: 700;
font-size: 64px;
line-height: 1;
letter-spacing: -0.02em;
color: #23262F;
}
.currency-sign{
font-size: 24px;
}
</style>
<tr>
    <td style="padding: 10px 30px 0; text-align: center;">
        <h1 style="box-sizing:border-box;font-family:'Inter','Helvetica Neue',Helvetica,Arial,sans-serif;font-weight:600;line-height:1.5;margin-bottom:40px;font-size:24px;margin-top:0;text-align:center"><?= __('Woohoo! You made a sale!') ?></h1>

        <div class="currency-payment is-price">
            <div class="currency-field w-full">
                <p style="box-sizing:border-box;font-family:'Inter','Helvetica Neue',Helvetica,Arial,sans-serif;font-size:60px;line-height:2;margin-bottom:40px;margin-top:0;color: #23262F;font-weight: 700;">

                    <strong style="box-sizing:border-box;font-family:'Inter','Helvetica Neue',Helvetica,Arial,sans-serif;font-size:16px;line-height:2;font-weight:600"><?= \Currency::symbol($spv->currency) ?></strong> <?= nr($spv->price) ?><br>
                </p>
            </div>
        </div>

        <?php if ($payee = \App\User::find($spv->payee_user_id)): ?>
            
        <p style="box-sizing:border-box;font-family:'Inter','Helvetica Neue',Helvetica,Arial,sans-serif;font-size:16px;line-height:2;margin-bottom:40px;margin-top:0;text-align:center; margin-top: 15px;">
            <strong style="box-sizing:border-box;font-family:'Inter','Helvetica Neue',Helvetica,Arial,sans-serif;font-size:16px;line-height:2;font-weight:600"><?= $payee->name  ?></strong>
            <?= ao($spv->meta, 'item.processed_description') ?>
        </p>
        <?php endif ?>
        
        <p style="font-size: 14px; padding-top: 15px;"></p>
    </td>
</tr>