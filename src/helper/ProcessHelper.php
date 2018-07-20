<?php
/**
 * Created by PhpStorm.
 * User: hayto
 * Date: 2018/7/1
 * Time: 21:09
 */

namespace Thsoft\helper;


class ProcessHelper
{
    /**
     * 当前是否是Mac系统
     * @return bool
     * @author too <hayto@foxmail.com>
     */
    public static function isMac():bool
    {
        return false !== stripos(PHP_OS, 'Darwin');
    }

    /**
     * 当前是否是cli环境
     * @return bool
     * @author too <hayto@foxmail.com>
     */
    public static function isCli():bool
    {
        return 'cli' === PHP_SAPI;
    }

    /**
     * 设置进程名
     * @param string $processTitle
     * @return bool
     * @author too <hayto@foxmail.com>
     */
    public static function setProcessTitle(string $processTitle):bool
    {
        if(false === self::isMac()){
            if(function_exists('cli_set_process_title')){
                return @cli_set_process_title($processTitle);
            }
        }
        return false;
    }

    /**
     * 获取进程名
     * @return null|string
     * @author too <hayto@foxmail.com>
     */
    public function getProcessTitle():?string
    {
        if(function_exists('cli_get_process_title')){
            return @cli_get_process_title();
        }
        return null;
    }
}