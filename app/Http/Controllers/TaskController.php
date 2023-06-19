<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\StoreRequest;
use App\Http\Requests\Task\UpdateRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:sanctum");
    }

    public function index(): JsonResponse{
        $tasks = QueryBuilder::for(Task::class)
            ->allowedFilters([
                "task",
                "description",
                "user_id",
            ])
            ->paginate();
        $tasks = TaskResource::collection($tasks)->response()->getData(true);
        return $this->successReadCollection($tasks);
    }

    public function store(StoreRequest $request): JsonResponse{
        DB::beginTransaction();
        try {
            $task = TaskService::store($request->validated());
            $task = TaskResource::make($task);
            DB::commit();
            return $this->successCreated($task);
        } catch (\Exception $exception){
            DB::rollBack();
            return $this->errorOccurred($exception->getMessage());
        }
    }

    public function update(Task $task, UpdateRequest $request): JsonResponse{
        DB::beginTransaction();
        try {
            $task = TaskService::update($task, $request->validated());
            $task = TaskResource::make($task);
            DB::commit();
            return $this->successUpdated($task);
        } catch (\Exception $exception){
            return $this->errorOccurred($exception->getMessage());
        }
    }
}
