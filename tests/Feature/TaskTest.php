<?php


namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Task;
use App\Jobs\ProcessTask;
use App\Services\TaskService;
use Illuminate\Support\Facades\Bus;
use Faker\Factory as Faker;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /**
     *
     * @return void
     */
    public function test_create_task(): void
    {
        Bus::fake();
        $faker = Faker::create();
        $size = $faker->numberBetween(1, 10);
        $response = $this->postJson('/api/tasks', ['size' => $size]);
        $response->assertStatus(200);
        $taskId = $response->json('data.id');
        $this->assertDatabaseHas('tasks', ['id' => $taskId, 'size' => $size, 'status' => 'pending']);
        Bus::assertDispatched(ProcessTask::class);
        $task = Task::find($taskId);
        $job = new ProcessTask($task);
        $job->handle(app(TaskService::class));
        $task->refresh();
        $this->assertEquals('completed', $task->status);
        $this->assertDatabaseHas('tasks', ['id' => $taskId, 'size' => $size, 'status' => 'completed']);
        $this->assertCount($size, $task->result);
    }

    /**
     *
     * @return void
     */
    public function test_create_task_with_invalid_size(): void
    {
        $response = $this->postJson('/api/tasks', ['size' => 0]);
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'success',
            'data' => [
                'size'
            ]
        ]);
    }

    /**
     *
     * @return void
     */
    public function test_create_task_without_size(): void
    {
        $response = $this->postJson('/api/tasks', []);
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'success',
            'data' => [
                'size'
            ]
        ]);
    }

    /**
     *
     * @return void
     */
    public function test_get_task(): void
    {
        $faker = Faker::create();
        $size = $faker->numberBetween(1, 10);
        $task = Task::create(['size' => $size, 'status' => 'pending']);
        $response = $this->getJson("/api/tasks/{$task->id}");
        $response->assertStatus(200);
        $response->assertJson(['data' => ['id' => $task->id, 'size' => $task->size, 'status' => $task->status]]);
    }

    /**
     *
     * @return void
     */
    public function test_get_task_not_found()
    {
        $faker = Faker::create();
        $taskId = $faker->numberBetween();
        $response = $this->getJson("/api/tasks/$taskId");
        $response->assertStatus(404);
    }
}
