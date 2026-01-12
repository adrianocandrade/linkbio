<?php
return [
    'facebook' => [
        'name' => 'Facebook',
        "icon" => "la la-facebook-f",
        "color" => "#4064ac",
        "template" => "
        <script>
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
                n.callMethod.apply(n,arguments):n.queue.push(arguments)};
                if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
                n.queue=[];t=b.createElement(e);t.async=!0;
                t.src=v;s=b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t,s)}(window, document,'script',
                'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', {pixel});
            fbq('track', 'PageView');
        </script>

        <noscript><img height=\"1\" width=\"1\" style='display:none' src='https://www.facebook.com/tr?id={pixel}&ev=PageView&noscript=1\"/></noscript>",
    ],

    'twitter' => [
        'name' => 'Twitter',
        'color' => '#08a0e9',
        "icon" => "la la-twitter",
        "template" => "
        <script>
            !function(e,t,n,s,u,a){e.twq||(s=e.twq=function(){s.exe?s.exe.apply(s,arguments):s.queue.push(arguments);
            },s.version='1.1',s.queue=[],u=t.createElement(n),u.async=!0,u.src='//static.ads-twitter.com/uwt.js',
                a=t.getElementsByTagName(n)[0],a.parentNode.insertBefore(u,a))}(window,document,'script');

            twq('init', '{pixel}');
            twq('track', 'PageView');
        </script>",
    ],

    'google_analytics' => [
        'name' => 'Google Analytics',
        'color' => '#ffaf0080',
        'class' => 'col-span-2 md:col-span-1',
        "svg" => "<svg class=\"icon icon-google-analytics\"><use xlink:href=".gs('assets/image/svg', 'sprite.svg#icon-google-analytics')."></use></svg>",
        "template" => "
        <script async src='https://www.googletagmanager.com/gtag/js?id={pixel}'></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{pixel}');
        </script>",
    ],

    'google_tag_manager' => [
        'name' => 'Google Tag Manager',
        'class' => 'col-span-2 md:col-span-1',
        'color' => '#8ab4f8a8',
        "svg" => "<svg class=\"icon icon-google-analytics\"><use xlink:href=".gs('assets/image/svg', 'sprite.svg#icon-google-tag-manager')."></use></svg>",

        "template" => "
        <script>
            (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','{pixel}');
        </script>

        <noscript>
            <iframe src=\"https://www.googletagmanager.com/ns.html?id={pixel}\" height=\"0\" width=\"0\" style=\"display: none; visibility: hidden;\"></iframe>
        </noscript>",
    ],

    'quora' => [
        'name' => 'Quora',
        'color' => '#B92B27',
        "icon" => "la la-quora",
        "template" => "
        <script>
            !function(q,e,v,n,t,s){if(q.qp) return; n=q.qp=function(){n.qp?n.qp.apply(n,arguments):n.queue.push(arguments);}; n.queue=[];t=document.createElement(e);t.async=!0;t.src=v; s=document.getElementsByTagName(e)[0]; s.parentNode.insertBefore(t,s);}(window, 'script', 'https://a.quora.com/qevents.js');
            qp('init', '{pixel}');
            qp('track', 'ViewContent');
        </script>

        <noscript>
            <img height=\"1\" width=\"1\" style=\"display: none;\" src=\"https://q.quora.com/_/ad/{pixel}/pixel?tag=ViewContent&noscript=1\"/>
        </noscript>",
    ],

    'pinterest' => [
        'name' => 'Pinterest',
        'color' => '#BD081C',
        "icon" => "sni sni-pinterest",
        "template" => "
            <script type='text/javascript'>
            !function(e){if(!window.pintrk){window.pintrk=function(){window.pintrk.queue.push(Array.prototype.slice.call(arguments))};var n=window.pintrk;n.queue=[],n.version='3.0';var t=document.createElement('script');t.async=!0,t.src=e;var r=document.getElementsByTagName('script')[0];r.parentNode.insertBefore(t,r)}}('https://s.pinimg.com/ct/core.js');
            pintrk('load', '{pixel}');
            pintrk('page');
        </script>

        <noscript>
            <img height=\"1\" width=\"1\" style=\"display:none;\" alt=\"\"
                 src=\"https://ct.pinterest.com/v3/?tid={pixel}&noscript=1\" />
        </noscript>",
    ],
];
