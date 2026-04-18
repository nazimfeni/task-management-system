<?php
namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    protected function authenticate()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        return $user;
    }

    #[Test]
    public function it_can_list_tasks()
    {
        $this->authenticate();

        Task::factory()->count(3)->create();

        $response = $this->get('/tasks');

        $response->assertStatus(200);
    }

    #[Test]
    public function it_can_create_task()
    {
        $user = $this->authenticate();

        $response = $this->post('/tasks', [
            'title'       => 'Test Task',
            'description' => 'Test Description',
        ]);

        $response->assertRedirect('/tasks');

        $this->assertDatabaseHas('tasks', [
            'title'      => 'Test Task',
            'created_by' => $user->id,
        ]);
    }

    #[Test]
    public function it_validates_required_title()
    {
        $this->authenticate();

        $response = $this->post('/tasks', []);

        $response->assertSessionHasErrors('title');
    }

    #[Test]
    public function it_can_update_task()
    {
        $this->authenticate();

        $task = Task::factory()->create();

        $response = $this->put("/tasks/{$task->id}", [
            'title' => 'Updated Task',
        ]);

        $response->assertRedirect('/tasks');

        $this->assertDatabaseHas('tasks', [
            'id'    => $task->id,
            'title' => 'Updated Task',
        ]);
    }

    #[Test]
    public function it_can_delete_task()
    {
        $this->authenticate();

        $task = Task::factory()->create();

        $response = $this->delete("/tasks/{$task->id}");

        $response->assertRedirect('/tasks');

        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
        ]);
    }
}
