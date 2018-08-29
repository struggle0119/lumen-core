<?php
/**
 * Author: guojinli
 * Date: 2018-05-09
 * Description: fucking what?
 */

namespace App\Http\Controllers\Wechat;


use Illuminate\Support\Facades\Log;
use Overtrue\LaravelWeChat\Controllers\Controller;

class TestController extends Controller
{
    /**
     * 接收微信小程序推过来的消息
     * @return mixed
     */
    public function serve() {
        Log::info("微信消息接收开始");

        //获取微信小程序应用实例
        $app = app('wechat.mini_program');

        //EasyWeChat\Kernel\ServerGuard 返回实例
        $server = $app->server;

        //将信息返回给微信小程序
        return $server->serve();
    }
}