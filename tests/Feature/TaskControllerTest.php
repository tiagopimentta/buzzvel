<?php

namespace Tests\Feature;

use App\Models\Task;
use Tests\TestCase;

// Importe o modelo de Task ou o caminho correto para ele

class TaskControllerTest extends TestCase
{
    const BASE_API = 'api/tasks/';
    public function test_create_task_with_user_id_exists()
    {
        $data = [
            'title' => 'Nova Tarefa',
            'description' => 'Descrição da tarefa',
        ];

        $user_id = 1;
        $headers = ['user_id' => $user_id];

        $response = $this->withHeaders($headers)->post('/api/tasks', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('tasks', $data);
    }

    public function test_do_not_create_task_when_user_id_was_not_found()
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
