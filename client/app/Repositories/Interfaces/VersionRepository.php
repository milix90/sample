<?php

namespace App\Repositories\Interfaces;

use App\Repositories\BaseRepository;

interface VersionRepository extends BaseRepository
{
    public function createNewVersion($request, $appCode);

    public function updateVersionParams($request, $version);
}
