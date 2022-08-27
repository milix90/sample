<?php

namespace App\Console\Commands;

use App\Jobs\ReleaseRequest;
use App\Models\Version;
use Illuminate\Console\Command;

class ReleaseCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'release:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'check applications in progress version';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
        $items = Version::query()->latest()->progress()->get();

        foreach ($items as $i => $item) {
            dispatch(new ReleaseRequest($item));
            sleep(rand(2, 5));
        }
    }
}
