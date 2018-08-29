<?php
/**
 * Author: guojinli
 * Date: 2018-04-28
 * Description: test
 */

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Models\Account\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

class TestController extends Controller {
    /**
     * 测试返回数据方法
     */
    public function test(Request $request) {
//        Cache::put('username123', '122221', 10);
//        Cache::get('username123');
        $this->validateRequest($request);

        return ApiResponse::respond('123');
    }

    public function login(Request $request) {
        $user = new User($request);
        $token = JWTAuth::fromUser($user);

        //$token = $this->jwt->attempt($request->only('name', 'password'));
        return ApiResponse::respond($token);
    }
}