<?php
/**
 * Created by PhpStorm.
 * User: Hong Tu <hayto@foxmail.com>
 * Date: 2018/7/19
 * Time: 23:22
 */

namespace Thsoft\di;

class Container
{
    /**
     * @var array 保存单例对象
     * @author Hong Tu <hayto@foxmail.com>
     */
    public static  $_singleton = [];

    /**
     * @var array 保存对象定义
     * @author Hong Tu <hayto@foxmail.com>
     */
    public static $_definitions = [];

    /**
     * @var array 存储class的反射对象, className是索引
     * @author Hong Tu <hayto@foxmail.com>
     */
    private static $_reflections = [];

    /**
     * @var array 存储class的依赖
     * @author Hong Tu <hayto@foxmail.com>
     */
    private static $_dependencies = [];
}