<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Repositories\TaskRepository;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    protected $tasks;

    public function __construct(TaskRepository $tasks)
    {
        $this->tasks = $tasks;
    }

    public function index()
    {
        $tasks = $this->tasks->all();
        return response()->json($tasks);
    }

    public function store(Request $request)
    {
        $task = $this->tasks->create($request->all());
        return response()->json($task, 201);
    }

    public function show($id)
    {
        $task = $this->tasks->find($id);
        return response()->json($task);
    }

    public function update(Request $request, $id)
    {
        $task = $this->tasks->update($id, $request->all());
        return response()->json($task);
    }

    public function destroy($id)
    {
        $this->tasks->delete($id);
        return response()->json(null, 204);
    }

}
