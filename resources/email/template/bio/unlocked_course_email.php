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
                    <strong style="box-sizing:border-box;font-family:'Inter','Helvetica Neue',Helvetica,Arial,sans-serif;font-size:16px;line-height:2;font-weight:600">Page:</strong> <a href="<?=  bio_url($spv->user) ?>"><?= user('name', $spv->user) ?></a><br>
                    <strong style="box-sizing:border-box;font-family:'Inter','Helvetica Neue',Helvetica,Arial,sans-serif;font-size:16px;line-height:2;font-weight:600">Date:</strong> <?= \Carbon\Carbon::parse($spv->created_at)->toFormattedDateString(); ?><br><br>
                </p>


                <div style="box-sizing:border-box;font-family:'Inter','Helvetica Neue',Helvetica,Arial,sans-serif;font-size:16px;line-height:2">
                    <table style="box-sizing:border-box;font-family:'Inter','Helvetica Neue',Helvetica,Arial,sans-serif;font-size:16px;line-height:2;width:100%;margin:20px 0">
                        <tbody style="box-sizing:border-box;font-family:'Inter','Helvetica Neue',Helvetica,Arial,sans-serif;font-size:16px;line-height:2">
                            <tr>
                                <td align="left" width="96" style="box-sizing:border-box;font-family:'Inter','Helvetica Neue',Helvetica,Arial,sans-serif;font-size:16px;line-height:2;margin:0;padding:10px 0;vertical-align:top">
                                    <div style="box-sizing:border-box;font-family:'Inter','Helvetica Neue',Helvetica,Arial,sans-serif;font-size:16px;line-height:2;width:80px;height:60px;border-radius:8px;overflow:hidden;background-color:#f7f7f8;margin-right:16px">


                                        <?php 
                                            $media = '';
                                            if ($course = \App\Models\Course::find(ao($spv->meta, 'course'))) {

                                                $media = media_or_url($course->banner, 'media/courses/banner');
                                                $media = videoOrImage($media, ['attr' => 'style="box-sizing:border-box;font-family:\'Inter\',Helvetica,Arial,sans-serif;font-size:16px;line-height:2;max-width:100%;width:80px;height:60px;object-fit:cover"', 'no_lozad' => true]);
                                            }
                                        ?>
                                        <?= $media ?>

                                    </div>
                                </td>
                                <td align="left" style="box-sizing:border-box;font-family:'Inter','Helvetica Neue',Helvetica,Arial,sans-serif;font-size:16px;line-height:2;margin:0;padding:10px 0;vertical-align:top">
                                    <strong style="box-sizing:border-box;font-family:'Inter','Helvetica Neue',Helvetica,Arial,sans-serif;font-size:16px;line-height:2;font-weight:600"><?= ao($spv->meta, 'item.name') ?></strong>
                                    <p style="margin-top: 5px; font-size: 14px;"><?= ao($spv->meta, 'item.description') ?></p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div style="box-sizing:border-box;font-family:'Inter','Helvetica Neue',Helvetica,Arial,sans-serif;font-size:16px;line-height:2;margin-bottom:40px;border-top:2px solid #25252d;border-bottom:2px solid #25252d">
                    <table style="box-sizing:border-box;font-family:'Inter','Helvetica Neue',Helvetica,Arial,sans-serif;font-size:16px;line-height:2;margin:30px auto;width:100%">
                        <tbody style="box-sizing:border-box;font-family:'Inter','Helvetica Neue',Helvetica,Arial,sans-serif;font-size:16px;line-height:2">
                            <tr>
                                <td align="left" style="box-sizing:border-box;font-family:'Inter','Helvetica Neue',Helvetica,Arial,sans-serif;font-size:16px;line-height:2;margin:0;padding:10px 0;vertical-align:top;padding-top:0;padding-bottom:0">
                                    <strong style="box-sizing:border-box;font-family:'Inter','Helvetica Neue',Helvetica,Arial,sans-serif;font-size:16px;line-height:2;font-weight:600"><?= __('Total') ?></strong>
                                </td>
                                <td align="right" style="box-sizing:border-box;font-family:'Inter','Helvetica Neue',Helvetica,Arial,sans-serif;font-size:16px;line-height:2;margin:0;padding:10px 0;vertical-align:top;padding-top:0;padding-bottom:0">
                                    <strong style="box-sizing:border-box;font-family:'Inter','Helvetica Neue',Helvetica,Arial,sans-serif;font-size:16px;line-height:2;font-weight:600"><?= price_with_cur($spv->currency, $spv->price) ?></strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <a href="<?= \Bio::route($spv->user, 'user-bio-courses-take-course', ['id' => ao($spv->meta, 'course')]) ?>" rel="noopener" style="box-sizing:border-box;font-family:'Inter','Helvetica Neue',Helvetica,Arial,sans-serif;line-height:2;width:100%;font-size:15px;font-weight:700;border-radius:16px/16px;text-align:center;color:#000;padding:10px 24px;margin:0;display:block;overflow:hidden;text-decoration:none;background-color:#e5e7eb" target="_blank"><?= __('Take Course') ?></a>
                <br>
            </td>
        </tr>
    </tbody>
</table>