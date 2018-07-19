<?php
/**
 * Created by PhpStorm.
 * User: hayto
 * Date: 2018/7/16
 * Time: 22:11
 */

namespace Thsoft\exceptions;


class InvalidCallException extends \BadMethodCallException
{
    public function getName()
    {
        return "错误的调用";
    }
}