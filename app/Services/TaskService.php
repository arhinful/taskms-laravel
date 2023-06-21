<?php

namespace App\Services;

use App\Models\Task;

class TaskService
{
    public static function store(array $data): Task{
//        $task = auth()->user()->tasks()->create($data);
        $data = array_merge($data, [
            'user_id' => 1
        ]);
        $task = Task::create($data);
        return $task;
    }

    public static function update(Task $task, array $data): Task{
        $task->update($data);
        return $task;
    }
}
