<?php

namespace App\Http\Controllers;

use App\Helpers\APIFormatter;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $input = $request->validate([
                'username' => 'required|unique:users,username',
                'email' => 'required|unique:users,email',
                'password' => 'required|confirmed'
            ]);

            $admin_access = User::create([
                'username' => $input['username'],
                'email' => $input['email'],
                'password' => Hash::make($input['password'])
            ]);

            $token = $admin_access->createToken('myapptoken')->plainTextToken;

            $token_response = [
                'token' => $token
            ];

            $data = User::where('id', '=', $admin_access->id)->get();

            if ($data) {
                return APIFormatter::createAPI(200, 'Success', [$data, $token_response]);
            } else {
                return APIFormatter::createAPI(400, 'Failed');
            }
        } catch (Exception $error) {
            return APIFormatter::createAPI(400, 'Failed', $error);
        }
    }

    public function sendVerification(Request $request)
    {
        if ($request->user()->hasVerification) {
        }
    }

    public function login(Request $request)
    {
        try {
            $input = $request->validate([
                'email' => 'required',
                'password' => 'required',
            ]);

            // Check
            $admin_access = User::where('email', $input['email'])->first();
            if (!($admin_access) || !(Hash::check($input['password'], $admin_access->password))) {
                return APIFormatter::createAPI(400, 'Failed');
            }

            $data = $admin_access;
            $token = $admin_access->createToken('myapptoken')->plainTextToken;
            $token_response = [
                'token' => $token
            ];

            return APIFormatter::createAPI(200, 'Success', [$data, $token_response]);
        } catch (Exception $error) {
            return APIFormatter::createAPI(400, 'Error', $error);
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();
            return APIFormatter::createAPI(200, 'Success', 'Logged Out');
        } catch (Exception $error) {
            return APIFormatter::createAPI(400, 'Failed', $error);
        }
    }
}
