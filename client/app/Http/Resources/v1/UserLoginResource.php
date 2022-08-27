<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class UserLoginResource extends JsonResource
{
    /**
     * @var
     */
    protected $token;

    /**
     * @param $resource
     * @param $token
     */
    public function __construct($resource)
    {
        parent::__construct($resource);
        $this->token = $resource;
    }

    /**
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            "access_token" => $this->token,
            "token_type" => "bearer",
            "ttl" => config('jwt.ttl')
        ];
    }
}
