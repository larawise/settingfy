<?php

use Larawise\Settingfy\Contracts\SettingfyContract;

if (! function_exists('setting')) {
    /**
     * Get / set the specified setting value.
     *
     * @param array<string, mixed>|string|null $key
     * @param mixed $default
     * @param bool $persist
     *
     * @return ($key is null ? SettingfyContract : ($key is string ? mixed : null))
     */
    function setting($key = null, $default = null, $persist = false)
    {
        // No key provided — return the Settingfy service instance
        if (is_null($key)) {
            return app('settingfy');
        }

        // Array provided — set multiple settings (optionally save if forced)
        if (is_array($key)) {
            return $persist === true
                ? app('settingfy')->set($key)->save()
                : app('settingfy')->set($key);
        }

        // Single key provided — retrieve the setting value with optional default
        return app('settingfy')->get($key, $default);
    }
}
