<?php

namespace App\Modules\VersionIModifier\interfaces;

interface VersionObjectInterface
{
    public function call($item);

    public function modify();
}
