<?php

namespace App\Jobs;

use App\Models\Version;
use Illuminate\Support\Facades\Log;

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
        $this->item = $item;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $payload = json_decode($this->item, true);
        !is_null($payload) && Log::info("Payload received! ID: {$payload['version_id']}");

        Version::query()->create([
            'application_id' => $payload['application_id'],
            'app_file' => $payload['app_file'],
            'images' => $payload['images'],
            'version' => $payload['version'],
            'change_log' => $payload['change_log'],
            'status' => $payload['status'],
        ]);

        sleep(1);
    }
}
