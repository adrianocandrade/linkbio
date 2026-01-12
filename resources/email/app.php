<!doctype html>
<html>
    <head>
        <meta name="viewport" content="width=device-width" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title></title>
        <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap');
        .table-body{
        background: #f6f6f6;
        background-color: #fff;
        width: 100%;
        }
        .table-container{
        display: block;
        margin: 0 auto !important;
        max-width: 600px;
        padding: 0px;
        width: 600px;
        }
        .table-main{
        background: #ffffff;
        border-radius: 3px;
        width: 100%;
        }
        .table-content{
        box-sizing: border-box;
        display: block;
        margin: 0 auto;
        max-width: 580px;
        padding: 4px;
        }
        .table-footer{
        clear: both;
        text-align: center;
        width: 100%;
        background-color: #171819;
        padding: 20px 0;
        font-size: 10px;
        }
        p, ul, ol{
        font-family: sans-serif;
        font-size: 16px;
        font-weight: normal;
        margin: 0;
        line-height: 24px;
        margin-bottom: 15px;
        }
        .logo-container{
        padding: 60px 20px 20px;
        }
        .color-white{
        color: #fff;
        }
        .automate-message{
        font-size:12px;
        line-height:20px;
        text-align:left;
        color:#afafaf;
        }
        .main-wrapper table{
        width: 100%;
        }
        </style>
    </head>
    <body class="">
        <table class="table-body" role="presentation" cellspacing="0" cellpadding="0" border="0">
            <tbody>
                <tr>
                    <td>&nbsp;</td>
                    <td class="table-container" role="content-container">
                        <div class="table-content" role="module">
                            <table class="table-main" role="presentation module">
                                <tbody>
                                    <tr>
                                        <td class="main-wrapper" role="modules-container">
                                            <table role="presentation module-content" cellspacing="0" cellpadding="0" border="0">
                                                <tbody>
                                                    <tr>
                                                        <td align="center">
                                                            <div class="logo-container">
                                                                <img alt="[WEBSITE_NAME]" src="[LOGO]" style="height:25px">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="center">
                                                            <h1 style="font-family:sans-serif;font-size:28px;margin-bottom:20px">&nbsp;</h1>
                                                        </td>
                                                    </tr>
                                                    <tr role="module-content">
                                                        <td>
                                                            <table role="presentation module" cellspacing="0" cellpadding="0" border="0">
                                                                <tbody>
                                                                    [CONTENT]
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    
                                </tbody>
                            </table>

                            <div class="table-footer" style="border-radius: 1rem;">
                                <table role="presentation module" cellspacing="0" cellpadding="0" border="0">
                                    <tbody>
                                        <tr>
                                            <td style="text-align:left;padding:30px; width: 100%">
                                                <p class="color-white automate-message"><?= __('This is an automated message. You are receiving this email because you have a registerd account with [WEBSITE_NAME].') ?></p>

                                                <div style="font-size:12px;line-height:20px;text-align:left; padding-bottom: 10px;" class="color-white">
                                                    <a href="<?= url('/') ?>" style="text-decoration:none" class="color-white">
                                                        <strong class="color-white"><?= __('Sent with ♥ by [WEBSITE_NAME]') ?></strong>
                                                    </a>
                                                </div>

                                                <div style="padding: 23px 0 0 0; font-size: 12px;">
                                                    <a href="<?= url('/') ?>" style="color: #fff;"><?= __('© :year. [WEBSITE_NAME]', ['year' => date('Y')]) ?></a>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </td>
                    <td>&nbsp;</td>
                </tr>
            </tbody>
        </table>
    </body>
</html>