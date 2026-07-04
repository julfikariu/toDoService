<?php

namespace App\Services;

use App\Models\Todo;
use App\Events\TodoCreated;

class TodoService
{
    /**
     * Create a new Todo.
     *
     * @param array $data
     * @return Todo
     */
    public function createTodo(array $data): Todo
    {
        $todo = Todo::create([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'status' => 'pending',
        ]);

        event(new TodoCreated());

        return $todo;
    }
}
