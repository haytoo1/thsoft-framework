<?php
/**
 * Created by PhpStorm.
 * User: hayto
 * Date: 2018/7/16
 * Time: 22:06
 */

namespace Thsoft\exceptions;

class UnknownPropertyException extends \Exception
{
    public function getName()
    {
        return "未知的属性";
    }
}