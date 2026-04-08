<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_tasks_page_loads()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/tasks');

        $response->assertStatus(200);
    }

    // 1. User Registration
    public function test_user_can_register()
    {
        $response = $this->post('/register', [
            'name'                  => 'Test User',
            'email'                 => 'testuser@example.com',
            'password'              => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertDatabaseHas('users', ['email' => 'testuser@example.com']);
    }

    // 2. User Login
    public function test_user_can_login()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/login', [
            'email'    => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    // 3. Task Creation
    public function test_user_can_create_task()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/tasks', [
            'title'       => 'New Test Task',
            'description' => 'Task description',
        ]);

        $response->assertRedirect('/tasks');
        $this->assertDatabaseHas('tasks', [
            'title'      => 'New Test Task',
            'created_by' => $user->id,
        ]);
    }

    // 4. Task Edit Page Loads
    public function test_user_can_view_task_edit_page()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['created_by' => $user->id]);

        $response = $this->actingAs($user)->get("/tasks/{$task->id}/edit");

        $response->assertStatus(200);
    }

    // 5. Task Update
    public function test_user_can_update_task()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['created_by' => $user->id]);

        $response = $this->actingAs($user)->put("/tasks/{$task->id}", [
            'title'       => 'Updated Task Title',
            'description' => 'Updated description',
        ]);

        $response->assertRedirect('/tasks');
        $this->assertDatabaseHas('tasks', [
            'id'    => $task->id,
            'title' => 'Updated Task Title',
        ]);
    }

    // 6. Task Delete
    public function test_user_can_delete_task()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['created_by' => $user->id]);

        $response = $this->actingAs($user)->delete("/tasks/{$task->id}");

        $response->assertRedirect('/tasks');
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
