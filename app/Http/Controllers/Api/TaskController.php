<?php

namespace App\Http\Controllers\Api;

use App\Models\Task;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreValidation;
use App\Http\Resources\TaskResource;

use function PHPSTORM_META\type;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(['data' => TaskResource::collection(Task::all())], 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreValidation $request)
    {
        $data = $request->validated();
        $newTask = Task::create($data);
        return response()->json(
            [
                'msg' => "Добавлено",
                'data' => new TaskResource($newTask)
            ],
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $task = Task::find($id);
        if ($task) {
            return response()->json(
                [
                    "msg" => "Успешно",
                    'data' => new TaskResource($task)
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'msg' => "Запись не найдена",
                    "data" => []
                ],
                404
            );
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreValidation $request, $id)
    {
        $data = $request->validated();

        $editTask = Task::find($id);
        if ($editTask) {
            $editTask->update($data);

            return response()->json(
                [
                    'msg' => "Успешно обновлено",
                    "data" => new TaskResource($editTask)
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'msg' => "Запись не найдена",
                    "data" => []
                ],
                404
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $task = Task::find($id);
        if ($task) {
            $task->delete();

            return response()->json(['msg' => "Элемент $id успешно удален "], 200);
        } else {
            return response()->json(['msg' => "Запись не найдена"], 404);
        }
    }
}
