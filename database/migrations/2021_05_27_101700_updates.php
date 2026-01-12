<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Updates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        // Blog
        if (!Schema::hasTable('blog')) {
            Schema::create('blog', function (Blueprint $table) {
                $table->id();
                $table->string('location');
                $table->string('name')->nullable();
                $table->string('status')->default(0);
                $table->string('type')->default('internal');
                $table->string('thumbnail')->nullable();
                $table->longText('description')->nullable();
                $table->longText('settings')->nullable();
                $table->string('author')->nullable();
                $table->string('ttr')->nullable();
                $table->integer('position')->default(0);
                $table->integer('total_views')->default(0);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('wallet')) {
            Schema::create('wallet', function (Blueprint $table) {
                $table->id();
                $table->integer('user');
                $table->float('balance', 16, 2)->default(0);
                $table->string('default_country')->default('NG');
                $table->string('default_currency')->default('NGN');
                $table->string('default_method')->nullable();
                $table->string('status')->default(1);
                $table->longText('settlement')->nullable();
                $table->string('pin')->nullable();
                $table->longText('extra')->nullable();
                $table->integer('rave_setup')->default(0);
                $table->longText('rave_subaccount')->nullable();
                $table->longText('rave_payout')->nullable();
                $table->integer('stripe_setup')->default(0);
                $table->longText('stripe_info')->nullable();
                $table->integer('wallet_setup')->default(0);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('wallet_settlements')) {
            Schema::create('wallet_settlements', function (Blueprint $table) {
                $table->id();
                $table->integer('user');
                $table->integer('settlement_id')->nullable();
                $table->longText('settlement')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('wallet_saved_cards')) {
            Schema::create('wallet_saved_cards', function (Blueprint $table) {
                $table->id();
                $table->integer('user');
                $table->string('token')->nullable();
                $table->string('last_four')->nullable();
                $table->longText('payload')->nullable();
                $table->longText('extra')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('wallet_transactions')) {
            Schema::create('wallet_transactions', function (Blueprint $table) {
                $table->id();
                $table->integer('user');
                $table->integer('spv_id')->nullable();
                $table->string('type')->nullable();
                $table->float('amount', 16, 2)->nullable();
                $table->string('currency')->nullable();
                $table->longText('transaction')->nullable();
                $table->longText('payload')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('tip_collection')) {
            Schema::create('tip_collection', function (Blueprint $table) {
                $table->id();
                $table->integer('user');
                $table->integer('payee_user_id')->nullable();
                $table->integer('element_id')->nullable();
                $table->integer('is_private')->default(0);
                $table->float('amount', 16, 2)->nullable();
                $table->string('currency')->nullable();
                $table->longText('info')->nullable();
                $table->timestamps();
            });
        }


        if (!Schema::hasTable('sandy_embed_store')) {
            Schema::create('sandy_embed_store', function (Blueprint $table) {
                $table->id();
                $table->string('link')->nullable();
                $table->longText('data')->nullable();
                $table->timestamps();
            });
        }
        
        if (!Schema::hasTable('domains')) {
            Schema::create('domains', function (Blueprint $table) {
                $table->id();
                $table->integer('user')->nullable();
                $table->integer('is_active')->default(0);
                $table->string('scheme')->nullable();
                $table->string('host')->nullable();
                $table->longText('settings')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('support_conversations')) {
            Schema::create('support_conversations', function (Blueprint $table) {
                $table->id();
                $table->integer('user');
                $table->string('topic')->nullable();
                $table->string('description')->nullable();
                $table->integer('status')->default(1);
                $table->longText('extra')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('support_messages')) {
            Schema::create('support_messages', function (Blueprint $table) {
                $table->id();
                $table->integer('conversation_id');
                $table->integer('user_id');
                $table->string('from')->default('user');
                $table->integer('from_id')->nullable();
                $table->string('type')->default('text');
                $table->longText('data')->nullable();
                $table->string('seen')->default(0);
                $table->longText('extra')->nullable();
                $table->timestamps();
            });
        }

        // Pixels

        if (!Schema::hasTable('pixels')) {
            Schema::create('pixels', function (Blueprint $table) {
                $table->id();
                $table->integer('user');
                $table->string('name')->nullable();
                $table->integer('status')->default(0);
                $table->string('pixel_id')->nullable();
                $table->string('pixel_type')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('plans_history')) {
            Schema::create('plans_history', function (Blueprint $table) {
                $table->id();
                $table->integer('plan_id');
                $table->integer('user_id');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('plan_payments')) {
            Schema::create('plan_payments', function (Blueprint $table) {
                $table->id();
                $table->integer('user');
                $table->string('name')->nullable();
                $table->string('plan')->nullable();
                $table->string('plan_name')->nullable();
                $table->string('duration')->nullable();
                $table->string('email')->nullable();
                $table->string('ref')->nullable();
                $table->string('currency')->nullable();
                $table->float('price', 16, 2)->nullable();
                $table->string('gateway')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('pending_plan')) {
            Schema::create('pending_plan', function (Blueprint $table) {
                $table->id();
                $table->integer('user');
                $table->integer('status')->default(0);
                $table->string('email')->nullable();
                $table->string('name')->nullable();
                $table->string('ref')->nullable();
                $table->integer('plan')->nullable();
                $table->string('duration')->nullable();
                $table->longText('info')->nullable();
                $table->string('method')->default('bank');
                $table->timestamps();
            });
        }

        // Payment spv

        if (!Schema::hasTable('payments_spv')) {
            Schema::create('payments_spv', function (Blueprint $table) {
                $table->id();
                $table->string('sxref')->nullable();
                $table->string('email')->nullable();
                $table->string('currency')->nullable();
                $table->integer('status')->default(0);
                $table->integer('is_paid')->default(0);
                $table->float('price', 16, 2)->nullable();
                $table->string('method')->nullable();
                $table->string('method_ref')->nullable();
                $table->string('callback')->nullable();
                $table->longText('keys')->nullable();
                $table->longText('meta')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('payments_spv_history')) {
            Schema::create('payments_spv_history', function (Blueprint $table) {
                $table->id();
                $table->integer('spv_id')->nullable();
                $table->integer('status')->default(0);
                $table->string('method')->nullable();
                $table->string('method_ref')->nullable();
                $table->longText('method_data')->nullable();
                $table->timestamps();
            });
        }



        if (!Schema::hasTable('yetti_spv')) {
            Schema::create('yetti_spv', function (Blueprint $table) {
                $table->id();
                $table->integer('user');
                $table->integer('payee_user_id')->nullable();
                $table->string('sxref')->nullable();
                $table->string('email')->nullable();
                $table->string('currency')->nullable();
                $table->integer('is_paid')->default(0);
                $table->float('price', 16, 2)->nullable();
                $table->float('split_price', 16, 2)->nullable();
                $table->string('method')->nullable();
                $table->string('method_ref')->nullable();
                $table->string('callback')->nullable();
                $table->longText('meta')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('yetti_spv_history')) {
            Schema::create('yetti_spv_history', function (Blueprint $table) {
                $table->id();
                $table->string('spv_id')->nullable();
                $table->integer('status')->default(0);
                $table->string('method')->nullable();
                $table->string('method_ref')->nullable();
                $table->longText('payload_data')->nullable();
                $table->timestamps();
            });
        }
        
        // Blocks
        if (!Schema::hasTable('blocks')) {
            Schema::create('blocks', function (Blueprint $table) {
                $table->id();
                $table->integer('user');
                $table->string('block');
                $table->longText('blocks')->nullable();
                $table->longText('settings')->nullable();
                $table->integer('position')->default(0);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('blocks_element')) {
            Schema::create('blocks_element', function (Blueprint $table) {
                $table->id();
                $table->integer('user');
                $table->integer('block_id');
                $table->longText('thumbnail')->nullable();
                $table->integer('is_element')->nullable();
                $table->integer('element')->nullable();
                $table->string('link')->nullable();
                $table->longText('content')->nullable();
                $table->longText('settings')->nullable();
                $table->integer('position')->default(0);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('highlights')) {
            Schema::create('highlights', function (Blueprint $table) {
                $table->id();
                $table->integer('user');
                $table->longText('thumbnail')->nullable();
                $table->integer('is_element')->nullable();
                $table->integer('element')->nullable();
                $table->string('link')->nullable();
                $table->longText('content')->nullable();
                $table->integer('position')->default(0);
                $table->timestamps();
            });
        }

        // Elements
        if (!Schema::hasTable('elements')) {
            Schema::create('elements', function (Blueprint $table) {
                $table->id();
                $table->integer('user');
                $table->string('slug')->unique();
                $table->string('name')->nullable();
                $table->string('thumbnail')->nullable();
                $table->longText('element')->nullable();
                $table->longText('content')->nullable();
                $table->longText('settings')->nullable();
                $table->integer('position')->default(0);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('elementdb')) {
            Schema::create('elementdb', function (Blueprint $table) {
                $table->id();
                $table->integer('user');
                $table->integer('element')->nullable();
                $table->string('email')->nullable();
                $table->longText('database')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('visitors')) {
            Schema::create('visitors', function (Blueprint $table) {
                $table->id();
                $table->integer('user')->nullable();
                $table->string('slug')->nullable();
                $table->string('session')->nullable();
                $table->string('ip')->nullable();
                $table->longText('tracking')->nullable();
                $table->integer('views')->default(0);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('user_upload_paths')) {
            Schema::create('user_upload_paths', function (Blueprint $table) {
                $table->id();
                $table->integer('user')->nullable();
                $table->text('path')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('linker_track')) {
            Schema::create('linker_track', function (Blueprint $table) {
                $table->id();
                $table->integer('linker')->nullable();
                $table->integer('user')->nullable();
                $table->string('session')->nullable();
                $table->string('link')->nullable();
                $table->string('slug')->nullable();
                $table->string('ip')->nullable();
                $table->longText('tracking')->nullable();
                $table->integer('views')->default(1);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('docs_categories')) {
            Schema::create('docs_categories', function (Blueprint $table) {
                $table->id();
                $table->string('name')->nullable();
                $table->string('slug')->nullable();
                $table->longText('media')->nullable();
                $table->integer('position')->default(0);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('docs_guides')) {
            Schema::create('docs_guides', function (Blueprint $table) {
                $table->id();
                $table->string('name')->nullable();
                $table->string('slug')->nullable();
                $table->integer('status')->default(1);
                $table->integer('docs_category')->nullable();
                $table->longText('media')->nullable();
                $table->longText('content')->nullable();
                $table->integer('position')->default(0);
                $table->timestamps();
            });
        }
        
        if (!Schema::hasTable('bio_devicetoken')) {
            Schema::create('bio_devicetoken', function (Blueprint $table) {
                $table->id();
                $table->integer('user')->nullable();
                $table->string('device_token');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('bio_push_notification')) {
            Schema::create('bio_push_notification', function (Blueprint $table) {
                $table->id();
                $table->integer('user')->nullable();
                $table->longText('content')->nullable();
                $table->timestamps();
            });
        }


        // Updates
        Schema::table('linker', function (Blueprint $table) {
            if (!Schema::hasColumn('linker', 'user')) {
                $table->integer('user')->nullable();
            }
        });
        
        Schema::table('blocks', function (Blueprint $table) {
            if (!Schema::hasColumn('blocks', 'title')) {
                $table->text('title')->after('block')->nullable();
            }
        });

        Schema::table('blog', function (Blueprint $table) {
            if (!Schema::hasColumn('blog', 'postedBy')) {
                $table->integer('postedBy')->after('location')->nullable();
            }
        });

        // Users
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'booking')) {
                $table->longText('booking')->after('background')->nullable();
            }
            if (!Schema::hasColumn('users', 'background_settings')) {
                $table->longText('background_settings')->after('background')->nullable();
            }
            if (!Schema::hasColumn('users', 'seo')) {
                $table->longText('seo')->after('settings')->nullable();
            }
            if (!Schema::hasColumn('users', 'pwa')) {
                $table->longText('pwa')->after('seo')->nullable();
            }
            if (!Schema::hasColumn('users', 'store')) {
                $table->longText('store')->after('settings')->nullable();
            }
            if (!Schema::hasColumn('users', 'integrations')) {
                $table->longText('integrations')->after('settings')->nullable();
            }
            if (!Schema::hasColumn('users', 'payments')) {
                $table->longText('payments')->after('settings')->nullable();
            }
            if (!Schema::hasColumn('users', 'lastCountry')) {
                $table->string('lastCountry')->after('lastAgent')->nullable();
            }
            if (!Schema::hasColumn('users', 'api')) {
                $table->string('api')->after('lastCountry')->unique()->nullable();
            }
            if (!Schema::hasColumn('users', 'font')) {
                $table->string('font')->after('buttons')->nullable();
            }
            if (!Schema::hasColumn('users', 'theme')) {
                $table->string('theme')->after('font')->nullable();
            }
            if (!Schema::hasColumn('users', 'color')) {
                $table->longText('color')->after('theme')->nullable();
            }
            if (!Schema::hasColumn('users', 'avatar_settings')) {
                $table->longText('avatar_settings')->after('avatar')->nullable();
            }
            if (!Schema::hasColumn('users', 'phone_number')) {
                $table->longText('phone_number')->after('lastCountry')->nullable();
            }
        });

        // Plans
        Schema::table('plans', function (Blueprint $table) {
            if (!Schema::hasColumn('plans', 'position')) {
                $table->integer('position')->after('settings')->default(0);
            }
            if (!Schema::hasColumn('plans', 'price_type')) {
                $table->string('price_type')->after('settings')->default('price');
            }
            if (!Schema::hasColumn('plans', 'defaults')) {
                $table->integer('defaults')->after('settings')->default(0);
            }
            if (!Schema::hasColumn('plans', 'extra')) {
                $table->longText('extra')->after('settings')->nullable();
            }
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
