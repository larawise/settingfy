<?php

namespace Larawise\Settingfy\Drivers;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Encryption\Encrypter;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Redis\Factory;
use Larawise\Support\Traits\Connectable;

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
class RedisDriver extends Driver
{
    use Connectable;

    /**
     * Create a new database setting driver instance.
     *
     * @param Repository $config
     * @param Encrypter $encrypter
     * @param Dispatcher $events
     * @param Factory $redis
     *
     * @return void
     */
    public function __construct($config, $encrypter, $events, $redis)
    {
        parent::__construct($config, $encrypter, $events);

        $this->setRedisFactory($redis);
        $this->setConnectionName($this->config('settingfy.connection'));
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
        // Determine which keys were deleted compared to previous state
        $changes = $this->audit($items);

        // Remove each deleted key from Redis
        foreach ($changes['deleted'] as $key) {
            $this->redis()->del("settingfy:{$key}");
        }
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
        // Detect changes between current and incoming settings
        $changes = $this->audit($items);

        // Process both newly added and updated keys
        foreach (['added', 'updated'] as $type) {
            foreach ($changes[$type] as $key) {
                // Split dot-notation key into group and name
                [$group, $name] = explode('.', $key);

                // Encrypt value if required
                $value = $this->performEncrypt($key, $items[$group][$name]);

                // Store value in Redis using serialized format
                $this->redis()->set("settingfy:{$key}", serialize($value));
            }

            // Dispatch appropriate event for added or updated keys
            if (! empty($changes[$type])) {
                $type === 'added'
                    ? $this->fireCreatedEvent($items, $changes[$type])
                    : $this->fireUpdatedEvent($items, $changes[$type]);
            }
        }
    }

    /**
     * Read settings from the underlying storage.
     *
     * @return array
     */
    protected function read()
    {
        // Check connection only once per lifecycle
        if ($this->connected === null) {
            $this->connected = $this->isConnected();
        }

        // Abort if Redis is unreachable
        if (! $this->connected) {
            return [];
        }

        // Fetch all keys matching the Settingfy prefix
        $keys = $this->redis()->keys("settingfy:*");
        $settings = [];

        foreach ($keys as $fullKey) {
            // Remove prefix to get group.key format
            $shortKey = str_replace("{$this->getRedisPrefix()}settingfy:", '', $fullKey);

            // Split into group and key
            [$group, $name] = explode('.', $shortKey, 2);

            // Fetch and decrypt value
            $value = $this->redis()->get("settingfy:$shortKey");

            $settings[$group][$name] = $this->performDecrypt($shortKey, unserialize($value));
        }

        return $settings;
    }
}
