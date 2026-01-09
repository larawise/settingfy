<?php

namespace Larawise\Settingfy\Drivers;

use Dotenv\Dotenv;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Encryption\Encrypter;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Env;
use RuntimeException;

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
class EnvDriver extends Driver
{
    /**
     * The filesystem implementation.
     *
     * @var Filesystem
     */
    protected $files;

    /**
     * Create a new env setting driver instance.
     *
     * @param Repository $config
     * @param Encrypter $encrypter
     * @param Dispatcher $events
     * @param Filesystem $files
     *
     * @return void
     */
    public function __construct($config, $encrypter, $events, $files)
    {
        parent::__construct($config, $encrypter, $events);

        $this->files = $files;
    }

    /**
     * Delete settings from storage that are not present in the given items.
     *
     * @param array $items
     *
     * @return void
     */
    protected function delete($items)
    {
        // ...
    }

    /**
     * Write settings to the underlying storage.
     *
     * @param array $items
     *
     * @return void
     */
    protected function write($items)
    {
        if ($this->files->missing($path = $this->environmentFilePath())) {
            throw new RuntimeException("The file [{$path}] does not exist.");
        }

        Env::writeVariables($items, $this->environmentFilePath(), true);
    }

    /**
     * Read settings from the underlying storage.
     *
     * @return array
     */
    protected function read()
    {
        return Dotenv::create(
            $this->environmentRepository(),
            $this->environmentPath(),
            $this->environmentFile()
        )->safeLoad();
    }

    /**
     * Get the current environment repository instance used by Laravel.
     *
     * @return \Dotenv\Repository\RepositoryInterface
     */
    protected function environmentRepository()
    {
        return Env::getRepository();
    }

    /**
     * Get the name of the environment file Laravel is using.
     *
     * @return string
     */
    protected function environmentFile()
    {
        return app()->environmentFile();
    }

    /**
     * Get the path to the environment file directory.
     *
     * @return string
     */
    protected function environmentFilePath()
    {
        return app()->environmentFilePath();
    }

    /**
     * Get the path to the environment file directory.
     *
     * @return string
     */
    protected function environmentPath()
    {
        return app()->environmentPath();
    }
}
