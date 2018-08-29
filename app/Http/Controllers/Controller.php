<?php

namespace App\Http\Controllers;

use App\Exceptions\RequestException;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use Tymon\JWTAuth\JWTAuth;

class Controller extends BaseController
{
    /**
     * 授权方式
     * @var
     */
    protected $jwt;

    /**
     * 统一定制返回值
     */
    use ApiResponse;

    public function __construct(Request $request, JWTAuth $jwt)
    {
        $this->jwt = $jwt;
        $this->validateRequest($request);
    }

    /**
     * 覆盖父类方法，在此统一定义返回信息，不需要走框架定义的异常信息
     * @param Request $request
     * @param \Illuminate\Contracts\Validation\Validator $validator
     */
    protected function throwValidationException(Request $request, $validator)
    {
        $result  = [];
        //错误格式化输出
        $errors = $this->formatValidationErrors($validator);
        if (!empty($errors)) {
            //一个字段可能会有多个信息提示
            foreach ($errors as $field => $messages) {
                $result = array_merge($result, $messages);
            }
        }
        throw new RequestException($result[0]);
    }

    /**
     * 表单验证
     * @param Request $request
     * @param null $name
     */
    protected function validateRequest(Request $request, $name = null)
    {
        if (! $validator = $this->getValidator($request, $name)) {
            return;
        }

        $rules    = array_get($validator, 'rules', []);
        $messages = array_get($validator, 'messages', []);
        $this->validate($request, $rules, $messages);
    }

    /**
     * 获取验证类规则
     * @param Request $request
     * @param null $name
     * @return bool|mixed
     */
    protected function getValidator(Request $request, $name = null)
    {
        list($controller, $method) = explode('@', $request->route()[1]['uses']);

        $method = $name ?: $method;

        $class = str_replace('Controller', 'Validation', $controller);
        if (! class_exists($class) || ! method_exists($class, $method)) {
            return false;
        }
        return call_user_func([new $class, $method]);
    }
}
