@extends(Route::has('docs-index') ? 'docs::layouts.master' : 'index::layouts.master')
@section('title', __('Api'))
@section('content')
<div class="md:p-20 p-5">
  <div class="api-docs-div lg:grid lg:grid-cols-5 gap-4 sandy-tabs">
    <div class="api-docs-menu mb-8 md:mb-0 md:flex">
      <a class="nav-link sandy-tabs-link active" href="#">
        <i class="icon sio maps-and-navigation-049-home"></i>
        {{ __('General') }}
      </a>
      <a class="nav-link sandy-tabs-link" href="#">
        <i class="icon sio network-icon-069-users"></i>
        {{ __('User') }}
      </a>
      <a class="nav-link sandy-tabs-link" href="#">
        <i class="icon sio database-and-storage-063-page-layout"></i>
        {{ __('Blocks') }}
      </a>
      <a class="nav-link sandy-tabs-link" href="#">
        <i class="icon sio shopping-icon-024-store"></i>
        {{ __('Plan') }}
      </a>
      <a class="nav-link sandy-tabs-link" href="#">
        <i class="sio internet-074-bar-chart icon"></i>
        {{ __('Analytics') }}
      </a>
      <a class="nav-link sandy-tabs-link" href="#">
        <i class="icon sio design-and-development-017-blog-template"></i>
        {{ __('Pixels') }}
      </a>
      <a class="nav-link sandy-tabs-link" href="#">
        <i class="icon sio banking-finance-flaticon-003-line-chart"></i>
        {{ __('Activities') }}
      </a>
      <a class="nav-link sandy-tabs-link" href="#">
        <i class="icon sio communication-006-chat-bubble"></i>
        {{ __('Audience') }}
      </a>
      <a class="nav-link sandy-tabs-link" href="#">
        <i class="icon sio shopping-icon-010-check"></i>
        {{ __('Membership') }}
      </a>
    </div>
    <div class="api-docs-content col-span-4">
      <div class="sandy-tabs-item" >
        <div class="mb-5">
          <h2 class="text-black text-xl mb-1">{{ __('Api Documentation') }}</h2>
        </div>
        <div class="title-sections mb-14">
          <p class="text-black text-sm">{{ __('This is the documentation for the available API endpoints, which are built around the REST architecture. All the API endpoints will return a JSON response with the standard HTTP response codes and need a Bearer Authentication via an API Key') }}</p>
        </div>
        <div class="step-banner bg-gray-500 rounded-xl mb-14">
          <div class="text-base mb-5">
            {{ __("Here's the base api url where you will send requests to with the endpoints") }}
          </div>
          <div class="is-label text-white">{{ __('Api Url') }}</div>
          <div class="form-input copy active">
            <input type="text" value="{{ route('sandy-api-index') }}" readonly="">
            <div class="copy-btn" data-copy="{{ route('sandy-api-index') }}" data-after-copy="{{ __('Copied') }}">
              <i class="la la-copy"></i>
            </div>
          </div>
        </div>
        <div class="title-sections mb-10">
          <h2 class="text-black mb-1 text-lg">{{ __('Workspaces') }}</h2>
          <p class="text-black text-sm">{{ __('You can filter results by a specific workspace by passing the `workspace_id` query parameter to any endpoint.') }}</p>
        </div>
        <div class="title-sections mb-10">
          <h2 class="text-black mb-1 text-lg">{{ __('Auth') }}</h2>
          <p class="text-black text-sm">{{ __('All the API endpoints require an API key sent by the Bearer Authentication method') }}</p>
        </div>
        <div class="mb-5 pb-3">
          {{ __('Example Request') }}
        </div>
        <div class="dark-code">
          curl --request GET \
          --url '{{ route('sandy-api-index') }}/<span class="c-cyan">{endpoint}</span>' \
          --header 'Authorization: Bearer <span class="c-cyan">{api_key}</span>' \
        </div>
        <div class="title-sections mb-10 mt-10">
          <h2 class="text-black mb-1 text-lg">{{ __('Example') }}</h2>
          <p class="text-black text-sm">{{ __('Example method in different languages on how to post requests to our api') }}</p>
        </div>
        <div class="sandy-accordion">
          <div class="sandy-accordion-head">{{ __('Curl') }}</div>
          <div class="sandy-accordion-body">
            <div class="sandy-accordion-content">
              <div class="dark-code">
                curl --request GET \
                --url '{{ route('sandy-api-index') }}/<span class="c-cyan">{endpoint}</span>' \
                --header 'Authorization: Bearer <span class="c-cyan">{api_key}</span>' \
                -d {page: 2}
              </div>
            </div>
          </div>
        </div>
        <div class="sandy-accordion">
          <div class="sandy-accordion-head">{{ __('PHP') }}</div>
          <div class="sandy-accordion-body">
            <div class="sandy-accordion-content">
                                            <pre class="language-php">
                                                  <code>
                                                    $url = '{{ route('sandy-api-index') }}/<span class="c-cyan">{endpoint}</span>';
                                                    $body = [
                                                          'page' => 2,
                                                          'results_per_page' => 25,
                                                    ];
                                                    $body = json_encode($body);
                                                    // Open connection
                                                    $ch = curl_init();
                                                    curl_setopt($ch,CURLOPT_URL, $url);
                                                    // Set either it's a POST or GET request
                                                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
                                                    curl_setopt($ch,CURLOPT_POST, true);
                                                    // Add post body array if available
                                                    // Uncomment this line if you want to post data to api
                                                    #curl_setopt($ch,CURLOPT_POSTFIELDS, $body);
                                                    // Your headers with api key as the Authorization Bearer
                                                    curl_setopt($ch, CURLOPT_HTTPHEADER, [
                                                      "Authorization: Bearer {api_key}",
                                                      "Cache-Control: no-cache",
                                                      "Content-Type" => "application/json",
                                                    ]);
                                                    
                                                    //So that curl_exec returns the contents of the cURL; rather than echoing it
                                                    curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
                                                    
                                                    //execute post
                                                    $result = curl_exec($ch);
                                                    // Echo Result
                                                    echo $result;
                                                  </code>
              </pre>
            </div>
          </div>
        </div>
        <div class="sandy-accordion">
          <div class="sandy-accordion-head">{{ __('Laravel Guzzle HTTP') }}</div>
          <div class="sandy-accordion-body">
            <div class="sandy-accordion-content">
                                            <pre class="language-php">
                                                  <code>
                                                    // Post URL
                                                    $url = '{{ route('sandy-api-index') }}/<span class="c-cyan">{endpoint}</span>';
                                                    // Init Guzzel Client
                                                    $client = new \GuzzleHttp\Client();
                                                    // Set headers with api key as the Authorization Bearer
                                                    $headers = [
                                                        'Content-Type' => 'application/json',
                                                        'cache-control' => 'no-cache',
                                                        'Authorization' => "Bearer {api_key}",
                                                    ];
                                                    // Post data array
                                                    $body = [
                                                        'page' => 1,
                                                        'results_per_page' => 10,
                                                    ];
                                                    $body = json_encode($body);
                                                    // Guzzle Content with headers and body 
                                                    $content = ['headers' => $headers];
                                                    // Uncomment this line if you want to post data to api
                                                    #$content['body'] = $body;
                                                    // Post Content to api and Set either it's a POST or GET request
                                                    $response = $client->request('GET', $url, $content);
                                                    // Echo Result
                                                    echo $response->getBody()->getContents();
                                                  </code>
              </pre>
            </div>
          </div>
        </div>
      </div>
      <div class="sandy-tabs-item" id="user">
        <div class="sandy-accordion">
          <div class="sandy-accordion-head">{{ __('Retrieve User') }}</div>
          <div class="sandy-accordion-body">
            <div class="sandy-accordion-content">
              <div class="mb-5 py-3">
                {{ __('Endpoint') }}
              </div>
                                          <pre class="mb-5 language-O flex items-center">
                                                <span class="text-sticker success mr-3 mt-0 no-shadow">{{ __('GET') }}</span>
                                                <span>{{ route('sandy-api-retrieve-user') }}</span>
              </pre>
              <div class="mb-5 py-3">
                {{ __('Example Request') }}
              </div>
                                          <pre>
                                                <code class="language-O">
                                                  curl --request GET \
                                                  --url '{{ route('sandy-api-retrieve-user') }}' \
                                                  --header 'Authorization: Bearer <span class="c-cyan">{api_key}</span>' \
                                                </code>
              </pre>
              <div class="mb-5 py-3">
                {{ __('Response') }}
              </div>
                                          <pre>
                                                <code class="language-json">
                                                  {
                                                     "response":{
                                                        "id":1,
                                                        "email":"example@gmail.com",
                                                        "name":"John Doe",
                                                        "bio":"Click here to add a brief summary about your page",
                                                        "username":"example",
                                                        "avatar":"http:\/\/bio.test\/media\/bio\/avatar\/49ZBjwZeXUhWa5yx9QeMnz6uT5oyW1H4BchFORAd.png",
                                                        "plan_name": "Acquire",
                                                        "plan_due": "Sep 12, 2021",
                                                        "is_active":1,
                                                        "seo":{
                                                          "enable": "1",
                                                          "block_engine": "0",
                                                           "page_name":"Example's page",
                                                            "page_description": "Check/uncheck a checkbox, use the attribute checked and alter that. With jQuery you can do:",
                                                            "opengraph_image": "http://bio.test/media/bio/seo/6kT687EGp8DYjQCYdOKSlXnVNiMT7acd4O0Hh3jJ.png"
                                                        },
                                                        "social":{
                                                           "email":null,
                                                           "whatsapp":"+2348104199676",
                                                           "facebook":"example",
                                                           "instagram":"example",
                                                           "twitter":"example",
                                                           "youtube":"example"
                                                        },
                                                        "customize":{
                                                           "font":"Quicksand",
                                                           "theme":"magma",
                                                           "button_background_color": "#FFFFFF",
                                                           "button_text_color": "#000",
                                                           "texts_color": "#000000",
                                                           "radius":"round",
                                                           "bio_align":"left"
                                                        },
                                                        "background":{
                                                           "type":null,
                                                           "settings":{
                                                              "video":{
                                                                 "source":"upload",
                                                                 "external_url":null,
                                                                 "video":"http:\/\/bio.test\/media\/bio\/background\/PwmffQGo0Z6m07Fmwso1Y9lmCxdajZHkCqk4K5eI.mp4"
                                                              },
                                                              "image":{
                                                                 "source":"upload",
                                                                 "external_url":"http:\/\/app.yetti.test\/pawel-czerwinski-8uZPynIu-rQ-unsplash.jpg",
                                                                 "image":"http:\/\/bio.test\/media\/bio\/background\/uvrZTXDzXQikLwNUUlszGa1ihzvoqxSpAMwvLV5Q.png"
                                                              },
                                                              "solid":{
                                                                 "color":"#B9B396"
                                                              },
                                                              "gradient":{
                                                                 "color_1":"#F6B38D",
                                                                 "color_2":"#FFED97",
                                                                 "animate":"1"
                                                              }
                                                           }
                                                        },
                                                        "lastActivity":"2021-07-15 21:18:17",
                                                        "lastAgent":"Windows",
                                                        "lastCountry":"",
                                                        "total_login":53
                                                     }
                                                  }
                                                </code>
              </pre>
            </div>
          </div>
        </div>
      </div>
      <div class="sandy-tabs-item" id="block">
        <div class="sandy-accordion">
          <div class="sandy-accordion-head">{{ __('Retrieve Blocks') }}</div>
          <div class="sandy-accordion-body">
            <div class="sandy-accordion-content">
              <div class="mb-5 py-3">
                {{ __('Endpoint') }}
              </div>
                                          <pre class="mb-5 language-O flex items-center">
                                                <span class="text-sticker success mr-3 mt-0 no-shadow">{{ __('GET') }}</span>
                                                <span>{{ route('sandy-api-retrieve-blocks') }}</span>
              </pre>
              <div class="mb-5 py-3">
                {{ __('Example Request') }}
              </div>
                                          <pre>
                                                <code class="language-O">
                                                  curl --request GET \
                                                  --url '{{ route('sandy-api-retrieve-blocks') }}' \
                                                  --header 'Authorization: Bearer <span class="c-cyan">{api_key}</span>' \
                                                  -d {page: 1, results_per_page: 25}
                                                </code>
              </pre>
              <div class="flex-table mt-4">
                <!--Table header-->
                <div class="flex-table-header">
                  <span>{{ __('Parm') }}</span>
                  <span>{{ __('Details') }}</span>
                  <span class="is-grow"></span>
                </div>
                <div class="flex-table-item">
                  <div class="flex-table-cell" data-th="{{ __('Parm') }}">
                    <span class="light-text">page</span>
                  </div>
                  <div class="flex-table-cell" data-th="{{ __('Details') }}">
                    <span class="text-sticker info mr-3 mt-0 no-shadow">{{ __('Optional') }}</span>
                  </div>
                  <div class="flex-table-cell is-grow" data-th="">
                    <span class="tag is-green is-rounded">{{ __('Number of page results from. Defaults to 1.') }}</span>
                  </div>
                </div>
                <div class="flex-table-item">
                  <div class="flex-table-cell" data-th="{{ __('Parm') }}">
                    <span class="light-text">results_per_page</span>
                  </div>
                  <div class="flex-table-cell" data-th="{{ __('Details') }}">
                    <span class="text-sticker info mr-3 mt-0 no-shadow">{{ __('Optional') }}</span>
                  </div>
                  <div class="flex-table-cell is-grow" data-th="">
                    <span class="tag is-green is-rounded">{{ __('Results per page. Allowed values are: 10, 25, 50, 100, 250. Defaults to 10.') }}</span>
                  </div>
                </div>
              </div>
              <div class="mb-5 py-3">
                {{ __('Response') }}
              </div>
                                          <pre>
                                                <code class="language-json">
                                                  {
                                                     "status":true,
                                                     "response":[
                                                        {
                                                           "id":8,
                                                           "user":1,
                                                           "block":"image",
                                                           "name":null,
                                                           "subheading":null,
                                                           "blocks":null,
                                                           "settings":null,
                                                           "position":4,
                                                           "created_at":"2021-07-06T11:58:11.000000Z",
                                                           "updated_at":"2021-07-13T13:09:18.000000Z",
                                                           "items":[
                                                              {
                                                                 "id":39,
                                                                 "block_id":8,
                                                                 "thumbnail":"http:\/\/bio.test\/media\/blocks\/j86oCLpt8Jm5amn13Deq3ffcrbkON2O1KbCz08cw.jpg",
                                                                 "is_element":0,
                                                                 "element":null,
                                                                 "link":"https:\/\/",
                                                                 "content":{
                                                                    "caption":null,
                                                                    "alt":null
                                                                 },
                                                                 "settings":null,
                                                                 "position":0,
                                                                 "created_at":"2021-07-15T10:12:46.000000Z",
                                                                 "updated_at":"2021-07-15T10:12:46.000000Z"
                                                              },
                                                              {
                                                                 "id":13,
                                                                 "block_id":8,
                                                                 "thumbnail":"http:\/\/bio.test\/media\/blocks\/YX2M36J8ldxgeFKisH9fNxqpwn0ZnmvzlSH0B4aJ.jpg",
                                                                 "is_element":0,
                                                                 "element":null,
                                                                 "link":null,
                                                                 "content":{
                                                                    "caption":"Yooo",
                                                                    "alt":null
                                                                 },
                                                                 "settings":null,
                                                                 "position":0,
                                                                 "created_at":"2021-07-06T11:58:11.000000Z",
                                                                 "updated_at":"2021-07-10T09:49:16.000000Z"
                                                              }
                                                           ]
                                                        }
                                                     ],
                                                     "meta":{
                                                        "current_page":1,
                                                        "first_page_url":"http:\/\/bio.test\/api\/v1\/blocks?page=1",
                                                        "from":1,
                                                        "last_page":1,
                                                        "last_page_url":"http:\/\/bio.test\/api\/v1\/blocks?page=1",
                                                        "next_page_url":null,
                                                        "path":"http:\/\/bio.test\/api\/v1\/blocks",
                                                        "per_page":25,
                                                        "prev_page_url":null,
                                                        "to":6,
                                                        "total":6
                                                     }
                                                  }
                                                </code>
              </pre>
            </div>
          </div>
        </div>
        <div class="sandy-accordion">
          <div class="sandy-accordion-head">{{ __('Retrieve Single Block') }}</div>
          <div class="sandy-accordion-body">
            <div class="sandy-accordion-content">
              <div class="mb-5 py-3">
                {{ __('Endpoint') }}
              </div>
                                          <pre class="mb-5 language-O flex items-center">
                                                <span class="text-sticker success mr-3 mt-0 no-shadow">{{ __('GET') }}</span>
                                                <span>{{ route('sandy-api-retrieve-blocks') }}/{block_id}</span>
              </pre>
              <div class="mb-5 py-3">
                {{ __('Example Request') }}
              </div>
                                          <pre>
                                                <code class="language-O">
                                                  curl --request GET \
                                                  --url '{{ route('sandy-api-retrieve-blocks') }}/{block_id}' \
                                                  --header 'Authorization: Bearer <span class="c-cyan">{api_key}</span>' \
                                                </code>
              </pre>
              <div class="mb-5 py-3">
                {{ __('Response') }}
              </div>
                                          <pre>
                                                <code class="language-json">
                                                  {
                                                     "status":true,
                                                     "response":{
                                                        "id":11,
                                                        "user":1,
                                                        "block":"slider",
                                                        "name":"Follow Me On Instagram",
                                                        "subheading":null,
                                                        "blocks":{
                                                           "content":null
                                                        },
                                                        "settings":null,
                                                        "position":2,
                                                        "created_at":"2021-07-07T11:17:43.000000Z",
                                                        "updated_at":"2021-07-13T13:09:18.000000Z",
                                                        "items":[
                                                           {
                                                              "id":30,
                                                              "block_id":11,
                                                              "thumbnail":"http:\/\/bio.test\/media\/blocks\/DKtR30uUDipNeL24tmoDzj2iyuiSAEY6qyrLz4i4.jpg",
                                                              "is_element":0,
                                                              "element":null,
                                                              "link":null,
                                                              "content":{
                                                                 "caption":null
                                                              },
                                                              "settings":null,
                                                              "position":0,
                                                              "created_at":"2021-07-12T09:42:09.000000Z",
                                                              "updated_at":"2021-07-12T09:42:09.000000Z"
                                                           },
                                                           {
                                                              "id":19,
                                                              "block_id":11,
                                                              "thumbnail":"http:\/\/bio.test\/media\/blocks\/bA0ZbvgZhlvISN9gT9BhqN3T1gIZBzeTd4Ux888N.jpg",
                                                              "is_element":0,
                                                              "element":null,
                                                              "link":null,
                                                              "content":{
                                                                 "caption":null
                                                              },
                                                              "settings":null,
                                                              "position":0,
                                                              "created_at":"2021-07-07T11:17:55.000000Z",
                                                              "updated_at":"2021-07-07T11:17:55.000000Z"
                                                           },
                                                           {
                                                              "id":18,
                                                              "block_id":11,
                                                              "thumbnail":"http:\/\/bio.test\/media\/blocks\/It0JCQE1R9Wz2ThiTSYktJw2mjXVvS8IR1ofGHZP.jpg",
                                                              "is_element":0,
                                                              "element":null,
                                                              "link":null,
                                                              "content":{
                                                                 "caption":null
                                                              },
                                                              "settings":null,
                                                              "position":1,
                                                              "created_at":"2021-07-07T11:17:43.000000Z",
                                                              "updated_at":"2021-07-10T00:50:34.000000Z"
                                                           }
                                                        ]
                                                     }
                                                  }
                                                </code>
              </pre>
            </div>
          </div>
        </div>
      </div>
      <div class="sandy-tabs-item" id="plan">
        <div class="sandy-accordion">
          <div class="sandy-accordion-head">{{ __('Plan History') }}</div>
          <div class="sandy-accordion-body">
            <div class="sandy-accordion-content">
              <div class="mb-5 py-3">
                {{ __('Endpoint') }}
              </div>
                            <pre class="mb-5 language-O flex items-center">
                                  <span class="text-sticker success mr-3 mt-0 no-shadow">{{ __('GET') }}</span>
                                  <span>{{ route('sandy-api-retrieve-plan-history') }}</span>
              </pre>
              <div class="mb-5 py-3">
                {{ __('Example Request') }}
              </div>
                            <pre>
                                  <code class="language-O">
                                    curl --request GET \
                                    --url '{{ route('sandy-api-retrieve-plan-history') }}' \
                                    --header 'Authorization: Bearer {api_key}' \
                                    -d {page: 1, results_per_page: 25}
                                  </code>
              </pre>
              <div class="flex-table mt-4">
                <!--Table header-->
                <div class="flex-table-header">
                  <span>{{ __('Parm') }}</span>
                  <span>{{ __('Details') }}</span>
                  <span class="is-grow"></span>
                </div>
                <div class="flex-table-item">
                  <div class="flex-table-cell is-media" data-th="{{ __('Parm') }}">
                    <div class="ml-auto md:ml-0">
                      <span class="light-text">page</span>
                      <span class="light-text text-xs italic font-bold">integer</span>
                    </div>
                  </div>
                  <div class="flex-table-cell" data-th="{{ __('Details') }}">
                    <span class="text-sticker info mr-3 mt-0 no-shadow">{{ __('Optional') }}</span>
                  </div>
                  <div class="flex-table-cell is-grow" data-th="">
                    <span class="tag is-green is-rounded">{{ __('Number of page results from. Defaults to 1.') }}</span>
                  </div>
                </div>
                <div class="flex-table-item">
                  <div class="flex-table-cell is-media" data-th="{{ __('Parm') }}">
                    <div class="ml-auto md:ml-0">
                      <span class="light-text">results_per_page</span>
                      <span class="light-text text-xs italic font-bold">integer</span>
                    </div>
                  </div>
                  <div class="flex-table-cell" data-th="{{ __('Details') }}">
                    <span class="text-sticker info mr-3 mt-0 no-shadow">{{ __('Optional') }}</span>
                  </div>
                  <div class="flex-table-cell is-grow" data-th="">
                    <span class="tag is-green is-rounded">{{ __('Results per page. Allowed values are: 10, 25, 50, 100, 250. Defaults to 10.') }}</span>
                  </div>
                </div>
              </div>
              <div class="mb-5 py-3">
                {{ __('Response') }}
              </div>
                                          <pre>
                                                <code class="language-json">
                                                  {
                                                    "status": true,
                                                    "response": [
                                                        {
                                                            "id": 4,
                                                            "user": 1,
                                                            "name": "John Doe",
                                                            "plan": "1",
                                                            "plan_name": "Acquire",
                                                            "duration": "annually",
                                                            "email": "example@gmail.com",
                                                            "ref": "YYpkJ",
                                                            "currency": "USD",
                                                            "price": 40,
                                                            "gateway": "paypal",
                                                            "created_at": "2021-08-04T14:39:25.000000Z",
                                                            "updated_at": null
                                                        },
                                                        {
                                                            "id": 3,
                                                            "user": 1,
                                                            "name": "John Doe",
                                                            "plan": "4",
                                                            "plan_name": "Google",
                                                            "duration": "annually",
                                                            "email": "example@gmail.com",
                                                            "ref": "ZkHzW",
                                                            "currency": "USD",
                                                            "price": 20,
                                                            "gateway": "paypal",
                                                            "created_at": "2021-08-04T13:55:43.000000Z",
                                                            "updated_at": null
                                                        },
                                                        {
                                                            "id": 2,
                                                            "user": 1,
                                                            "name": "John Doe",
                                                            "plan": "4",
                                                            "plan_name": "Google",
                                                            "duration": "annually",
                                                            "email": "example@gmail.com",
                                                            "ref": "z66eq",
                                                            "currency": "USD",
                                                            "price": 20,
                                                            "gateway": "paypal",
                                                            "created_at": "2021-08-04T13:53:48.000000Z",
                                                            "updated_at": null
                                                        },
                                                        {
                                                            "id": 1,
                                                            "user": 1,
                                                            "name": "John Doe",
                                                            "plan": "1",
                                                            "plan_name": "Acquire",
                                                            "duration": "annually",
                                                            "email": "example@gmail.com",
                                                            "ref": "H2HJW",
                                                            "currency": "USD",
                                                            "price": 40,
                                                            "gateway": "paypal",
                                                            "created_at": "2021-08-04T11:35:35.000000Z",
                                                            "updated_at": null
                                                        }
                                                    ],
                                                    "meta": {
                                                        "current_page": 1,
                                                        "first_page_url": "http://bio.test/api/v1/plan-history?page=1",
                                                        "from": 1,
                                                        "last_page": 1,
                                                        "last_page_url": "http://bio.test/api/v1/plan-history?page=1",
                                                        "next_page_url": null,
                                                        "path": "http://bio.test/api/v1/plan-history",
                                                        "per_page": 50,
                                                        "prev_page_url": null,
                                                        "to": 4,
                                                        "total": 4
                                                    }
                                                }
                                                </code>
              </pre>
            </div>
          </div>
        </div>
      </div>
      <div class="sandy-tabs-item" id="analytics">
        <div class="sandy-accordion">
          <div class="sandy-accordion-head">{{ __('Live Visitors') }}</div>
          <div class="sandy-accordion-body">
            <div class="sandy-accordion-content">
              <div class="mb-5 py-3">
                {{ __('Endpoint') }}
              </div>
                                          <pre class="mb-5 language-O flex items-center">
                                                <span class="text-sticker success mr-3 mt-0 no-shadow">{{ __('GET') }}</span>
                                                <span>{{ route('sandy-api-retrieve-analytics-live') }}</span>
              </pre>
              <div class="mb-5 py-3">
                {{ __('Example Request') }}
              </div>
                                          <pre>
                                                <code class="language-O">
                                                  curl --request GET \
                                                  --url '{{ route('sandy-api-retrieve-analytics-live') }}' \
                                                  --header 'Authorization: Bearer <span class="c-cyan">{api_key}</span>' \
                                                </code>
              </pre>
              <div class="mb-5 py-3">
                {{ __('Response') }}
              </div>
                                          <pre>
                                                <code class="language-json">
                                                  {
                                                     "status":true,
                                                     "response":{
                                                        "visitors":[
                                                           {
                                                              "user":1,
                                                              "ip":"127.0.0.1",
                                                              "tracking":{
                                                                 "country":{
                                                                    "iso":"us",
                                                                    "name":"United States",
                                                                    "city":"Anniston, US"
                                                                 },
                                                                 "agent":{
                                                                    "browser":"Firefox",
                                                                    "os":"Windows"
                                                                 }
                                                              },
                                                              "last_activity":1626465080
                                                           }
                                                        ],
                                                        "insight":{
                                                           "countries":{
                                                              "us":{
                                                                 "unique":1,
                                                                 "name":"United States"
                                                              }
                                                           },
                                                           "cities":{
                                                              "Anniston, US":{
                                                                 "unique":1,
                                                                 "name":"Anniston",
                                                                 "iso":"US"
                                                              }
                                                           },
                                                           "devices":{
                                                              "Windows":{
                                                                 "unique":2,
                                                                 "name":"Windows"
                                                              }
                                                           },
                                                           "browsers":{
                                                              "Firefox":{
                                                                 "unique":1,
                                                                 "name":"Firefox"
                                                              },
                                                              "Edge":{
                                                                 "unique":1,
                                                                 "name":"Edge"
                                                              }
                                                           },
                                                           "getviews":{
                                                              "unique":2
                                                           }
                                                        }
                                                     }
                                                  }
                                                </code>
              </pre>
            </div>
          </div>
        </div>
        <div class="sandy-accordion">
          <div class="sandy-accordion-head">{{ __('Clicks Insight') }}</div>
          <div class="sandy-accordion-body">
            <div class="sandy-accordion-content">
              <div class="mb-5 py-3">
                {{ __('Endpoint') }}
              </div>
                                          <pre class="mb-5 language-O flex items-center">
                                                <span class="text-sticker success mr-3 mt-0 no-shadow">{{ __('GET') }}</span>
                                                <span>{{ route('sandy-api-retrieve-analytics-clicks') }}</span>
              </pre>
              <div class="mb-5 py-3">
                {{ __('Example Request') }}
              </div>
                                          <pre>
                                                <code class="language-O">
                                                  curl --request GET \
                                                  --url '{{ route('sandy-api-retrieve-analytics-clicks') }}' \
                                                  --header 'Authorization: Bearer <span class="c-cyan">{api_key}</span>' \
                                                </code>
              </pre>
              <div class="mb-5 py-3">
                {{ __('Response') }}
              </div>
                                          <pre>
                                                <code class="language-json">
                                                  {
                                                     "status":true,
                                                     "response":{
                                                        "links":{
                                                           "3ttM4":{
                                                              "visits":21,
                                                              "unique":7,
                                                              "link":"http:\/\/bio.test"
                                                           },
                                                           "jCdhn":{
                                                              "visits":4,
                                                              "unique":2,
                                                              "link":"http:\/\/bio.test\/mix"
                                                           },
                                                           "IvfnS":{
                                                              "visits":4,
                                                              "unique":3,
                                                              "link":"https:\/\/bio.test"
                                                           }
                                                        },
                                                        "insight":{
                                                           "visits":29,
                                                           "unique":12
                                                        }
                                                     }
                                                  }
                                                </code>
              </pre>
            </div>
          </div>
        </div>
        <div class="sandy-accordion">
          <div class="sandy-accordion-head">{{ __('Single Click Insight') }}</div>
          <div class="sandy-accordion-body">
            <div class="sandy-accordion-content">
              <div class="mb-5 py-3">
                {{ __('Endpoint') }}
              </div>
                                          <pre class="mb-5 language-O flex items-center">
                                                <span class="text-sticker success mr-3 mt-0 no-shadow">{{ __('GET') }}</span>
                                                <span>{{ route('sandy-api-retrieve-analytics-clicks') }}/{slug}</span>
              </pre>
              <div class="mb-5 py-3">
                {{ __('Example Request') }}
              </div>
                                          <pre>
                                                <code class="language-O">
                                                  curl --request GET \
                                                  --url '{{ route('sandy-api-retrieve-analytics-clicks') }}/{slug}' \
                                                  --header 'Authorization: Bearer <span class="c-cyan">{api_key}</span>' \
                                                </code>
              </pre>
              <div class="mb-5 py-3">
                {{ __('Response') }}
              </div>
                                          <pre>
                                                <code class="language-json"> 
                                                  {
                                                     "status":true,
                                                     "response":{
                                                        "countries":{
                                                           "us":{
                                                              "visits":3,
                                                              "unique":2,
                                                              "name":"United States"
                                                           },
                                                           "au":{
                                                              "visits":1,
                                                              "unique":1,
                                                              "name":"Australia"
                                                           }
                                                        },
                                                        "cities":{
                                                           "Anniston, US":{
                                                              "visits":2,
                                                              "unique":1,
                                                              "name":"Anniston",
                                                              "iso":"US"
                                                           },
                                                           "Bedford, US":{
                                                              "visits":1,
                                                              "unique":1,
                                                              "name":"Bedford",
                                                              "iso":"US"
                                                           },
                                                           "Sydney, AU":{
                                                              "visits":1,
                                                              "unique":1,
                                                              "name":"Sydney",
                                                              "iso":"AU"
                                                           }
                                                        },
                                                        "devices":{
                                                           "Windows":{
                                                              "visits":21,
                                                              "unique":7,
                                                              "name":"Windows"
                                                           }
                                                        },
                                                        "browsers":{
                                                           "Edge":{
                                                              "visits":14,
                                                              "unique":3,
                                                              "name":"Edge"
                                                           },
                                                           "Firefox":{
                                                              "visits":7,
                                                              "unique":4,
                                                              "name":"Firefox"
                                                           }
                                                        },
                                                        "getviews":{
                                                           "visits":21,
                                                           "unique":7
                                                        }
                                                     }
                                                  }
                                                </code>
              </pre>
            </div>
          </div>
        </div>
        <div class="sandy-accordion">
          <div class="sandy-accordion-head">{{ __('Views Insight') }}</div>
          <div class="sandy-accordion-body">
            <div class="sandy-accordion-content">
              <div class="mb-5 py-3">
                {{ __('Endpoint') }}
              </div>
                                          <pre class="mb-5 language-O flex items-center">
                                                <span class="text-sticker success mr-3 mt-0 no-shadow">{{ __('GET') }}</span>
                                                <span>{{ route('sandy-api-retrieve-analytics-views') }}</span>
              </pre>
              <div class="mb-5 py-3">
                {{ __('Example Request') }}
              </div>
                                          <pre>
                                                <code class="language-O">
                                                  curl --request GET \
                                                  --url '{{ route('sandy-api-retrieve-analytics-views') }}' \
                                                  --header 'Authorization: Bearer <span class="c-cyan">{api_key}</span>' \
                                                </code>
              </pre>
              <div class="mb-5 py-3">
                {{ __('Response') }}
              </div>
                                          <pre>
                                                <code class="language-json">
                                                  {
                                                     "status":true,
                                                     "response":{
                                                        "countries":{
                                                           "us":{
                                                              "visits":15,
                                                              "unique":8,
                                                              "name":"United States"
                                                           },
                                                           "au":{
                                                              "visits":3,
                                                              "unique":1,
                                                              "name":"Australia"
                                                           },
                                                           "in":{
                                                              "visits":2,
                                                              "unique":1,
                                                              "name":"India"
                                                           }
                                                        },
                                                        "cities":{
                                                           "Alabama, US":{
                                                              "visits":2,
                                                              "unique":2,
                                                              "name":"Alabama",
                                                              "iso":"US"
                                                           },
                                                           "Anniston, US":{
                                                              "visits":8,
                                                              "unique":3,
                                                              "name":"Anniston",
                                                              "iso":"US"
                                                           },
                                                           "Bedford, US":{
                                                              "visits":5,
                                                              "unique":3,
                                                              "name":"Bedford",
                                                              "iso":"US"
                                                           },
                                                           "Sydney, AU":{
                                                              "visits":3,
                                                              "unique":1,
                                                              "name":"Sydney",
                                                              "iso":"AU"
                                                           },
                                                           "Patna, IN":{
                                                              "visits":2,
                                                              "unique":1,
                                                              "name":"Patna",
                                                              "iso":"IN"
                                                           }
                                                        },
                                                        "devices":{
                                                           "Windows":{
                                                              "visits":493,
                                                              "unique":44,
                                                              "name":"Windows"
                                                           },
                                                           "AndroidOS":{
                                                              "visits":66,
                                                              "unique":8,
                                                              "name":"AndroidOS"
                                                           },
                                                           "iOS":{
                                                              "visits":2,
                                                              "unique":2,
                                                              "name":"iOS"
                                                           }
                                                        },
                                                        "browsers":{
                                                           "Firefox":{
                                                              "visits":102,
                                                              "unique":29,
                                                              "name":"Firefox"
                                                           },
                                                           "Edge":{
                                                              "visits":388,
                                                              "unique":14,
                                                              "name":"Edge"
                                                           },
                                                           "Chrome":{
                                                              "visits":69,
                                                              "unique":9,
                                                              "name":"Chrome"
                                                           },
                                                           "Safari":{
                                                              "visits":2,
                                                              "unique":2,
                                                              "name":"Safari"
                                                           }
                                                        },
                                                        "getviews":{
                                                           "visits":562,
                                                           "unique":55
                                                        }
                                                     }
                                                  }
                                                </code>
              </pre>
            </div>
          </div>
        </div>
      </div>
      
      <div class="sandy-tabs-item" id="pixel">
        <div class="sandy-accordion">
          <div class="sandy-accordion-head">{{ __('Retrieve Pixels') }}</div>
          <div class="sandy-accordion-body">
            <div class="sandy-accordion-content">
              <div class="mb-5 py-3">
                {{ __('Endpoint') }}
              </div>
                                          <pre class="mb-5 language-O flex items-center">
                                                <span class="text-sticker success mr-3 mt-0 no-shadow">{{ __('GET') }}</span>
                                                <span>{{ route('sandy-api-retrieve-pixels') }}</span>
              </pre>
              <div class="mb-5 py-3">
                {{ __('Example Request') }}
              </div>
                                          <pre>
                                                <code class="language-O">
                                                  curl --request GET \
                                                  --url '{{ route('sandy-api-retrieve-pixels') }}' \
                                                  --header 'Authorization: Bearer <span class="c-cyan">{api_key}</span>' \
                                                  -d {page: 1, results_per_page: 25}
                                                </code>
              </pre>
              <div class="flex-table mt-4">
                <!--Table header-->
                <div class="flex-table-header">
                  <span>{{ __('Parm') }}</span>
                  <span>{{ __('Details') }}</span>
                  <span class="is-grow"></span>
                </div>
                <div class="flex-table-item">
                  <div class="flex-table-cell is-media" data-th="{{ __('Parm') }}">
                    <div class="ml-auto md:ml-0">
                      <span class="light-text">page</span>
                      <span class="light-text text-xs italic font-bold">integer</span>
                    </div>
                  </div>
                  <div class="flex-table-cell" data-th="{{ __('Details') }}">
                    <span class="text-sticker info mr-3 mt-0 no-shadow">{{ __('Optional') }}</span>
                  </div>
                  <div class="flex-table-cell is-grow" data-th="">
                    <span class="tag is-green is-rounded">{{ __('Number of page results from. Defaults to 1.') }}</span>
                  </div>
                </div>
                <div class="flex-table-item">
                  <div class="flex-table-cell is-media" data-th="{{ __('Parm') }}">
                    <div class="ml-auto md:ml-0">
                      <span class="light-text">results_per_page</span>
                      <span class="light-text text-xs italic font-bold">integer</span>
                    </div>
                  </div>
                  <div class="flex-table-cell" data-th="{{ __('Details') }}">
                    <span class="text-sticker info mr-3 mt-0 no-shadow">{{ __('Optional') }}</span>
                  </div>
                  <div class="flex-table-cell is-grow" data-th="">
                    <span class="tag is-green is-rounded">{{ __('Results per page. Allowed values are: 10, 25, 50, 100, 250. Defaults to 10.') }}</span>
                  </div>
                </div>
              </div>
              <div class="mb-5 py-3">
                {{ __('Response') }}
              </div>
                                          <pre>
                                                <code class="language-json">
                                                  {
                                                     "status":true,
                                                     "response":[
                                                        {
                                                           "id":1,
                                                           "user":1,
                                                           "name":"FB Pixel",
                                                           "status":1,
                                                           "pixel_id":"21312",
                                                           "pixel_type":"facebook",
                                                           "created_at":"2021-06-10T10:25:53.000000Z",
                                                           "updated_at":"2021-07-12T10:46:47.000000Z"
                                                        },
                                                        {
                                                           "id":2,
                                                           "user":1,
                                                           "name":"Twitter Pixel",
                                                           "status":1,
                                                           "pixel_id":"Click here!",
                                                           "pixel_type":"twitter",
                                                           "created_at":"2021-06-10T11:33:17.000000Z",
                                                           "updated_at":"2021-07-12T16:22:40.000000Z"
                                                        },
                                                        {
                                                           "id":4,
                                                           "user":1,
                                                           "name":"Google Analytics",
                                                           "status":1,
                                                           "pixel_id":"321312",
                                                           "pixel_type":"google_analytics",
                                                           "created_at":"2021-07-12T11:18:47.000000Z",
                                                           "updated_at":"2021-07-12T11:18:47.000000Z"
                                                        },
                                                        {
                                                           "id":5,
                                                           "user":1,
                                                           "name":"Quora",
                                                           "status":1,
                                                           "pixel_id":"hmm",
                                                           "pixel_type":"quora",
                                                           "created_at":"2021-07-12T11:31:58.000000Z",
                                                           "updated_at":"2021-07-12T11:31:58.000000Z"
                                                        }
                                                     ],
                                                     "meta":{
                                                        "current_page":1,
                                                        "first_page_url":"http:\/\/bio.test\/api\/v1\/pixels?page=1",
                                                        "from":1,
                                                        "last_page":1,
                                                        "last_page_url":"http:\/\/bio.test\/api\/v1\/pixels?page=1",
                                                        "next_page_url":null,
                                                        "path":"http:\/\/bio.test\/api\/v1\/pixels",
                                                        "per_page":10,
                                                        "prev_page_url":null,
                                                        "to":4,
                                                        "total":4
                                                     }
                                                  }
                                                </code>
              </pre>
            </div>
          </div>
        </div>
        <div class="sandy-accordion">
          <div class="sandy-accordion-head">{{ __('Retrieve a Pixel') }}</div>
          <div class="sandy-accordion-body">
            <div class="sandy-accordion-content">
              <div class="mb-5 py-3">
                {{ __('Endpoint') }}
              </div>
                                          <pre class="mb-5 language-O flex items-center">
                                                <span class="text-sticker success mr-3 mt-0 no-shadow">{{ __('GET') }}</span>
                                                <span>{{ route('sandy-api-post-pixels') }}/{id}</span>
              </pre>
              <div class="mb-5 py-3">
                {{ __('Example Request') }}
              </div>
                                          <pre>
                                                <code class="language-O">
                                                  curl {{ route('sandy-api-post-pixels') }}/{id} \
                                                  -H 'Content-Type': 'application/json' \
                                                  -H 'Authorization: Bearer <span class="c-cyan">{api_key}</span>' \
                                                  -X GET
                                                </code>
              </pre>
              <div class="mb-5 py-3">
                {{ __('Response') }}
              </div>
                                          <pre>
                                                <code class="language-json">
                                                  {
                                                     "status":true,
                                                     "response":{
                                                        "id":4,
                                                        "user":1,
                                                        "name":"Google Pixel",
                                                        "status":1,
                                                        "pixel_id":"3424232",
                                                        "pixel_type":"google_analytics",
                                                        "created_at":"2021-07-12T11:18:47.000000Z",
                                                        "updated_at":"2021-07-17T11:29:27.000000Z"
                                                     }
                                                  }
                                                </code>
              </pre>
            </div>
          </div>
        </div>
        <div class="sandy-accordion">
          <div class="sandy-accordion-head">{{ __('Pixel Templates') }}</div>
          <div class="sandy-accordion-body">
            <div class="sandy-accordion-content">
              <div class="mb-5 py-3">
                {{ __('Endpoint') }}
              </div>
                                          <pre class="mb-5 language-O flex items-center">
                                                <span class="text-sticker success mr-3 mt-0 no-shadow">{{ __('GET') }}</span>
                                                <span>{{ route('sandy-api-retrieve-pixels-template') }}</span>
              </pre>
              <div class="mb-5 py-3">
                {{ __('Example Request') }}
              </div>
                                          <pre>
                                                <code class="language-O">
                                                  curl {{ route('sandy-api-retrieve-pixels-template') }} \
                                                  -H 'Content-Type': 'application/json' \
                                                  -H 'Authorization: Bearer {api_key}' \
                                                  -X GET
                                                </code>
              </pre>
              <div class="mb-5 py-3">
                {{ __('Response') }}
              </div>
                                          <pre>
                                                <code class="language-json">
                                                  {
                                                     "status":true,
                                                     "response":{
                                                        "facebook":{
                                                           "name":"Facebook",
                                                           "icon":"la la-facebook-f",
                                                           "color":"#4064ac",
                                                           "template":"\n <\script>\n !function(f,b,e,v,n,t,s)\n {if(f.fbq)return;n=f.fbq=function(){n.callMethod?\n n.callMethod.apply(n,arguments):n.queue.push(arguments)};\n if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';\n n.queue=[];t=b.createElement(e);t.async=!0;\n t.src=v;s=b.getElementsByTagName(e)[0];\n s.parentNode.insertBefore(t,s)}(window, document,'script',\n 'https:\/\/connect.facebook.net\/en_US\/fbevents.js');\n fbq('init', {pixel});\n fbq('track', 'PageView');\n <\/script>\n\n <\noscript><\img height=\"1\" width=\"1\" style='display:none' src='https:\/\/www.facebook.com\/tr?id={pixel}&ev=PageView&noscript=1\"\/><\/noscript>"
                                                        },
                                                        "twitter":{
                                                           "name":"Twitter",
                                                           "color":"#08a0e9",
                                                           "icon":"la la-twitter",
                                                           "template":"\n <\script>\n !function(e,t,n,s,u,a){e.twq||(s=e.twq=function(){s.exe?s.exe.apply(s,arguments):s.queue.push(arguments);\n },s.version='1.1',s.queue=[],u=t.createElement(n),u.async=!0,u.src='\/\/static.ads-twitter.com\/uwt.js',\n a=t.getElementsByTagName(n)[0],a.parentNode.insertBefore(u,a))}(window,document,'script');\n\n twq('init', '{pixel}');\n twq('track', 'PageView');\n <\/script>"
                                                        },
                                                        "google_analytics":{
                                                           "name":"Google Analytics",
                                                           "color":"#ffaf0080",
                                                           "class":"col-span-2 md:col-span-1",
                                                           "svg":"<\svg xmlns=\"http:\/\/www.w3.org\/2000\/svg\" viewBox=\"0 0 301112 333331\" shape-rendering=\"geometricPrecision\" text-rendering=\"geometricPrecision\" image-rendering=\"optimizeQuality\" fill-rule=\"evenodd\" clip-rule=\"evenodd\"><\path d=\"M301110 291619c124 22886-18333 41521-41206 41644-1700 14-3415-82-5101-288-21227-3140-36776-21611-36256-43057V43342c-507-21474 15084-39944 36324-43057 22721-2660 43304 13602 45964 36324 192 1673 288 3346 274 5032v249977z\" fill=\"#f9ab00\"\/><\path d=\"M41288 250756c22804 0 41288 18484 41288 41288s-18484 41288-41288 41288S0 314848 0 292044s18484-41288 41288-41288zm108630-125126c-22913 1261-40685 20472-40150 43413v110892c0 30099 13246 48364 32649 52258 22393 4539 44209-9928 48748-32320 562-2743 836-5526 822-8323V167124c41-22886-18470-41467-41356-41507-233 0-480 0-713 14z\" fill=\"#e37400\"\/><\/svg>",
                                                           "template":"\n <\script async src='https:\/\/www.googletagmanager.com\/gtag\/js?id={pixel}'><\/script>\n <\script>\n window.dataLayer = window.dataLayer || [];\n function gtag(){dataLayer.push(arguments);}\n gtag('js', new Date());\n gtag('config', '{pixel}');\n <\/script>"
                                                        },
                                                        "google_tag_manager":{
                                                           "name":"Google Tag Manager",
                                                           "class":"col-span-2 md:col-span-1",
                                                           "color":"#8ab4f8a8",
                                                           "svg":"<\svg version=\"1.1\" id=\"Layer_1\" xmlns=\"http:\/\/www.w3.org\/2000\/svg\" xmlns:xlink=\"http:\/\/www.w3.org\/1999\/xlink\" x=\"0px\" y=\"0px\"\n viewBox=\"0 0 2469.7 2469.8\" style=\"enable-background:new 0 0 2469.7 2469.8;\" xml:space=\"preserve\"><\style type=\"text\/css\">.st0{fill:#8AB4F8;}.st1{fill:#4285F4;}.st2{fill:#246FDB;}<\/style><\g><\path class=\"st0\" d=\"M1449.8,2376L1021,1946.7l921.1-930.5l436.7,436.6L1449.8,2376z\"\/>\n <\path class=\"st1\" d=\"M1452.9,527.1L1016.3,90.4L90.5,1016.2c-120.6,120.5-120.7,315.8-0.2,436.4c0.1,0.1,0.2,0.2,0.2,0.2l925.8,925.8l428.3-430.3L745,1235.1L1452.9,527.1z\"\/><\path class=\"st0\" d=\"M2378.7,1016.2L1452.9,90.4c-120.6-120.6-316.1-120.6-436.7,0c-120.6,120.6-120.6,316.1,0,436.6l926.3,925.8c120.6,120.6,316.1,120.6,436.6,0c120.6-120.6,120.6-316.1,0-436.6L2378.7,1016.2z\"\/><\circle class=\"st2\" cx=\"1231.2\" cy=\"2163.9\" r=\"306\"\/><\/g><\/svg>",
                                                           "template":"\n <\script>\n (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':\n new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],\n j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=\n 'https:\/\/www.googletagmanager.com\/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);\n })(window,document,'script','dataLayer','{pixel}');\n <\/script>\n\n <\noscript>\n <\iframe src=\"https:\/\/www.googletagmanager.com\/ns.html?id={pixel}\" height=\"0\" width=\"0\" style=\"display: none; visibility: hidden;\"><\/iframe>\n <\/noscript>"
                                                        },
                                                        "quora":{
                                                           "name":"Quora",
                                                           "color":"#B92B27",
                                                           "icon":"la la-quora",
                                                           "template":"\n <\script>\n !function(q,e,v,n,t,s){if(q.qp) return; n=q.qp=function(){n.qp?n.qp.apply(n,arguments):n.queue.push(arguments);}; n.queue=[];t=document.createElement(e);t.async=!0;t.src=v; s=document.getElementsByTagName(e)[0]; s.parentNode.insertBefore(t,s);}(window, 'script', 'https:\/\/a.quora.com\/qevents.js');\n qp('init', '{pixel}');\n qp('track', 'ViewContent');\n <\/script>\n\n <\noscript>\n <\img height=\"1\" width=\"1\" style=\"display: none;\" src=\"https:\/\/q.quora.com\/_\/ad\/{pixel}\/pixel?tag=ViewContent&noscript=1\"\/>\n <\/noscript>"
                                                        },
                                                        "pinterest":{
                                                           "name":"Pinterest",
                                                           "color":"#BD081C",
                                                           "icon":"sni sni-pinterest",
                                                           "template":"\n <\script type='text\/javascript'>\n !function(e){if(!window.pintrk){window.pintrk=function(){window.pintrk.queue.push(Array.prototype.slice.call(arguments))};var n=window.pintrk;n.queue=[],n.version='3.0';var t=document.createElement('script');t.async=!0,t.src=e;var r=document.getElementsByTagName('script')[0];r.parentNode.insertBefore(t,r)}}('https:\/\/s.pinimg.com\/ct\/core.js');\n pintrk('load', '{pixel}');\n pintrk('page');\n <\/script>\n\n <\noscript>\n <\img height=\"1\" width=\"1\" style=\"display:none;\" alt=\"\"\n src=\"https:\/\/ct.pinterest.com\/v3\/?tid={pixel}&noscript=1\" \/>\n <\/noscript>"
                                                        }
                                                     }
                                                  }
                                                </code>
              </pre>
            </div>
          </div>
        </div>
        <div class="sandy-accordion">
          <div class="sandy-accordion-head">{{ __('Add New Pixel') }}</div>
          <div class="sandy-accordion-body">
            <div class="sandy-accordion-content">
              <div class="mb-5 py-3">
                {{ __('Endpoint') }}
              </div>
                                          <pre class="mb-5 language-O flex items-center">
                                                <span class="text-sticker danger mr-3 mt-0 no-shadow">{{ __('POST') }}</span>
                                                <span>{{ route('sandy-api-post-pixels') }}</span>
              </pre>
              <div class="mb-5 py-3">
                {{ __('Example Request') }}
              </div>
                                          <pre>
                                                <code class="language-O">
                                                  curl {{ route('sandy-api-post-pixels') }} \
                                                  -H 'Content-Type': 'multipart/form-data' \
                                                  -H 'Authorization: Bearer <span class="c-cyan">{api_key}</span>' \
                                                  -d {name: 'A FaceBook Pixel', type: facebook, status: 1, pixel_id: 214212}
                                                  -X POST
                                                </code>
              </pre>
              <div class="flex-table mt-4">
                <!--Table header-->
                <div class="flex-table-header">
                  <span>{{ __('Parm') }}</span>
                  <span>{{ __('Details') }}</span>
                  <span class="is-grow"></span>
                </div>
                <div class="flex-table-item">
                  <div class="flex-table-cell is-media" data-th="{{ __('Parm') }}">
                    <div class="ml-auto md:ml-0">
                      <span class="light-text">name</span>
                      <span class="light-text text-xs italic font-bold">string</span>
                    </div>
                  </div>
                  <div class="flex-table-cell" data-th="{{ __('Details') }}">
                    <span class="text-sticker danger mr-3 mt-0 no-shadow">{{ __('Required') }}</span>
                  </div>
                  <div class="flex-table-cell is-grow" data-th="">
                    <span class="tag is-green is-rounded">{{ __('Name of the pixel to be saved.') }}</span>
                  </div>
                </div>
                <div class="flex-table-item">
                  <div class="flex-table-cell is-media" data-th="{{ __('Parm') }}">
                    <div class="ml-auto md:ml-0">
                      <span class="light-text">type</span>
                      <span class="light-text text-xs italic font-bold">string</span>
                    </div>
                  </div>
                  <div class="flex-table-cell" data-th="{{ __('Details') }}">
                    <span class="text-sticker danger mr-3 mt-0 no-shadow">{{ __('Required') }}</span>
                  </div>
                  <div class="flex-table-cell is-grow" data-th="">
                    <span class="tag is-green is-rounded">{{ __('Type of pixel. Check pixel template section to see available pixel types. Ex: facebook, google, etc.') }}</span>
                  </div>
                </div>
                <div class="flex-table-item">
                  <div class="flex-table-cell is-media" data-th="{{ __('Parm') }}">
                    <div class="ml-auto md:ml-0">
                      <span class="light-text">status</span>
                      <span class="light-text text-xs italic font-bold">integer</span>
                    </div>
                  </div>
                  <div class="flex-table-cell" data-th="{{ __('Details') }}">
                    <span class="text-sticker info mr-3 mt-0 no-shadow">{{ __('Optional') }}</span>
                  </div>
                  <div class="flex-table-cell is-grow" data-th="">
                    <span class="tag is-green is-rounded">{{ __('Status of the pixel if active or not. Allowed values: 1 for active, 0 for not active. Defaults to 1') }}</span>
                  </div>
                </div>
                <div class="flex-table-item">
                  <div class="flex-table-cell is-media" data-th="{{ __('Parm') }}">
                    <div class="ml-auto md:ml-0">
                      <span class="light-text">pixel_id</span>
                      <span class="light-text text-xs italic font-bold">string</span>
                    </div>
                  </div>
                  <div class="flex-table-cell" data-th="{{ __('Details') }}">
                    <span class="text-sticker danger mr-3 mt-0 no-shadow">{{ __('Required') }}</span>
                  </div>
                  <div class="flex-table-cell is-grow" data-th="">
                    <span class="tag is-green is-rounded">{{ __('Your pixel id to be saved.') }}</span>
                  </div>
                </div>
              </div>
              <div class="mb-5 py-3">
                {{ __('Response') }}
              </div>
                                          <pre>
                                                <code class="language-json">
                                                  {
                                                     "status":true,
                                                     "response":{
                                                        "id":13,
                                                        "message":"Pixel saved Successfully"
                                                     }
                                                  }
                                                </code>
              </pre>
            </div>
          </div>
        </div>
        <div class="sandy-accordion">
          <div class="sandy-accordion-head">{{ __('Update Pixel') }}</div>
          <div class="sandy-accordion-body">
            <div class="sandy-accordion-content">
              <div class="mb-5 py-3">
                {{ __('Endpoint') }}
              </div>
                                          <pre class="mb-5 language-O flex items-center">
                                                <span class="text-sticker danger mr-3 mt-0 no-shadow">{{ __('POST') }}</span>
                                                <span>{{ route('sandy-api-post-pixels') }}/{id}</span>
              </pre>
              <div class="mb-5 py-3">
                {{ __('Example Request') }}
              </div>
                                          <pre>
                                                <code class="language-O">
                                                  curl {{ route('sandy-api-post-pixels') }}/{id} \
                                                  -H 'Content-Type': 'multipart/form-data' \
                                                  -H 'Authorization: Bearer <span class="c-cyan">{api_key}</span>' \
                                                  -d {name: 'A FaceBook Pixel', type: facebook, status: 1, pixel_id: 214212}
                                                  -X POST
                                                </code>
              </pre>
              <div class="flex-table mt-4">
                <!--Table header-->
                <div class="flex-table-header">
                  <span>{{ __('Parm') }}</span>
                  <span>{{ __('Details') }}</span>
                  <span class="is-grow"></span>
                </div>
                <div class="flex-table-item">
                  <div class="flex-table-cell is-media" data-th="{{ __('Parm') }}">
                    <div class="ml-auto md:ml-0">
                      <span class="light-text">name</span>
                      <span class="light-text text-xs italic font-bold">string</span>
                    </div>
                  </div>
                  <div class="flex-table-cell" data-th="{{ __('Details') }}">
                    <span class="text-sticker danger mr-3 mt-0 no-shadow">{{ __('Required') }}</span>
                  </div>
                  <div class="flex-table-cell is-grow" data-th="">
                    <span class="tag is-green is-rounded">{{ __('Name of the pixel to be saved.') }}</span>
                  </div>
                </div>
                <div class="flex-table-item">
                  <div class="flex-table-cell is-media" data-th="{{ __('Parm') }}">
                    <div class="ml-auto md:ml-0">
                      <span class="light-text">type</span>
                      <span class="light-text text-xs italic font-bold">string</span>
                    </div>
                  </div>
                  <div class="flex-table-cell" data-th="{{ __('Details') }}">
                    <span class="text-sticker danger mr-3 mt-0 no-shadow">{{ __('Required') }}</span>
                  </div>
                  <div class="flex-table-cell is-grow" data-th="">
                    <span class="tag is-green is-rounded">{{ __('Type of pixel. Check pixel template section to see available pixel types. Ex: facebook, google, etc.') }}</span>
                  </div>
                </div>
                <div class="flex-table-item">
                  <div class="flex-table-cell is-media" data-th="{{ __('Parm') }}">
                    <div class="ml-auto md:ml-0">
                      <span class="light-text">status</span>
                      <span class="light-text text-xs italic font-bold">integer</span>
                    </div>
                  </div>
                  <div class="flex-table-cell" data-th="{{ __('Details') }}">
                    <span class="text-sticker info mr-3 mt-0 no-shadow">{{ __('Optional') }}</span>
                  </div>
                  <div class="flex-table-cell is-grow" data-th="">
                    <span class="tag is-green is-rounded">{{ __('Status of the pixel if active or not. Allowed values: 1 for active, 0 for not active. Defaults to 1') }}</span>
                  </div>
                </div>
                <div class="flex-table-item">
                  <div class="flex-table-cell is-media" data-th="{{ __('Parm') }}">
                    <div class="ml-auto md:ml-0">
                      <span class="light-text">pixel_id</span>
                      <span class="light-text text-xs italic font-bold">string</span>
                    </div>
                  </div>
                  <div class="flex-table-cell" data-th="{{ __('Details') }}">
                    <span class="text-sticker danger mr-3 mt-0 no-shadow">{{ __('Required') }}</span>
                  </div>
                  <div class="flex-table-cell is-grow" data-th="">
                    <span class="tag is-green is-rounded">{{ __('Your pixel id to be saved.') }}</span>
                  </div>
                </div>
              </div>
              <div class="mb-5 py-3">
                {{ __('Response') }}
              </div>
                                          <pre>
                                                <code class="language-json">
                                                  {
                                                     "status":true,
                                                     "response":{
                                                        "id":13,
                                                        "message":"Pixel edited Successfully"
                                                     }
                                                  }
                                                </code>
              </pre>
            </div>
          </div>
        </div>
        <div class="sandy-accordion">
          <div class="sandy-accordion-head">{{ __('Delete Pixel') }}</div>
          <div class="sandy-accordion-body">
            <div class="sandy-accordion-content">
              <div class="mb-5 py-3">
                {{ __('Endpoint') }}
              </div>
                                          <pre class="mb-5 language-O flex items-center">
                                                <span class="text-sticker danger mr-3 mt-0 no-shadow">{{ __('POST') }}</span>
                                                <span>{{ route('sandy-api-post-pixels') }}/{id}/delete</span>
              </pre>
              <div class="mb-5 py-3">
                {{ __('Example Request') }}
              </div>
                                          <pre>
                                                <code class="language-O">
                                                  curl {{ route('sandy-api-post-pixels') }}/{id}/delete \
                                                  -H 'Content-Type': 'multipart/form-data' \
                                                  -H 'Authorization: Bearer <span class="c-cyan">{api_key}</span>' \
                                                  -X POST
                                                </code>
              </pre>
              <div class="mb-5 py-3">
                {{ __('Response') }}
              </div>
                                          <pre>
                                                <code class="language-json">
                                                  {
                                                     "status":true,
                                                     "response":"Pixel deleted Successfully"
                                                  }
                                                </code>
              </pre>
            </div>
          </div>
        </div>
      </div>
      
      <div class="sandy-tabs-item" id="activity">
        <div class="sandy-accordion">
          <div class="sandy-accordion-head">{{ __('Retrieve Activity') }}</div>
          <div class="sandy-accordion-body">
            <div class="sandy-accordion-content">
              <div class="mb-5 py-3">
                {{ __('Endpoint') }}
              </div>
                                          <pre class="mb-5 language-O flex items-center">
                                                <span class="text-sticker success mr-3 mt-0 no-shadow">{{ __('GET') }}</span>
                                                <span>{{ route('sandy-api-retrieve-activities') }}</span>
              </pre>
              <div class="mb-5 py-3">
                {{ __('Example Request') }}
              </div>
                                          <pre>
                                                <code class="language-O">
                                                  curl {{ route('sandy-api-retrieve-activities') }} \
                                                  -H 'Content-Type': 'application/json' \
                                                  -H 'Authorization: Bearer <span class="c-cyan">{api_key}</span>' \
                                                  -d {page: 1, results_per_page: 30, type: 'login'}
                                                  -X GET
                                                </code>
              </pre>
              <div class="flex-table mt-4">
                <!--Table header-->
                <div class="flex-table-header">
                  <span>{{ __('Parm') }}</span>
                  <span>{{ __('Details') }}</span>
                  <span class="is-grow"></span>
                </div>
                <div class="flex-table-item">
                  <div class="flex-table-cell is-media" data-th="{{ __('Parm') }}">
                    <div class="ml-auto md:ml-0">
                      <span class="light-text">page</span>
                      <span class="light-text text-xs italic font-bold">integer</span>
                    </div>
                  </div>
                  <div class="flex-table-cell" data-th="{{ __('Details') }}">
                    <span class="text-sticker info mr-3 mt-0 no-shadow">{{ __('Optional') }}</span>
                  </div>
                  <div class="flex-table-cell is-grow" data-th="">
                    <span class="tag is-green is-rounded">{{ __('Number of page results from. Defaults to 1.') }}</span>
                  </div>
                </div>
                <div class="flex-table-item">
                  <div class="flex-table-cell is-media" data-th="{{ __('Parm') }}">
                    <div class="ml-auto md:ml-0">
                      <span class="light-text">results_per_page</span>
                      <span class="light-text text-xs italic font-bold">integer</span>
                    </div>
                  </div>
                  <div class="flex-table-cell" data-th="{{ __('Details') }}">
                    <span class="text-sticker info mr-3 mt-0 no-shadow">{{ __('Optional') }}</span>
                  </div>
                  <div class="flex-table-cell is-grow" data-th="">
                    <span class="tag is-green is-rounded">{{ __('Results per page. Allowed values are: 10, 25, 50, 100, 250. Defaults to 10.') }}</span>
                  </div>
                </div>
                <div class="flex-table-item">
                  <div class="flex-table-cell is-media" data-th="{{ __('Parm') }}">
                    <div class="ml-auto md:ml-0">
                      <span class="light-text">type</span>
                      <span class="light-text text-xs italic font-bold">string</span>
                    </div>
                  </div>
                  <div class="flex-table-cell" data-th="{{ __('Details') }}">
                    <span class="text-sticker info mr-3 mt-0 no-shadow">{{ __('Optional') }}</span>
                  </div>
                  <div class="flex-table-cell is-grow" data-th="">
                    <span class="tag is-green is-rounded">{{ __('Type of activity result. Allowed values are: Reset Password, Login, Plan, api_reset') }}</span>
                  </div>
                </div>
              </div>
              <div class="mb-5 py-3">
                {{ __('Response') }}
              </div>
                                          <pre>
                                                <code class="language-json">  
                                                {
                                                   "status":true,
                                                   "response":[
                                                      {
                                                         "id":1,
                                                         "user":1,
                                                         "type":"Reset Password",
                                                         "message":"Successful Login",
                                                         "ip":"ip",
                                                         "os":"Windows",
                                                         "browser":"Firefox",
                                                         "created_at":"2021-06-02T21:31:07.000000Z",
                                                         "updated_at":"2021-06-02T21:31:07.000000Z"
                                                      },
                                                      {
                                                         "id":2,
                                                         "user":1,
                                                         "type":"Login",
                                                         "message":"Failed Login",
                                                         "ip":"ip",
                                                         "os":"Windows",
                                                         "browser":"Firefox",
                                                         "created_at":"2021-06-02T21:33:17.000000Z",
                                                         "updated_at":"2021-06-02T21:33:17.000000Z"
                                                      },
                                                      {
                                                         "id":3,
                                                         "user":1,
                                                         "type":"Login",
                                                         "message":"Successful Login",
                                                         "ip":"ip",
                                                         "os":"Windows",
                                                         "browser":"Firefox",
                                                         "created_at":"2021-06-02T21:33:39.000000Z",
                                                         "updated_at":"2021-06-02T21:33:39.000000Z"
                                                      }
                                                   ],
                                                   "meta":{
                                                      "current_page":1,
                                                      "first_page_url":"http:\/\/bio.test\/api\/v1\/activities?page=1",
                                                      "from":1,
                                                      "last_page":6,
                                                      "last_page_url":"http:\/\/bio.test\/api\/v1\/activities?page=6",
                                                      "next_page_url":"http:\/\/bio.test\/api\/v1\/activities?page=2",
                                                      "path":"http:\/\/bio.test\/api\/v1\/activities",
                                                      "per_page":10,
                                                      "prev_page_url":null,
                                                      "to":10,
                                                      "total":57
                                                   }
                                                }
                                                </code>
              </pre>
            </div>
          </div>
        </div>
      </div>

      <div class="sandy-tabs-item" id="audience">
        <div class="sandy-accordion">
          <div class="sandy-accordion-head">{{ __('Retrieve Contacts') }}</div>
          <div class="sandy-accordion-body">
            <div class="sandy-accordion-content">
              <div class="mb-5 py-3">
                {{ __('Endpoint') }}
              </div>
              <pre class="mb-5 language-O flex items-center">
                  <span class="text-sticker success mr-3 mt-0 no-shadow">{{ __('GET') }}</span>
                  <span>{{ route('sandy-api-retrieve-contacts') }}</span>
              </pre>
              <div class="mb-5 py-3">
                {{ __('Example Request') }}
              </div>
              <pre>
                  <code class="language-O">
                    curl --request GET \
                    --url '{{ route('sandy-api-retrieve-contacts') }}' \
                    --header 'Authorization: Bearer <span class="c-cyan">{api_key}</span>' \
                    -d {page: 1, results_per_page: 25, workspace_id: 1}
                  </code>
              </pre>
              <div class="mb-5 py-3">
                {{ __('Response') }}
              </div>
              <pre>
                  <code class="language-json">
                    {
                        "status": true,
                        "response": [
                            {
                                "id": 1,
                                "email": "contact@example.com",
                                "name": "Contact Name",
                                "workspace_id": 1
                            }
                        ]
                    }
                  </code>
              </pre>
            </div>
          </div>
        </div>
      </div>

      <div class="sandy-tabs-item" id="membership">
        <div class="sandy-accordion">
          <div class="sandy-accordion-head">{{ __('Retrieve Plans') }}</div>
          <div class="sandy-accordion-body">
            <div class="sandy-accordion-content">
              <div class="mb-5 py-3">
                {{ __('Endpoint') }}
              </div>
              <pre class="mb-5 language-O flex items-center">
                  <span class="text-sticker success mr-3 mt-0 no-shadow">{{ __('GET') }}</span>
                  <span>{{ route('sandy-api-retrieve-membership-plans') }}</span>
              </pre>
              <div class="mb-5 py-3">
                {{ __('Example Request') }}
              </div>
              <pre>
                  <code class="language-O">
                    curl --request GET \
                    --url '{{ route('sandy-api-retrieve-membership-plans') }}' \
                    --header 'Authorization: Bearer <span class="c-cyan">{api_key}</span>' \
                    -d {page: 1, results_per_page: 25, workspace_id: 1}
                  </code>
              </pre>
              <div class="mb-5 py-3">
                {{ __('Response') }}
              </div>
              <pre>
                  <code class="language-json">
                    {
                        "status": true,
                        "response": [
                            {
                                "id": 1,
                                "name": "VIP Plan",
                                "price": 99.00,
                                "workspace_id": 1
                            }
                        ]
                    }
                  </code>
              </pre>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection