<?php
/**
 * Created by PhpStorm.
 * User: too
 * Date: 2018/7/20
 * Time: 14:28
 * @author too <hayto@foxmail.com>
 */

namespace Thsoft;
use Swoole\Http\Server;
use Thsoft\di\Container;

class Thsoft
{
    public static $app = null;

    /**
     * @var Server
     */
    public static $server = null;

    /**
     * @var Container
     */
    public static $container;

    /**
     * 创建对象
     * @param array $definition 创建对象所需要的数据, 包含class名和创建对象后的初始化配置
     * @param array $constructConfig 对象构造参数
     * @return object
     * @author too <hayto@foxmail.com>
     */
    public static function createObject(array $definition, array $constructConfig=[]):object
    {
        $class = $definition['class'];
        unset($definition['class']);
        return Thsoft::$container->get($class, $constructConfig, $definition);
    }
}