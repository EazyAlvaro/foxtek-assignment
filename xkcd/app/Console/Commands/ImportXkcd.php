<?php

namespace App\Console\Commands;

use App\Modules\Xkcd\XkcdService;
use Illuminate\Console\Command;

class ImportXkcd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:xkcd';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $service = new XkcdService();
        $service->import();
    }
}
