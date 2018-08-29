<?php
/**
 * Author: guojinli
 * Date: 2018-04-28
 * Description: 异常码统一处理
 */

namespace App\Helpers;


class ApiException
{
    /**
     * 引入响应实体
     */
    use ApiResponse;

    //正常值
    public const CODE_SUCCESS = '200';
    //需要展示的异常code前缀
    public const CODE_PREFIX = '9';
    #------------------------------系统异常开始-------------------------------------------
    public const CODE_SYSTEM = '100';
    public const CODE_SYSTEM_UNKNOWN = self::CODE_PREFIX.self::CODE_SYSTEM.'100';
    #------------------------------系统异常结束-------------------------------------------

    #------------------------------用户模块开始-------------------------------------------
    public const CODE_ACCOUNT = '200';
    public const CODE_ACCOUNT_LOGIN = self::CODE_PREFIX.self::CODE_ACCOUNT.'100';
    public const CODE_ACCOUNT_AUTHORIZATION= self::CODE_PREFIX.self::CODE_ACCOUNT.'101';
    public const CODE_ACCOUNT_TOKEN_MISSING= self::CODE_PREFIX.self::CODE_ACCOUNT.'102';
    public const CODE_ACCOUNT_TOKEN_DISABLED= self::CODE_PREFIX.self::CODE_ACCOUNT.'103';
    public const CODE_ACCOUNT_TOKEN_INVALID=self::CODE_PREFIX.self::CODE_ACCOUNT.'104';
    public const CODE_ACCOUNT_TOKEN_FAILED=self::CODE_PREFIX.self::CODE_ACCOUNT.'105';
    #------------------------------用户模块结束-------------------------------------------

    /**
     * @var array 错误提示
     */
    public static $message = [
        self::CODE_SYSTEM_UNKNOWN => '系统错误',
        self::CODE_ACCOUNT_LOGIN => '登录失败',
        self::CODE_ACCOUNT_AUTHORIZATION => '用户未授权',
        self::CODE_ACCOUNT_TOKEN_MISSING => '授权码不存在',
        self::CODE_ACCOUNT_TOKEN_DISABLED => '授权码不可用',
        self::CODE_ACCOUNT_TOKEN_INVALID => '无效的授权码',
        self::CODE_ACCOUNT_TOKEN_FAILED => '授权失败',
    ];

    /**
     * 异常统一返回
     * @param $code 异常码
     * @param $trace 错误详细信息
     */
    public static function show($code, array $trace) {
        if (array_key_exists($code, self::$message)) {
            $json = [
                'code' => $code,
                'msg' => self::$message[$code],
                'trace' => $trace,
            ];
        } else {
            $json = [
                'code' => self::CODE_SYSTEM_UNKNOWN,
                'msg' => self::$message[self::CODE_SYSTEM_UNKNOWN],
                'trace' => $trace,
            ];
        }
        return ApiResponse::respond($json);
    }

}