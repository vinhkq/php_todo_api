<?php

namespace App\Http\Controllers;

use App\Repositories\TodoRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TodosController extends Controller
{
    // TODO Add Middleware to check todo exist
    private $todoRepo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TodoRepository $todoRepo)
    {
        // Construct
        $this->todoRepo = $todoRepo;
    }

    public function index()
    {
        $response = [
            'message' => 'Hello from API Index',
        ];
        return new JsonResponse($response, 200);
    }

    public function indexTodos()
    {
        return $this->todoRepo->all();
    }

    public function viewTodo($id)
    {
        // TODO Check exist in middleware
        return $this->todoRepo->get($id);
    }

    public function createTodo(Request $request)
    {
        $this->validate($request, [
            'title' => 'required'
        ]);

        $data = [
            'title' => $request->input('title'),
            'due_date' => $request->input('due_date', null),
            'color' => $request->input('color', null),
            'todo_groups_id' => 1
        ];
        return $this->todoRepo->create($data);
    }

    public function updateTodo($id, Request $request)
    {
        // TODO Check exist in middleware
        $this->validate($request, [
            'title' => 'required'
        ]);

        $data = [
            'title' => $request->input('title'),
            'due_date' => $request->input('due_date', null),
            'color' => $request->input('color', null)
        ];

        return $this->todoRepo->update($data, $id);
    }

    public function deleteTodo($id)
    {
        // TODO Check exist in middleware
        return $this->todoRepo->delete($id);
    }

    public function moveTodo($id, Request $request)
    {
        return $this->todoRepo->move($id, $request->input('prior_sibling_id', ''));
    }
}