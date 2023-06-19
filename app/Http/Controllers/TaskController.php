<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\StoreRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;

class TaskController extends Controller
{
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

            DB::commit();
            return $this->successCreated();
        } catch (\Exception $exception){
            DB::rollBack();
            return $this->errorOccurred($exception->getMessage());
        }
    }
}
