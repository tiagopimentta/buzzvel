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


    /**
     * @OA\Get (
     *     tags={"Tasks"},
     *     path="/api/tasks",
     *     summary="List all tasks",
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     )
     * )
     * @return JsonResponse
     */
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


    /**
     * @OA\Post (
     *     tags={"Tasks"},
     *     path="/api/tasks",
     *     summary="Create a task",
     *     @OA\Parameter(
     *         name="user_id",
     *         in="header",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             example="Task registered successfully"
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *     ),
     *     security={{ "jwt": {} }},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(property="title", type="string", example="titulo post"),
     *                 @OA\Property(property="description", type="string", example="description post"),
     *                 @OA\Property(property="file", type="string", format="binary"),
     *             )
     *         )
     *     )
     * ),
     *
     * @param Request $request
     * @return JsonResponse
     */

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


    /**
     *
     * @OA\Get(
     *     tags={"Tasks"},
     *     path="/api/tasks/{id}",
     *     summary="Get information about an task",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the task to retrieve",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             example="Tasks retrieved successfully"
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tasks not found"
     *     )
     * )
     *
     * @param int $id
     * @return JsonResponse
     */
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

    /**
     * @OA\Post (
     *     tags={"Tasks"},
     *     path="/api/tasks/{id}/",
     *     summary="Update a task",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the task to update",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="user_id",
     *         in="header",
     *         required=true,
     *         description="ID of the user",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             example="Task updated successfully"
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(property="_method", type="string", example="PUT"),
     *                 @OA\Property(property="title", type="string", example="New title"),
     *                 @OA\Property(property="description", type="string", example="New description"),
     *                 @OA\Property(property="status", type="string", example="COMPLETED"),
     *                 @OA\Property(property="file", type="file", format="binary"),
     *             )
     *         )
     *     ),
     *     @OA\Header(
     *         header="Accept",
     *         description="Content type",
     *         @OA\Schema(type="string"),
     *         required=true,
     *     )
     * )
     */

    public function update(Request $request, int $id): JsonResponse
    {
        //var_dump($id, $request->header('user_id'), $request->all());die;

        try {
            $search_user = $this->service->findUserInTask($id, $request->header('user_id'));
            if ($search_user) {
                $response = $this->service->update($id, $request->only(['title', 'description', 'status', 'file']));
            }
            return $this->success(
                $this->messageSuccessDefault,
                $response,
                Response::HTTP_CREATED
            );
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     *
     * @OA\Delete (
     *     tags={"Tasks"},
     *     path="/api/tasks/{id}/",
     *     summary="Delete a tasks",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the tasks to delete",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             example="Tasks deleted successfully"
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tasks not found"
     *     )
     * )
     *
     * @param int $id
     * @return JsonResponse
     */
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
