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
<table align="center" width="456" cellpadding="0" cellspacing="0" role="presentation" style="box-sizing:border-box;font-family:'Inter','Helvetica Neue',Helvetica,Arial,sans-serif;font-size:16px;line-height:2;background-color:#ffffff;border-color:#e8e5ef;border-radius:2px;border-width:1px;margin:0 auto;padding:0;width:456px">
    <tbody>
        <tr>
            <td style="box-sizing:border-box;font-family:'Inter','Helvetica Neue',Helvetica,Arial,sans-serif;font-size:16px;line-height:2;max-width:100vw;padding-left:16px;padding-right:16px">



                <p style="box-sizing:border-box;font-family:'Inter','Helvetica Neue',Helvetica,Arial,sans-serif;font-size:16px;line-height:2;margin-top:40px;margin-bottom:40px">
                    <img src="<?= \Bio::emoji('Partying_Face') ?>" alt="" style="box-sizing:border-box;font-family:'Inter','Helvetica Neue',Helvetica,Arial,sans-serif;font-size:16px;line-height:2;max-width:100%;width: 40%;height:auto;display: inline-block;" tabindex="0">

                </p>

                <h1 style="box-sizing:border-box;font-family:'Inter','Helvetica Neue',Helvetica,Arial,sans-serif;font-weight:600;line-height:1.5;margin-bottom:40px;font-size:24px;margin-top:0;text-align:left"><?= __('Thanks for your order!') ?></h1>


                <p style="box-sizing:border-box;font-family:'Inter','Helvetica Neue',Helvetica,Arial,sans-serif;font-size:16px;line-height:2;margin-bottom:40px;margin-top:0;text-align:left">
                    <strong style="box-sizing:border-box;font-family:'Inter','Helvetica Neue',Helvetica,Arial,sans-serif;font-size:16px;line-height:2;font-weight:600">Order ID:</strong> #<?= $order_id ?? '' ?><br>
                    <strong style="box-sizing:border-box;font-family:'Inter','Helvetica Neue',Helvetica,Arial,sans-serif;font-size:16px;line-height:2;font-weight:600">Page:</strong> <a href="<?=  bio_url($order->user) ?>"><?= user('name', $order->user) ?></a><br>


                    <strong style="box-sizing:border-box;font-family:'Inter','Helvetica Neue',Helvetica,Arial,sans-serif;font-size:16px;line-height:2;font-weight:600">Date:</strong> <?= \Carbon\Carbon::parse($order->created_at)->toFormattedDateString(); ?><br><br>
                </p>

            <?php if (is_array($cart = ao($order->extra, 'cart'))): ?>
                <?php foreach ($cart as $key => $value): ?>
                    <?php 
                        $product = \Sandy\Blocks\shop\Models\Product::find(ao($value, 'attributes.product_id'));
                        $banner = $product ? media_or_url($product->banner, 'media/shop/banner') : '';
                        $banner = $product ?  videoOrImage($banner, ['attr' => 'style="box-sizing:border-box;font-family:\'Inter\',Helvetica,Arial,sans-serif;font-size:16px;line-height:2;max-width:100%;width:80px;height:60px;object-fit:cover"', 'no_lozad' => true]) : '';
                    ?>

                    <?php if ($product): ?>
                                
                        <div style="box-sizing:border-box;font-family:'Inter','Helvetica Neue',Helvetica,Arial,sans-serif;font-size:16px;line-height:2">
                            <table style="box-sizing:border-box;font-family:'Inter','Helvetica Neue',Helvetica,Arial,sans-serif;font-size:16px;line-height:2;width:100%;margin:20px 0">
                                <tbody style="box-sizing:border-box;font-family:'Inter','Helvetica Neue',Helvetica,Arial,sans-serif;font-size:16px;line-height:2">
                                    <tr>
                                        <td align="left" width="96" style="box-sizing:border-box;font-family:'Inter','Helvetica Neue',Helvetica,Arial,sans-serif;font-size:16px;line-height:2;margin:0;padding:10px 0;">
                                            <div style="box-sizing:border-box;font-family:'Inter','Helvetica Neue',Helvetica,Arial,sans-serif;font-size:16px;line-height:2;width:80px;height:60px;border-radius:8px;overflow:hidden;background-color:#f7f7f8;margin-right:16px">

                                                <?= $banner ?>

                                            </div>
                                        </td>
                                        <td align="left" style="box-sizing:border-box;font-family:'Inter','Helvetica Neue',Helvetica,Arial,sans-serif;font-size:16px;line-height:2;margin:0;padding:10px 0;vertical-align:top">

                                            <strong style="box-sizing:border-box;font-family:'Inter','Helvetica Neue',Helvetica,Arial,sans-serif;font-size:16px;line-height:2;font-weight:600; margin-bottom: 0;"><?= ao($value, 'name') ?></strong>

                                            <p style="margin-bottom: 0; font-size: 10px;"><?= \Bio::price(ao($value, 'price'), $order->user) ?> x<?= ao($value, 'quantity') ?></p>

                                            <?php if (!empty(ao($value, 'attributes.options'))): ?>
                                                <p style="margin-top: 1px; font-size: 10px;"><?= ao($value, 'attributes.options.name') ?></p>
                                            <?php endif ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    <?php endif ?>
                <?php endforeach ?>
            <?php endif ?>
                <div style="box-sizing:border-box;font-family:'Inter','Helvetica Neue',Helvetica,Arial,sans-serif;font-size:16px;line-height:2;margin-bottom:40px;border-top:2px solid #25252d;border-bottom:2px solid #25252d">
                    <table style="box-sizing:border-box;font-family:'Inter','Helvetica Neue',Helvetica,Arial,sans-serif;font-size:16px;line-height:2;margin:30px auto;width:100%">
                        <tbody style="box-sizing:border-box;font-family:'Inter','Helvetica Neue',Helvetica,Arial,sans-serif;font-size:16px;line-height:2">
                            <tr>
                                <td align="left" style="box-sizing:border-box;font-family:'Inter','Helvetica Neue',Helvetica,Arial,sans-serif;font-size:16px;line-height:2;margin:0;padding:10px 0;vertical-align:top;padding-top:0;padding-bottom:0">
                                    <strong style="box-sizing:border-box;font-family:'Inter','Helvetica Neue',Helvetica,Arial,sans-serif;font-size:16px;line-height:2;font-weight:600"><?= __('Total') ?></strong>
                                </td>
                                <td align="right" style="box-sizing:border-box;font-family:'Inter','Helvetica Neue',Helvetica,Arial,sans-serif;font-size:16px;line-height:2;margin:0;padding:10px 0;vertical-align:top;padding-top:0;padding-bottom:0">
                                    <strong style="box-sizing:border-box;font-family:'Inter','Helvetica Neue',Helvetica,Arial,sans-serif;font-size:16px;line-height:2;font-weight:600"><?= price_with_cur($order->currency, $order->price) ?></strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                    <div style="font-size: 10px; margin-top: 5px;"><?= __('Visit the purchased product page to view order.') ?></div>
                <br>
            </td>
        </tr>
    </tbody>
</table>