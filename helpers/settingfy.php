<?php

use Larawise\Settingfy\Contracts\SettingfyContract;

if (! function_exists('setting')) {
    /**
     * Get / set the specified setting value.
     *
     * @param array<string, mixed>|string|null $key
     * @param mixed $default
     *
     * @return ($key is null ? SettingfyContract : ($key is string ? mixed : null))
     */
    function setting($key = null, $default = null)
    {
        if (is_null($key)) {
            // No key provided — return the full settingfy service
            return app('settingfy');
        }

        if (is_array($key)) {
            // Array provided — set multiple settings at once
            return app('settingfy')->set($key);
        }

        // String key provided — retrieve the setting value or fallback to default
        return app('settingfy')->get($key, $default);
    }
}
