<?php

namespace Larawise\Settingfy\Facades;

use Illuminate\Support\Facades\Facade;

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
 *
 * @method static \Larawise\Settingfy\Contracts\SettingfyContract driver(string|null $name)
 * @method static bool has(string|array $key)
 * @method static array hasMany(array $keys)
 * @method static mixed get(string $key, mixed $default)
 * @method static array getMany(array $keys)
 * @method static \Larawise\Settingfy\Contracts\SettingfyContract set(string $key, mixed $value, bool $force)
 * @method static \Larawise\Settingfy\Contracts\SettingfyContract setMany(string $keys, bool $force)
 * @method static \Larawise\Settingfy\Contracts\SettingfyContract forget(string|array $key, bool $force)
 * @method static \Larawise\Settingfy\Contracts\SettingfyContract flush()
 * @method static bool save()
 * @method static array all()
 *
 * @see \Larawise\Settingfy\SettingfyManager
 */
class Settingfy extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'settingfy';
    }
}
