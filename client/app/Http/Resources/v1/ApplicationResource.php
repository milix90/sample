<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationResource extends JsonResource
{
    public function toArray($request)
    {
        $app = [
            'name' => $this->name ?? null,
            'description' => $this->description ?? null,
        ];
        $versions = [];

        if (isset($this->versions) && count($this->versions) >= 1) {
            foreach ($this->versions as $i => $item) {
                $versions[$i] = [
                    'version' => $item->version ?? null,
                    'status' => $item->status ?? null,
                    'created_at' => $item->created_at ?? null,
                    'updated_at' => $item->created_at ?? null,
                ];
            }
        }

        $app['versions'] = $versions;

        return $app;
    }
}
