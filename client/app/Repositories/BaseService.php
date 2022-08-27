<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class BaseService implements BaseRepository
{
    /**
     * @var Model
     */
    public $model;

    /**
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model->query();
    }


    /**
     * @param array $payload
     * @return Builder|Model
     * @throws \Exception
     */
    public function createItem(array $payload): Model|Builder
    {
        try {
            $result = $this->model->create($payload);
        } catch (\Exception $e) {
            Log::error($e->getMessage() . $e->getTraceAsString());
            throw new \Exception($e);
        }

        return $result;
    }


    /**
     * @param array $payload
     * @param string $columnValue
     * @param string $column
     * @param string $sign
     * @return bool|int
     * @throws \Exception
     */
    public function updateItem(array $payload, string $columnValue, string $column = 'id', string $sign = '='): bool|int
    {
        try {
            $item = $this->model->where($column, $sign, $columnValue)->firstOrFail();
            $result = $item->update($payload);
        } catch (\Exception $e) {
            Log::error($e->getMessage() . $e->getTraceAsString());
            throw new \Exception($e);
        }

        return $result;
    }

    /**
     * @param string $columnValue
     * @param string $column
     * @return bool|mixed|null
     * @throws \Exception
     */
    public function deleteItem(string $columnValue, string $column = 'id'): mixed
    {
        try {
            $item = $this->model->where($column,'=', $columnValue)->firstOrFail();
            $result = $item->delete();
        } catch (\Exception $e) {
            Log::error($e->getMessage() . $e->getTraceAsString());
            throw new \Exception($e);
        }

        return $result;
    }
}
