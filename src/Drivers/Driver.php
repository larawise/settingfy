<?php

namespace Larawise\Settingfy\Drivers;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Encryption\Encrypter;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Larawise\Settingfy\Contracts\SettingfyContract as SettingfyDriver;
use Larawise\Support\Driver as LarawiseDriver;
use Larawise\Settingfy\Events\SettingsCreated;
use Larawise\Settingfy\Events\SettingsDeleted;
use Larawise\Settingfy\Events\SettingsUpdated;

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
abstract class Driver extends LarawiseDriver implements SettingfyDriver
{
    /**
     * The list of guarded setting keys.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The in-memory settings storage.
     *
     * @var array
     */
    protected $items = [];

    /**
     * The loaded state of the settings.
     *
     * @var bool
     */
    protected $loaded = false;

    /**
     * The unsaved state of the settings.
     *
     * @var bool
     */
    protected $unsaved = false;

    /**
     * Create a new database setting driver instance.
     *
     * @param Repository $config
     * @param Encrypter $encrypter
     * @param Dispatcher $events
     *
     * @return void
     */
    public function __construct($config, $encrypter, $events)
    {
        parent::__construct($config, $encrypter, $events);

        $this->guarded = $this->config('settingfy.guarded');
        $this->encryptOnly = $this->config('settingfy.encrypt_only');
        $this->encrypt = $this->config('settingfy.encrypt');
    }

    /**
     * Compare current items with stored settings and categorize differences.
     *
     * @param array $items
     *
     * @return array{added: array, updated: array, deleted: array}
     */
    protected function audit($items = [])
    {
        $existing = $this->read();

        $added = [];
        $updated = [];
        $deleted = [];

        // Detect added and updated keys by comparing memory against storage
        foreach ($items as $group => $values) {
            foreach ($values as $name => $value) {
                if (! isset($existing[$group][$name])) {
                    // Key is new — not present in storage
                    $added[] = "{$group}.{$name}";
                } elseif ($existing[$group][$name] !== $value) {
                    // Key exists but value has changed
                    $updated[] = "{$group}.{$name}";
                }
            }
        }

        // Detect deleted keys by comparing storage against memory
        foreach ($existing as $group => $values) {
            foreach ($values as $name => $_) {
                if (! isset($items[$group][$name])) {
                    // Key was removed from memory — should be deleted from storage
                    $deleted[] = "{$group}.{$name}";
                }
            }
        }

        // Return categorized change list
        return compact('added', 'updated', 'deleted');
    }

    /**
     * Retrieve all settings currently loaded in memory.
     *
     * @return array
     */
    public function all()
    {
        // Ensure settings are loaded before accessing them
        $this->load();

        // Return the in-memory settings array
        return $this->items;
    }

    /**
     * Delete settings from the underlying storage.
     *
     * @param array $items
     *
     * @return void
     */
    abstract protected function delete($items);

    /**
     * Forget a given setting value.
     *
     * @param string|array $key
     * @param bool $force
     *
     * @return SettingfyDriver
     */
    public function forget($key, $force = false)
    {
        // Prevent deletion of guarded keys unless forced
        if (! $this->shouldBeProtected($key, $force)) {
            return $this;
        }

        // Ensure settings are loaded before accessing them
        $this->load();

        // Remove the specified key using Laravel's dot notation helper
        Arr::forget($this->items, $key);

        // Mark the settings as modified so they can be persisted later
        $this->unsaved = true;

        return $this;
    }

    /**
     * Flush all settings value.
     *
     * @return $this
     */
    public function flush()
    {
        // Clear all in-memory setting items
        $this->items = [];

        // Mark the settings as modified (unsaved)
        $this->unsaved = true;

        return $this;
    }

    /**
     * Get the specified setting value.
     *
     * @param string|array $key
     * @param mixed $default
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        // Ensure settings are loaded before accessing them
        $this->load();

        // If multiple keys are provided, delegate to hasMany()
        if (is_array($key)) {
            return $this->getMany($key);
        }

        // Retrieve the value using Laravel's dot notation
        // Then decrypt it if necessary
        return $this->performDecrypt(
            identifier: $key,
            value: Arr::get($this->items, $key, $default)
        );
    }

    /**
     * Retrieve multiple setting values from memory.
     *
     * @param array $keys
     *
     * @return array
     */
    public function getMany($keys)
    {
        $payload = [];

        foreach ($keys as $key => $default) {
            // If the array is numerically indexed, treat value as key and default as null
            if (is_numeric($key)) {
                [$key, $default] = [$default, null];
            }

            // Retrieve the value using the get() method
            $payload[$key] = $this->get($key, $default);
        }

        return $payload;
    }

    /**
     * Determine if the given setting value exists.
     *
     * @param string|array $key
     *
     * @return bool
     */
    public function has($key)
    {
        // Ensure settings are loaded before accessing them
        $this->load();

        // If multiple keys are provided, delegate to hasMany()
        if (is_array($key)) {
            return $this->hasMany($key);
        }

        // Check if the key exists in the loaded settings array
        return Arr::has($this->items, $key);
    }

    /**
     * Determine if multiple setting keys exist in memory.
     *
     * @param array $keys
     *
     * @return array
     */
    public function hasMany($keys)
    {
        $payload = [];

        foreach ($keys as $key) {
            // Check if each key exists in the current settings
            $payload[$key] = $this->has($key);
        }

        return $payload;
    }

    /**
     * Load settings from the underlying storage into memory.
     *
     * @param bool $force
     *
     * @return void
     */
    protected function load($force = false)
    {
        // Load settings only if not already loaded or if forced
        if (! $this->loaded || $force) {
            // Read from storage (e.g. file or database)
            $this->items = $this->read();

            // Mark as loaded to prevent redundant reads
            $this->loaded = true;
        }
    }

    /**
     * Persist the current in-memory settings to storage.
     *
     * @return bool
     */
    public function save()
    {
        // Skip saving if no changes were made
        if (! $this->unsaved) {
            return false;
        }

        // Synchronize settings by writing current items and deleting missing ones.
        $this->sync($this->items);

        // Clear the unsaved flag to indicate a clean state
        $this->unsaved = false;

        // Indicate that save was successfully performed
        return true;
    }

    /**
     * Set a given setting value.
     *
     * @param string|array $key
     * @param mixed $value
     * @param bool $force
     *
     * @return SettingfyDriver
     */
    public function set($key, $value = null, $force = false)
    {
        // Skip guarded keys unless forced
        if ($this->shouldBeProtected($key, $force)) {
            return $this;
        }

        // Ensure settings are loaded before modifying them
        $this->load();

        // If multiple keys are provided, delegate to setMany()
        if (is_array($key)) {
            return $this->setMany($key, $force);
        }

        // Store the value using Laravel's dot notation
        // Encrypt the value if necessary before storing
        Arr::set($this->items, $key, $this->performEncrypt($key, $value));

        // Mark the settings as modified for later persistence
        $this->unsaved = true;

        return $this;
    }

    /**
     * Set multiple setting values at once.
     *
     * @param array $keys
     * @param bool $force
     *
     * @return SettingfyDriver
     */
    public function setMany($keys, $force = false)
    {
        foreach ($keys as $key => $value) {
            $this->set($key, $value, $force);
        }

        return $this;
    }

    /**
     * Determine whether the given key is guarded and should be protected from mutation.
     *
     * @param string $key
     * @param bool $force
     *
     * @return bool
     */
    protected function shouldBeProtected($key, $force = false)
    {
        // Guarding explicitly bypassed
        if ($force) {
            return false;
        }

        foreach ($this->guarded as $pattern) {
            // Check if the identifier matches the current pattern (supports wildcards)
            if (Str::is($pattern, $key)) {
                // Match found — encryption should be applied
                return true;
            }
        }

        // No match — skip encryption for this identifier
        return false;
    }

    /**
     * Dispatch the settings created event with the given items and changes.
     *
     * @param array $items
     * @param array $changes
     *
     * @return void
     */
    protected function fireCreatedEvent($items, $changes)
    {
        $this->dispatch(new SettingsCreated($items, $changes, auth()->id() ?? 'system'));
    }

    /**
     * Dispatch the settings updated event with the given items and changes.
     *
     * @param array $items
     * @param array $changes
     *
     * @return void
     */
    protected function fireUpdatedEvent(array $items, array $changes)
    {
        $this->dispatch(new SettingsUpdated($items, $changes, auth()->id() ?? 'system'));
    }

    /**
     * Dispatch the settings deleted event with the given items and changes.
     *
     * @param array $items
     * @param array $changes
     *
     * @return void
     */
    protected function fireDeletedEvent($items, $changes)
    {
        $this->dispatch(new SettingsDeleted($items, $changes, auth()->id() ?? 'system'));
    }

    /**
     * Synchronize settings by writing current items and deleting missing ones.
     *
     * @param array $items
     *
     * @return void
     */
    protected function sync($items)
    {
        // Write current settings to storage
        $this->write($items);

        // Delete settings that are no longer present
        $this->delete($items);
    }

    /**
     * Read settings from the underlying storage.
     *
     * @return array
     */
    abstract protected function read();

    /**
     * Write settings to the underlying storage.
     *
     * @param array $items
     *
     * @return void
     */
    abstract protected function write($items);
}
