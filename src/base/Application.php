<?php
/**
 * Created by PhpStorm.
 * User: too
 * Date: 2018/7/20
 * Time: 14:30
 * @author too <hayto@foxmail.com>
 */

namespace Thsoft\base;
use Swoole\Http\Server;
use Thsoft;

/**
 * Class Application
 * @property $server
 * @package Thsoft\base
 * @author too <hayto@foxmail.com>
 */
class Application extends ServiceLocator
{
    public $host = null;
    public $port = null;

    public function setServer($server)
    {
        foreach ($server as $key=>$value){
            $this->$key = $value;
        }
    }
    public function getServer()
    {
    }





    public function init()
    {
        parent::init();
        Thsoft\Thsoft::$app = $this;
        Thsoft\Thsoft::$container = new Thsoft\di\Container();
        Thsoft\Thsoft::$server = new Server($this->host, $this->port);
    }

    public function run()
    {
//        Thsoft\Thsoft::$server->start();
    }
}