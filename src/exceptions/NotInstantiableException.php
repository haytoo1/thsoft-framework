<?php
/**
 * Created by PhpStorm.
 * User: too
 * Date: 2018/7/20
 * Time: 17:17
 * @author too <hayto@foxmail.com>
 */

namespace Thsoft\exceptions;


class NotInstantiableException
{
    public function getName()
    {
        return "没有可实例化的子类";
    }
}