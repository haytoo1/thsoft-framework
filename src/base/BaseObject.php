<?php
/**
 * Created by PhpStorm.
 * User: Hong Tu <hayto@foxmail.com>
 * Date: 2018/7/1
 * Time: 22:01
 */

namespace Thsoft\base;

use Thsoft\exceptions\InvalidCallException;
use Thsoft\exceptions\UnknownPropertyException;

/**
 * 框架基础类
 * Class BaseObject
 * @package Thsoft\base
 * @author Hong Tu <hayto@foxmail.com>
 */
class BaseObject
{
    /**
     * BaseObject constructor.
     * @param array $config
     */
    public function __construct(array $config=[])
    {
        foreach ($config as $_key=>$_value){
            $this->$_key = $_value;
        }
        $this->init();
    }

    /**
     * 创建实例后的初始化逻辑
     * @author Hong Tu <hayto@foxmail.com>
     */
    public function init()
    {

    }

    /**
     * 读取一个不可访问的属性时被调用
     * @param $name
     * @return mixed
     * @throws UnknownPropertyException
     * @author Hong Tu <hayto@foxmail.com>
     */
    public function __get($name)
    {
        $getter = "get{$name}";
        if(method_exists($this, $getter)){
            return $this->$getter;
        }
        $setter = "set{$name}";
        if(method_exists($this, $setter)){
            throw new InvalidCallException("属性". static::class. "::{$name}是只写的");
        }
        throw new UnknownPropertyException("未知的属性:".static::class ."::{$name}");
    }

    /**
     * 给不可访问的属性赋值时被调用
     * @param $name
     * @param $value
     * @return mixed
     * @throws UnknownPropertyException
     * @author Hong Tu <hayto@foxmail.com>
     */
    public function __set($name, $value)
    {
        $setter = "set{$name}";
        if(method_exists($this, $setter)){
            return $this->$setter($value);
        }
        $getter = "get{$name}";
        if(method_exists($this, $getter)){
            throw new InvalidCallException("属性".static::class ."::{$name}是只读的");
        }
        throw new UnknownPropertyException("未知的属性:".static::class ."::{$name}");
    }

    /**
     * 对不可访问的属性使用isset()函数时被调用
     * @param $name
     * @return bool
     * @author Hong Tu <hayto@foxmail.com>
     */
    public function __isset($name)
    {
        $getter = "get{$name}";
        if (method_exists($this, $getter)) {
            return null !== $this->$getter();
        }
        return false;
    }

    /**
     * 对不可访问的属性使用unset()函数时被调用
     * @param $name
     * @return mixed
     * @throws UnknownPropertyException
     * @author Hong Tu <hayto@foxmail.com>
     */
    public function __unset($name)
    {
        $setter = "set{$name}";
        if (method_exists($this, $setter)) {
            return $this->$setter(null);
        }

        $getter = "get{$name}";
        if(method_exists($this, $getter)){
            throw new InvalidCallException("unset只读的属性:". static::class."::{$name}");
        }
        throw new UnknownPropertyException("未知的属性:". static::class. "::{$name}");
    }

    /**
     * echo $obj时被调用
     * @return string
     * @author Hong Tu <hayto@foxmail.com>
     */
    public function __toString()
    {
        return static::class;
    }


    /**
     * 判断属性能否被读取
     * @param $name
     * @param bool $checkVars
     * @return bool
     * @author Hong Tu <hayto@foxmail.com>
     */
    public function canGetProperty($name, $checkVars = true)
    {
        return method_exists($this, "get{$name}") || $checkVars && property_exists($this, $name);
    }

    /**
     * 判断属性能否被赋值
     * @param $name
     * @param bool $checkVars
     * @return bool
     * @author Hong Tu <hayto@foxmail.com>
     */
    public function canSetProperty($name, $checkVars = true)
    {
        return method_exists($this, "set{$name}") || $checkVars && property_exists($this, $name);
    }

    /**
     * 判断对象是否存在某个属性
     * @param $name
     * @param bool $checkVars
     * @return bool
     * @author Hong Tu <hayto@foxmail.com>
     */
    public function hasProperty($name, $checkVars = true)
    {
        return $this->canGetProperty($name, $checkVars) || $this->canSetProperty($name, false);
    }

    /**
     * 判断对象是否存在某个方法
     * @param $name
     * @return bool
     * @author Hong Tu <hayto@foxmail.com>
     */
    public function hasMethod($name)
    {
        return method_exists($this, $name);
    }
}