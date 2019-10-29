<?php

namespace App\Console\Commands;

use App\Statistics\Rating;
use Illuminate\Console\Command;
use App\User;

class RateProductsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:rate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rate products based on their comparison to their competitors';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        User::all()->each(function($user) {
            (new Rating)->get($user);
        });
    }

}
