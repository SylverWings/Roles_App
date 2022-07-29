<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function getAllTasks()
    {
        try {
            Log::info('Getting all Tasks');
            
            $task = DB::table('tasks')->select('title', 'user_id')->get()->toArray();

            return response()->json(
                [
                    'success' => true,
                    'message' => "Get all taks retrieved.",
                    'data' => $task
                ],
                200
            );
        } catch (\Exception $exception) {
            Log::error('Error getting tasks: ' . $exception->getMessage());

            return response()->json(
                [
                    'success' => false,
                    'message' => "Error getting tasks"
                ],
                500
            );
        }
    }

    public function createTasks(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string',                
            ]);

            if ($validator->fails()) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => $validator->errors()
                    ],
                    400
                );
            };    

            $title = $request->input('title');
            $userId= auth()->user()->id;
            
            $newTask = new Task();

            $newTask->title = $title;           
            $newTask->user_id = $userId;

            $newTask->save();

            return response()->json(
                [
                    "success" => true,
                    "messagge" => "Task created"
                ],
                200
            );
        } catch (\Exception $exception) {
            Log::error('Error creating tasks: ' . $exception->getMessage());

            return response()->json(
                [
                    "success" => true,
                    "messagge" => "Error creating task"
                ],
                500
            );
        }
    }
    
    public function updateTasks(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'string',                
            ]);

            if ($validator->fails()) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => $validator->errors()
                    ],
                    400
                );
            };    

            $task = Task::query()->findOrFail($id);

            $title = $request->input('title');

            if(isset($title)) {
                $task->title = $title;
            }

            $task->save();

            return response()->json(
                [
                    "success" => true,
                    "messagge" => "Task updated"
                ],
                200
            );
        } catch (\Exception $exception) {
            Log::error('Error updating task: ' . $exception->getMessage());

            return response()->json(
                [
                    "success" => true,
                    "messagge" => "Error updateing task"
                ],
                500
            );
        }
    }

    public function deleteContact($id)
    {
        try {
            Task::query()->find($id)->delete();

            return response()->json(
                [
                    "success" => true,
                    "messagge" => "Task created"
                ],
                200
            );
        } catch (\Exception $exception) {
            Log::error('Error deleting Exception task: '.$exception->getMessage());

            return response()->json(
                [
                    "success" => true,
                    "messagge" => "Error deleting task"
                ],
                500
            );
        } catch (\Throwable $throwable) {
            Log::error('Error deleting Throwable task: '.$throwable->getMessage());

            return response()->json(
                [
                    "success" => true,
                    "messagge" => "Error deleting task"
                ],
                500
            );
        }
    }
}
