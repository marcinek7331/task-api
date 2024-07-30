<?php

namespace App\Services;

use App\Constants\TaskStatus;
use App\Models\Task;
use Illuminate\Support\Facades\Bus;
use App\Jobs\ProcessTask;

final class TaskService
{
    /**
     *
     * @param array $attributes
     *
     * @return Task
     */
    public function createTask(array $attributes): Task
    {
        $task = Task::create($attributes + [Task::STATUS => TaskStatus::PENDING]);
        Bus::dispatch(new ProcessTask($task));

        return $task;
    }

    /**
     *
     * @param Task $task
     *
     * @return void
     */
    public function completeTask(Task $task): void
    {
        $task->result = $this->generateUniqueRandomArray($task->size);
        $task->status = TaskStatus::COMPLETED;
        $task->save();
    }

    /**
     *
     * @param int $size
     *
     * @return array
     */
    private function generateUniqueRandomArray(int $size): array
    {
        $uniqueNumbers = [];
        while (count($uniqueNumbers) < $size) {
            $rand = rand();
            if (!in_array($rand, $uniqueNumbers)) {
                $uniqueNumbers[] = $rand;
            }
        }

        return $uniqueNumbers;
    }
}
