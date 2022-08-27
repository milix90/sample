<?php

namespace App\Modules\VersionIModifier\classes;

trait Helper
{
    public function filePathHandler(): array
    {
        $app_code = $this->version->load('application')->application->app_code;
        $version = $this->version->version;
        $dir = storage_path($app_code . DIRECTORY_SEPARATOR . $version . DIRECTORY_SEPARATOR);
        $filename = $app_code . '_' . $version . '_';

        return [$dir, $filename];
    }
}
