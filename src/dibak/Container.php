<?php
/**
 * Created by PhpStorm.
 * User: Hong Tu <hayto@foxmail.com>
 * Date: 2018/7/19
 * Time: 23:22
 */

namespace Thsoft\dibak;

/**
 * 来一发IOC容器
 * Class Container
 * @package Thsoft\di
 * @author too <hayto@foxmail.com>
 */
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

    public function get(string $className, $constructConfig=[], $params=[])
    {
        if(isset(self::$_singleton[$className])){
            return self::$_singleton[$className];
        }
        if(!isset(self::$_definitions[$className])){
            $obj = $this->buildObject($className, $constructConfig, $params);
            return $obj;
        }
    }

    public function buildObject(string $className, array $constructConfig=[], array $config=[])
    {
        echo "走了build\r\n";
        /**
         * @var  $reflection \ReflectionClass
         */
        list ($reflection, $dependencies) = $this->getDependencies($className);
        /* 填充构造参数 */
        foreach ($constructConfig as $index => $param) {
            $dependencies[$index] = $param;
        }
        $dependencies = $this->resolveDependencies($dependencies, $reflection);
        if (!$reflection->isInstantiable()) {
            throw new NotInstantiableException($reflection->name);
        }
        $object = $reflection->newInstanceArgs($dependencies);
        if (!empty($config)) {
            foreach ($config as $name=>$value){
                $object->$name = $value;
            }
        }
        return $object;
    }

    /**
     * 获取class创建对象所需要的依赖
     * @param string $className 类名
     * @return array
     * @throws \ReflectionException
     * @author too <hayto@foxmail.com>
     */
    public function getDependencies(string $className)
    {
        echo "走了获取依赖\r\n";
        // 已经缓存了, 就直接用
        if (isset(self::$_reflections[$className])) {
            return [self::$_reflections[$className], self::$_dependencies[$className]];
        }

        $dependencies = [];
        $reflection = new \ReflectionClass($className);
        $contructors = $reflection->getConstructor();
        if(null !== $contructors){
            $params = $contructors->getParameters();
            foreach ($params as $_param){
                // 构造函数有默认值, 就直接用
                if($_param->isDefaultValueAvailable()){
                    $dependencies[] = $_param->getDefaultValue();
                }else{
                    /**
                     * 获取参数类型 如下
                     *      变量$s获取到就是Son类
                     *      变量$age获取到就是null
                     * public function __construct($name='defaultName', $age, Son $s)
                     */
                    $_className = $_param->getClass();
                    $_name = $_className;
                    if(null !== $_className){
                        $_name = $_className->getName();
                    }
                    $dependencies[] = Instance::of($_name);
                }
            }
        }
        // 反射对象和依赖信息都缓存起来
        self::$_reflections[$className] = $reflection;
        self::$_dependencies[$className] = $dependencies;

        return [$reflection, $dependencies];
    }

    public function resolveDependencies($dependencies, \ReflectionClass $reflection= null)
    {
        echo "走了解析依赖\r\n";
        foreach ($dependencies as $index=>$dependency){

            if($dependency instanceof Instance){
                /**
                 * @var \ReflectionClass $dependency
                 */
                if($dependency instanceof \ReflectionClass){
                    var_dump($dependency->isInterface());
                }

                /*if($dependency->className !== null){
                    $dependencies[$index] = $this->get($dependency->className);
                    continue;
                }
                // 此时$dependency->className === null 表示缺少构造参数, 应该抛出错误了
                if(null !== $reflection){
                    $class = $reflection->getName();// 出错的类名
                    $paramName = $reflection->getConstructor()->getParameters()[$index]->getName(); // 缺少的参数名
                    throw new InvalidConfigException("实例化类{$class}时缺少{$paramName}构造参数");
                }*/
            }
        }
        die;
        return $dependencies;
    }
}