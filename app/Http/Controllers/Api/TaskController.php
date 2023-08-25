<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{

    /**
     * @var TaskService
     */

    protected TaskService $service;

    public function __construct(TaskService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request): JsonResponse
    {
        return $this->ok(TaskResource::collection(
            $this
                ->service
                ->getRepository()
                ->getPaginationList(params: $request->all())
        ));
    }

    public function create()
    {
        //
    }

    public function store(TaskRequest $request)
    {
        try {
            $request['user_id'] = $request->header('user_id');
            $response = $this->service->save($request->all());
            return $this->success($this->messageSuccessDefault,
                $response,
                Response::HTTP_CREATED
            );
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            return $this->ok($this->service->findUser($id));
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $response = $this->service->update($id, $request->only(['title', 'status', 'file']));
            return $this->success(
                $this->messageSuccessDefault,
                $response,
                Response::HTTP_CREATED
            );
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $this->service->getRepository()->find($id);
            $this->service->delete($id);
            return $this->success();
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
