<?php
namespace Tests\Unit;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    protected function authenticate()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        return $user;
    }

    #[Test]
    public function deleting_a_task_removes_it_from_database()
    {
        $this->authenticate();

        $task = Task::factory()->create();

        $this->delete(route('tasks.destroy', $task->id));

        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
        ]);
    }
}