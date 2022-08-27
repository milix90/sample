<?php

namespace App\Repositories;

interface BaseRepository
{
    public function createItem(array $payload);

    public function updateItem(array $payload, string $columnValue, string $column = 'id', string $sign = '=');

    public function deleteItem(string $columnValue, string $column = 'id');
}
