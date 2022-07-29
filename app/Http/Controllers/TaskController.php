<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    public function getAllTasks()
    {
        try {
            Log::info('Getting all Tasks');
            // QUERY BUILDER
            // $contacts = DB::table('contacts')->select('name', 'email')->get()->toArray();

            // MODEL
            $task = Task::query()
                ->get()
                ->toArray();

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
}
