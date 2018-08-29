<?php

namespace App\Http\Middleware;

use App\Exceptions\RequestException;
use App\Helpers\ApiException;
use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class Authenticate extends BaseMiddleware
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        try {
            //验证token是否存在
            if (!$this->auth->parser()->setRequest($request)->hasToken()) {
                throw new RequestException(ApiException::CODE_ACCOUNT_TOKEN_MISSING);
            }
            //设置值,同时会验证token是否有效,无效会抛出 AuthenticationException 异常
            $this->auth->guard($guard)->authenticate();
        } catch (AuthenticationException $exception) {
            try {
                //过期之后需要重新设置
                $token = $this->auth->guard($guard)->refresh();
                Log::info("刷新的一次token" . $token);
                //设置header中的 Authorization 属性 值为 'Bearer '.$token
                return $this->setAuthenticationHeader($next($request), $token);
            } catch (TokenBlacklistedException $e) {
                throw new RequestException(ApiException::CODE_ACCOUNT_TOKEN_DISABLED);
            } catch (TokenInvalidException $e) {
                throw new RequestException(ApiException::CODE_ACCOUNT_TOKEN_INVALID);
            } catch (JWTException $e) {
                throw new RequestException(ApiException::CODE_ACCOUNT_TOKEN_INVALID);
            }
        }

        return $next($request);
    }
}
