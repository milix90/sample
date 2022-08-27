<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class VersionDetailsResource extends JsonResource
{
    /**
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'app_file' => $this->app_file ?? null,
            'images' => $this->images ?? [],
            'change_log' => $this->change_log ?? null,
            'status' => $this->status ?? null,
            'created_at' => $this->created_at ?? null,
        ];
    }
}
