<?php declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    protected Model $model;

    public function findById(int $id): Model
    {
        return $this->model->findOrFail($id);
    }
}
