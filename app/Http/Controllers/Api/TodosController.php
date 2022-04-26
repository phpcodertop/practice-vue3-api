<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Todo;
use Illuminate\Http\Request;

class TodosController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('jwt');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(Todo::latest()->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required'
        ]);
        $todo = Todo::create([
           'content' => $request->input('content'),
           'completed' => 0
        ]);
        return response()->json($todo, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Todo $todo
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Todo $todo)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Todo $todo
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Todo $todo)
    {
        $request->validate([
            'completed' => 'required'
        ]);
        $todo->completed = $request->completed;
        $todo->save();

        return response()->json($todo, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Todo $todo
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Todo $todo)
    {
        //
    }
}
