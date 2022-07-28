<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    const SUPER_ADMIN_ROLE = 3;
    public function addRoleSuperAdminToUserById($id)
    {

        try {
            $user = User::query()->find($id);

            $user->roles()->attach(self::SUPER_ADMIN_ROLE);

            return response()->json(
                [
                    "success" => true,
                    "message" => "Role added successfully"
                ],
                200
            );
        } catch (\Exception $exception) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Imposible add role: " . $exception
                ]
            );
        }
    }

    public function deleteUserById($id)
    {
        try {
            User::query()->find($id)->delete();

            return response()->json(
                [
                    "success" => true,
                    "messagge" => "User created"
                ],
                200
            );
        } catch (\Exception $exception) {
            Log::error('Error deleting Exception user: ' . $exception->getMessage());

            return response()->json(
                [
                    "success" => true,
                    "messagge" => "Error deleting user"
                ],
                500
            );
        } catch (\Throwable $throwable) {
            Log::error('Error deleting Throwable user: ' . $throwable->getMessage());

            return response()->json(
                [
                    "success" => true,
                    "messagge" => "Error deleting user"
                ],
                500
            );
        }
    }
}
