<?php
namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    // use RefreshDatabase;

    // /**
    //  * Create and authenticate user
    //  */
    // protected function authenticate()
    // {
    //     $user = User::factory()->create();
    //     $this->actingAs($user);

    //     return $user;
    // }

    // #[Test]
    // public function user_can_view_tasks_list()
    // {
    //     $this->authenticate();

    //     Task::factory()->count(3)->create();

    //     $response = $this->get(route('tasks.index'));

    //     $response->assertStatus(200);
    // }

    // #[Test]

    // public function user_can_open_create_page()
    // {
    //     $this->authenticate();

    //     $response = $this->get(route('tasks.create'));

    //     $response->assertStatus(200);
    // }

    // #[Test]
    // public function user_can_create_task()
    // {
    //     $user = $this->authenticate();

    //     $data = [
    //         'title'       => 'Test Task',
    //         'description' => 'Test Description',
    //     ];

    //     $response = $this->post(route('tasks.store'), $data);

    //     $response->assertRedirect(route('tasks.index'));

    //     $this->assertDatabaseHas('tasks', [
    //         'title'       => 'Test Task',
    //         'description' => 'Test Description',
    //         'created_by'  => $user->id,
    //     ]);
    // }

    // #[Test]
    // public function title_is_required_when_creating_task()
    // {
    //     $this->authenticate();

    //     $response = $this->post(route('tasks.store'), [
    //         'title' => '',
    //     ]);

    //     $response->assertSessionHasErrors('title');
    // }

    // #[Test]
    // public function user_can_view_edit_page()
    // {
    //     $this->authenticate();

    //     $task = Task::factory()->create();

    //     $response = $this->get(route('tasks.edit', $task->id));

    //     $response->assertStatus(200);
    // }

    // #[Test]
    // public function user_can_update_task()
    // {
    //     $this->authenticate();

    //     $task = Task::factory()->create();

    //     $updatedData = [
    //         'title'       => 'Updated Task',
    //         'description' => 'Updated Description',
    //     ];

    //     $response = $this->put(route('tasks.update', $task->id), $updatedData);

    //     $response->assertRedirect('/tasks');

    //     $this->assertDatabaseHas('tasks', [
    //         'id'          => $task->id,
    //         'title'       => 'Updated Task',
    //         'description' => 'Updated Description',
    //     ]);
    // }

    // #[Test]
    // public function user_can_delete_task()
    // {
    //     $this->authenticate();

    //     $task = Task::factory()->create();

    //     $response = $this->delete(route('tasks.destroy', $task->id));

    //     $response->assertRedirect('/tasks');

    //     $this->assertDatabaseMissing('tasks', [
    //         'id' => $task->id,
    //     ]);
    }
