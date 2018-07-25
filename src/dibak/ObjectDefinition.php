<?php
/**
 * Created by PhpStorm.
 * User: too
 * Date: 2018/7/12
 * Time: 17:35
 * @author too <hayto@foxmail.com>
 */

namespace Thsoft\dibak;

/**
 * 对象定义类
 * Class ObjectDefinition
 * @package Thsoft\di
 * @author too <hayto@foxmail.com>
 */
class ObjectDefinition
{
    /**
     * 单例
     */
    const SINGLETON = 1;

    /**
     * 每次创建一个新实例
     */
    const PROTOTYPE = 2;

    /**
     * @var 实体名, 多数时候等于类名
     */
    public $name;

    /**
     * @var 类名
     */
    public $className;

    public $scope = self::SINGLETON;
}