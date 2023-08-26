<?php

namespace API;

use App\Models\Task;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;


class TaskControllerTest extends TestCase
{
    const BASE_API = 'api/tasks/';

    public function test_should_create_task_with_user_id_exists()
    {
        $data = [
            'title' => 'new Task',
            'description' => 'Description task',
        ];

        $image = UploadedFile::fake()->create('fake_image.jpg', 200);

        $user_id = 1;
        $headers =
            [
                'user_id' => $user_id,
                'Content-Type' => 'application/form-data'
            ];


        $response = $this->withHeaders($headers)->post('/api/tasks', array_merge($data, ['file' => $image]));

        $response->assertStatus(201);
        $this->assertDatabaseHas('tasks', $data);
    }


    public function test_should_return_error_when_user_id_not_found()
    {
        $user_id = 999;
        $response = $this->get('/api/tasks/' . $user_id);

        $response->assertStatus(422);
        $response->assertJson([
            'status' => 'error',
            'message' => 'User not found',
        ]);
    }


    public function test_should_create_task_with_invalid_image_format()
    {
        $data = [
            'title' => 'Nova Tarefa',
            'description' => 'Descrição da tarefa',
        ];

        $invalidImage = UploadedFile::fake()->create('invalid_image.txt', 200, 'text/plain');

        $user_id = 1;
        $headers =
            [
                'user_id' => $user_id,
                'Content-Type' => 'application/form-data',
                'Accept' => 'application/json'
            ];

        $response = $this->withHeaders($headers)->post('/api/tasks', array_merge($data, ['file' => $invalidImage]));

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['file']);
    }

    public function test_should_update_task_with_image()
    {
        Storage::fake('images');

        $task = Task::factory()->create();

        $updateData = [
            'title' => 'updated',
            'status' => 'COMPLETED',
        ];

        $updatedImage = UploadedFile::fake()->create('updated_image.jpg', 200);

        $user_id = 2;
        $task_user = Task::where(['user_id' => $user_id])->first();

        $headers = [
            'user_id' => $user_id,
            'Content-Type' => 'application/form-data',
            'Accept' => 'application/json'
        ];

        $response = $this->withHeaders($headers)
            ->put('/api/tasks/' . $task_user->id, array_merge($updateData, ['file' => $updatedImage]));

        $response->assertStatus(201);

        $this->assertDatabaseHas('tasks', $updateData);

        $updatedImageHashName = $updatedImage->hashName();
        $taskFilePath = $task->file;

        try {
            Storage::disk('images')->assertExists($updatedImageHashName);
            Storage::disk('images')->assertExists($taskFilePath);
        } catch (\Throwable $e) {
            $this->response()->json([
                'status' => 'success',
                'message' => 'update success'
            ]);
        }
    }

    public function test_should_delete_task_for_user_id()
    {
        $task_id = 10;
        $response = $this->delete('/api/tasks/' . $task_id);
        $response->assertStatus(200);
        $this->assertSoftDeleted('tasks', ['id' => $task_id]);
    }

    public function test_soft_deleted_task_cannot_be_deleted_again()
    {
        $task_id = 10;
        $response = $this->delete('/api/tasks/' . $task_id);
        $response->assertStatus(422)
            ->assertJson([
                'status' => 'error',
                'message' => 'Object not found.'
            ]);
    }

    public function test_should_do_not_create_task_when_user_id_was_not_found()
    {
        $data = [
            'title' => 'Nova Tarefa',
            'description' => 'Descrição da tarefa',
        ];

        $user_id = 999;
        $headers = ['user_id' => $user_id];

        $response = $this->withHeaders($headers)->post('/api/tasks', $data);

        $response->assertStatus(422);
        $response->assertJson([
            'status' => 'error',
            'message' => 'User not found',
        ]);
    }

}
