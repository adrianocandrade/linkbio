<?php

namespace Sandy\Plugins\api\Controllers\Api;

use Illuminate\Routing\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Route, Response;
use App\User;
use App\Models\Block;
use App\Models\Blockselement;

class BlockController extends Controller{
    public function retrieve(Request $request){
        // Get User
        $user = User::api($request->s_token)->first();

        $input = phpInput();
        
        // Page
        $page = (int) ao($input, 'page');
        if (!is_int($page)) {
            $page = 1;
        }

        // Paginate
        $paginate = (int) ao($input, 'results_per_page');
        if (!in_array($paginate, [10, 25, 50, 100, 250])) {
            $paginate = 10;
        }

        // Blocks
        $blocks = Block::where('user', $user->id);

        if ($request->has('workspace_id')) {
            $blocks->where('workspace_id', $request->workspace_id);
        }

        $blocks = $blocks->paginate(
            $paginate,
            ['*'],
            'page',
            $page
        );

        $block = [];

        foreach ($blocks as $item) {
            $elementsModel = Blockselement::where('block_id', $item->id)->orderBy('position', 'ASC')->orderBy('id', 'DESC')->get();

            $items = [];

            foreach ($elementsModel as $value) {
                $value['thumbnail'] = getStorage('media/blocks', $value->thumbnail);

                $items[] = $value;
            }

            $item['items'] = $items;
            
            $block[] = $item;
        }

        $blocks = $blocks->toArray();

        $response = [
            'status' => true,
            'response' => $block,

            'meta' => [
                'current_page' => ao($blocks, 'current_page'),
                'first_page_url' => ao($blocks, 'first_page_url'),
                'from' => ao($blocks, 'from'),
                'last_page' => ao($blocks, 'last_page'),
                'last_page_url' => ao($blocks, 'last_page_url'),
                'next_page_url' => ao($blocks, 'next_page_url'),
                'path' => ao($blocks, 'path'),
                'per_page' => ao($blocks, 'per_page'),
                'prev_page_url' => ao($blocks, 'prev_page_url'),
                'to' => ao($blocks, 'to'),
                'total' => ao($blocks, 'total'),
            ],
        ];

        return Response::json($response);
    }

    public function single($block_id, Request $request){
        // Get User
        $user = User::api($request->s_token)->first();

        $input = json_decode(file_get_contents('php://input'), true);

        // Blocks
        $query = Block::where('user', $user->id)->where('id', $block_id);

        if ($request->has('workspace_id')) {
            $query->where('workspace_id', $request->workspace_id);
        }

        $block = $query->first();

        if (!$block) {
            $response = [
                'status' => false,
                'message' => __('Block not Found'),
            ];
            return Response::json($response);
        }

        $elementsModel = Blockselement::where('block_id', $block->id)->orderBy('position', 'ASC')->orderBy('id', 'DESC')->get();

        $items = [];

        foreach ($elementsModel as $value) {
            $value['thumbnail'] = getStorage('media/blocks', $value->thumbnail);

            $items[] = $value;
        }

        $block['items'] = $items;

        $response = [
            'status' => true,
            'response' => $block,
        ];

        return Response::json($response);
    }
}