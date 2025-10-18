<?php

namespace Larawise\Settingfy\Drivers;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Encryption\Encrypter;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Filesystem\Filesystem;

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
class NativeDriver extends Driver
{
    /**
     * The filesystem implementation.
     *
     * @var Filesystem
     */
    protected $files;

    /**
     * Create a new native setting driver instance.
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
        // ...
    }

    /**
     * Read settings from the underlying storage.
     *
     * @return array
     */
    protected function read()
    {
        // ...
    }
}
