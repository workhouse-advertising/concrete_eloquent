<?php

namespace Concrete\Package\ConcreteEloquent;

defined('C5_EXECUTE') or die(_("Access Denied."));

use Config;
use Concrete\Core\Package\Package;
use Illuminate\Database\Capsule\Manager as CapsuleManager;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;

class Controller extends Package
{
    protected $pkgHandle = 'concrete_eloquent';
    protected $appVersionRequired = '5.7.1';
    protected $pkgVersion = '1.0.0';

    public function getPackageDescription()
    {
        return t('Enables Laravel Eloquent ORM in Concrete5');
    }

    public function getPackageName()
    {
        return t('Eloquent ORM');
    }

    protected function bootEloquent()
    {
        $capsuleManager = new CapsuleManager();
        // Add DB connection
        //// TODO: Check default connection (driver type, etc...) and allow the ability to specify alternative connections
        $capsuleManager->addConnection(array(
            'driver' => 'mysql',
            'host' => Config::get('database.connections.concrete.server'),
            'database' => Config::get('database.connections.concrete.database'),
            'username' => Config::get('database.connections.concrete.username'),
            'password' => Config::get('database.connections.concrete.password'),
            'charset' => Config::get('database.connections.concrete.charset'),
            'prefix' => ''
        ));
        $capsuleManager->setEventDispatcher(new Dispatcher(new Container));
        $capsuleManager->bootEloquent();
    }

    public function on_start()
    {
        $this->bootEloquent();
    }

    public function install()
    {
        parent::install();
    }

    public function upgrade()
    {
        parent::upgrade();
    }
}

