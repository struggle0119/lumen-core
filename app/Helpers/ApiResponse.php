<?php
/**
 * Author: guojinli
 * Date: 2018-04-27
 * Description: 统一返回值，统一处理
 */

namespace App\Helpers;

trait ApiResponse
{
    /**
     * @param array|string $data 返回信息的主体，数组或者是字符串
     * @param int $status http code
     * @param array $headers 头信息
     * @param int $options 返回数据格式的附加配置信息
     * @param string $type 返回值类型
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public static function respond($data = []
        , $status = 200
        , $headers = []
        , $options = 0
        , $type = 'json'
    ) {
        $msg = [
            'body' => $data,
            'code' => $status,
            'headers' => $headers,
        ];
        if (strcmp('json', $type) === 0) {
            return response()->json($msg, $status, $headers, $options);
        }
        return response('目前仅支持json格式!');
    }
}