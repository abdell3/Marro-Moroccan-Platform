<?php

namespace App\Repositories\Interfaces;

interface BaseRepositoryInterface
{
    public function all(array $columns = ['*']);

    public function find(int $id, array $columns = ['*']);

    public function create(array $data);

    public function update(int $id, array $data);

    public function delete(int $id);

    public function firstWhere(array $condition, array $columns = ['*']);

    public function where(array $condition, array $columns = ['*']);

    public function paginate(int $perPage = 15, array $columns = ['*']);
}
