<?php

namespace App\Http\Controllers\Api;

use App\Models\Task;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreValidation;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::all();

        if ($tasks) {
            return response()->json(['msg' => "Это index", "data" => $tasks]);
        }

        return response()->json(['msg' => "Что-то пошло не так"]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->json(['msg' => "Это index"]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreValidation $request)
    {
        $data = $request->validated();
        if ($data) {
            Task::create($data);
            return response()->json(['msg' => "Добавлено", 'data' => $data]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $task = Task::find($id);
        if ($task) {
            return response()->json(["msg" => "Успешно", 'data' => $task]);
        }

        return response()->json(['msg' => "Пользователь не найден"]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreValidation $request, $id)
    {
        $data = $request->validated();
        $editTask = Task::find($id);
        $editTask->update($data);

        return response()->json(['msg' => "Успешно обновлено", "data" => $data]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Task::find($id)->delete();

        return response()->json(['msg' => "Элемент $id успешно удален "]);
    }
}
