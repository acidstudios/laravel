<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AcidInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:install {--S|seed}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialize the complete Api Template';

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
        $seed = $this->option('seed');

        if(isset($seed)) {
            $this->call('migrate:refresh', ['--seed']);
        } else {
            $this->call('migrate:refresh');
        }

        $this->call('passport:install');
    }
}
