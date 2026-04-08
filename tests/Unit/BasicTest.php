<?php
namespace Tests\Unit;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BasicTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_task()
    {
        $user = User::factory()->create();

        $task = Task::create([
            'title'       => 'Test Task for testing',
            'description' => 'Test Description',
            'created_by'  => $user->id,
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

    public function test_example()
    {
        $this->assertTrue(true);
    }

    public function test_dashboard_page_loads()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
    }

    public function test_dashboard_requires_login()
    {
        $response = $this->get('/dashboard');

        $response->assertStatus(302); // redirect to login
    }

    public function test_dashboard_logged_in_user()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
    }

}
