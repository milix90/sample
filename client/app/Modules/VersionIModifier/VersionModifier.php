<?php

namespace App\Modules\VersionIModifier;

use App\Modules\VersionIModifier\classes\Helper;
use App\Modules\VersionIModifier\interfaces\VersionObjectInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class VersionModifier implements VersionObjectInterface
{
    use Helper;

    /**
     * @var Builder
     */
    protected Builder $version;
    /**
     * @var array
     */
    private array $items = [];
    /**
     * @var
     */
    protected $payload;

    /**
     * @param Builder $builder
     * @param $payload
     */
    public function __construct(Builder $builder, $payload)
    {
        $this->version = $builder;
        $this->payload = $payload;
    }

    /**
     * @param $item
     * @return $this
     */
    public function call($item): VersionModifier
    {
        $index = Str::snake(class_basename($item));

        /**
         * handle if column is null or not
         * just empty columns will be added
         */
        if (is_null($this->version->{$index}))
            $this->items[$index] = $item;

        return $this;
    }

    /**
     * @return void
     */
    public function modify()
    {
        foreach ($this->items as $index => $field) {
            $field->handle($this->payload[$index]);
        }
    }
}
