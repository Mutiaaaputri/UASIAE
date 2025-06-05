<?php

namespace App\Http\Controllers;

use App\Models\UserService;
use Illuminate\Http\Request;
use App\Http\Resources\UserServiceResource;
use Illuminate\Validation\ValidationException;

class UserServiceController extends Controller
{
    public function index()
    {
        return new UserServiceResource(UserService::all(), 'Success', 'List of users');
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:user_services',
                'password' => 'required|min:6',
                'role' => 'required|in:admin,user'
            ]);

            $data['password'] = bcrypt($data['password']);
            $user = UserService::create($data);

            return new UserServiceResource($user, 'Success', 'User created');
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Gagal membuat data, harap lengkapi semua field!',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Terjadi kesalahan internal pada server.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $user = UserService::find($id);

        if (!$user) {
            return response()->json([
                'status' => 'Error',
                'message' => 'User not found',
                'data' => null
            ], 404);
        }

        return new UserServiceResource($user, 'Success', 'User detail');
    }

    public function update(Request $request, $id)
    {
        $user = UserService::find($id);

        if (!$user) {
            return response()->json([
                'status' => 'Error',
                'message' => 'User not found',
                'data' => null
            ], 404);
        }

        $user->update($request->all());

        return new UserServiceResource($user, 'Success', 'User updated');
    }

    public function destroy($id)
    {
        $user = UserService::find($id);

        if (!$user) {
            return response()->json([
                'status' => 'Error',
                'message' => 'User not found',
                'data' => null
            ], 404);
        }

        $user->delete();

        return response()->json([
            'status' => 'Success',
            'message' => 'User deleted'
        ], 200);
    }

    public function getUser($id)
    {
        $user = UserService::find($id);

        if (!$user) {
            return response()->json([
                'status' => 'Error',
                'message' => 'User not found',
                'data' => null
            ], 404);
        }

        return new UserServiceResource($user, 'Success', 'User detail');
    }
}
