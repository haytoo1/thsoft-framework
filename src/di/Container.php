<?php
/**
 * Created by PhpStorm.
 * User: Hong Tu <hayto@foxmail.com>
 * Date: 2018/7/25
 * Time: 21:22
 */
namespace Thsoft\di;

use Ds\Map;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Thsoft\base\BaseObject;

class Container extends BaseObject implements ContainerInterface
{
    /**
     * 存储单例对象
     * @var array
     * @author Hong Tu <hayto@foxmail.com>
     */
    protected $_singleton = [];

    /**
     * 存储 对象定义), key是对象别名,类名, 接口
     * @var array
     * @author Hong Tu <hayto@foxmail.com>
     */
    protected $_definitions = [];

    public function init()
    {
        parent::init();
    }

    public function get($id)
    {
        // 存在单例, 直接返回
        if(isset($this->_singleton[$id])){
            return $this->_singleton[$id];
        }
        // 定义里没有, 说明是新来的对象
        if(!isset($this->_definitions[$id])){
            return $this->build($id);
        }
        
        $definitions = $this->_definitions[$id];
        
        $className = $definitions['class'];
        unset($definitions['class']);
    }

    private function build($id)
    {

    }

    public function has($id)
    {
        return $this->_singleton->hasKey($id) || $this->_definitions->hasKey($id);
    }
    
    
    
    public function make(string $className)
    {
        // 保存类的依赖(即构造方法参数) 
        $dependencies = [];

        $reflectionObj = new \ReflectionClass($className);
        $constructor = $reflectionObj->getConstructor();
        // 有构造方法
        if(null !== $constructor){
            // $parameter对象 表示构造方法的每个参数
            foreach ($constructor->getParameters() as $parameter){
                // 有默认值的参数
                if($parameter->isDefaultValueAvailable()){
                    $dependencies[] = $parameter->getDefaultValue();
                }else{
                    /**
                     * @var \ReflectionClass $class
                     */
                    $class = $parameter->getClass();
                    if(null !== $class){
                        $dependencies[] = $class->getName();
                    }else{

                    }
                }
            }
        }
//        var_dump($dependencies);
        die;
    }
    
}