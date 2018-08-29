# 开发需要了解的基础

## 注意事项
根目录下的config会覆盖lumen-framework/config下的同名文件

## 配置文件的使用
所有的配置信息都需要在.env文件中体现，使用前需要在 bootstrap/app.php 注册相应的配置文件,获取时层级结构用 . 分隔
Config::get('redis.test.host');

## 日志的使用方法
使用前需要在 bootstrap/app.php, 开启门面模式$app->withFacades();,牺牲点性能换来少一层的封装
引用 Illuminate\Support\Facades\Log, 如:Log::info('test');

## 异常处理
throw new BusinessException(ApiException::CODE_SYSTEM_UNKNOWN); 具体的异常码需要自行按规则制定

## 数据库读写分离
详细查看 config/database.php 中的配置信息
