<?php

namespace App\Modules\VersionIModifier\classes;

use App\Modules\VersionIModifier\interfaces\ModifyInterface;
use App\Modules\VersionIModifier\VersionModifier;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AppFile extends VersionModifier implements ModifyInterface
{
    /**
     * @param $payload
     * @return void
     * @throws \Exception
     */
    public function handle($payload)
    {
        $file = $payload->file;
        list($dir, $filename) = $this->filePathHandler();
        $filename = $filename . 'app' . $file->getClientOriginalExtension();

        try {
            Storage::disk('local')->put($dir . $filename, file_get_contents($file));
            $this->version->update(['app_file' => $dir . $filename]);
        } catch (\Exception $e) {
            Log::error($e->getMessage() . $e->getTraceAsString());
            throw new \Exception($e);
        }
    }
}
