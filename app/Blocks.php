<?php

namespace App;

use Illuminate\Support\ServiceProvider;
use App\Models\Block;
use App\Models\Blockselement;

class Blocks{
    private $path;
    private $dir;

    function __construct(){
        $plugins = base_path('sandy/Blocks');
        $this->dir = $plugins;
        $this->path = scandir($plugins);
    }

    public static function has($plugin){
        $self = new self();
        $pluginDir = "$self->dir/$plugin";
        if (is_dir($pluginDir)) {
            return true;
        }

        return false;
    }

    public static function dir($block, $dir = ''){
        $self = new self();
        $blockDir = "$self->dir/$block";
        if (is_dir($blockDir)) {
            return "$blockDir/$dir";
        }

        return false;
    }

    public function getInstalledPlugins(){
        $plugins = [];

        $directory = new \DirectoryIterator($this->dir);


        foreach ($directory as $info){
            if (!$info->isDot()) {
                $plugin = $info->getFilename();
                $path = $info->getPathname();

                if (file_exists($config = "{$path}/config.php")) {
                    
                    $config = require $config;
                    foreach($config as $key => $value){
                        $plugins[$key] = $value;
                    }
                }
            }
        }



        return $plugins;
    }



    public static function linktree_links($user_id, $username){

        try {
            $html = file_get_contents("https://linktr.ee/" . $username);
            //Create a new DOM document
            $dom = new \DOMDocument;

            //Parse the HTML. The @ is used to suppress any parsing errors
            //that will be thrown if the $html string isn't valid XHTML.
            @$dom->loadHTML($html);

            //Get all links. You could also use any other tag name here,
            //like 'img' or 'table', to extract other tags.
            $links = $dom->getElementsByTagName('a');

            if (!empty($links)) {

                $wrapper = new Block;
                $wrapper->user = $user_id;
                $wrapper->block = 'links';
                $wrapper->blocks = [];
                $wrapper->save();


                $i = 0;
                //Iterate over the extracted links and display their URLs
                foreach ($links as $link){
                    $i++;
                    if ($link->firstChild->tagName == 'p' && !\Str::contains($link->getAttribute('href'), 'linktr.ee')) {

                        // Elements
                        $blocks = new Blockselement;
                        $blocks->block_id = $wrapper->id;
                        $blocks->user = $user_id;
                        $blocks->thumbnail = [];
                        $blocks->link = $link->getAttribute('href');
                        $blocks->content = ['heading' => $link->nodeValue];
                        $blocks->position = $i;
                        $blocks->is_element = 0;

                        $blocks->save();
                    }
                }
            }

            return true;
        } catch (\Exception $e) {
            
        }

        return false;
    }

    public static function LinkOrElementHtml($user_id, $defaults = []){
        if (!$user = \App\User::find($user_id)) {
            return false;
        }

        return view('mix::include.element-skel', ['user' => $user, 'defaults' => $defaults]);
    }





    public static function add_config($config = []){
        $blocks = config('blocks');

        foreach ($config as $key => $value) {
            $blocks[$key] = $value;
        }


        config(['blocks' => $blocks]);
    }

    public static function block_create_route($block){
        $route = "sandy-blocks-$block-skel";

        if (\Route::has($route)) {

            return route($route);
        }

        $route = config("blocks.$block.route");
        if ($route && \Route::has($route)) {

            return route($route);
        }

        return '#';

    }



    public static function create_block_sections($user_id, $type, $data = [], $workspace_id = null){
        $blocks = ao($data, 'blocks');
        $thumbnail = ao($data, 'element.thumbnail');

        $link = ao($data, 'element.link');

        $content = ao($data, 'element.content');
        if (ao($data, 'element.is_element') && $i_element = \App\Models\Element::find(ao($data, 'element.element'))) {
            $link = \Route::has("sandy-app-$i_element->element-render") ? parse(route("sandy-app-$i_element->element-render", $i_element->slug), 'path') : '';
            $content['link'] = $link;
        }

        // Get workspace_id if not provided
        if (!$workspace_id) {
            $workspace_id = session('active_workspace_id', null);
            
            // ✅ Segurança: Validar que workspace da sessão pertence ao usuário
            if ($workspace_id) {
                $workspace = \App\Models\Workspace::where('id', $workspace_id)
                    ->where('user_id', $user_id)
                    ->where('status', 1)
                    ->first();
                
                if (!$workspace) {
                    // Workspace inválida, usar default
                    $workspace_id = null;
                }
            }
            
            if (!$workspace_id) {
                // Fallback: get default workspace for user
                $defaultWorkspace = \App\Models\Workspace::where('user_id', $user_id)
                    ->where('is_default', 1)
                    ->where('status', 1)
                    ->first();
                if ($defaultWorkspace) {
                    $workspace_id = $defaultWorkspace->id;
                }
            }
        }

        $wrapper = new Block;
        $wrapper->user = $user_id;
        $wrapper->workspace_id = $workspace_id;
        $wrapper->block = $type;
        $wrapper->blocks = $blocks;
        $wrapper->save();


        // Elements
        $blocks = new Blockselement;
        $blocks->block_id = $wrapper->id;
        $blocks->user = $user_id;
        $blocks->thumbnail = $thumbnail;
        $blocks->link = addHttps($link);
        $blocks->content = $content;
        $blocks->is_element = ao($data, 'element.is_element');

        if (ao($data, 'element.is_element')) {
            $blocks->element = ao($data, 'element.element');
        }

        $blocks->save();

        return true;
    }

    public static function preset_blocks($user){
        $skel = self::preset_blocks_skel();

        if (!$user = \App\User::find($user)) {
            return false;
        }

        foreach ($skel['sections'] as $key => $value) {
            // Block
            $section = new Block;
            $section->block = $key;
            $section->user = $user->id;
            $section->blocks = ao($value, 'content');
            $section->save();

            //

            if (is_array(ao($value, 'blocks'))) {
                foreach (ao($value, 'blocks') as $key => $value) {
                    $block = new Blockselement;
                    $block->block_id = $section->id;
                    $block->thumbnail = ao($value, 'thumbnail');
                    $block->user = $user->id;
                    $block->content = ao($value, 'content');
                    $block->save();
                }
            }
        }

        $user->bio = ao($skel, 'others.bio');
        $user->save();

        return true;
    }


    public static function preset_blocks_skel(){
        $skel = [

                'image' => [
                    'blocks' => [
                        'item_2' => [
                            'thumbnail' => [
                                'type' => 'external',
                                'upload' => null,
                                'link' => gs('assets/image/others', 'default-sandy-skeleton.png')
                            ],


                            'content' => [
                                'caption' => __('Second Image'),
                                'alt' => __('Our Second Preset Image')
                            ],
                        ],
                        'item_1' => [
                            'thumbnail' => [
                                'type' => 'external',
                                'upload' => null,
                                'link' => gs('assets/image/others', 'default-sandy-skeleton.png')
                            ],


                            'content' => [
                                'caption' => __('First Image'),
                                'alt' => __('Our First Preset Image')
                            ],
                        ],
                    ],
                ],

                'links' => [
                    'blocks' => [
                        'link_1' => [
                            'thumbnail' => [
                                'type' => 'external',
                                'upload' => null,
                                'link' => gs('assets/image/others', 'default-sandy-skeleton.png')
                            ],


                            'content' => [
                                'heading' => __('Crazy Links 🥴')
                            ],
                        ],
                        'link_2' => [
                            'thumbnail' => [
                                'type' => 'external',
                                'upload' => null,
                                'link' => gs('assets/image/others', 'default-sandy-skeleton.png')
                            ],


                            'content' => [
                                'heading' => __('Earn Cash 🤑')
                            ],
                        ],
                        'link_3' => [
                            'thumbnail' => [
                                'type' => 'external',
                                'upload' => null,
                                'link' => gs('assets/image/others', 'default-sandy-skeleton.png')
                            ],


                            'content' => [
                                'heading' => __('Dont Click! 😺')
                            ],
                        ],
                    ],
                ],
                'text' => [
                    'content' => [
                        'heading' => __('Welcome Aboard 🤩'),
                        'content' => __('<ul><li><p>We have added some blocks to help you get started.</p></li></ul><ul><li><p>Click this to edit or any of the elements below.</p></li></ul><ul><li><p>You can drag them to reorder their position.</p></li></ul><ul><li><p>Click on the (+) icon to add more blocks.</p></li></ul><ul><li><p>Click on the blot menu to add elements.</p></li></ul><ul><li><p>Elements can be in the form of email collection, paid items, etc.</p></li></ul>'),
                    ]
                ]
        ];

        $others = [
            'bio' => __('Click here to add a brief summary about your page to get your audience interested in what you do.')
        ];
        $returned = [
            'sections' => $skel,
            'others' => $others
        ];

        return $returned;
    }
}
