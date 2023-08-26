<?php

namespace App\Services;

use App\Models\Task;
use App\Models\User;
use App\Repositories\TaskRepository;
use Exception;
use Illuminate\Database\Eloquent\Model;

class TaskService extends BaseService
{
    protected TaskRepository $productRepository;

    public function __construct(TaskRepository $repository)
    {
        $this->taskRepository = $repository;
        parent::__construct($repository);
    }

    public function save(array $params): Model
    {
        $task = User::find($params['user_id']);
        if (!$task) {
            throw new Exception('User not found');
        }

        if (isset($params['file'])) {
            $imagePath = $params['file']->store('images', 'public');
            $params['image'] = $imagePath;
            unset($params['file']);
        }

        return parent::save($params);
    }

    public function findUser(int $id)
    {
        $task = Task::withTrashed()->find($id);

        if (!$task) {
            throw new Exception('User not found');
        }

        $task->created = $task->created_at->format('d/m/Y H:i:s');
        $task->updated = $task->updated_at->format('d/m/Y H:i:s');

        if (!$task->image) {
            unset($task->image);
        }

        if ($task->deleted_at) {
            $task->deleted = $task->deleted_at->format('d/m/Y H:i:s');
        }

        return $task;
    }

    public function findUserInTask(int $id, string $user_id)
    {
        $user_task = Task::where(['id' => $id])->where(['user_id' => $user_id])->first();
        if (!$user_task) {
            throw new Exception('User not found');
        }
        return $user_task;
    }
}
