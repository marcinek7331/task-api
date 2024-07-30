<?php

namespace App\Jobs;

use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessTask implements ShouldQueue
{
    use Queueable, SerializesModels, Dispatchable, InteractsWithQueue;

    /**
     *
     * @var Task $task
     */
    private $task;

    /**
     *
     * @param Task $task
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     *
     * @param TaskService $taskService
     *
     * @return void
     */
    public function handle(TaskService $taskService): void
    {
        sleep(15);
        $taskService->completeTask($this->task);
    }
}
