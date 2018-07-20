<?php
/**
 * Created by PhpStorm.
 * User: too
 * Date: 2018/7/20
 * Time: 16:19
 * @author too <hayto@foxmail.com>
 */

namespace Thsoft\exceptions;


class InvalidConfigException extends \Exception
{
    public function getName()
    {
        return "错误的配置";
    }
}