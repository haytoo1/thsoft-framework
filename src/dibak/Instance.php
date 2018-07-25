<?php
/**
 * Created by PhpStorm.
 * User: too
 * Date: 2018/7/12
 * Time: 14:37
 * @author too <hayto@foxmail.com>
 */

namespace Thsoft\dibak;


class Instance
{
    /**
     * @var 类名
     */
    public $className;

    public function __construct($className)
    {
        $this->className = $className;
    }

    public static function of($className)
    {
        return new self($className);
    }
}