<?php

namespace App\Modules\VersionIModifier\classes;

use App\Modules\VersionIModifier\interfaces\ModifyInterface;
use App\Modules\VersionIModifier\VersionModifier;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class Images extends VersionModifier implements ModifyInterface
{
    /**
     * @param $payload
     * @return void
     * @throws \Exception
     */
    public function handle($payload)
    {
        $images = [];
        list($dir, $filename) = $this->filePathHandler();

        try {
            foreach ($payload as $index => $image) {
                $filename = $filename . 'image_' . $index . $image->file->getClientOriginalExtension();
                Storage::disk('local')->put($dir . $filename, file_get_contents($image->file));
                $images[] = $dir . $filename;
            }

            $this->version->update(['images' => $images]);
        } catch (\Exception $e) {
            Log::error($e->getMessage() . $e->getTraceAsString());
            throw new \Exception($e);
        }
    }
}
