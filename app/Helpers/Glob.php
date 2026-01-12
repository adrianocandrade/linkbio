<?php

if (!function_exists('slugify')) {
    function slugify($string, $delimiter = '_'){
        try {
            $slug = new \Ausi\SlugGenerator\SlugGenerator();
            return $slug->generate($string, ['delimiter' => $delimiter]);
        } catch (Exception $e) {
            return $string;
        }
    }
}
if (!function_exists('toObject')) {
    function toObject($array){
        return json_decode(json_encode($array));
    }
}
if (!function_exists('seed_random_number')) {
    function seed_random_number($seed, $limit = 100){
        
        $StringSeed = $seed;
        $IntSeed = crc32($StringSeed);
        srand($IntSeed);
        return rand(1, $limit);
    }
}


if (!function_exists('hour2min')) {
    function hour2min($time){
        $time1 = strtotime('12:00am');
        $time2 = strtotime($time);


        $difference = round(abs($time2 - $time1) / 3600,2);
        $hours = $difference;
        $minutes = 0; 
        if (strpos($hours, ':') !== false) 
        { 
            // Split hours and minutes. 
            list($hours, $minutes) = explode(':', $hours); 
        } 
        return $hours * 60 + $minutes;
    }
}

if (!function_exists('yetti_highlight_stories')) {
    function yetti_highlight_stories($user, $link_type = 'mix', $workspace_id = null){
        if(!$user = \App\User::find($user)){
            return false;
        }
        
        // Get workspace_id if not provided
        if ($workspace_id === null) {
            $workspace_id = session('active_workspace_id', null);
        }
        
        $highlightsQuery = \App\Models\Highlight::where('user', $user->id);
        if ($workspace_id) {
            $highlightsQuery->where('workspace_id', $workspace_id);
        }
        $highlights = $highlightsQuery->get();

        $link = '';
        $link_text = '';
        

        $return = [];

        foreach ($highlights as $item) {
            $media = media_or_url($item->thumbnail, 'media/highlight');

            switch ($link_type) {
                case 'mix':
                    $link = route('user-mix-highlight-edit', $item->id);
                    $link_text = __('Edit Hightlight');
                break;
                case 'public':
                    $link = \App\Models\Highlight::elem_or_linkonly($item->id, $user->id);
                    $link_text = __('View Link');
                break;
            }
            $return[] = [
                'id' => "box-$item->id",
                'photo' => avatar($user->id),
                'name' => ao($item->content, 'heading'),
                'link' => $link,
                'lastUpdated' => strtotime($item->updated_at),
                'items' => [
                    [
                        'id'        => $item->id,
                        'type'      => 'photo',
                        'length'    => 5,
                        'src'       => $media,
                        'preview'   => $media,
                        'link'      => $link,
                        'linkText'  => $link_text,
                        'time'      => strtotime($item->updated_at),
                        'seen'      => false,
                    ]
                ]
            ];
        }


        return $return;
    }
}

if (!function_exists('orion')) {
    function orion($icon, $class = ''){

        $path = gs("assets/image/svg/orion-svg-sprite.svg#$icon");
        $svg = "<svg class=\"svg-icon orion-svg-icon $class\"><use xlink:href=\"$path\"></use></svg>";

        return $svg;
    }
}


if (!function_exists('get_svg')) {
    function get_svg($location, $icon = ''){
        if (!mediaExists($location, $icon)) {
            return 'false';
        }

        try {
            return file_get_contents(public_path("$location/$icon"));
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return 'false1';
    }
}


if (!function_exists('feather')) {
    function feather($icon, $class = ''){

        $path = gs("assets/image/svg/feather-sprite.svg#$icon");
        $svg = "<svg class=\"svg-icon feather-svg-icon $class\"><use xlink:href=\"$path\"></use></svg>";

        return $svg;
    }
}

if (!function_exists('iconsprite')) {
    function iconsprite($icon, $class = ''){

        $path = gs("assets/image/svg/icon-sprite-2.svg#$icon");
        $svg = "<svg class=\"svg-icon icon-sprite-2 $class\"><use xlink:href=\"$path\"></use></svg>";

        return $svg;
    }
}
if (!function_exists('emoji')) {

    function emoji($emoji, $extension = 'gif'){
        $path = "assets/image/emoji/$emoji.$extension";

        return gs($path);
    }
}

if (!function_exists('empty_section')) {

    function empty_section($data = []){

        return view('includes.is-empty', ['data' => $data]);
    }
}

if (!function_exists('bio_prefix')) {
    function bio_prefix(){
        $base_url = config('app.url');

        $return = parse($base_url, 'host') . '/@';
        if (config('app.BIO_DOMAIN_PREFIX')) {
            $return = parse(config('app.BIO_DOMAIN_PREFIX'), 'host') . '/@';
        }

        if (config('app.BIO_WILDCARD')) {
            $return = '{name}.' . parse(config('app.BIO_WILDCARD_DOMAIN'), 'host');
        }


        return $return;
    }
}

if (!function_exists('get_previous')) {
    function get_previous($route){
        if (url()->previous() == url()->current()) {
            return route($route);
        }


        return url()->previous();
    }
}

if (!function_exists('sandy_plural')) {
    function sandy_plural( $amount, $singular = '', $plural = 's' ) {
        if ( $amount === 1 ) {
            return $singular;
        }
        return $plural;
    }
}

if (!function_exists('svg_i')) {
    function svg_i($icon, $class = ''){

        $path = gs("assets/image/svg/orion-svg-sprite.svg#$icon");
        $svg = "<svg class=\"svg-icon orion-svg-icon $class\"><use xlink:href=\"$path\"></use></svg>";

        return $svg;
    }
}

if (!function_exists('get_qrcode')) {
    function get_qrcode($user_id){
        if (!$user = \App\User::find($user_id)) {
            return false;
        }



        return gs("media/qrcode", "$user->username.png");
    }
}


if (!function_exists('getContrastColor')) {
    function getContrastColor($hexColor) {

        // hexColor RGB
        $R1 = hexdec(substr($hexColor, 1, 2));
        $G1 = hexdec(substr($hexColor, 3, 2));
        $B1 = hexdec(substr($hexColor, 5, 2));

        // Black RGB
        $blackColor = "#000000";
        $R2BlackColor = hexdec(substr($blackColor, 1, 2));
        $G2BlackColor = hexdec(substr($blackColor, 3, 2));
        $B2BlackColor = hexdec(substr($blackColor, 5, 2));

         // Calc contrast ratio
         $L1 = 0.2126 * pow($R1 / 255, 2.2) +
               0.7152 * pow($G1 / 255, 2.2) +
               0.0722 * pow($B1 / 255, 2.2);

        $L2 = 0.2126 * pow($R2BlackColor / 255, 2.2) +
              0.7152 * pow($G2BlackColor / 255, 2.2) +
              0.0722 * pow($B2BlackColor / 255, 2.2);

        $contrastRatio = 0;
        if ($L1 > $L2) {
            $contrastRatio = (int)(($L1 + 0.05) / ($L2 + 0.05));
        } else {
            $contrastRatio = (int)(($L2 + 0.05) / ($L1 + 0.05));
        }

        // If contrast is more than 5, return black color
        if ($contrastRatio > 5) {
            return '#000000';
        } else { 
            // if not, return white color.
            return '#FFFFFF';
        }
    }
}


if (!function_exists('strip_param_from_url')) {
    function strip_param_from_url( $url, $param = []) {
        $base_url = strtok($url, '?');
        $parsed_url = parse_url($url);              // Parse it 
        $query = ao($parsed_url, 'query');              // Get the query string
        parse_str( $query, $parameters );           // Convert Parameters into array


        foreach ($param as $key => $value) {
            unset( $parameters[$value] );
        }

        $new_query = http_build_query($parameters); // Rebuilt query string
        return $base_url.'?'.$new_query;            // Finally url is ready
    }
}

if (!function_exists('sandy_cdn')) {
    function sandy_cdn($media, $extra = []){

        if (config('app.FILESYSTEM') !== 'local') {
            return false;
        }


        return route('sandy-site-cdn', ['photo' => $media, 'width' => ao($extra, 'width'), 'height' => ao($extra, 'height')]);
    }
}

if (!function_exists('sandy_dev_links')) {
    function sandy_dev_links($key = null){
        $array = [
            'docs' => 'https://withsandy.gitbook.io/rio',
            'script' => 'https://rio-script.com',
            'support' => 'https://support.sandydev.com',
            'aws_purchase' => 'https://sandycode.gumroad.com/l/iXNeF'
        ];



        return ao($array, $key);
    }
}

if (!function_exists('search_docs')) {
    function search_docs($query){
        if (\Route::has('docs-index')) {
            $docs = App\Models\DocsGuide::where('status', 1)->where('name', 'LIKE','%'.$query.'%')->get();
            if (!$docs->isEmpty()) {
                return route('docs-index', ['query' => $query]);
            }
        }


        return false;
    }
}
if (!function_exists('has_https')) {
    function has_https(){
        if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on') {
            return false;
        }else{
            return true;
        }


        return false;
    }
}
if (!function_exists('app_changelog')) {
    function app_changelog(){
        $changelog = [];
        if (is_array($config_log = config('sandy.version.changelog'))) {
            $changelog = $config_log;
        }





        return $changelog;
    }
}
if (!function_exists('app_version')) {
    function app_version(){
        return config('sandy.version.current');
    }
}

if (!function_exists('truncate_html')) {
    function truncate_html($text, $max_length) {

        $text = strip_tags($text);
        return \Str::words($text, $max_length);

    }
}

if (!function_exists('is_admin')) {
    function is_admin($user_id){
        if (!$user = \App\User::where('id', $user_id)->where('role', 1)->first()) {
            return false;
        }

        return true;
    }
}

if (!function_exists('db_con')) {
    function db_con(){
        try {
            DB::connection()->getPdo();
            if(DB::connection()->getDatabaseName()){
                return true;
            }
        } catch (\Exception $e) {
            return false;
        }

        return false;
    }
}
if (!function_exists('is_installed')) {
    function is_installed(){
        if (!config('app.APP_INSTALL') && config('app.SESSION_DRIVER') == 'file') {
            return false;
        }

        return true;
    }
}

if (!function_exists('addsitescheme')) {
    function addsitescheme($url){
        $url = strtolower($url);
        $url = addHttps($url);

        if (validate_url($url)) {
            return $url;
        }

        return '';
    }
}

if (!function_exists('validate_date_string')) {
    function validate_date_string($date){
        try {
            $date = (string) $date;
            \Carbon\Carbon::parse($date);
        } catch (\Carbon\Exceptions\InvalidFormatException $e) {
            return false;
        }

        return true;
    }
}

if (!function_exists('price_with_cur')) {
    function price_with_cur($currency, $price, $delimiter = 1){
        $currency = strtoupper($currency);
        $code = \Currency::symbol($currency);

        $price = (float) $price;
        $price = number_format($price, $delimiter);
        $light = "{$code}{$price}";

        return $light;
    }
}

if (!function_exists('barba_prevent')) {
    function barba_prevent(){
        if (settings('others.spa_prevent') == 'disable') {
            return 'data-no-instant="false"';
        }

        return false;
    }
}

if (!function_exists('__t')) {
    function __t($string, array $values = []){
        $string = __($string, $values);
        return clean($string, 'titles');
    }
}

if (!function_exists('normal_export_to_csv')) {
    function normal_export_to_csv(array $array, array $columns, string $name){
        $slug = \Str::random(3);
        $name = slugify($name, '-');
        $date = slugify(\Carbon\Carbon::now(settings('others.timezone'))->toFormattedDateString(), '-');
        $fileName = "$name-$slug-$date.csv";

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $callback = function() use($array, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            foreach ($array as $key => $value) {
                $column = [];
                foreach ($columns as $col_key => $col_value) {
                    $column[] = ao($value, $col_value);
                }
                fputcsv($file, $column);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}


if (!function_exists('head_code')) {
    function head_code(){
        if (!settings('headjscss.enable')) {
            return false;
        }


        return "<style>" . clean(settings('headjscss.code'), 'clean_all') . "</style>";
    }
}


if (!function_exists('user_pwa')) {
    function user_pwa($user_id){
        if (!$user = \App\User::find($user_id)) {
            return false;
        }

        if (!\App\Bio::can_install_pwa($user->id)) {
            return false;
        }

        user_manifest($user_id);

        $config = (new \App\Pwa\Service\ManifestService)->init();

        return view('vendor.pwa.meta', ['config' => $config, 'user' => $user]);
    }
}

if (!function_exists('user_manifest')) {
    function user_manifest($user_id){
        if (!$bio = \App\User::find($user_id)) {
            return false;
        }

        if (!\App\Bio::can_install_pwa($bio->id)) {
            return false;
        }



        $cdn = function($media, $width, $height) use($bio){

            $return = "/cdn?photo=media/bio/pwa-app-icon/". user('pwa.app_icon', $bio->id) .'&height='. $height .'&width='. $width .'';
            return $return;

            return sandy_cdn($media, ['width' => $width, 'height' => $height]);
        };



        $manifest = [
            'name' => $bio->name,
            'short_name' => $bio->name,
            'start_url' => bio_url($bio->id) . '/',
            'background_color' => '#ffffff',
            'theme_color' => user('pwa.theme_color', $bio->id),
            'display' => 'standalone',
            'orientation'=> 'any',
            'status_bar'=> 'black',


            'icons' => [
                '72x72' => [
                    'path' => $cdn('media/bio/pwa-app-icon/'. user('pwa.app_icon', $bio->id), '72', '72'),
                    'purpose' => 'any'
                ],
                '96x96' => [
                    'path' => $cdn('media/bio/pwa-app-icon/'. user('pwa.app_icon', $bio->id), '96', '96'),
                    'purpose' => 'any'
                ],
                '128x128' => [
                    'path' => $cdn('media/bio/pwa-app-icon/'. user('pwa.app_icon', $bio->id), '128', '128'),
                    'purpose' => 'any'
                ],
                '144x144' => [
                    'path' => $cdn('media/bio/pwa-app-icon/'. user('pwa.app_icon', $bio->id), '144', '144'),
                    'purpose' => 'any'
                ],
                '152x152' => [
                    'path' => $cdn('media/bio/pwa-app-icon/'. user('pwa.app_icon', $bio->id), '152', '152'),
                    'purpose' => 'any'
                ],
                '192x192' => [
                    'path' => $cdn('media/bio/pwa-app-icon/'. user('pwa.app_icon', $bio->id), '192', '192'),
                    'purpose' => 'any'
                ],
                '384x384' => [
                    'path' => $cdn('media/bio/pwa-app-icon/'. user('pwa.app_icon', $bio->id), '384', '384'),
                    'purpose' => 'any'
                ],
                '512x512' => [
                    'path' => $cdn('media/bio/pwa-app-icon/'. user('pwa.app_icon', $bio->id), '512', '512'),
                    'purpose' => 'any'
                ],
            ],
            'splash' => [
                '640x1136' => '/images/icons/splash-640x1136.png',
                '750x1334' => '/images/icons/splash-750x1334.png',
                '828x1792' => '/images/icons/splash-828x1792.png',
                '1125x2436' => '/images/icons/splash-1125x2436.png',
                '1242x2208' => '/images/icons/splash-1242x2208.png',
                '1242x2688' => '/images/icons/splash-1242x2688.png',
                '1536x2048' => '/images/icons/splash-1536x2048.png',
                '1668x2224' => '/images/icons/splash-1668x2224.png',
                '1668x2388' => '/images/icons/splash-1668x2388.png',
                '2048x2732' => '/images/icons/splash-2048x2732.png',
            ],
            'custom' => [
                'scope' => './'
            ]
        ];

        $splash = [];
        foreach (['640x1136', '750x1334', '1242x2208', '1125x2436', '828x1792', '1242x2688', '1536x2048', '1668x2224', '1668x2388', '2048x2732'] as $key => $value) {
            if (file_exists(public_path('media/bio/pwa-splash/'. settings("pwa_splash.$value")))) {
                $splash[$value] = url('media/bio/pwa-splash/' . settings("pwa_splash.$value"));
            }
        }

        $manifest['splash'] = $splash;

        config(['sandypwa.manifest' => $manifest]);
    }
}

if (!function_exists('array_exclude')) {
    function array_exclude($array, Array $excludeKeys){
        $new_array = [];


        foreach ($array as $key => $value) {
            if (in_array($key, $excludeKeys)) {
                $new_array[$key] = $value;
            }
        }
        
        return $new_array;
    }
}

if (!function_exists('user_verified')) {
    function user_verified($user_id){
        if (!$user = \App\User::find($user_id)) {
            return false;
        }

        if (!plan('settings.verified', $user->id)) {
            return false;
        }

        if (user('settings.verified', $user_id)) {
            return '<svg xmlns="http://www.w3.org/2000/svg" id="icon-verified" class="verified ml-2" viewBox="0 0 122.88 116.87"><polygon class="cls-1" points="61.37 8.24 80.43 0 90.88 17.79 111.15 22.32 109.15 42.85 122.88 58.43 109.2 73.87 111.15 94.55 91 99 80.43 116.87 61.51 108.62 42.45 116.87 32 99.08 11.73 94.55 13.73 74.01 0 58.43 13.68 42.99 11.73 22.32 31.88 17.87 42.45 0 61.37 8.24 61.37 8.24"></polygon><path class="cls-2" d="M37.92,65c-6.07-6.53,3.25-16.26,10-10.1,2.38,2.17,5.84,5.34,8.24,7.49L74.66,39.66C81.1,33,91.27,42.78,84.91,49.48L61.67,77.2a7.13,7.13,0,0,1-9.9.44C47.83,73.89,42.05,68.5,37.92,65Z"></path></svg>';
        }


        return false;
    }
}

if (!function_exists('user_ads')) {
    function user_ads($location, $user_id = null){
        if ($user = \App\User::find($user_id)) {
            if (plan('settings.ads', $user->id)) {
                return false;
            }
        }

        switch ($location) {
            case 'header':
                return settings('ads.header');
            break;

            case 'footer':
                return settings('ads.footer');
            break;
        }

        return false;
    }
}

if (!function_exists('terms_and_privacy')) {
    function terms_and_privacy($text = ''){
        $website_name = config('app.name');
        $website_name = "$website_name's";

        // And
        $and = !empty(settings('others.terms')) && !empty(settings('others.privacy')) ? __('and') : '';

        // Terms
        $terms_html = '<a href="'. settings('others.terms') .'" target="_blank" class="text-link">'. __('Terms of Service') .'</a>';
        $terms = !empty(settings('others.terms')) ? $terms_html : '';

        // Privacy 
        $privacy_html = '<a href="'. settings('others.privacy') .'" target="_blank" class="text-link">'. __('Privacy Policy') .'</a>';
        $privacy = !empty(settings('others.privacy')) ? $privacy_html : '';


        // Returned html
        $html = '<div class="text-gray-400 text-center mt-5 text-center mt-5"><p class="max-w-50 mx-auto text-sm">'. __('By clicking ":text" you agree to :website_name :privacy :and :terms.', ['website_name' => $website_name, 'and' => $and, 'terms' => $terms, 'privacy' => $privacy, 'text' => $text]) .'</p> </div>';

        if (!empty(settings('others.terms')) || !empty(settings('others.privacy'))) {
            return $html;
        }

        return false;
    }
}

if (!function_exists('bio_branding_display')) {
    function bio_branding_display($user_id){
        if (!$user = \App\User::find($user_id)) {
            return false;
        }


        if (plan('settings.branding', $user->id)) {
            
            if (user('settings.remove_branding', $user->id)) {
                return false;
            }
        }

        return true;
    }
}

if (!function_exists('get_chart_data')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function get_chart_data(Array $main_array){
            $results = [];
            foreach($main_array as $date_label => $data) {
                foreach($data as $label_key => $label_value) {
                    if(!isset($results[$label_key])) {
                        $results[$label_key] = [];
                    }
                    $results[$label_key][] = $label_value;
                }
            }
            foreach($results as $key => $value) {
                $results[$key] = '["' . implode('", "', $value) . '"]';
            }
            $results['labels'] = '["' . implode('", "', array_keys($main_array)) . '"]';
            return $results;
    }
}

if (!function_exists('head_seo_tags')) {
    function head_seo_tags(){
        $html = '';

        // Check if user seo is active
        if (!settings('seo.enable')) {
            return false;
        }
        
        $page_name = settings('seo.page_name');
        $page_description = settings('seo.page_description');

        // Page title
        $html .= '<title>'. $page_name .'</title>
        ';

        // Meta Description
        $html .= '<meta name="description" content="'. $page_description .'" />
        ';

        // OP
        $html .= '<meta property="og:title" content="'. $page_name .'" />
        ';
        $html .= '<meta property="og:description" content="'. $page_description .'" />
        ';

        // Twitter
        $html .= '<meta property="twitter:title" content="'. $page_name .'" />
        ';
        $html .= '<meta property="twitter:description" content="'. $page_description .'" />
        ';

        /*
        if (!empty($image = ao($user->seo, 'opengraph_image'))) {
            if(mediaExists('media/bio/seo', $image)){
                $gs = gs('media/bio/seo', $image);

                // Image
                $html .= '<meta property="og:image" content="'. $gs .'" />
                ';
                $html .= '<meta property="twitter:image" content="'. $gs .'" />
                ';
            }
        }*/


        if (settings('seo.block_engine')) {
            $html .= '<meta name="robots" content="noindex">';
        }
        return $html;
    }
}

if (!function_exists('formatBytes')) {
    function formatBytes($bytes, $precision = 2) {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        
        if ($bytes <= 0) {
            return '0 B';
        }
        
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        
        $bytes /= (1 << (10 * $pow));
        
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}

if (!function_exists('tidyHTML')) {
    function tidyHTML($buffer) {
        // load our document into a DOM object
        $dom = new DOMDocument();
        // we want nice output
        $dom->preserveWhiteSpace = false;
        $dom->loadHTML($buffer);
        $dom->formatOutput = true;
        return($dom->saveHTML());
    }
}

if (!function_exists('user_seo_tags')) {
    function user_seo_tags($user_id, $page = 'defaults'){
        $html = '';
        $seo = [];

        // Check for user
        if (!$user = \App\User::find($user_id)) {
            return false;
        }

        $page_name = $user->name;
        $page_description = $user->bio;
        $favicon_icon = avatar($user->id);
        $block_seo = false;

        // Check if it's in plan
        if (plan('settings.seo', $user->id) && ao($user->seo, 'enable')) {
            $page_name = !empty(ao($user->seo, 'page_name')) ? ao($user->seo, 'page_name') : $page_name;
            $page_description = !empty(ao($user->seo, 'page_description')) ? ao($user->seo, 'page_description') : $page_description;

            if (!empty($image = ao($user->seo, 'opengraph_image'))) {
                if(mediaExists('media/bio/seo', $image)){
                    $favicon_icon = gs('media/bio/seo', $image);
                }
            }

            $block_seo = ao($user->seo, 'block_engine');
        }

        $defaults = [
            '<title>'. $page_name .'</title>',
            '<meta name="description" content="'. $page_description .'" />',
        ];
        $seo[] = $defaults;

        // FaceBook
        $facebook = [
            '<!-- Facebook Seo Tags -->',
            '<meta property="og:type" content="website" />',
            '<meta property="og:url" content="'. url()->current() .'" />',
            '<meta property="og:title" content="'. $page_name .'" />',
            '<meta property="og:description" content="'. $page_description .'" />',
        ];
        $seo[] = $facebook;


        // Twitter
        $twitter = [
            '<!-- Twitter Seo Tags -->',
            '<meta property="twitter:type" content="website" />',
            '<meta property="twitter:url" content="'. url()->current() .'" />',
            '<meta property="twitter:title" content="'. $page_name .'" />',
            '<meta property="twitter:description" content="'. $page_description .'" />'
        ];
        $seo[] = $twitter;

        // Google
        $google = [
            '<!-- Google / Search Engine Tags -->',
            '<meta itemprop="name" content="'. $page_name .'" />',
            '<meta itemprop="description" content="'. $page_description .'" />'
        ];
        $seo[] = $google;


        // Favicons Seo

        // Image
        $seo[] = [
            '<!-- Images -->',
            '<link href="'. $favicon_icon .'" rel="shortcut icon" type="image/png" />',
            '<meta property="og:image" content="'. $favicon_icon .'" />',
            '<meta property="twitter:image" content="'. $favicon_icon .'" />',
            '<meta itemprop="image" content="'. $favicon_icon .'"/>'
        ];

        // Block SEO
        if ($block_seo) {
            $seo[] = [
                '<!-- Block Seo -->',
                '<meta name="robots" content="noindex">'
            ];
        }


        foreach ($seo as $key => $value) {
            $html .= "\n\n";
            $html .= is_array($value) ? implode(PHP_EOL, $value) : $value;
        }

        return $html;
    }
}

if (!function_exists('formatBytes')) {
    function formatBytes($bytes, $precision = 2) {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        
        if ($bytes <= 0) {
            return '0 B';
        }
        
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        
        $bytes /= (1 << (10 * $pow));
        
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}

if (!function_exists('xcopy')) {
    function xcopy($source, $dest, $permissions = 0755){
        $sourceHash = hashDirectory($source);
        // Check for symlinks
        if (is_link($source)) {
            return symlink(readlink($source), $dest);
        }

        // Simple copy for a file
        if (is_file($source)) {
            return copy($source, $dest);
        }

        // Make destination directory
        if (!is_dir($dest)) {
            mkdir($dest, $permissions);
        }

        // Loop through the folder
        $dir = dir($source);
        while (false !== $entry = $dir->read()) {
            // Skip pointers
            if ($entry == '.' || $entry == '..') {
                continue;
            }

            // Deep copy directories
            if($sourceHash != hashDirectory($source."/".$entry)){
                 xcopy("$source/$entry", "$dest/$entry", $permissions);
            }
        }

        // Clean up
        $dir->close();
        return true;
    }
}

if (!function_exists('hashDirectory')) {
    function hashDirectory($directory){
        if (! is_dir($directory)){ return false; }

        $files = array();
        $dir = dir($directory);

        while (false !== ($file = $dir->read())){
            if ($file != '.' and $file != '..') {
                if (is_dir($directory . '/' . $file)) { $files[] = hashDirectory($directory . '/' . $file); }
                else { $files[] = md5_file($directory . '/' . $file); }
            }
        }

        $dir->close();

        return md5(implode('', $files));
    }
}

if (!function_exists('listFolderFiles')) {
    function listFolderFiles($dir)
    {
        echo '<ol>';
        foreach (new DirectoryIterator($dir) as $fileInfo) {
            if (!$fileInfo->isDot()) {
                echo '<li>' . $fileInfo->getFilename();
                if ($fileInfo->isDir()) {
                    listFolderFiles($fileInfo->getPathname());
                }
                echo '</li>';
            }
        }
        echo '</ol>';
    }
}

if (!function_exists('ActivatePlan')) {
    function ActivatePlan($user_id, $plan, $duration){
        $plan_history = new \App\Models\PlansHistory;
        $plan = \App\Models\Plan::find($plan);
        $user = \App\User::find($user_id);

        // Get User Plans
        $plan_user = new \App\Models\PlansUser;

        // Check if Plan Exists
        if (!$plan) {
            return ['status' => false, 'response' => __('Plan Could Not Be Found.')];
        }

        // Check if User Exists
        if (!$user) {
            return ['status' => false, 'response' => __('User Could Not Be Found.')];
        }


        // Check if plans exists and delete them
        $plan_user->where('user_id', $user_id)->delete();

        // Add New Plan to User
        $plan_user->plan_id = $plan->id;
        $plan_user->user_id = $user->id;
        $plan_user->plan_due = $duration;
        // Save New Plan
        $plan_user->save();

        // Add Plan to History
        $plan_history->plan_id = $plan->id;
        $plan_history->user_id = $user->id;
        $plan_history->save();

        // Log activity
        logActivity($user->email, 'plan', __(':plan Activated Successfully.', ['plan' => $plan->name]));

        // Return true
        return ['status' => true, 'response' => __('Plan Activated Successfully.')];
    }
}



if (!function_exists('modal_media')) {
    function modal_media($data = [], $location = null){
        $media = media_or_url($data, $location);
        $type = ao($data, 'type');

        if ($type == 'solid_color') {
            $solid = ao($data, 'solid_color');
            return "<div style=\"background: $solid\" class=\"solid-color\"></div>";
        }


        return videoOrImage($media);
    }
}

if (!function_exists('videoOrImage')) {
    function videoOrImage($file, $data = []){

        $attr = ao($data, 'attr');

        $no_lozad = ao($data, 'no_lozad');
        $parse = parse($file, 'path');

        if (empty($file)) {
            return false;
        }


        $extension = pathinfo($parse, PATHINFO_EXTENSION);
        $video = ['mp4', 'ogg', '3gpp', '3gpp2', 'flv', 'mpeg', 'mpeg-2', 'mpeg4', 'ogg', 'ogm', 'quicktime', 'webm', 'avi'];
        $html = '';

        $src = $no_lozad ? "src=\"$file\"" : "data-src=\"$file\"";

        if (in_array($extension, $video)) {
            $html = "<video class=\"lozad video-background image sandy-upload-modal-identifier\" $attr loop=\"\" autoplay=\"\" playsinline=\"\" muted=\"\"><source $src type=\"video/mp4\"></video>";
        }else{
            $html = '<img '.$src.' class="bio-background-inner lozad image sandy-upload-modal-identifier" '. $attr .' alt="">';
        }


        return $html;
    }
}

if (!function_exists('formatBytes')) {
    function formatBytes($bytes, $precision = 2) {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        
        if ($bytes <= 0) {
            return '0 B';
        }
        
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        
        $bytes /= (1 << (10 * $pow));
        
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}

if (!function_exists('parse')) {
    function parse($url, $key = null){
        $array = parse_url($url);
        
        // Serve array without error
        app('config')->set('array-parse-temp', $array);
        $key = !empty($key) ? '.'.$key : null;
        return app('config')->get('array-parse-temp'. $key);
    }
}

if(!function_exists('random_avatar')){
    
    function random_avatar($key = null, $type = 'adventurer'){


        return "https://api.dicebear.com/9.x/$type/svg?seed=$key";
    }
}

if (!function_exists('ao')) {
    function ao($array, $key = null){

        $array = json_decode(json_encode($array), true);
        app('config')->set('array-temp', $array);
        $key = !empty($key) ? '.'.$key : null;
        return app('config')->get('array-temp'. $key);
    }
}

if (!function_exists('human2byte')) {
    function human2byte($value) {
      return preg_replace_callback('/^\s*(\d+)\s*(?:([kmgt]?)b?)?\s*$/i', function ($m) {
        switch (strtolower($m[2])) {
          case 't': $m[1] *= 1024;
          case 'g': $m[1] *= 1024;
          case 'm': $m[1] *= 1024;
          case 'k': $m[1] *= 1024;
        }
        return $m[1];
      }, $value);
    }
}

if (!function_exists('nr')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function nr($n, $nf = false, $precision = 1) {
        if ($nf) {
            return number_format($n);
        }

        if ($n < 900) {
            // 0 - 900
            $n_format = number_format($n, $precision);
            $suffix = '';
        } else if ($n < 900000) {
            // 0.9k-850k
            $n_format = number_format($n / 1000, $precision);
            $suffix = 'K';
        } else if ($n < 900000000) {
            // 0.9m-850m
            $n_format = number_format($n / 1000000, $precision);
            $suffix = 'M';
        } else if ($n < 900000000000) {
            // 0.9b-850b
            $n_format = number_format($n / 1000000000, $precision);
            $suffix = 'B';
        } else {
            // 0.9t+
            $n_format = number_format($n / 1000000000000, $precision);
            $suffix = 'T';
        }

      // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
      // Intentionally does not affect partials, eg "1.50" -> "1.50"
        if ( $precision > 0 ) {
            $dotzero = '.' . str_repeat( '0', $precision );
            $n_format = str_replace( $dotzero, '', $n_format );
        }

        return $n_format . $suffix;
    }
}

if (!function_exists('cr')) {
    function cr($price, $currency){

    }
}

if (!function_exists('logo')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function logo(){
      $logo = settings('logo');
      $default = gs('assets/image/others/default-logo.png');

      if (empty($logo)) {
          return $default;
      }

      if (!mediaExists('media/site/logo', $logo)) {
        return $default;
      }

      $logo = getStorage('media/site/logo', $logo);
      return $logo;
    }
}

if (!function_exists('mix_logo')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function mix_logo(){
      $logo = settings('mix_logo');
      $default = gs('assets/image/others/mix-default-logo.png');

      if (empty($logo) || !mediaExists('media/site/logo', $logo)) {
          return $default;
      }

      $logo = getStorage('media/site/logo', $logo);

      return $logo;
    }
}

if (!function_exists('favicon')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function favicon(){
      $favicon = settings('favicon');
      $default = gs('assets/image/others/default-favicon.png');

      if (empty($favicon)) {
          return $default;
      }

      if (!mediaExists('media/site/favicon', $favicon)) {
        return $default;
      }


      $favicon = getStorage('media/site/favicon', $favicon);

      return $favicon;
    }
}


if (!function_exists('env_update')) {
    function env_update($data = array()){
        if(count($data) > 0){
            $env = file_get_contents(base_path() . '/.env');
            $env = explode("\n", $env);
            foreach((array)$data as $key => $value) {
                if($key == "_token") {
                    continue;
                }
                $notfound = true;
                foreach($env as $env_key => $env_value) {
                    $entry = explode("=", $env_value, 2);
                    if($entry[0] == $key){
                        $env[$env_key] = $key . "=\"" . $value."\"";
                        $notfound = false;
                    } else {
                        $env[$env_key] = $env_value;
                    }
                }
                if($notfound) {
                    $env[$env_key + 1] = "\n".$key . "=\"" . $value."\"";
                }
            }
            $env = implode("\n", $env);
            file_put_contents(base_path('.env'), $env);
            return true;
        } else {
            return false;
        }
    }

}


if (!function_exists('settings')) {
    function settings($key = null){
       $getsettings = \App\Models\Setting::all()
       ->keyBy('key')
       ->transform(function ($setting) {
             $value = json_decode($setting->value, true);
             $value = (json_last_error() === JSON_ERROR_NONE) ? $value : $setting->value;
             return $value;
        })->toArray();
       app('config')->set('settings', $getsettings);
       $key = !empty($key) ? '.'.$key : null;
       return app('config')->get('settings'.$key);
    }
}


if (!function_exists('settings_put')) {
    function settings_put($key, $data = []){

        $settings = [];
        $settings[$key] = $data;

        $value = $data;
        if (is_array($value)) {
            $settings[$key] = json_encode($value);
            $value = json_encode($value);
        }

        $key_value = ['key' => $key, 'value' => $value];
        if (\App\Models\Setting::where('key', $key)->first()) {
                \App\Models\Setting::where('key', $key)->update(['value' => $value]);
        }else{
            \App\Models\Setting::insert($key_value);
        }
    }
}

if (!function_exists('GetPlan')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function GetPlan($key = null, $id = null){
        $plan_model = new \App\Models\Plan;
        // Lets get our package
        if (!$plan = $plan_model->where('id', $id)->first()) {
            return false;
        }

        $plan = $plan->toArray();


        // Plan settings
        return ao($plan, $key);
    }
}

if (!function_exists('plan')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function plan($key = null, $user = null){
        if ($user) {
            $user = \App\User::where('id', $user)->first();
            if (!$user) {
                return false;
            }
        }
        if (Auth::check() && !$user) {
            $user = Auth::user();
        }elseif (!Auth::check() && !$user) {
            return false;
        }

        $plan_user = new \App\Models\PlansUser;
        $plan_model = new \App\Models\Plan;

        $plan_skel = [
            'name' => __('No Plan!'),
            'settings' => [
                
            ]
        ];
        // Lets check for plan

        if (!$plan_user = $plan_user->where('user_id', $user->id)->first()) {
            return ao($plan_skel, $key);
        }

        // Lets get our package
        if (!$plan = $plan_model->where('id', $plan_user->plan_id)->first()) {
            return ao($plan_skel, $key);
        }

        $plan = $plan->toArray();

        $plan['plan_due'] = $plan_user->plan_due;


        switch (ao($plan, 'price_type')) {
            case 'paid':
                $plan['plan_due_string'] = \Carbon\Carbon::parse(ao($plan, 'plan_due'))->toFormattedDateString();
            break;

            case 'free':
                $plan['plan_due_string'] = __('Free Forever');
            break;

            case 'trial':
                $plan['plan_due_string'] = \Carbon\Carbon::parse(ao($plan, 'plan_due'))->toFormattedDateString();
            break;
        }

        // Plan settings
        app('config')->set('plan', $plan);
        $key = !empty($key) ? '.'.$key : null;
        return app('config')->get('plan'.$key);
    }
}
if (!function_exists('nf')) {
    function nf($numbers, $decimal = 2){
        $return = number_format($numbers, $decimal);
        return $return;
    }
}

if (!function_exists('preg_grep_keys_values')) {
    function preg_grep_keys_values($pattern, $input, $flags = 0) {
        return array_merge(
          array_intersect_key($input, array_flip(preg_grep($pattern, array_keys($input), $flags))),
          preg_grep($pattern, $input, $flags)
       );
    }
}

if (!function_exists('isJson')) {
    function isJson($string) {
       json_decode($string);
       return json_last_error() === JSON_ERROR_NONE;
    }
}

if (!function_exists('avatar')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function avatar($user = null, $html = false){



        if ($user) {
            $user = \App\User::where('id', $user)->first();

            if (!$user) {
                return false;
            }
        }elseif (!$user && Auth::check()) {
            $user = Auth::user();
        }else{
            return false;
        }

        $html_avatar = function() use ($user){
            $type = ao($user->avatar_settings, 'type');

            $check = !empty(user('avatar_settings.upload', $user->id)) && mediaExists('media/bio/avatar', user('avatar_settings.upload', $user->id)) ? true : false;
            $location = 'media/bio/avatar';
            $avatar = user('avatar_settings.upload', $user->id);
            $link = ao($user->avatar_settings, 'link');

            if (!$check && empty($link)) {
                $type = 'external';
                $link = random_avatar("rio-avatar-$user->id");
            }

            $avatar = [
                'type' => $type,
                'link' => $link,
                'upload' => $avatar
            ];
            return media_or_url($avatar, $location, true);
        };

        $avatar = user('avatar_settings.upload', $user->id);
        $default = random_avatar("rio-avatar-$user->id");
        $check = mediaExists('media/bio/avatar', $avatar);
        $path = getStorage('media/bio/avatar', $avatar);


        if ($html) {

            return $html_avatar();
        }


        $avatar = (!empty($avatar) && $check) ? $path : $default;

        if (ao($user->avatar_settings, 'type') == 'external') {
            $avatar = ao($user->avatar_settings, 'link');
        }

        return $avatar;
    }
}

if (!function_exists('storageFileSize')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function storageFileSize($directory, $file){
      $location = $directory .'/'. $file;
      $filesystem = sandy_filesystem($location);

      if (Storage::disk($filesystem)->exists($location)) {

          return Storage::disk($filesystem)->size($location);
      }

      return 0;
    }
}

if (!function_exists('storageDeleteDir')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function storageDeleteDir($directory){
      $location = $directory;
      $filesystem = sandy_filesystem($location);

      if (Storage::disk($filesystem)->exists($location)) {

          Storage::disk($filesystem)->deleteDirectory($location);

          return true;
      }

      return false;
    }
}

if (!function_exists('storageDelete')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function storageDelete($directory, $file = null){
      $location = $directory .'/'. $file;
      $filesystem = sandy_filesystem($location);

      if (Storage::disk($filesystem)->exists($location)) {

          Storage::disk($filesystem)->delete($location);

          return true;
      }

      return false;
    }
}

if (!function_exists('mediaExists')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function mediaExists($directory, $file = null){
      $location = $directory .'/'. $file;
      $filesystem = sandy_filesystem($location);

      if (Storage::disk($filesystem)->exists($location)) {
          return true;
      }

      return false;
    }
}

if (!function_exists('gs')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function gs($directory, $file = null){
        if ($file == null) {
            $file = basename($directory);
            $directory = dirname($directory);
        }

        return getStorage($directory, $file);
    }
}

if (!function_exists('getStorage')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function getStorage($directory, $file){
        // App Debug
        if (config('app.debug')) {
            $pathinfo = pathinfo($file);
            $date = date('Y-m-d H:i:s');

            $app_debug_css = explode(',', config('app.APP_DEBUG_CSS'));
            if (in_array(ao($pathinfo, 'basename'), $app_debug_css)) {
                $file = "$file?v=$date";
            }
        }
        
      $location = $directory .'/'. $file;
      $filesystem = sandy_filesystem($location);

      $get = \Storage::disk($filesystem)->url($location);

      return $get;
    }
}

if (!function_exists('sandy_filesystem')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function sandy_filesystem($location){
      $filesystem = env('FILESYSTEM');

      if (!config('app.AWS_ASSETS')) {
        $assets = explode('/', $location);
        if (isset($assets[0]) && $assets[0] == 'assets') {
            $filesystem = 'local';
        }
      }


      return $filesystem;
    }
}

if (!function_exists('getStoragePutAs')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function getStoragePutAs($directory, $file, $name){
      $filesystem = sandy_filesystem($directory);

      $put = \Storage::disk($filesystem)->putFileAs($directory, $file, $name);
      \Storage::disk($filesystem)->setVisibility($put, 'public');

      return $name;
    }
}

if (!function_exists('putStorage')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function putStorage($directory, $file){
      $filesystem = sandy_filesystem($directory);


      $put = \Storage::disk($filesystem)->put($directory, $file);

      \Storage::disk($filesystem)->setVisibility($put, 'public');


      return basename($put);
    }
}

if (!function_exists('user')) {
    function user($key = null, $user = null){
        $using_auth = false;
        $workspace = null;
        
        if ($user) {
            $user = \App\User::where('id', $user)->first();
            if (!$user) {
                return false;
            }
        }
        
        if (Auth::check() && !$user) {
            $user = Auth::user();
            $using_auth = true;
        }elseif (!Auth::check() && !$user) {
            // In public context, try to get workspace from View shared data
            // This happens when accessing public pages via workspace slug
            try {
                $workspace = \Illuminate\Support\Facades\View::shared('workspace');
                if ($workspace && $workspace->user) {
                    $user = $workspace->user;
                }
            } catch (\Exception $e) {
                // View might not be available, continue
            }
            
            // If still no user, try to get from request attributes (set by middleware/trait)
            if (!$user) {
                try {
                    $request = request();
                    if ($request && method_exists($request, 'attributes')) {
                        $workspace = $request->attributes->get('workspace');
                        if ($workspace && $workspace->user) {
                            $user = $workspace->user;
                        }
                    }
                } catch (\Exception $e) {
                    // Request might not be available
                }
            }
        }

        // Workspace Overlay - for authenticated context
        if ($using_auth && session()->has('active_workspace_id')) {
            $workspace = \App\Models\Workspace::find(session('active_workspace_id'));
            if ($workspace && $workspace->user_id == $user->id) {
                $wsAttributes = $workspace->toArray();
                
                // Map slug to username
                if(isset($wsAttributes['slug'])) {
                    $wsAttributes['username'] = $wsAttributes['slug'];
                }
                
                // Remove critical identity fields from workspace array to prevent overwriting user auth info
                unset($wsAttributes['id'], $wsAttributes['email'], $wsAttributes['password'], $wsAttributes['role'], $wsAttributes['plan_id'], $wsAttributes['created_at'], $wsAttributes['updated_at'], $wsAttributes['user_id']);

                // Force attributes onto the user model
                foreach($wsAttributes as $k => $v) {
                    if ($v !== null) {
                        $user->{$k} = $v;
                    }
                }
            }
        }
        // Workspace Overlay - for public context
        elseif (!$using_auth && $workspace && $user) {
            // Merge workspace attributes into user for public pages
            $wsAttributes = $workspace->toArray();
            
            // Map slug to username
            if(isset($wsAttributes['slug'])) {
                $wsAttributes['username'] = $wsAttributes['slug'];
            }
            
            // Remove critical identity fields
            unset($wsAttributes['id'], $wsAttributes['user_id'], $wsAttributes['created_at'], $wsAttributes['updated_at']);

            // Force attributes onto the user model
            foreach($wsAttributes as $k => $v) {
                if ($v !== null) {
                    $user->{$k} = $v;
                }
            }
        }

        app('config')->set('user', $user);
        $key = !empty($key) ? '.'.$key : null;
        return app('config')->get('user'.$key);
    }
}

if (!function_exists('get_bio_apps_content')) {
    function get_bio_apps_content($slug, $key){
        $bio = getBioResourceFile();

        if (array_key_exists($slug, $bio)) {
            $bio = $bio[$slug];
            $bio['slug'] = $slug;
            app('config')->set('bio-temp-2', $bio);

            $key = !empty($key) ? '.'.$key : null;
            return app('config')->get('bio-temp-2'.$key);
        }

        return false;
    }
}

if (!function_exists('get_bio_apps_input')) {
    function get_bio_apps_input($slug){
        $bio = getBioResourceFile();

        if (array_key_exists($slug, $bio)) {
            $bio = $bio[$slug];
            app('config')->set('bio-temp', $bio);
            $html = '';

            foreach (config('bio-temp.inputs') as $key => $value) {
                $type = $value['type'] ?? '';
                $slug = $key ?? '';
                $name = $value['name'] ?? '';
                $description = $value['description'] ?? '';

                $extra = [];

                if ($type == 'select') {
                    if (!empty($value['options'])) {
                        $extra['options'] = $value['options'];
                    }
                }

                $html .= input_html($type, $slug, $name, $description, '', $extra);
            }

            return $html;
        }

        return false;
    }
}


if (!function_exists('input_html')) {
    function input_html($type, $slug, $name, $description = '', $value = '', $extra = []){
        $value = $value;


        $html = '<div class="form-input mb-7">';

        $html .= '<label for="login-username">'. __($name) .'</label>';

        if ($type == 'text') {
            $html .= '<input type="text" value="'. $value .'" name="data['. $slug .'][text]">';
        }

        if ($type == 'textarea') {
            $html .= '<textarea name="data['. $slug .'][textarea]" class="editor">'. $value .'</textarea>';
        }

        if ($type == 'select') {
            $html .= '<select class="custom-select" name="data['. $slug .'][select]">';

            if (!empty($extra['options'])) {
             foreach ($extra['options'] as $option_key => $option_label) {
                $html .= '<option value="'.$option_key.'">'.$option_label.'</option>';
              }
            }

            $html .= '</select>';
        }

        if ($type == 'image') {
            $html .= 'image div noting';
        }

        $html .= '</div>';

        return $html;
    }
}

if (!function_exists('formatBytes')) {
    function formatBytes($bytes, $precision = 2) {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        
        if ($bytes <= 0) {
            return '0 B';
        }
        
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        
        $bytes /= (1 << (10 * $pow));
        
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}


if (!function_exists('getBioResourceFile')) {
    function getBioResourceFile(){
        return require base_path('resources') . "/bio/bio.php";
    }
}

if (!function_exists('socials')) {
    function socials(){
        $path = base_path('resources/others/socials.php');

        $socials = \File::get($path);
        $socials = json_decode($socials, true);

        if (!is_array($socials)) {
            $socials = [];
        }

        return $socials;
    }
}

if (!function_exists('getOtherResourceFile')) {
    function getOtherResourceFile($file, $dir = 'others', $file_get_contents = false){
        if (file_exists($include = base_path('resources') . "/$dir/$file.php")) {
            if (!$file_get_contents) {
                return require $include;
            }

            return file_get_contents($include);
        }
    }
}

if (!function_exists('json_to_array')) {
    function json_to_array($json, $reverse = false){
        if (is_json($json)) {
            $array = json_decode($json, true);


            return $array;
        }

        return [];
    }
}
if (!function_exists('is_json')) {
    function is_json($string) {
       json_decode($string);
       return json_last_error() === JSON_ERROR_NONE;
    }
}

if (!function_exists('includeAppRoute')) {
    function includeAppRoute($file){
        foreach(scandir($path = app_path('sandy/apps')) as $dir){
            if (file_exists($filepath = "{$path}/{$dir}/{$file}.php")) {
                require $filepath;
            }
        }
    }
}

if (!function_exists('getAllBioApps')) {
    function getAllBioApps(){
        $configs = [];
        $dir = base_path('sandy/Segment');

        foreach(scandir($path = $dir) as $dir){
            if (file_exists($filepath = "{$path}/{$dir}/config.php")) {
                if (\Elements::config($dir)) {
                    $configs[$dir] = \Elements::config($dir);
                }
            }
        }


        return $configs;
    }
}
if (!function_exists('fonts')) {
    function fonts($type = 'array'){
        $path = base_path('resources/others/fonts.php');

        $fonts = \File::get($path);
        $fonts = json_decode($fonts, true);

        if (!is_array($fonts)) {
            $fonts = [];
        }

        $html = '';
        $styles = '';

        foreach ($fonts as $key => $value) {
            $variants = ao($value, 'variants');
            $url = "https://fonts.googleapis.com/css?family=$key:$variants";
            
            $html .= "<link href='$url' rel='stylesheet' type='text/css'>";

            $styles .= '.'.slugify($key).'-font-preview {font-family: "'.$key.'"}';
        }

        if ($type == 'html') {
            $html .= "<style> $styles </style>";
            return $html;
        }

        return $fonts;
    }
}
if (!function_exists('all_locale')) {
    function all_locale(){
       // Get current translation locale
       $locale = config('app.locale');

       // Get all translations files
       $path = resource_path('lang');
       // Languages array
       $languages = \File::files($path);

       return $languages;
    }
}
if (!function_exists('string_uppercase')) {
    function string_uppercase($string){
       return ucwords(str_replace('_', ' ', $string));
    }
}
if (!function_exists('userFont')) {
    function userFont($user){
        $fonts = fonts();
        $html = '';
        $styles = '';

        if (!$user = \App\User::find($user)) {
            return false;
        }

        if (!plan('settings.customize', $user->id)) {
            return false;
        }

        if (array_key_exists($font = $user->font, $fonts)) {
            $variants = ao($fonts, "$font.variants");
            $url = "https://fonts.googleapis.com/css?family=$font:$variants";
            $html .= "<link href='$url' rel='stylesheet' type='text/css'>";
            $styles .= '* {font-family: "'.$font.'", sans-serif}';
        }

        $html .= "<style> $styles </style>";

        return $html;
    }
}

if (!function_exists('formatBytes')) {
    function formatBytes($bytes, $precision = 2) {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        
        if ($bytes <= 0) {
            return '0 B';
        }
        
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        
        $bytes /= (1 << (10 * $pow));
        
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
if (!function_exists('radius_and_align_class')) {
    function radius_and_align_class($user, $type = 'radius'){
        $classes = '';

        if (!$user = \App\User::find($user)) {
            return false;
        }

        if (!plan('settings.customize', $user->id)) {
            return false;
        }

        switch ($type) {
            case 'radius':
                $radius = 'round';
                if (!empty($user_radius = user('settings.radius', $user->id))) {
                    $radius = "radius-$user_radius";
                }
                return $radius;
            break;

            case 'align':
                $align = 'a-center';
                if (!empty($user_align = user('settings.bio_align', $user->id))) {
                    $align = "a-$user_align";
                }

                return $align;
            break;
        }
    }
}
if (!function_exists('BioColorCss')) {
    function BioColorCss($user){
        $styles = '';

        if (!$user = \App\User::find($user)) {
            return false;
        }

        if (!plan('settings.customize', $user->id)) {
            return false;
        }

        $text = ao($user->color, 'text');
        $styles .= !empty($user->color['text']) ? ".theme-text-color, .theme-text-color * { color: $text !important }" : '';

        $background = ao($user->color, 'background');
        $styles .= !empty($user->color['background']) ? " .theme-background-color { background: $background !important }" : '';

        $background_button = ao($user->color, 'button_background');
        $styles .= !empty($user->color['button_background']) ? " .theme-button-background { background: $background_button !important }" : '';

        $button_text_color = ao($user->color, 'button_color');
        $styles .= !empty($user->color['button_color']) ? ".theme-button-text-color, .theme-button-text-color * { color: $button_text_color }" : '';

        $html = "<style> $styles </style>";

        return $html;
    }
}

if (!function_exists('formatBytes')) {
    function formatBytes($bytes, $precision = 2) {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        
        if ($bytes <= 0) {
            return '0 B';
        }
        
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        
        $bytes /= (1 << (10 * $pow));
        
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
if (!function_exists('tracking_log')) {
    function tracking_log(){
        $ip = getIp(); //getIp() 102.89.2.139

        $agent = new \Jenssegers\Agent\Agent;
        $iso_code = geoCountry($ip, 'country.iso_code');
        $iso_code = strtolower($iso_code);
        $country = geoCountry($ip, 'country.names.en');
        $city = geoCity($ip, 'city.names.en');

        $tracking = ['country' => ['iso' => $iso_code, 'name' => $country, 'city' => $city], 'agent' => ['browser' => $agent->browser(), 'os' => $agent->platform()]];


        return $tracking;
    }
}

if (!function_exists('logActivity')) {
    function logActivity($email, $type, $message){
        if (!$user = \App\User::where('email', $email)->first()) {
            return false;
        }
        $user = \App\User::find($user->id);
        // Get user agent
        $agent = new Jenssegers\Agent\Agent;
        // Get user country iso code
        $countryIso = geoCountry(getIp(), 'country.iso_code');
        $countryIso = strtoupper($countryIso);

        // Update user last activity
        $user->lastActivity = \Carbon\Carbon::now();
        $user->lastAgent = $agent->platform();
        $user->lastCountry = $countryIso;
        $user->save();

        // Add new activity log
        $activity = new \App\Models\Authactivity;
        $activity->user = $user->id;
        $activity->type = $type;
        $activity->message = $message;
        $activity->browser = $agent->browser();
        $activity->os = $agent->platform();

        // Ip
        $activity->ip = getIp();

        $activity->save();

        return true;
    }
}

if (!function_exists('getBioBackground')) {
    function getBioBackground($id, $type = 'user'){
        $bio = \App\User::find($id);
        $inner = '';
        $wrapper = '';
        $classes = '';

        if (!$bio) {
            return false;
        }

        if (!plan('settings.customize', $bio->id)) {
            return false;
        }

        $background = function ($background, $id){
            $inner = '';
            switch ($background) {
                case 'image':
                    $image = '';
                    if (user('background_settings.image.source', $id) == 'upload') {
                        $image = getStorage('media/bio/background', user('background_settings.image.image', $id));
                    }elseif (user('background_settings.image.source', $id) == 'url') {
                        $image = user('background_settings.image.external_url', $id);
                    }

                    $inner .= "<img class='bio-background-inner' src='$image'>";
                break;

                case 'color':
                    $solid = user('background_settings.solid.color', $id);

                    $inner .= "<div style=\"background: $solid\" class=\"solid-color\"></div>";
                break;

                case 'video':
                    $video = '';
                    $source = user('background_settings.video.source', $id);

                    if ($source == 'upload') {
                        $video = getStorage('media/bio/background', user('background_settings.video.video', $id));
                    }elseif ($source == 'url') {
                        $video = user('background_settings.video.external_url', $id);
                    }

                    $inner .= "<video class=\"lozad video-background\" loop=\"\" autoplay=\"\" playsinline=\"\" muted=\"\"><source data-src=\"$video\" type=\"video/mp4\"></video>";
                break;

                case 'gradient':
                    $gradient1 = user('background_settings.gradient.color_1', $id);
                    $gradient2 = user('background_settings.gradient.color_2', $id);
                    $animate = user('background_settings.gradient.animate', $id);

                    $hex2rgb = function($color){
                        $array = hex2rgb($color);

                        $rgb = is_array($array) ? implode(',', $array) : '#000000';
                        $rgb = "rgb($rgb)";

                        return $rgb;
                    };

                    $gradient1RGB = $hex2rgb($gradient1);
                    $gradient2RGB = $hex2rgb($gradient2);

                    $animateCss = "rgba(0, 0, 0, 0) linear-gradient(45deg, $gradient2RGB, $gradient1RGB, $gradient2RGB, $gradient1RGB) repeat scroll 0% 0% / 400% 400%";

                    $noneAnimateCss = "rgba(0, 0, 0, 0) linear-gradient(15.92deg, $gradient1 7.76%, $gradient2 94.18%) repeat scroll 0% 0%";

                    $returnGradient = $animate ? $animateCss : $noneAnimateCss;

                    $class = $animate ? 'animate' : '';

                    $inner .= "<div style=\"background: $returnGradient\" class=\"gradient-color $class\"></div>";
                break;
            }

            return $inner;
        };

        if ($type !== 'user') {
            $inner = $background($type, $id);
            $wrapper .= "<div class='bio-background $classes'> $inner </div>";
            return $wrapper;
        }

        $inner = $background($bio->background, $id);

        $wrapper .= "<div class='bio-background $classes'> $inner </div>";

        return $wrapper;
    }
}
if (!function_exists('ElementIcon')) {
    function ElementIcon($element){
        $html = '';

        if (Elements::config($element, 'thumbnail.type') == 'icon'):
            $html .= '<div class="thumbnail h-avatar is-elem md is-video remove-before shadow-bg shadow-bg-s rounded-2xl" style="background: '.Elements::config($element, 'thumbnail.background').'; color: '. Elements::config($element, 'thumbnail.i-color') .'">
                <i class="'. Elements::config($element, 'thumbnail.thumbnail') .'"></i>
            </div>';
        endif;


        return $html;
    }
}

if (!function_exists('formatBytes')) {
    function formatBytes($bytes, $precision = 2) {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        
        if ($bytes <= 0) {
            return '0 B';
        }
        
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        
        $bytes /= (1 << (10 * $pow));
        
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
if (!function_exists('getPluginAdminMenus')) {
    function getPluginAdminMenus(){
        global $adminMenu;
        $html = '';
        $getItem = function($array, $key){

            app('config')->set('array-temp', $array);
            $key = !empty($key) ? '.'.$key : null;
            return app('config')->get('array-temp'. $key);
        };

        if (!empty($adminMenu)) {
            $html .= "<div class='sidebar__caption'>". __('Plugin') ."</div>";
        }

        if (is_array($adminMenu)) {
            foreach ($adminMenu as $key => $value) {
               $html .= '<a class="sidebar__item" '. ao($value, 'a-attr') .' href="'. $getItem($value, 'url') .'"><div class="sidebar__icon"><i class="icon '. $getItem($value, 'icon') .'"></i></div><div class="sidebar__text">'. $getItem($value, 'name') .'</div></a>';
            }
        }

        return $html;
    }
}

if (!function_exists('formatBytes')) {
    function formatBytes($bytes, $precision = 2) {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        
        if ($bytes <= 0) {
            return '0 B';
        }
        
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        
        $bytes /= (1 << (10 * $pow));
        
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
if (!function_exists('geoCountry')) {
    function geoCountry($ip, $key = null){
        $database = storage_path('geoip/GeoLite2-Country.mmdb');
        $reader = new MaxMind\Db\Reader($database);

        $items = $reader->get($ip);

        $reader->close();

        return ao($items, $key);
    }
}
if (!function_exists('geoCity')) {
    function geoCity($ip, $key = null){
        $database = storage_path('geoip/GeoLite2-City.mmdb');
        $reader = new MaxMind\Db\Reader($database);

        $items = $reader->get($ip);

        $reader->close();


        app('config')->set('geo-temp', $items);
        $key = !empty($key) ? '.'.$key : null;
        return app('config')->get('geo-temp'. $key);
    }
}

if (!function_exists('getIp')) {
    function getIp() {

        //return '41.210.63.255';

        if(array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {

            if(strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',')) {
                $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);

                return trim(reset($ips));
            } else {
                return $_SERVER['HTTP_X_FORWARDED_FOR'];
            }

        } else if (array_key_exists('REMOTE_ADDR', $_SERVER)) {
            return $_SERVER['REMOTE_ADDR'];
        } else if (array_key_exists('HTTP_CLIENT_IP', $_SERVER)) {
            return $_SERVER['HTTP_CLIENT_IP'];
        }

        return '';
    }
}

if (!function_exists('share_to_media')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function share_to_media($type, $name, $url){
        $url = $url;

        if ($type == 'facebook') {
            $query = urldecode(http_build_query([
                'app_id' => env('FACEBOOK_APP_ID'),
                'href' => $url,
                'display' => 'page',
                'title' => urlencode($name)
            ]));

            return 'https://www.facebook.com/dialog/share?' . $query;
        }

        if ($type == 'twitter') {
            $query = urldecode(http_build_query([
                'url' => $url,
                'text' => urlencode(\Str::limit($name, 120))
            ]));

            return 'https://twitter.com/intent/tweet?' . $query;
        }

        if ($type == 'whatsapp') {
            $query = urldecode(http_build_query([
                'text' => urlencode($name . ' ' . $url)
            ]));

            return 'https://wa.me/?' . $query;
        }

        if ($type == 'linkedin') {
            $query = urldecode(http_build_query([
                'url' => $url,
                'summary' => urlencode($name)
            ]));

            return 'https://www.linkedin.com/shareArticle?mini=true&' . $query;
        }

        if ($type == 'pinterest') {
            $query = urldecode(http_build_query([
                'url' => $url,
                'description' => urlencode($name)
            ]));

            return 'https://pinterest.com/pin/create/button/?media=&' . $query;
        }

        if ($type == 'google') {
            $query = urldecode(http_build_query([
                'url' => $url,
            ]));

            return 'https://plus.google.com/share?' . $query;
        }
    }
}

if (!function_exists('bio_url')) {
    function bio_url($user, $type = 'full', $link = false){
        // Check if $user is a workspace slug or user id/username
        $workspace = null;
        $userModel = null;
        
        // Try to find workspace by slug first
        $workspace = \App\Models\Workspace::where('slug', $user)->where('status', 1)->first();
        
        if ($workspace) {
            // It's a workspace slug
            $userModel = $workspace->user;
            $slug = $workspace->slug;
            
            // Get Domain for workspace
            $domain = \App\Models\Domain::where('workspace_id', $workspace->id)->where('is_active', 1)->first();
            if (!$domain) {
                // Fallback to user domain
                $domain = \App\Models\Domain::where('user', $userModel->id)->where('is_active', 1)->first();
            }
        } else {
            // Try to find user by id or username
            if (!$userModel = \App\User::find($user)) {
                $userModel = \App\User::where('username', $user)->first();
            }
            
            if (!$userModel) {
                return false;
            }
            
            $slug = $userModel->username;
            
            // Get Domain
            $domain = \App\Models\Domain::where('user', $userModel->id)->where('is_active', 1)->first();
        }
        
        if (!$userModel) {
            return false;
        }
        
        $domainUrl = $domain ? "$domain->scheme://$domain->host" : '';

        // Get Routed url - use workspace slug if available, otherwise username
        $routedLink = route('user-bio-home', $slug);

        // Defind returnValue to avoid errors
        $returnValue = !$domain ? $routedLink : $domainUrl;

        if (!plan('settings.custom_domain', $userModel->id)) {
            $returnValue = $routedLink;
        }

        $host = parse($returnValue, 'host');
        $path = parse($returnValue, 'path');
        $parse = "$host{$path}";

        $return = $type == 'full' ? $returnValue : $parse;

        if ($link) {
            $return = "$return/$link";
        }

        // Return the value
        return $return;
    }
}

if (!function_exists('EditBlocksContent')) {
    function EditBlocksContent($block_id){
        $model = new \App\Models\Block;
        $elements = new \App\Models\Blockselement;

        $block = $model->find($block_id);
        $block['elements'] = $elements->where('block_id', $block->id)
                            ->orderBy('position', 'ASC')
                            ->orderBy('id', 'DESC')
                            ->get();

        if (!$block) {
            return false;
        }

        // Check if block exists


        if (is_dir($path = base_path("sandy/Blocks/$block->block/Block"))) {
            $blockFolder = new \DirectoryIterator($path);

            if (file_exists($include = "$path/edit_block.php")) {
                require $include;
            }
        }

    }
}

if (!function_exists('GetBlocksContent')) {
    function GetBlocksContent($block_id){
        $model = new \App\Models\Block;
        $elements = new \App\Models\Blockselement;

        $block = $model->find($block_id);
        $block['elements'] = $elements->where('block_id', $block->id)
                            ->orderBy('position', 'ASC')
                            ->orderBy('id', 'DESC')
                            ->get();

        if (!$block) {
            return false;
        }

        // Check if block exists


        if (is_dir($path = base_path("sandy/Blocks/$block->block/Block"))) {
            $blockFolder = new \DirectoryIterator($path);

            if (file_exists($include = "$path/views.php")) {
                require $include;
            }
        }

    }
}

if (!function_exists('getYouTubeVideoId')) {
    function getYouTubeVideoId($url) {
            $regExp = "/^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((?:\w|-){11})(?:&list=(\S+))?$/";
            preg_match($regExp, $url, $video);
            return $video[1] ?? '';
    }
}

if (!function_exists('getVimeoId')) {
    function getVimeoId($url) {
        if (preg_match('#(?:https?://)?(?:www.)?(?:player.)?vimeo.com/(?:[a-z]*/)*([0-9]{6,11})[?]?.*#', $url, $m)) {
            return $m[1] ?? '';
        }
        return false;
    }
}

if (!function_exists('getVimeoThumb')) {
    function getVimeoThumb($id) {
        try {
            $arr_vimeo = unserialize(file_get_contents("https://vimeo.com/api/v2/video/$id.php"));
            return $arr_vimeo[0]['thumbnail_large'];
        } catch (\Exception $e) {
            
        }


        // return $arr_vimeo[0]['thumbnail_small']; // returns small thumbnail
        // return $arr_vimeo[0]['thumbnail_medium']; // returns medium thumbnail
        // return $arr_vimeo[0]['thumbnail_large']; // returns large thumbnail
    }
}
if (!function_exists('getDailyMotionId')) {
    function getDailyMotionId($url){
        if (preg_match('!^.+dailymotion\.com/(video|hub)/([^_]+)[^#]*(#video=([^_&]+))?|(dai\.ly/([^_]+))!', $url, $m)) {
            if (isset($m[6])) {
                return $m[6];
            }
            if (isset($m[4])) {
                return $m[4];
            }
            return $m[2] ?? '';
        }
        return false;
    }
}
if (!function_exists('getDailymotionThumb')) {
    function getDailymotionThumb($id) {
        try {
            $thumbnail_large_url = 'https://api.dailymotion.com/video/'.$id.'?fields=thumbnail_720_url'; //pass thumbnail_360_url, thumbnail_480_url, thumbnail_720_url, etc. for different sizes
            $json_thumbnail = file_get_contents($thumbnail_large_url);
            $arr_dailymotion = json_decode($json_thumbnail, TRUE);
            $thumb = $arr_dailymotion['thumbnail_720_url'];
            return $thumb;
          } catch (\Exception $e) {
                return false;

                // Log error
          }  
    }
}

if (!function_exists('getVideoBlocksThumbnail')) {
    function getVideoBlocksThumbnail($stream, $video){
        switch ($stream) {
            case 'youtube':
                $videoID = getYouTubeVideoId($video);

                return "https://img.youtube.com/vi/$videoID/maxresdefault.jpg";

                // sddefault.jpg - Low quality
                // mqdefault.jpg - Medium quality
                // hqdefault.jpg - High quality
                // maxresdefault.jpg - Max quality
            break;

            case 'vimeo':
                $videoID = getVimeoId($video);

                return getVimeoThumb($videoID);
            break;

            case 'dailymotion':
                $videoID = getDailyMotionId($video);

                return getDailymotionThumb($videoID);
            break;
        }

        return false;
    }
}

if (!function_exists('getEmbedableLink')) {
    function getEmbedableLink($stream = '', $video = ''){
        switch ($stream) {
            case 'youtube':
                if(preg_match('/^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((?:\w|-){11})(?:&list=(\S+))?$/', $video, $match)) {
                    $embed = $match[1] ?? '';

                    $embed = "https://www.youtube.com/embed/$embed?autoplay=1";
                    
                    return $embed;
                }
            break;
            case 'vimeo':
                if(preg_match('/https:\/\/(player\.)?vimeo\.com(\/video)?\/(\d+)/', $video, $match)) {
                    $embed = $match[3] ?? '';

                    $embed = "https://player.vimeo.com/video/$embed";

                    return $embed;
                }
            break;
            case 'twitch':
                if(preg_match('/^(?:https?:\/\/)?(?:www\.)?(?:twitch\.tv\/)(.+)$/', $video, $match)) {
                    $embed = $match[1] ?? '';

                    $server = $_SERVER['HTTP_HOST'];

                    $embed = "https://player.twitch.tv/?channel=$embed&autoplay=false&parent=$server";

                    return $embed;
                }
            break;
            case 'soundcloud':
                if(preg_match('/(soundcloud\.com)/', $video)) {
                    $embed = $video;

                    $embed = "https://w.soundcloud.com/player/?url=$embed&color=%23ff5500&auto_play=false&hide_related=false&show_comments=true&show_user=true&show_reposts=false&show_teaser=true&visual=true";

                    return $embed;
                }
            break;
            case 'dailymotion':
                $video_id = getDailyMotionId($video);

                $embed = "https://www.dailymotion.com/embed/video/$video_id?autoplay=1";

                return $embed;
            break;
        }

        return $video;
    }
}

if (!function_exists('getUserPixel')) {
    function getUserPixel($user){
        $pixels = \App\Models\Pixel::user($user)->active()->get();
        $skeleton = getOtherResourceFile('pixels');

        if (!plan('settings.pixel_codes', $user)) {
            return false;
        }

        $script = '';

        foreach ($pixels as $pixel) {
            $skelName = ao($skeleton, "$pixel->pixel_type.name");

            $script .= "

            <!-- ID:$pixel->name on $skelName Pixel:START  -->";


            $template = ao($skeleton, "$pixel->pixel_type.template");
            $template = str_replace('{pixel}', $pixel->pixel_id, $template);

            $script .= $template;

            $script .= "
            <!-- ID:$pixel->name on $skelName Pixel:END  -->";
        }


        return $script;
    }
}

if (!function_exists('addHttps')) {
    function addHttps($url, $scheme = 'https'){
        return parse_url($url, PHP_URL_SCHEME) === null ? "$scheme://$url" : $url;
    }
}

if (!function_exists('set_trans')) {
    function set_trans($trans){
        session()->put('locale', $trans);
        return back();
    }
}

if (!function_exists('validate_url')) {
    function validate_url( $url ) {

        $path = parse_url($url, PHP_URL_PATH);
        $encoded_path = array_map('urlencode', explode('/', $path));
        $url = str_replace($path, implode('/', $encoded_path), $url);

        return filter_var($url, FILTER_VALIDATE_URL) ? true : false;
    }
}

if (!function_exists('linker')) {
    function linker($uri, $user){
        $model = new \App\Models\Linker;

        if (!validate_url($uri)) {
            //return false;
        }

        $createLinker = function($url) use ($model, $user){
            $slug = \Str::random(5);
            $new = $model;
            $new->url = $url;
            $new->slug = $slug;
            $new->user = $user;
            $new->save();

            return $slug;
        };


        $route = function($slug, $user){
            return route('linker', ['slug' => $slug]);
        };

        if (!$linker = $model->where('user', $user)->where('url', $uri)->first()) {
            $slug = $createLinker($uri);


            return $route($slug, $user);
        }


        return $route($linker->slug, $user);
    }
}

if (!function_exists('hex2rgb')) {
    function hex2rgb( $colour ) {
        $hex = str_replace("#", "", $colour);

         if(strlen($hex) == 3) {
          $r = hexdec(substr($hex,0,1).substr($hex,0,1));
          $g = hexdec(substr($hex,1,1).substr($hex,1,1));
          $b = hexdec(substr($hex,2,1).substr($hex,2,1));
        } else {
          $r = hexdec(substr($hex,0,2));
          $g = hexdec(substr($hex,2,2));
          $b = hexdec(substr($hex,4,2));
        }
        return array( 'red' => $r, 'green' => $g, 'blue' => $b );

        if ( $colour[0] == '#' ) {
                $colour = substr( $colour, 1 );
        }
        if ( strlen( $colour ) == 6 ) {
                list( $r, $g, $b ) = array( $colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5] );
        } elseif ( strlen( $colour ) == 3 ) {
                list( $r, $g, $b ) = array( $colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2] );
        } else {
                return false;
        }
        $r = hexdec( $r );
        $g = hexdec( $g );
        $b = hexdec( $b );
        return array( 'red' => $r, 'green' => $g, 'blue' => $b );
    }
}

if (!function_exists('getAuthorizationHeader')) {
    function getAuthorizationHeader(){
        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        }
        else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            //print_r($requestHeaders);
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        return $headers;
    }
}

if (!function_exists('getBearerToken')) {
    function getBearerToken() {
        $headers = getAuthorizationHeader();
        // HEADER: Get the access token from the header
        if (!empty($headers)) {
            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                return $matches[1];
            }
        }
        return null;
    }
}

if (!function_exists('phpInput')) {
    function phpInput(){
        return json_decode(file_get_contents('php://input'), true);
    }
}

if (!function_exists('updateElement')) {
    function updateElement($id, $content = [], $extra = []){
        $element = \App\Models\Element::find($id);

        // Validate element
        $element->content = $content;

        foreach ($extra as $key => $value) {
            $element->{$key} = $value;
        }


        $element->save();

        return ['status' => true, 'response' => __('Updated successfully')];
    }
}

if (!function_exists('insertElement')) {
    function insertElement($user, $elementName, $content = [], $extra = []){
        $slug = \Str::random(4);
        $user = \App\User::find($user);
        $element = new \App\Models\Element;

        if (!$user) {
            return ['status' => false, 'response' => __('User not found')];
        }

        // Validate element
        // Get workspace_id from session if available
        $workspaceId = session('active_workspace_id', null);
        
        // ✅ Segurança: Validar que workspace da sessão pertence ao usuário
        if ($workspaceId) {
            $workspace = \App\Models\Workspace::where('id', $workspaceId)
                ->where('user_id', $user->id)
                ->where('status', 1)
                ->first();
            
            if (!$workspace) {
                // Workspace inválida, usar default
                $workspaceId = null;
            }
        }
        
        if (!$workspaceId) {
            // Fallback: get default workspace for user
            $defaultWorkspace = \App\Models\Workspace::where('user_id', $user->id)
                ->where('is_default', 1)
                ->where('status', 1)
                ->first();
            if ($defaultWorkspace) {
                $workspaceId = $defaultWorkspace->id;
            }
        }

        $element->user = $user->id;
        $element->workspace_id = $workspaceId;
        $element->slug = $slug;
        $element->element = $elementName;
        $element->content = $content;

        foreach ($extra as $key => $value) {
            $element->{$key} = $value;
        }


        $element->save();

        $data = [
            'element' => [
                'content' => [
                    'heading' => ao($extra, 'name')
                ],

                'is_element' => true,
                'element' => $element->id,
            ]
        ];
        \Blocks::create_block_sections($user->id, 'links', $data, $workspaceId);

        return ['status' => true, 'response' => __('Inserted successfully'), 'model' => $element, 'element_id' => $element->id];
    }
}

if (!function_exists('BioGlobal')) {
    function BioGlobal($array = []){
        foreach ($array as $key => $value) {
            $GLOBALS['BioGlobal'][$key] = $value;
        }

        return $GLOBALS['BioGlobal'];
    }
}

if (!function_exists('BioGlobalRetrieve')) {
    function BioGlobalRetrieve($key = null){
        return ao($GLOBALS['BioGlobal'], $key);
    }
}

if (!function_exists('elements')) {
    function elements($user, $workspace_id = null){
        $model = new \App\Models\Element;

        $elementsQuery = $model->where('user', $user);
        
        // Use workspace_id if provided, otherwise try session
        if ($workspace_id === null) {
            $workspace_id = session('active_workspace_id', null);
            
            // ✅ Segurança: Validar que workspace da sessão pertence ao usuário
            if ($workspace_id) {
                $workspace = \App\Models\Workspace::where('id', $workspace_id)
                    ->where('user_id', $user)
                    ->where('status', 1)
                    ->first();
                
                if (!$workspace) {
                    // Workspace inválida, não filtrar (mostrar todas do usuário ou null)
                    $workspace_id = null;
                }
            }
        }
        
        if ($workspace_id) {
            $elementsQuery->where('workspace_id', $workspace_id);
        }
        
        $elements = $elementsQuery->orderBy('id', 'DESC')->get();

        return $elements;
    }
}

if (!function_exists('colorFromImage')) {
    function colorFromImage($image){
        $color = false;

        try {
            $path = $image;
            $palette = \League\ColorExtractor\Palette::fromFilename($path);
            $colors = $palette->getMostUsedColors(1);
            foreach ($colors as $key => $value) {
                $color = \League\ColorExtractor\Color::fromIntToHex($key);
            }
        } catch (\Exception $e) {
                    
        }

        return $color;
    }
}

if (!function_exists('elemOrLink')) {
    function elemOrLink($id, $user){
        $blocksElem = \App\Models\Blockselement::find($id);

        //
        if (!$blocksElem) {
            return false;
        }



        $link = linker($blocksElem->link, $user);
        $html = "href=\"$link\" app-sandy-prevent=\"\" target=\"_blank\" ";

        if ($blocksElem->is_element) {
            if ($element = \App\Models\Element::find($blocksElem->element)) {
                // This is our element

                if (\Route::has("sandy-app-$element->element-render")) {
                    $link = route("sandy-app-$element->element-render", $element->slug);
                    //$link = linker($link, $user);

                    return "href=\"$link\" app-sandy-prevent=\"\"";
                }
            }
        }

        if (!empty($blocksElem->link)) {
            return $html;
        }


        return false;
    }
}

if (!function_exists('url_query')) {
    function url_query($to, array $params = [], array $additional = []) {
        $url = url($to, $additional);

        $params = !empty($params) ? '?' . \Arr::query($params) : '';
        return \Str::finish($url, $params);
    }
}

if (!function_exists('Ethumb')) {
    function Ethumb($location, array $item) {
        $type = ao($item, 'type');
        $url = '';

        switch ($type) {
            case 'upload':
                $thumb = ao($item, 'thumbnail');
                $url = gs($location, $thumb);
            break;
        }


        return $url;
    }
}

if (!function_exists('fancy_error')) {
    function fancy_error($method = null, $error = null) {
        return view('include.payment-error', ['method' => $method, 'error' => $error]);
    }
}

if (!function_exists('sandy_upload_modal')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function sandy_upload_modal($data = [], $location = false){

        if ($location) {
            $data['upload'] = gs($location, ao($data, 'upload'));
        }

        return view('mix::include.sandy-upload-modal', ['data' => $data]);
    }
}

if (!function_exists('sandy_upload_modal_upload')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function sandy_upload_modal_upload($request, $location, $file_size = '2048', $user_id = null, $update = false){
        $upload_file = function($input) use ($request, $location, $file_size, $user_id){

            $validation = 'image|mimes:jpeg,png,jpg,gif,svg';
            if ($file_size) {
                $validation = "$validation|max:$file_size";
            }

            if (empty($request->{$input})) {
                return false;
            }

            // Validate image (validação básica do Laravel)
            $request->validate([
                $input => $validation,
            ]);

            // ✅ Segurança: Validação adicional com magic bytes
            try {
                if (function_exists('validateImageFile')) {
                    $maxSizeBytes = is_numeric($file_size) ? ($file_size * 1024) : 2097152; // Converter KB para bytes
                    validateImageFile($request->{$input}, $maxSizeBytes);
                }
            } catch (\Exception $e) {
                throw new \Illuminate\Validation\ValidationException(
                    validator([], []),
                    [$input => [$e->getMessage()]]
                );
            }

            // ✅ Segurança: Sanitizar nome do arquivo
            $file = $request->file($input);
            if ($file) {
                $originalName = $file->getClientOriginalName();
                $sanitizedName = function_exists('sanitizeFileName') 
                    ? sanitizeFileName($originalName) 
                    : $originalName;
                
                // Usar nome sanitizado se diferente
                if ($sanitizedName !== $originalName && method_exists($file, 'storeAs')) {
                    // Aplicar nome sanitizado durante o upload
                }
            }

            // Image name
            $image = \UserStorage::put($location, $request->{$input}, $user_id);

            // Return image name
            return $image;
        };

        $process_image = $upload_file('sandy_upload_media_upload');


        // Thumbnail
        $image = [
            'type' => $request->sandy_upload_media_type,
            'upload' => $process_image,
            'link' => $request->sandy_upload_media_link,
            'solid_color' => $request->sandy_upload_solid_color
        ];

        if ($update) {
            $image['upload'] = ao($update, 'upload');
            if ($process_image) {
                if (mediaExists($location, ao($update, 'upload'))) {
                    storageDelete($location, ao($update, 'upload'));
                }
                $image['upload'] = $process_image;
            }
        }


        return $image;
    }
}

if (!function_exists('media_or_url')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function media_or_url($data = [], $location = null, $html_media = false){
        $return = '';
        $type = ao($data, 'type');

        switch ($type) {
            case 'upload':
                $thumb = ao($data, 'upload');
                if (!empty($thumb) && mediaExists($location, $thumb)) {
                    $return = gs($location, $thumb);
                }
            break;

            case 'external':
                $return = ao($data, 'link');
            break;

            case 'solid_color':
                $return = ao($data, 'solid_color');
            break;
        }


        if ($html_media) {

            if ($type == 'solid_color') {
                $solid = ao($data, 'solid_color');
                return "<div style=\"background: $solid\" class=\"solid-color sandy-upload-modal-identifier\"></div>";
            }
            return videoOrImage($return, ['no_lozad' => true]);
        }



        return $return;
    }
}


if (!function_exists('my_log')) {
    function my_log(){
        if (file_exists(storage_path('logs/sandy.log'))) {
            $logfile = storage_path('logs/sandy.log');
        }else{
            file_put_contents(storage_path('logs/sandy.log'), '"========================== START ========================"' . PHP_EOL, FILE_APPEND);
            return false;
        }
        $args = func_get_args();
        $message = array_shift($args);

        if (is_array($message)) $message = implode(PHP_EOL, $message);

        $message = "[" . date("Y/m/d h:i:s", time()) . "] " . vsprintf($message, $args) . PHP_EOL;
        file_put_contents($logfile, $message, FILE_APPEND);
    }
}


if (!function_exists('support_conversation_messages')) {
    function support_conversation_messages($id, $looking = 'user'){
        $carbon = new \Carbon\Carbon;


        $conversation = \App\Models\SupportConversation::where('id', $id)->first();
        $messages = \App\Models\SupportMessage::where('conversation_id', $conversation->id)->get()->groupBy(function($date) {
          return $date->created_at->format('Y-m-d');
        });


        $html = '';


        if ($messages->isEmpty()) {
            return '<div class="is-empty p-20 text-center"><img src="'. gs('assets/image/others', 'empty-fld.png') .'" class="w-half m-auto" alt=""><p class="mt-10 text-lg font-bold">'. __('No messages found!') .'</p></div>';
        }

        foreach ($messages as $date => $items) {
            if ($carbon->parse($date)->isToday()) {
              $date = __('Today');
            }elseif ($carbon->parse($date)->isYesterday()) {
              $date = __('Yesterday');
            }else{
              $date = $carbon->parse($date)->diffForHumans();
            }

            $html .= '<div class="divider-container"><div class="divider"><span>' . $date . '</span></div></div>';


            foreach ($items as $item) {
                $avatar = avatar($item->from_id);
                $user_id = $item->from_id;
                $from = $item->from == 'user' ? 'is-left' : 'is-right';

                $html .= '<div class="message-item '. $from .'"><div class="message-ava"><div class="h-avatar md"><img class="object-cover" src="'. $avatar .'" alt=""></div></div><div class="message-details"><div class="message-head"><div class="message-man">'. user('name', $user_id) .'</div><div class="message-time">'. $carbon->parse($item->created_at)->diffForHumans() .'</div></div><div class="message-body">';


                switch ($item->type) {
                    case 'text':
                        $html .= '<div class="message-text">'. $item->data .'<div class="message-actions hidden"></div></div>';
                    break;

                    case 'link':
                        $html .= '<div class="files-item blue"> <div class="files-preview text-lg flex items-center justify-center"> <i class="sio seo-and-marketing-058-linked sligh-thick"></i> </div><div class="files-details"> <div class="files-title caption">'. __('Shared a link') .' </div><a href="'. $item->data .'" target="_blank" class="text-link text-sm" data-hover="'. $item->data .'">'. __('Open Link') .'</a> </div></div>';
                    break;


                    case 'image':
                        $image = gs('media/site/support', $item->data);
                        $parse = pathinfo($image);

                        $html .= '<div class="image-container"> <img data-src="'. $image .'" class="lozad"> <div class="image-overlay"></div><div class="image-actions"> <div class="actions-inner"> <a href="'. $image .'" download="'. ao($parse, 'basename') .'" class="action card-shadow"> <i class="sio network-icon-047-cloud-download sligh-thick"></i> </a> <a target="_blank" class="action messaging-popup sandy-fancybox" data-fancybox="gallery" data-src="'. $image .'" href="javascript:;"> <i class="sio seo-and-marketing-058-linked sligh-thick"></i> </a> </div></div></div>';
                    break;

                    case 'file':
                        $file = gs('media/site/support', $item->data);
                        $parse = pathinfo($file);
                        $html .= '<div class="files-item purple"> <div class="files-preview text-lg flex items-center justify-center"> <i class="sio seo-and-marketing-058-linked sligh-thick"></i> </div><div class="files-details"> <div class="files-title caption">'. __('Shared a File') .' </div><a href="'. $file .'" download="'. ao($parse, 'basename') .'" class="text-link text-sm" data-hover="'. $item->data .'">'. __('Download') .'</a> </div></div>';
                    break;
                }



                $html .= '</div></div></div>';
            }
        }



        return $html;
    }
}

if (!function_exists('formatBytes')) {
    function formatBytes($bytes, $precision = 2) {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        
        if ($bytes <= 0) {
            return '0 B';
        }
        
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        
        $bytes /= (1 << (10 * $pow));
        
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}


if (!function_exists('money')) {
    function money($amount, $currency = null){
        if (empty($currency)) {
            $currency = 'USD';
            if (function_exists('settings')) {
                // Try common keys
                $c = settings('payment.currency') ?? settings('payments.currency');
                if ($c) $currency = $c;
            }
        }
        
        return price_with_cur($currency, $amount);
    }
}

if (!function_exists('getCountries')) {
    function getCountries() {
        return [
            "AF" => "Afghanistan",
            "AL" => "Albania",
            "DZ" => "Algeria",
            "AS" => "American Samoa",
            "AD" => "Andorra",
            "AO" => "Angola",
            "AI" => "Anguilla",
            "AQ" => "Antarctica",
            "AG" => "Antigua and Barbuda",
            "AR" => "Argentina",
            "AM" => "Armenia",
            "AW" => "Aruba",
            "AU" => "Australia",
            "AT" => "Austria",
            "AZ" => "Azerbaijan",
            "BS" => "Bahamas",
            "BH" => "Bahrain",
            "BD" => "Bangladesh",
            "BB" => "Barbados",
            "BY" => "Belarus",
            "BE" => "Belgium",
            "BZ" => "Belize",
            "BJ" => "Benin",
            "BM" => "Bermuda",
            "BT" => "Bhutan",
            "BO" => "Bolivia",
            "BA" => "Bosnia and Herzegovina",
            "BW" => "Botswana",
            "BV" => "Bouvet Island",
            "BR" => "Brazil",
            "IO" => "British Indian Ocean Territory",
            "BN" => "Brunei Darussalam",
            "BG" => "Bulgaria",
            "BF" => "Burkina Faso",
            "BI" => "Burundi",
            "KH" => "Cambodia",
            "CM" => "Cameroon",
            "CA" => "Canada",
            "CV" => "Cape Verde",
            "KY" => "Cayman Islands",
            "CF" => "Central African Republic",
            "TD" => "Chad",
            "CL" => "Chile",
            "CN" => "China",
            "CX" => "Christmas Island",
            "CC" => "Cocos (Keeling) Islands",
            "CO" => "Colombia",
            "KM" => "Comoros",
            "CG" => "Congo",
            "CD" => "Congo, the Democratic Republic of the",
            "CK" => "Cook Islands",
            "CR" => "Costa Rica",
            "CI" => "Cote D'Ivoire",
            "HR" => "Croatia",
            "CU" => "Cuba",
            "CY" => "Cyprus",
            "CZ" => "Czech Republic",
            "DK" => "Denmark",
            "DJ" => "Djibouti",
            "DM" => "Dominica",
            "DO" => "Dominican Republic",
            "EC" => "Ecuador",
            "EG" => "Egypt",
            "SV" => "El Salvador",
            "GQ" => "Equatorial Guinea",
            "ER" => "Eritrea",
            "EE" => "Estonia",
            "ET" => "Ethiopia",
            "FK" => "Falkland Islands (Malvinas)",
            "FO" => "Faroe Islands",
            "FJ" => "Fiji",
            "FI" => "Finland",
            "FR" => "France",
            "GF" => "French Guiana",
            "PF" => "French Polynesia",
            "TF" => "French Southern Territories",
            "GA" => "Gabon",
            "GM" => "Gambia",
            "GE" => "Georgia",
            "DE" => "Germany",
            "GH" => "Ghana",
            "GI" => "Gibraltar",
            "GR" => "Greece",
            "GL" => "Greenland",
            "GD" => "Grenada",
            "GP" => "Guadeloupe",
            "GU" => "Guam",
            "GT" => "Guatemala",
            "GN" => "Guinea",
            "GW" => "Guinea-Bissau",
            "GY" => "Guyana",
            "HT" => "Haiti",
            "HM" => "Heard Island and Mcdonald Islands",
            "VA" => "Holy See (Vatican City State)",
            "HN" => "Honduras",
            "HK" => "Hong Kong",
            "HU" => "Hungary",
            "IS" => "Iceland",
            "IN" => "India",
            "ID" => "Indonesia",
            "IR" => "Iran, Islamic Republic of",
            "IQ" => "Iraq",
            "IE" => "Ireland",
            "IL" => "Israel",
            "IT" => "Italy",
            "JM" => "Jamaica",
            "JP" => "Japan",
            "JO" => "Jordan",
            "KZ" => "Kazakhstan",
            "KE" => "Kenya",
            "KI" => "Kiribati",
            "KP" => "Korea, Democratic People's Republic of",
            "KR" => "Korea, Republic of",
            "KW" => "Kuwait",
            "KG" => "Kyrgyzstan",
            "LA" => "Lao People's Democratic Republic",
            "LV" => "Latvia",
            "LB" => "Lebanon",
            "LS" => "Lesotho",
            "LR" => "Liberia",
            "LY" => "Libyan Arab Jamahiriya",
            "LI" => "Liechtenstein",
            "LT" => "Lithuania",
            "LU" => "Luxembourg",
            "MO" => "Macao",
            "MK" => "Macedonia, the Former Yugoslav Republic of",
            "MG" => "Madagascar",
            "MW" => "Malawi",
            "MY" => "Malaysia",
            "MV" => "Maldives",
            "ML" => "Mali",
            "MT" => "Malta",
            "MH" => "Marshall Islands",
            "MQ" => "Martinique",
            "MR" => "Mauritania",
            "MU" => "Mauritius",
            "YT" => "Mayotte",
            "MX" => "Mexico",
            "FM" => "Micronesia, Federated States of",
            "MD" => "Moldova, Republic of",
            "MC" => "Monaco",
            "MN" => "Mongolia",
            "MS" => "Montserrat",
            "MA" => "Morocco",
            "MZ" => "Mozambique",
            "MM" => "Myanmar",
            "NA" => "Namibia",
            "NR" => "Nauru",
            "NP" => "Nepal",
            "NL" => "Netherlands",
            "AN" => "Netherlands Antilles",
            "NC" => "New Caledonia",
            "NZ" => "New Zealand",
            "NI" => "Nicaragua",
            "NE" => "Niger",
            "NG" => "Nigeria",
            "NU" => "Niue",
            "NF" => "Norfolk Island",
            "MP" => "Northern Mariana Islands",
            "NO" => "Norway",
            "OM" => "Oman",
            "PK" => "Pakistan",
            "PW" => "Palau",
            "PS" => "Palestinian Territory, Occupied",
            "PA" => "Panama",
            "PG" => "Papua New Guinea",
            "PY" => "Paraguay",
            "PE" => "Peru",
            "PH" => "Philippines",
            "PN" => "Pitcairn",
            "PL" => "Poland",
            "PT" => "Portugal",
            "PR" => "Puerto Rico",
            "QA" => "Qatar",
            "RE" => "Reunion",
            "RO" => "Romania",
            "RU" => "Russian Federation",
            "RW" => "Rwanda",
            "SH" => "Saint Helena",
            "KN" => "Saint Kitts and Nevis",
            "LC" => "Saint Lucia",
            "PM" => "Saint Pierre and Miquelon",
            "VC" => "Saint Vincent and the Grenadines",
            "WS" => "Samoa",
            "SM" => "San Marino",
            "ST" => "Sao Tome and Principe",
            "SA" => "Saudi Arabia",
            "SN" => "Senegal",
            "CS" => "Serbia and Montenegro",
            "SC" => "Seychelles",
            "SL" => "Sierra Leone",
            "SG" => "Singapore",
            "SK" => "Slovakia",
            "SI" => "Slovenia",
            "SB" => "Solomon Islands",
            "SO" => "Somalia",
            "ZA" => "South Africa",
            "GS" => "South Georgia and the South Sandwich Islands",
            "ES" => "Spain",
            "LK" => "Sri Lanka",
            "SD" => "Sudan",
            "SR" => "Suriname",
            "SJ" => "Svalbard and Jan Mayen",
            "SZ" => "Swaziland",
            "SE" => "Sweden",
            "CH" => "Switzerland",
            "SY" => "Syrian Arab Republic",
            "TW" => "Taiwan, Province of China",
            "TJ" => "Tajikistan",
            "TZ" => "Tanzania, United Republic of",
            "TH" => "Thailand",
            "TL" => "Timor-Leste",
            "TG" => "Togo",
            "TK" => "Tokelau",
            "TO" => "Tonga",
            "TT" => "Trinidad and Tobago",
            "TN" => "Tunisia",
            "TR" => "Turkey",
            "TM" => "Turkmenistan",
            "TC" => "Turks and Caicos Islands",
            "TV" => "Tuvalu",
            "UG" => "Uganda",
            "UA" => "Ukraine",
            "AE" => "United Arab Emirates",
            "GB" => "United Kingdom",
            "US" => "United States",
            "UM" => "United States Minor Outlying Islands",
            "UY" => "Uruguay",
            "UZ" => "Uzbekistan",
            "VU" => "Vanuatu",
            "VE" => "Venezuela",
            "VN" => "Viet Nam",
            "VG" => "Virgin Islands, British",
            "VI" => "Virgin Islands, U.s.",
            "WF" => "Wallis and Futuna",
            "EH" => "Western Sahara",
            "YE" => "Yemen",
            "ZM" => "Zambia",
            "ZW" => "Zimbabwe"
        ];
    }
}
