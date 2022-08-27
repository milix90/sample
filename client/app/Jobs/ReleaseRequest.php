<?php

namespace App\Jobs;

class ReleaseRequest extends Job
{
    /**
     * @var
     */
    private $item;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($item)
    {
        //
        $this->item = json_encode($item);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
    }
}
