<?php

namespace App\Modules\VersionIModifier\classes;

use App\Modules\VersionIModifier\interfaces\ModifyInterface;
use App\Modules\VersionIModifier\VersionModifier;
use Illuminate\Support\Facades\Log;

class ChangeLog extends VersionModifier implements ModifyInterface
{
    /**
     * @param $payload
     * @return void
     * @throws \Exception
     */
    public function handle($payload)
    {
        try {
            $this->version->update(['change_log' => $payload]);
        } catch (\Exception $e) {
            Log::error($e->getMessage() . $e->getTraceAsString());
            throw new \Exception($e);
        }
    }
}
