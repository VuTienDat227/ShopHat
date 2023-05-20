<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\UserLogin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Carbon;

class UserLoginController extends Controller
{
    //
    public function generateToken($user)
    {
        try {
            $token = JWTAuth::fromUser($user);
            return $token;
        } catch (JWTException $e) {
            return null;
        }
    }
    public function getAllUsers()
    {
        try {
            $today = Carbon::now()->toDateString();
            $users = UserLogin::whereDate('created_at', $today)
                ->where('RoleId', 1)
                ->get();
            $userCount = $users->count();
            $yesterday = Carbon::yesterday()->toDateString();

            $usersLast = UserLogin::whereDate('created_at', $yesterday)
                ->where('RoleId', 1)
                ->get();
            $last = $usersLast->count();

            $totalUser = $userCount - $last;
            return response()->json(['userCount' => $userCount,'changeCount' => $totalUser], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function GetByIdName()
    {
        try {
            $token = JWTAuth::getToken();

            if (!$token) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            $user = JWTAuth::parseToken()->authenticate();

            if (!$user) {
                return response()->json(['error' => 'Không tìm thấy user'], 404);
            }

            $userName = $user->UserName;

            return response()->json(['userName' => $userName], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function GetAllIdName($id)
    {
        $user = UserLogin::find($id);
        if (!$user) {
            return response()->json(['error' => 'Không tìm thấy user'], 404);
        }
        $userData = [
            'FullName' => $user->FullName,
            'PhoneNumber' => $user->PhoneNumber,
            'Address' => $user->Address,
        ];
        return response()->json(['data' => $userData], 200);
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'UserName' => 'required',
            'PasswordUser' => 'required',
        ]);

        $user = UserLogin::where('UserName', $credentials['UserName'])->first();

        if ($user && Hash::check($credentials['PasswordUser'], $user->PasswordUser)) {
            $roleId = $user->RoleId;

            if ($roleId == 1 || $roleId == 2) {
                $token = $this->generateToken($user);
                $idUser = $user->id;
                return response()->json(['message' => 'Thành công', 'token' => $token, 'Id' => $idUser, 'RoleId' => $roleId], 200);
            } else {
                return response()->json(['error' => 'Lỗi'], 401);
            }
        } else {
            return response()->json(['error' => 'Phát sinh lỗi'], 401);
        }
    }

    public function logout(Request $request)
    {
        // Xóa thông tin đăng nhập đã lưu trữ trong session
        if ($request->session()->has('id')) {
            // Xóa thông tin đăng nhập đã lưu trữ trong session
            $request->session()->forget('id');
            return response()->json(['message' => 'Thành công'], 200);
        }

        return response()->json(['message' => 'Đã đăng nhập'], 200);
    }


    public function register(Request $request)
    {
        try {
            $credentials = $request->validate($this->registerRules());

            $hashedPassword = Hash::make($credentials['PasswordUser']);

            $userData = UserLogin::create([
                'UserName' => $credentials['UserName'],
                'PasswordUser' => $hashedPassword,
                'FullName' => $request->input('FullName'),
                'PhoneNumber' => $request->input('PhoneNumber'),
                'Address' => $request->input('Address'),
                'RoleId' => 1,
            ]);
            if (!$userData->wasRecentlyCreated) {
                // Người dùng đã tồn tại, trả về lỗi tương ứng
                return response()->json(['error' => 'Đã có user'], 409);
            }
            $token = $this->generateToken($userData);

            return response()->json(['user' => $userData, 'token' => $token], 201);

        } catch (QueryException $e) {
            // Xử lý lỗi nếu có

            return response()->json(['error' => 'Xảy ra lỗi'], 400);
        }
    }
    public function checkLogin(Request $request)
    {
        try {
            $token = $request->header('Authorization');

            if (!$token) {
                return response()->json(['isLoggedIn' => false], 200);
            }

            $user = JWTAuth::parseToken()->authenticate();

            if (!$user) {
                return response()->json(['isLoggedIn' => false], 200);
            }

            return response()->json(['isLoggedIn' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['isLoggedIn' => false], 200);
        }
    }
    protected function registerRules()
    {
        return [
            'UserName' => 'required|unique:UserLogin',
            'PasswordUser' => 'required|min:6',
            'FullName' => 'nullable',
            'PhoneNumber' => 'nullable',
            'Address' => 'nullable',
            'RoleId' => 'nullable',
        ];
    }
}
