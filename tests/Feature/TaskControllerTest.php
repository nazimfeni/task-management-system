<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function authenticate(): User
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        return $user;
    }

    // ── Index ────────────────────────────────────────────────────────────────

    #[Test]
    public function guest_cannot_view_tasks_list()
    {
        $response = $this->get(route('tasks.index'));

        $response->assertRedirect(route('login'));
    }

    #[Test]
    public function user_can_view_tasks_list()
    {
        $this->authenticate();
        Task::factory()->count(3)->create();

        $response = $this->get(route('tasks.index'));

        $response->assertStatus(200);
    }

    // ── Create ───────────────────────────────────────────────────────────────

    #[Test]
    public function user_can_open_create_page()
    {
        $this->authenticate();

        $response = $this->get(route('tasks.create'));

        $response->assertStatus(200);
    }

    // ── Store ────────────────────────────────────────────────────────────────

    #[Test]
    public function user_can_create_task()
    {
        $user = $this->authenticate();

        $response = $this->post(route('tasks.store'), [
            'title'       => 'Test Task',
            'description' => 'Test Description',
        ]);

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', [
            'title'       => 'Test Task',
            'description' => 'Test Description',
            'created_by'  => $user->id,
        ]);
    }

    #[Test]
    public function task_defaults_to_draft_status_on_create()
    {
        $this->authenticate();

        $this->post(route('tasks.store'), ['title' => 'Draft Task']);

        $this->assertDatabaseHas('tasks', [
            'title'  => 'Draft Task',
            'status' => 'draft',
        ]);
    }

    #[Test]
    public function title_is_required_when_creating_task()
    {
        $this->authenticate();

        $response = $this->post(route('tasks.store'), ['title' => '']);

        $response->assertSessionHasErrors('title');
        $this->assertDatabaseCount('tasks', 0);
    }

    #[Test]
    public function title_cannot_exceed_255_characters_on_create()
    {
        $this->authenticate();

        $response = $this->post(route('tasks.store'), [
            'title' => str_repeat('a', 256),
        ]);

        $response->assertSessionHasErrors('title');
    }

    // ── Edit ─────────────────────────────────────────────────────────────────

    #[Test]
    public function user_can_view_edit_page()
    {
        $this->authenticate();
        $task = Task::factory()->create();

        $response = $this->get(route('tasks.edit', $task->id));

        $response->assertStatus(200);
    }

    #[Test]
    public function edit_page_returns_404_for_nonexistent_task()
    {
        $this->authenticate();

        $response = $this->get(route('tasks.edit', 9999));

        $response->assertStatus(404);
    }

    // ── Update ───────────────────────────────────────────────────────────────

    #[Test]
    public function user_can_update_task()
    {
        $this->authenticate();
        $task = Task::factory()->create();

        $response = $this->put(route('tasks.update', $task->id), [
            'title'       => 'Updated Task',
            'description' => 'Updated Description',
        ]);

        $response->assertRedirect('/tasks');
        $this->assertDatabaseHas('tasks', [
            'id'          => $task->id,
            'title'       => 'Updated Task',
            'description' => 'Updated Description',
        ]);
    }

    #[Test]
    public function title_is_required_when_updating_task()
    {
        $this->authenticate();
        $task = Task::factory()->create(['title' => 'Original']);

        $response = $this->put(route('tasks.update', $task->id), ['title' => '']);

        $response->assertSessionHasErrors('title');
        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'title' => 'Original']);
    }

    #[Test]
    public function user_can_update_task_status()
    {
        $this->authenticate();
        $task = Task::factory()->create(['status' => 'draft']);

        $this->put(route('tasks.update', $task->id), [
            'title'  => $task->title,
            'status' => 'in_progress',
        ]);

        $this->assertDatabaseHas('tasks', [
            'id'     => $task->id,
            'status' => 'in_progress',
        ]);
    }

    // ── Destroy ──────────────────────────────────────────────────────────────

    #[Test]
    public function user_can_delete_task()
    {
        $this->authenticate();
        $task = Task::factory()->create();

        $response = $this->delete(route('tasks.destroy', $task->id));

        $response->assertRedirect('/tasks');
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

      #[Test]
    public function delete_returns_404_for_nonexistent_task()
    {
        $this->authenticate();

        $response = $this->delete(route('tasks.destroy', 9999));

        $response->assertStatus(404);
    }
}
