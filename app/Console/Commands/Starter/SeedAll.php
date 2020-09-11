<?php

namespace App\Console\Commands\Starter;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SeedAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'starter:seed-all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed all started data.';

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
     * @return int
     */
    public function handle()
    {
        $this->line('Seeding started.');
        Artisan::call('migrate:fresh');
        Artisan::call('module:seed');
        $this->info('Seeding done.');
    }
}
