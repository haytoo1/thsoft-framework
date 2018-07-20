<?php
/**
 * Created by PhpStorm.
 * User: too
 * Date: 2018/7/20
 * Time: 16:06
 * @author too <hayto@foxmail.com>
 */

namespace Thsoft\base;


use Thsoft\exceptions\InvalidConfigException;
use Thsoft\Thsoft;

class ServiceLocator extends Component
{
    /**
     * 存储组件对象: key是主键名, value是具体组件对象
     * @var array 
     */
    private $_components = [];

    /**
     * 存储组件定义: key是主键名, value是创建组件对象所需要的数据
     * @var array
     */
    private $_definitions = [];

    /**
     * @param string $id 组件名
     * @param array $definition 创建组件对象所需要的数据
     * @author too <hayto@foxmail.com>
     */
    public function set(string $id, array $definition):void
    {
        unset($this->_components[$id]);
        if ($definition === null) {
            unset($this->_definitions[$id]);
            return;
        }
        if(false === is_array($definition)){
            throw new InvalidConfigException("组件{$id}的配置参数必须是数组, 当前是". gettype($definition) );
        }
        if(false === isset($definition['class'])){
            throw new InvalidConfigException("组件{$id}的配置参数必须包含\"class\"字段");
        }
        $this->_definitions[$id] = $definition;
    }

    public function setComponents(array $components):void
    {
        foreach ($components as $id => $component) {
            $this->set($id, $component);
        }
    }

    /**
     * 是否存在组件
     * @param $id
     * @return bool
     * @author too <hayto@foxmail.com>
     */
    public function has(string $id):bool
    {
        return isset($this->_components[$id]) || isset($this->_definitions[$id]);
    }

    public function __get(string $id)
    {
        if($this->has($id)){
            return $this->get($id);
        }
        return null;
    }

    /**
     * 获取组件对象
     * @param string $id
     * @return object
     * @author too <hayto@foxmail.com>
     */
    public function get(string $id):object
    {
        if(isset($this->_components[$id])){
            return $this->_components[$id];
        }
        if(isset($this->_definitions[$id])){
            $definition = $this->_definitions[$id];
            $this->_components[$id] = Thsoft::createObject($definition);
            return $this->_components[$id];
        }
    }

    /**
     * 获取所有组件
     * @param bool $returnDefinitions
     * @return array
     * @author too <hayto@foxmail.com>
     */
    public function getComponents($returnDefinitions = true)
    {
        return $returnDefinitions ? $this->_definitions : $this->_components;
    }
}