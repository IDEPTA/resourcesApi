<?php

namespace App\Http\Controllers\Api;

use App\Models\Task;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreValidation;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\TaskResource;

/**
 * Контроллер, отвечающий за crud операции связанные с задачами
 */
class TaskController extends Controller
{
    /**
     * Возвращает весь список задач.
     */
    /**
     * @return JsonResponse json со всеми задачами
     */
    public function index(): JsonResponse 
    {
        return response()->json(['data' => TaskResource::collection(Task::all())], 200);
    }


    /**
     * Добавляет задачу в базу данных.
     */
    /**
     * @param StoreValidation $request валидация входящего запроса
     * 
     * @return JsonResponse json ответ с новой задачей и сообщением
     */
    public function store(StoreValidation $request): JsonResponse 
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
     * Возвращает конкретную задачу.
     */
    /**
     * @param int $id id задачи
     * 
     * @return JsonResponse json ответ с нужной задачей или пустой массив с сообщением
     */
    public function show(int $id): JsonResponse 
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
     * Обновляет задачу по id.
     */
    /**
     * @param StoreValidation $request запрос на обновление задачи и его валидация
     * @param int $id id задачи
     * 
     * @return JsonResponse json ответ с обновленной задачей или пустой массив с сообщением
     */
    public function update(StoreValidation $request, int $id): JsonResponse 
    {
        $data = $request->validated();

        $editTask = Task::find($id);
        if ($editTask) {
            $editTask->update($data);

            return response()->json(
                [
                    'msg' => "Успешно обновлено",
                    "data" => $data
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
     * Удаление задачи по id.
     */
    /**
     * @param int $id id задачи
     * 
     * @return JsonResponse сообщение об удалении задачи или о том, что запись не найдена
     */
    public function destroy(int $id): JsonResponse 
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
