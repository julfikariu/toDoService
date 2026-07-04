<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTodoRequest;
use App\Http\Resources\TodoResource;
use App\Models\Todo;
use App\Services\TodoService;
use Illuminate\Http\JsonResponse;

class TodoController extends Controller
{
    public function index(): JsonResponse
    {
        $todos = Todo::all();
        
        return response()->json([
            'success' => true,
            'message' => 'Todos retrieved successfully',
            'data' => TodoResource::collection($todos)
        ]);
    }

    public function store(StoreTodoRequest $request, TodoService $service): JsonResponse
    {
        $todo = $service->createTodo($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Todo created successfully',
            'data' => new TodoResource($todo)
        ], 201);
    }
}
