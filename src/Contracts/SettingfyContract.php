<?php

namespace Larawise\Settingfy\Contracts;

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
interface SettingfyContract
{
    /**
     * Get all the setting items for the application.
     *
     * @return array
     */
    public function all();

    /**
     * Forget a given setting value.
     *
     * @param array|string $key
     * @param bool $force
     *
     * @return SettingfyContract
     */
    public function forget($key, $force = false);

    /**
     * Flush all settings value.
     *
     * @return SettingfyContract
     */
    public function flush();

    /**
     * Get the specified setting value.
     *
     * @param string $key
     * @param mixed $default
     *
     * @return mixed
     */
    public function get($key, $default = null);

    /**
     * Retrieve multiple setting values from memory.
     *
     * @param array $keys
     *
     * @return array
     */
    public function getMany($keys);

    /**
     * Determine if the given setting value exists.
     *
     * @param string $key
     *
     * @return bool
     */
    public function has($key);

    /**
     * Determine if multiple setting keys exist in memory.
     *
     * @param array $keys
     * @param bool $force
     *
     * @return array
     */
    public function hasMany($keys, $force = false);

    /**
     * Persist the current in-memory settings to storage.
     *
     * @return bool
     */
    public function save();

    /**
     * Set a given setting value.
     *
     * @param string $key
     * @param mixed $value
     * @param bool $force
     *
     * @return SettingfyContract
     */
    public function set($key, $value = null, $force = false);

    /**
     * Set multiple setting values at once.
     *
     * @param array $keys
     * @param bool $force
     *
     * @return SettingfyContract
     */
    public function setMany($keys, $force = false);
}
