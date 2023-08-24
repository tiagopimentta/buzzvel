<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\TaskRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class TaskController extends Controller
{
    public function __construct(protected TaskRepositoryInterface $repository){}

    public function index(): JsonResponse
    {
        $tasks = $this->repository->all();
        return response()->json($tasks);
    }

    public function store(Request $request): JsonResponse
    {
        $filter = $request->header('user_id');
        $user = $this->repository->findUser($filter);

        if (!$user) {
            return response()->json(['error' => 'user not found']);
        }

        $request['user_id'] = $user->user_id;
        $request['status'] = 'PENDENTE';
        $request->only(['title', 'description']);

        $task = $this->repository->create($request->all());
        return response()->json(['success' => 'Task created success']);
    }

    public function show(int $id): JsonResponse
    {
        $task = $this->repository->find($id);
        if (!$task) {
            return response()->json(['error' => 'Task not found']);
        }
        return response()->json($task);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $task = $this->repository->update($id, $request->all());
        return response()->json(['success' => 'Task updated success']);
    }

    public function destroy(int $id): JsonResponse
    {
        $task = $this->repository->find($id);
        if (!$task) {
            return response()->json(['error' => 'Task not found']);
        }
        $task->delete();
        return response()->json(['success' => 'Task deleted successfully']);

    }
}
