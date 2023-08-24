<?php

namespace App\Repositories;

use App\Interfaces\TaskRepositoryInterface;
use App\Models\Task;
use App\Repositories\Eloquent\BaseRepository;

class TaskRepository extends BaseRepository implements TaskRepositoryInterface
{
    public function __construct()
    {
        parent:: __construct(new Task());
    }

    public function findUser($user_id)
    {
        return Task::where(['user_id'=> $user_id])->first();
    }
}
