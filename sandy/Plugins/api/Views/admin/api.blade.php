@extends('admin::layouts.master')
@section('title', __('Admin Api'))
@section('content')
<div class="sandy-page-row">
   <div class="sandy-page-col pl-0">
      <div class="page__head">
         <div class="step-banner remove-shadow">
            <div class="section-header">
               <div class="section-header-info">
                  <p class="section-pretitle">{{ __('Api') }}</p>
                  <h2 class="section-title">{{ __('Admin api') }}</h2>
               </div>
            </div>
         </div>
      </div>
      <div class="title-sections mb-10">
         <h2 class="text-black mb-1 text-lg">{{ __('Auth') }}</h2>
         <p class="text-black text-sm">{{ __('All the API endpoints require an API key sent by the Bearer Authentication method') }}</p>
      </div>
      <div class="mb-5 pb-3">
         {{ __('Example Request') }}
      </div>
      <pre class="language-php p-8">
        <code>
          <div class="dark-code">
            curl --request GET \
            --url '{{ route('sandy-api-admin-index') }}/<span class="c-cyan">{endpoint}</span>' \
            --header 'Authorization: Bearer <span class="c-cyan">{api_key}</span>' \
          </div>
        </code>
    </pre>
      <div class="mort-main-bg rounded-2xl p-5 mb-10 mt-10 step-banner c-black">
         <span class="mb-0 text-base">{{ __('Users') }}</span>
      </div>
      <div class="sandy-accordion">
         <div class="sandy-accordion-head">{{ __('Retrieve Users') }}</div>
         <div class="sandy-accordion-body">
            <div class="sandy-accordion-content">
               <div class="mb-5 py-3">
                  {{ __('Endpoint') }}
               </div>
               <pre class="mb-5 language-php p-5 flex items-center">
                <span class="text-sticker success mr-3 mt-0 no-shadow">{{ __('GET') }}</span>
                <span>{{ route('sandy-api-admin-retrieve-users') }}</span>
              </pre>
               <div class="mb-5 py-3">
                  {{ __('Example Request') }}
               </div>
               <pre class="p-5">
                  <code class="language-php">
                    curl --request GET \
                    --url '{{ route('sandy-api-admin-retrieve-users') }}' \
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
                  <div class="flex-table-item">
                     <div class="flex-table-cell is-media" data-th="{{ __('Parm') }}">
                        <div class="ml-auto md:ml-0">
                           <span class="light-text">search</span>
                           <span class="light-text text-xs italic font-bold">string</span>
                        </div>
                     </div>
                     <div class="flex-table-cell" data-th="{{ __('Details') }}">
                        <span class="text-sticker info mr-3 mt-0 no-shadow">{{ __('Optional') }}</span>
                     </div>
                     <div class="flex-table-cell is-grow" data-th="">
                        <span class="tag is-green is-rounded">{{ __('Search.') }}</span>
                     </div>
                  </div>
                  <div class="flex-table-item">
                     <div class="flex-table-cell is-media" data-th="{{ __('Parm') }}">
                        <div class="ml-auto md:ml-0">
                           <span class="light-text">search_by</span>
                           <span class="light-text text-xs italic font-bold">string</span>
                        </div>
                     </div>
                     <div class="flex-table-cell" data-th="{{ __('Details') }}">
                        <span class="text-sticker info mr-3 mt-0 no-shadow">{{ __('Optional') }}</span>
                     </div>
                     <div class="flex-table-cell is-grow" data-th="">
                        <span class="tag is-green is-rounded">{{ __('Search by. Allowed values are: name, email.') }}</span>
                     </div>
                  </div>
                  <div class="flex-table-item">
                     <div class="flex-table-cell is-media" data-th="{{ __('Parm') }}">
                        <div class="ml-auto md:ml-0">
                           <span class="light-text">order_type</span>
                           <span class="light-text text-xs italic font-bold">string</span>
                        </div>
                     </div>
                     <div class="flex-table-cell" data-th="{{ __('Details') }}">
                        <span class="text-sticker info mr-3 mt-0 no-shadow">{{ __('Optional') }}</span>
                     </div>
                     <div class="flex-table-cell is-grow" data-th="">
                        <span class="tag is-green is-rounded">{{ __('Order results by. Allowed values are: ASC for ascending, DESC for descending.') }}</span>
                     </div>
                  </div>
                  <div class="flex-table-item">
                     <div class="flex-table-cell is-media" data-th="{{ __('Parm') }}">
                        <div class="ml-auto md:ml-0">
                           <span class="light-text">order_by</span>
                           <span class="light-text text-xs italic font-bold">string</span>
                        </div>
                     </div>
                     <div class="flex-table-cell" data-th="{{ __('Details') }}">
                        <span class="text-sticker info mr-3 mt-0 no-shadow">{{ __('Optional') }}</span>
                     </div>
                     <div class="flex-table-cell is-grow" data-th="">
                        <span class="tag is-green is-rounded">{{ __('Order fields results by. Allowed values are: created_at, lastActivity, email, name.') }}</span>
                     </div>
                  </div>
               </div>
               <div class="mb-5 py-3">
                  {{ __('Response') }}
               </div>
               <pre class="p-5">
                  <code class="language-json">
                    {
                       "status":true,
                       "response":[
                          {
                             "id":1,
                             "email":"example@gmail.com",
                             "name":"John Doe",
                             "bio":"Click here to add a brief summary about your page",
                             "username":"example",
                             "avatar":"http:\/\/bio.test\/media\/bio\/avatar\/49ZBjwZeXUhWa5yx9QeMnz6uT5oyW1H4BchFORAd.png",
                             "plan_name":"Acquire",
                             "plan_due":"Sep 12, 2021",
                             "is_active":1,
                             "seo":{
                                "enable":"1",
                                "block_engine":"0",
                                "page_name":"Example's page",
                                "page_description":"Check/uncheck a checkbox, use the attribute checked and alter that. With jQuery you can do:",
                                "opengraph_image":"http://bio.test/media/bio/seo/6kT687EGp8DYjQCYdOKSlXnVNiMT7acd4O0Hh3jJ.png"
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
                                "button_background_color":"#FFFFFF",
                                "button_text_color":"#000",
                                "texts_color":"#000000",
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
                       ],
                       "meta":{
                          "current_page":1,
                          "first_page_url":"http://bio.test/api/v1/admin/users?page=1",
                          "from":1,
                          "last_page":1,
                          "last_page_url":"http://bio.test/api/v1/admin/users?page=1",
                          "next_page_url":null,
                          "path":"http://bio.test/api/v1/admin/users",
                          "per_page":10,
                          "prev_page_url":null,
                          "to":1,
                          "total":1
                       }
                    }
                  </code>
                </pre>
            </div>
         </div>
      </div>
      <div class="sandy-accordion">
         <div class="sandy-accordion-head">{{ __('Retrieve a User') }}</div>
         <div class="sandy-accordion-body">
            <div class="sandy-accordion-content">
               <div class="mb-5 py-3">
                  {{ __('Endpoint') }}
               </div>
               <pre class="mb-5 language-php p-5 flex items-center">
                <span class="text-sticker success mr-3 mt-0 no-shadow">{{ __('GET') }}</span>
                <span>{{ route('sandy-api-admin-retrieve-users') }}/retrieve/{user_id}</span>
              </pre>
               <div class="mb-5 py-3">
                  {{ __('Example Request') }}
               </div>
               <pre class="p-5">
                  <code class="language-php">
                    curl --request GET \
                    --url '{{ route('sandy-api-admin-retrieve-users') }}/retrieve/{user_id}' \
                    --header 'Authorization: Bearer {api_key}' \
                  </code>
              </pre>
               <div class="mb-5 py-3">
                  {{ __('Response') }}
               </div>
               <pre class="p-5">
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
      <div class="sandy-accordion">
         <div class="sandy-accordion-head">{{ __('New User') }}</div>
         <div class="sandy-accordion-body">
            <div class="sandy-accordion-content">
               <div class="mb-5 py-3">
                  {{ __('Endpoint') }}
               </div>
               <pre class="mb-5 language-php p-5 flex items-center">
                <span class="text-sticker success mr-3 mt-0 no-shadow">{{ __('POST') }}</span>
                <span>{{ route('sandy-api-admin-create-new-user') }}</span>
              </pre>
               <div class="mb-5 py-3">
                  {{ __('Example Request') }}
               </div>
               <pre class="p-5">
                  <code class="language-php">
                    curl --request POST \
                    --url '{{ route('sandy-api-admin-create-new-user') }}' \
                    --header 'Authorization: Bearer {api_key}' \
                     -d {name: 'example', email: 'example@gmail.com', password: 'example99@'}
                  </code>
              </pre>
               <div class="flex-table mt-4">
                  <!--Table header-->
                  <div class="flex-table-header">
                     <span>{{ __('Parm') }}</span>
                     <span>{{ __('Details') }}</span>
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
                  </div>
                  <div class="flex-table-item">
                     <div class="flex-table-cell is-media" data-th="{{ __('Parm') }}">
                        <div class="ml-auto md:ml-0">
                           <span class="light-text">email</span>
                           <span class="light-text text-xs italic font-bold">string</span>
                        </div>
                     </div>
                     <div class="flex-table-cell" data-th="{{ __('Details') }}">
                        <span class="text-sticker danger mr-3 mt-0 no-shadow">{{ __('Required') }}</span>
                     </div>
                  </div>
                  <div class="flex-table-item">
                     <div class="flex-table-cell is-media" data-th="{{ __('Parm') }}">
                        <div class="ml-auto md:ml-0">
                           <span class="light-text">password</span>
                           <span class="light-text text-xs italic font-bold">string</span>
                        </div>
                     </div>
                     <div class="flex-table-cell" data-th="{{ __('Details') }}">
                        <span class="text-sticker danger mr-3 mt-0 no-shadow">{{ __('Required') }}</span>
                     </div>
                  </div>
               </div>
               <div class="mb-5 py-3">
                  {{ __('Response') }}
               </div>
               <pre class="p-5">
                  <code class="language-json">
                    {
                        "status": true,
                        "response": {
                            "id": 46,
                            "message": "New user created"
                        }
                    }
                  </code>
                </pre>
            </div>
         </div>
      </div>
      <div class="sandy-accordion">
         <div class="sandy-accordion-head">{{ __('Update User') }}</div>
         <div class="sandy-accordion-body">
            <div class="sandy-accordion-content">
               <div class="mb-5 py-3">
                  {{ __('Endpoint') }}
               </div>
               <pre class="mb-5 language-php p-5 flex items-center">
                <span class="text-sticker success mr-3 mt-0 no-shadow">{{ __('POST') }}</span>
                <span>{{ route('sandy-api-admin-retrieve-users') }}/update/{user_id}</span>
              </pre>
               <div class="mb-5 py-3">
                  {{ __('Example Request') }}
               </div>
               <pre class="p-5">
                  <code class="language-php">
                    curl --request POST \
                    --url '{{ route('sandy-api-admin-retrieve-users') }}/update/{user_id}' \
                    --header 'Authorization: Bearer {api_key}' \
                     -d {name: 'example'}
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
                           <span class="light-text info italic font-bold">string</span>
                        </div>
                     </div>
                     <div class="flex-table-cell" data-th="{{ __('Details') }}">
                        <span class="text-sticker info mr-3 mt-0 no-shadow">{{ __('Required') }}</span>
                     </div>
                     <div class="flex-table-cell is-grow" data-th="">
                        <span class="tag is-green is-rounded">-</span>
                     </div>
                  </div>
                  <div class="flex-table-item">
                     <div class="flex-table-cell is-media" data-th="{{ __('Parm') }}">
                        <div class="ml-auto md:ml-0">
                           <span class="light-text">email</span>
                           <span class="light-text text-xs italic font-bold">string</span>
                        </div>
                     </div>
                     <div class="flex-table-cell" data-th="{{ __('Details') }}">
                        <span class="text-sticker info mt-0 no-shadow">Optional</span>
                     </div>
                     <div class="flex-table-cell is-grow" data-th="">
                        <span class="tag is-green is-rounded">-</span>
                     </div>
                  </div>
                  <div class="flex-table-item">
                     <div class="flex-table-cell is-media" data-th="{{ __('Parm') }}">
                        <div class="ml-auto md:ml-0">
                           <span class="light-text">password</span>
                           <span class="light-text text-xs italic font-bold">string</span>
                        </div>
                     </div>
                     <div class="flex-table-cell" data-th="{{ __('Details') }}">
                        <span class="text-sticker info mr-3 mt-0 no-shadow">{{ __('Optional') }}</span>
                     </div>
                     <div class="flex-table-cell is-grow" data-th="">
                        <span class="tag is-green is-rounded">-</span>
                     </div>
                  </div>
                  <div class="flex-table-item">
                     <div class="flex-table-cell is-media" data-th="{{ __('Parm') }}">
                        <div class="ml-auto md:ml-0">
                           <span class="light-text">role</span>
                           <span class="light-text text-xs italic font-bold">integer</span>
                        </div>
                     </div>
                     <div class="flex-table-cell" data-th="{{ __('Details') }}">
                        <span class="text-sticker info mr-3 mt-0 no-shadow">{{ __('Optional') }}</span>
                     </div>
                     <div class="flex-table-cell is-grow" data-th="">
                        <span class="tag is-green is-rounded">1 - Admin, 0 - User</span>
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
                        <span class="tag is-green is-rounded">1 - Active, 0 - Disabled / Banned</span>
                     </div>
                  </div>
               </div>
               <div class="mb-5 py-3">
                  {{ __('Response') }}
               </div>
               <pre class="p-5">
                  <code class="language-json">
                    {
                        "status": true,
                        "response": {
                            "id": 46,
                            "message": "New user created"
                        }
                    }
                  </code>
                </pre>
            </div>
         </div>
      </div>
      <div class="sandy-accordion">
         <div class="sandy-accordion-head">{{ __('Delete User') }}</div>
         <div class="sandy-accordion-body">
            <div class="sandy-accordion-content">
               <div class="mb-5 py-3">
                  {{ __('Endpoint') }}
               </div>
               <pre class="mb-5 language-php p-5 flex items-center">
                <span class="text-sticker success mr-3 mt-0 no-shadow">{{ __('POST') }}</span>
                <span>{{ route('sandy-api-admin-retrieve-users') }}/delete/{user_id}</span>
              </pre>
               <div class="mb-5 py-3">
                  {{ __('Example Request') }}
               </div>
               <pre class="p-5">
                  <code class="language-php">
                    curl --request POST \
                    --url '{{ route('sandy-api-admin-retrieve-users') }}/delete/{user_id}' \
                    --header 'Authorization: Bearer {api_key}' \
                  </code>
              </pre>
            </div>
         </div>
      </div>
      <div class="mort-main-bg rounded-2xl p-5 mb-10 mt-10 step-banner c-black">
         <span class="mb-0 text-base">{{ __('Plans') }}</span>
      </div>
      <div class="sandy-accordion">
         <div class="sandy-accordion-head">{{ __('Retrieve Plans') }}</div>
         <div class="sandy-accordion-body">
            <div class="sandy-accordion-content">
               <div class="mb-5 py-3">
                  {{ __('Endpoint') }}
               </div>
               <pre class="mb-5 language-php p-5 flex items-center">
                <span class="text-sticker success mr-3 mt-0 no-shadow">{{ __('GET') }}</span>
                <span>{{ route('sandy-api-admin-retrieve-plans') }}</span>
              </pre>
               <div class="mb-5 py-3">
                  {{ __('Example Request') }}
               </div>
               <pre class="p-5">
                  <code class="language-php">
                    curl --request GET \
                    --url '{{ route('sandy-api-admin-retrieve-plans') }}' \
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
               <pre class="p-5">
                  <code class="language-json">
                    {
                      "status": true,
                      "response": [
                          {
                              "id": 2,
                              "name": "Free Forever",
                              "slug": null,
                              "status": "1",
                              "price": {
                                  "monthly": null,
                                  "annually": null,
                                  "trial_duration": null
                              },
                              "settings": {
                                  "ads": "1",
                                  "qrcode": "1",
                                  "pixel_codes": "1",
                                  "social": "1",
                                  "add_to_head": "1",
                                  "custom_domain": "1",
                                  "seo": "1",
                                  "verified": "1",
                                  "api": "1",
                                  "branding": "1",
                                  "customize": "1",
                                  "blocks_limit": "3",
                                  "pixel_limit": "50"
                              },
                              "defaults": 0,
                              "extra": {
                                  "description": "Lorem Ipsum is simply dummy text of the printing and typesetting industry.",
                                  "featured": "1"
                              },
                              "price_type": "free",
                              "position": 1,
                              "created_at": "2021-06-13T15:32:00.000000Z",
                              "updated_at": "2021-08-12T10:49:59.000000Z"
                          },
                          {
                              "id": 1,
                              "name": "Acquire",
                              "slug": null,
                              "status": "1",
                              "price": {
                                  "monthly": "20",
                                  "annually": "40",
                                  "trial_duration": "5"
                              },
                              "settings": {
                                  "ads": "0",
                                  "qrcode": "1",
                                  "pixel_codes": "1",
                                  "social": "0",
                                  "add_to_head": "1",
                                  "custom_domain": "1",
                                  "seo": "1",
                                  "verified": "1",
                                  "api": "1",
                                  "branding": "1",
                                  "customize": "1",
                                  "blocks_limit": "60",
                                  "pixel_limit": "30"
                              },
                              "defaults": 1,
                              "extra": {
                                  "description": "It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.",
                                  "featured": "0"
                              },
                              "price_type": "paid",
                              "position": 0,
                              "created_at": "2021-06-08T10:29:58.000000Z",
                              "updated_at": "2021-08-13T10:28:20.000000Z"
                          }
                      ],
                      "meta": {
                          "current_page": 1,
                          "first_page_url": "http://bio.test/api/v1/admin/plans?page=1",
                          "from": 1,
                          "last_page": 1,
                          "last_page_url": "http://bio.test/api/v1/admin/plans?page=1",
                          "next_page_url": null,
                          "path": "http://bio.test/api/v1/admin/plans",
                          "per_page": 10,
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


      <div class="sandy-accordion">
         <div class="sandy-accordion-head">{{ __('Retrieve a Plan') }}</div>
         <div class="sandy-accordion-body">
            <div class="sandy-accordion-content">
               <div class="mb-5 py-3">
                  {{ __('Endpoint') }}
               </div>
               <pre class="mb-5 language-php p-5 flex items-center">
                <span class="text-sticker success mr-3 mt-0 no-shadow">{{ __('GET') }}</span>
                <span>{{ route('sandy-api-admin-retrieve-plans') }}/single/{id}</span>
              </pre>
               <div class="mb-5 py-3">
                  {{ __('Example Request') }}
               </div>
               <pre class="p-5">
                  <code class="language-php">
                    curl --request GET \
                    --url '{{ route('sandy-api-admin-retrieve-plans') }}/single/{id}' \
                    --header 'Authorization: Bearer {api_key}' \
                  </code>
              </pre>
               <div class="mb-5 py-3">
                  {{ __('Response') }}
               </div>
               <pre class="p-5">
                  <code class="language-json">
                    {
                      "status": true,
                      "response": {
                          "id": 1,
                          "name": "Acquire",
                          "slug": null,
                          "status": "1",
                          "price": {
                              "monthly": "20",
                              "annually": "40",
                              "trial_duration": "5"
                          },
                          "settings": {
                              "ads": "0",
                              "qrcode": "1",
                              "pixel_codes": "1",
                              "social": "0",
                              "add_to_head": "1",
                              "custom_domain": "1",
                              "seo": "1",
                              "verified": "1",
                              "api": "1",
                              "branding": "1",
                              "customize": "1",
                              "blocks_limit": "60",
                              "pixel_limit": "30"
                          },
                          "defaults": 1,
                          "extra": {
                              "description": "It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.",
                              "featured": "0"
                          },
                          "price_type": "paid",
                          "position": 0,
                          "created_at": "2021-06-08T10:29:58.000000Z",
                          "updated_at": "2021-08-13T10:28:20.000000Z"
                      }
                  }
                  </code>
                </pre>
            </div>
         </div>
      </div>


      <div class="sandy-accordion">
         <div class="sandy-accordion-head">{{ __('Add a Plan to User') }}</div>
         <div class="sandy-accordion-body">
            <div class="sandy-accordion-content">
               <div class="mb-5 py-3">
                  {{ __('Endpoint') }}
               </div>
               <pre class="mb-5 language-php p-5 flex items-center">
                <span class="text-sticker danger mr-3 mt-0 no-shadow">{{ __('POST') }}</span>
                <span>{{ route('sandy-api-admin-retrieve-plans') }}/add/{plan_id}</span>
              </pre>
               <div class="mb-5 py-3">
                  {{ __('Example Request') }}
               </div>
               <pre class="p-5">
                  <code class="language-php">
                    curl --request GET \
                    --url '{{ route('sandy-api-admin-retrieve-plans') }}/add/{plan_id}' \
                    --header 'Authorization: Bearer {api_key}' \
                     -d {user_id: 1}
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
                           <span class="light-text">user_id</span>
                           <span class="light-text text-xs italic font-bold">integer</span>
                        </div>
                     </div>
                     <div class="flex-table-cell" data-th="{{ __('Details') }}">
                        <span class="text-sticker danger mr-3 mt-0 no-shadow">{{ __('Required') }}</span>
                     </div>
                     <div class="flex-table-cell is-grow" data-th="">
                        <span class="tag is-green is-rounded">-</span>
                     </div>
                  </div>
                  <div class="flex-table-item">
                     <div class="flex-table-cell is-media" data-th="{{ __('Parm') }}">
                        <div class="ml-auto md:ml-0">
                           <span class="light-text">date</span>
                           <span class="light-text text-xs italic font-bold">Y-m-d</span>
                        </div>
                     </div>
                     <div class="flex-table-cell" data-th="{{ __('Details') }}">
                        <span class="text-sticker danger mr-3 mt-0 no-shadow">{{ __('Required') }}</span>
                     </div>
                     <div class="flex-table-cell is-grow" data-th="">
                        <span class="tag is-green is-rounded">Pass the due date in the format of Y-m-d ex: 2022-08-13.</span>
                     </div>
                  </div>
               </div>
               <div class="mb-5 py-3">
                  {{ __('Response') }}
               </div>
               <pre class="p-5">
                  <code class="language-json">
                    {
                        "status": true,
                        "response": "Plan added to Example"
                    }
                  </code>
                </pre>
            </div>
         </div>
      </div>

      <div class="mort-main-bg rounded-2xl p-5 mb-10 mt-10 step-banner c-black">
         <span class="mb-0 text-base">{{ __('Payments') }}</span>
      </div>
      <div class="sandy-accordion">
         <div class="sandy-accordion-head">{{ __('Retrieve Payments') }}</div>
         <div class="sandy-accordion-body">
            <div class="sandy-accordion-content">
               <div class="mb-5 py-3">
                  {{ __('Endpoint') }}
               </div>
               <pre class="mb-5 language-php p-5 flex items-center">
                <span class="text-sticker success mr-3 mt-0 no-shadow">{{ __('GET') }}</span>
                <span>{{ route('sandy-api-admin-retrieve-payments') }}</span>
              </pre>
               <div class="mb-5 py-3">
                  {{ __('Example Request') }}
               </div>
               <pre class="p-5">
                  <code class="language-php">
                    curl --request GET \
                    --url '{{ route('sandy-api-admin-retrieve-payments') }}' \
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
               <pre class="p-5">
                  <code class="language-json">
                    {
                      "status": true,
                      "response": [
                          {
                              "id": 9,
                              "user": 1,
                              "name": "Jeffrey Jola",
                              "plan": "1",
                              "plan_name": "Acquire",
                              "duration": "monthly",
                              "email": "jeffjola@gmail.com",
                              "ref": "mHvwd",
                              "currency": "INR",
                              "price": 20,
                              "gateway": "razor",
                              "created_at": "2021-08-12T08:54:05.000000Z",
                              "updated_at": null
                          },
                          {
                              "id": 8,
                              "user": 38,
                              "name": "Example",
                              "plan": "4",
                              "plan_name": "Google",
                              "duration": "annually",
                              "email": "ezample@gmail.com",
                              "ref": "d333E",
                              "currency": "INR",
                              "price": 20,
                              "gateway": "razor",
                              "created_at": "2021-08-10T16:13:03.000000Z",
                              "updated_at": null
                          }
                      ],
                      "meta": {
                          "current_page": 1,
                          "first_page_url": "http://bio.test/api/v1/admin/payments?page=1",
                          "from": 1,
                          "last_page": 1,
                          "last_page_url": "http://bio.test/api/v1/admin/payments?page=1",
                          "next_page_url": null,
                          "path": "http://bio.test/api/v1/admin/payments",
                          "per_page": 50,
                          "prev_page_url": null,
                          "to": 9,
                          "total": 9
                      }
                  }
                  </code>
                </pre>
            </div>
         </div>
      </div>
      <div class="sandy-accordion">
         <div class="sandy-accordion-head">{{ __('Retrieve a Payment') }}</div>
         <div class="sandy-accordion-body">
            <div class="sandy-accordion-content">
               <div class="mb-5 py-3">
                  {{ __('Endpoint') }}
               </div>
               <pre class="mb-5 language-php p-5 flex items-center">
                <span class="text-sticker success mr-3 mt-0 no-shadow">{{ __('GET') }}</span>
                <span>{{ route('sandy-api-admin-retrieve-payments') }}/single/{id}</span>
              </pre>
               <div class="mb-5 py-3">
                  {{ __('Example Request') }}
               </div>
               <pre class="p-5">
                  <code class="language-php">
                    curl --request GET \
                    --url '{{ route('sandy-api-admin-retrieve-payments') }}/single/{id}' \
                    --header 'Authorization: Bearer {api_key}' \
                  </code>
              </pre>
               <div class="mb-5 py-3">
                  {{ __('Response') }}
               </div>
               <pre class="p-5">
                  <code class="language-json">
                    {
                        "status": true,
                        "response": {
                            "id": 9,
                            "user": 1,
                            "name": "Jeffrey Jola",
                            "plan": "1",
                            "plan_name": "Acquire",
                            "duration": "monthly",
                            "email": "jeffjola@gmail.com",
                            "ref": "mHvwd",
                            "currency": "INR",
                            "price": 20,
                            "gateway": "razor",
                            "created_at": "2021-08-12T08:54:05.000000Z",
                            "updated_at": null
                        }
                    }
                  </code>
                </pre>
            </div>
         </div>
      </div>
   </div>
   <div class="sandy-page-col sandy-page-col_pt100 p-0 md:p-10">
      <div class="card card_widget">
         <div class="flex items-center mb-5">
            <i class="text-2xl sio banking-finance-flaticon-097-information-sign mr-3"></i>
            <p>{{ __('Info') }}</p>
         </div>
         <div class="mb-5">
            <div class="text-base mb-5">
               {{ __("Here's the base api url where you will send requests with the endpoints.") }}
            </div>
            <div class="is-label uppercase mb-2">{{ __('Api Url') }}</div>
            <div class="form-input copy active">
               <input type="text" value="{{ route('sandy-api-admin-index') }}">
               <div class="copy-btn" data-copy="{{ route('sandy-api-admin-index') }}" data-after-copy="{{ __('Copied') }}">
                  <i class="la la-copy"></i>
               </div>
            </div>
         </div>
         <p class="mb-5 italic text-xs">(Note: i will continue to improve the api of this script. ;) )</p>
         <div class="step-banner remove-shadow mort-main-bg mb-0">
            <div class="text-base c-dark mb-1">
               {{ __("Here's your api key") }}
            </div>
            <form action="{{ route('user-mix-settings-api-reset') }}" method="post">
               @csrf
               <button class="text-xs c-black font-bold mb-5 href-link-button">{{ __('Generate / Reset Key') }}</button>
            </form>
            <div class="is-label c-dark text-white">{{ __('Key') }}</div>
            <div class="form-input copy active">
               <input type="text" value="{{ user('api') }}" class="bg-sea" readonly="">
               <div class="copy-btn" data-copy="{{ user('api') }}" data-after-copy="{{ __('Copied') }}">
                  <i class="la la-copy"></i>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection