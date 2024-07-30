<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

final class TaskController extends Controller
{
    /**
     *
     * @param StoreTaskRequest $request
     * @param TaskService $taskService
     *
     * @return JsonResponse
     */
    public function store(StoreTaskRequest $request, TaskService $taskService): JsonResponse
    {
        $task = $taskService->createTask($request->validated());

        return $this->sendResponse(new TaskResource($task));
    }

    /**
     *
     * @param int $taskId
     *
     * @return JsonResponse
     */
    public function show(int $taskId): JsonResponse
    {
        try {
            $task = Task::findOrFail($taskId);
        } catch (ModelNotFoundException $e) {
            return $this->sendError('Task not found.');
        }

        return $this->sendResponse(new TaskResource($task));
    }
}
