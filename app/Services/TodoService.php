<?php

namespace App\Services;

use App\Models\Todo;
use App\Contracts\EventPublisherInterface;
use Illuminate\Support\Carbon;

class TodoService
{
    public function __construct(
        protected EventPublisherInterface $publisher
    ) {}

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

        $payload = [
            'event' => 'TodoCreated',
            'data' => [
                'todo_id' => $todo->id,
                'title' => $todo->title,
                'email' => $data['email'],
            ],
            'timestamp' => Carbon::now('UTC')->toIso8601String(),
        ];

        $this->publisher->publish('queue:todo-events', $payload);

        return $todo;
    }
}
