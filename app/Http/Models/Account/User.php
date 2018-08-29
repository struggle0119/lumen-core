<?php
/**
 * Author: guojinli
 * Date: 2018-05-07
 * Description: fucking what?
 */

namespace App\Http\Models\Account;


use App\Exceptions\RequestException;
use App\Helpers\ApiException;
use App\Http\Models\Model;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Model implements JWTSubject
{
    //用户名
    private $name;

    //密码
    private $password;

    /**
     * 构造函数
     */
    public function __construct() {

    }

    /**
     * 获取用户ID
     *
     * @param $name 用户名
     * @param $password 密码
     * @return mixed
     * @throws RequestException
     */
    public function getUserId() {
        $id = DB::table('user')
            ->where('name' , '=', $this->name)
            ->where('password', '=', $this->password)
            ->value('id');

        return $id;
    }

    /**
     * 实现 JWTSubject 需要的函数,用处是获取用户id
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        $userId = $this->getUserId();
        if (!is_numeric($userId)) {
            throw new RequestException(ApiException::CODE_ACCOUNT_LOGIN);
        }

        return $userId;
    }

    /**
     * 实现 JWTSubject 需要的函数,用处构造token时需要的构造选项，暂时无用
     *
     * @return mixed
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }
}