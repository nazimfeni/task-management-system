<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Task;
use App\Models\User;

class BasicTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_task()
    {
        $user = User::factory()->create();

        $task = Task::create([
            'title' => 'Test Task for testing',
            'description' => 'Test Description',
            'created_by' => $user->id,
        ]);

        $this->assertDatabaseHas('tasks', [
            'title' => 'Test Task for testing',
        ]);
    }

    /** @test */
    public function title_is_required()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        Task::create([
            'title' => null,
        ]);
    }
}
