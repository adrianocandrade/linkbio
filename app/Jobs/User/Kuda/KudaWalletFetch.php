<?php

namespace App\Jobs\User\Kuda;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class KudaWalletFetch implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    public $tries = 1;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user){
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(){
        $kuda = \App\Wallet\Kuda::fetch_kuda_account($this->user->id);
    }
}
