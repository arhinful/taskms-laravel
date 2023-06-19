<?php

namespace App\Http\Controllers;

use App\Http\Resources\TaskResource;
use App\Models\Task;
use Spatie\QueryBuilder\QueryBuilder;

class TaskController extends Controller
{
    public function index(){
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
}
