<?php

namespace App\Repositories;
use App\Models\Task;
use App\Repositories\Eloquent\BaseRepository;

class TaskRepository extends BaseRepository
{
    protected Task $model;

    public function __construct(Task $model)
    {
        $this->model = $model;
    }
}
