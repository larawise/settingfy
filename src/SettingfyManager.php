<?php

namespace Larawise\Settingfy;

use Larawise\Settingfy\Drivers\DatabaseDriver;
use Larawise\Settingfy\Drivers\EnvDriver;
use Larawise\Settingfy\Drivers\NativeDriver;
use Larawise\Settingfy\Drivers\RedisDriver;
use Larawise\Support\Manager;

/**
 * Srylius - The ultimate symphony for technology architecture!
 *
 * @package     Larawise
 * @subpackage  Settingfy
 * @version     v1.0.0
 * @author      Selçuk Çukur <hk@selcukcukur.com.tr>
 * @copyright   Srylius Teknoloji Limited Şirketi
 *
 * @see https://docs.larawise.com/ Larawise : Docs
 */
class SettingfyManager extends Manager
{
    /**
     * Create an instance of the database setting driver.
     *
     * @return DatabaseDriver
     */
    protected function createDatabaseDriver()
    {
        // Instantiate and return the settingfy service with a database store backend
        return new DatabaseDriver(
            config: $this->config,
            db: $this->container->make('db'),
            encrypter: $this->container->make('encrypter'),
            events: $this->container->make('events'),
        );
    }

    /**
     * Create an instance of the env setting driver.
     *
     * @return EnvDriver
     */
    protected function createEnvDriver()
    {
        // Instantiate and return the settingfy service with a database store backend
        return new EnvDriver(
            config: $this->config,
            encrypter: $this->container->make('encrypter'),
            events: $this->container->make('events'),
            files: $this->container->make('files')
        );
    }

    /**
     * Create an instance of the native setting driver.
     *
     * @return NativeDriver
     */
    protected function createNativeDriver()
    {
        // Instantiate and return the settingfy service with a database store backend
        return new NativeDriver(
            config: $this->config,
            encrypter: $this->container->make('encrypter'),
            events: $this->container->make('events'),
            files: $this->container->make('files')
        );
    }

    /**
     * Create an instance of the redis setting driver.
     *
     * @return RedisDriver
     */
    protected function createRedisDriver()
    {
        // Instantiate and return the settingfy service with a database store backend
        return new RedisDriver(
            config: $this->config,
            encrypter: $this->container->make('encrypter'),
            events: $this->container->make('events'),
            redis: $this->container->make('redis'),
        );
    }

    /**
     * Get the default driver name.
     *
     * @return string|null
     */
    public function getDefaultDriver()
    {
        return $this->config->get('settingfy.driver');
    }

    /**
     * Set the default driver name.
     *
     * @param string $name
     *
     * @return void
     */
    public function setDefaultDriver($name)
    {
        $this->config->set('settingfy.driver', $name);
    }
}
