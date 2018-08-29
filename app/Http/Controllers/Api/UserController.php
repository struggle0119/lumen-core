<?php
/**
 * Author: guojinli
 * Date: 2018-05-08
 * Description: 用户操作控制器
 */

namespace App\Http\Controllers\Api;


use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Models\Account\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    /**
     * 登录，生成token
     *
     * @param Request $request
     * @return mixed
     */
    public function login(Request $request) {
        $user = new User();
        $user->setName($request->get('name'));
        $user->setPassword($request->get('password'));

        $token = JWTAuth::fromUser($user);

        return ApiResponse::respond($token);
    }

    /**
     * 手工刷新token，正常不需要，在中间件中会自动刷新
     * @return mixed
     */
    public function refreshToken() {
        //中间件中已经处理了，不存在token时的情况，所以此处不需要再做处理
        $oldToken = JWTAuth::getToken();
        JWTAuth::setToken($oldToken);
        //获取原token
        return ApiResponse::respond(['token' => JWTAuth::refresh()]);
    }

    /**
     * 退出登录
     */
    public function logout() {
        $oldToken = JWTAuth::getToken();
        JWTAuth::invalidate($oldToken);
        return ApiResponse::respond('退出成功');
    }
}