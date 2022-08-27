<?php

namespace App\Repositories\Interfaces;

use App\Repositories\BaseRepository;

interface ApplicationRepository extends BaseRepository
{
    public function createAppItem(array $request);
}
