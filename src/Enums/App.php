<?php

namespace Larawise\Settingfy\Enums;

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
enum App: string
{
    /**
     * **Reference :** app.name
     */
    case NAME = 'APP_NAME';

    /**
     * **Reference :** app.version (for **Larawise**)
     */
    case VERSION = 'APP_VERSION';

    /**
     * **Reference :** app.install (for **Larawise**)
     */
    case INSTALL = 'APP_INSTALL';

    /**
     * **Reference :** app.env
     */
    case ENV = 'APP_ENV';

    /**
     * **Reference :** app.debug
     */
    case DEBUG = 'APP_DEBUG';

    /**
     * **Reference :** app.url
     */
    case URL = 'APP_URL';

    /**
     * **Reference :** app.asset_url (for **Larawise**)
     */
    case ASSET_URL = 'APP_ASSET_URL';

    /**
     * **Reference :** app.storage_url (for **Larawise**)
     */
    case STORAGE_URL = 'APP_STORAGE_URL';

    /**
     * **Reference :** app.locale
     */
    case LOCALE = 'APP_LOCALE';

    /**
     * **Reference :** app.fallback_locale
     */
    case FALLBACK_LOCALE = 'APP_FALLBACK_LOCALE';

    /**
     * **Reference :** app.faker_locale
     */
    case FAKER_LOCALE = 'APP_FAKER_LOCALE';

    /**
     * **Reference :** app.timezone (for **Larawise**)
     */
    case TIMEZONE = 'APP_TIMEZONE';

    /**
     * **Reference :** app.fallback_timezone (for **Larawise**)
     */
    case FALLBACK_TIMEZONE = 'APP_FALLBACK_TIMEZONE';

    /**
     * **Reference :** app.currency (for **Larawise**)
     */
    case CURRENCY = 'APP_CURRENCY';

    /**
     * **Reference :** app.fallback_currency (for **Larawise**)
     */
    case FALLBACK_CURRENCY = 'APP_FALLBACK_CURRENCY';

    /**
     * **Reference :** app.cipher (for **Larawise**)
     */
    case CIPHER = 'APP_CIPHER';

    /**
     * **Reference :** app.key
     */
    case KEY = 'APP_KEY';

    /**
     * **Reference :** app.previous_keys
     */
    case PREVIOUS_KEYS = 'APP_PREVIOUS_KEYS';

    /**
     * **Reference :** app.maintenance.driver
     */
    case MAINTENANCE_DRIVER = 'APP_MAINTENANCE_DRIVER';

    /**
     * **Reference :** app.maintenance.store
     */
    case MAINTENANCE_STORE = 'APP_MAINTENANCE_STORE';

    /**
     * Converts a config key (e.g. 'app.name') to its corresponding enum case.
     *
     * @param string $key
     *
     * @return self|null
     */
    public static function fromKey($key)
    {
        return match ($key) {
            'app.name' => self::NAME,
            'app.version' => self::VERSION,
            'app.install' => self::INSTALL,
            'app.env' => self::ENV,
            'app.debug' => self::DEBUG,
            'app.url' => self::URL,
            'app.asset_Url' => self::ASSET_URL,
            'app.storage_url' => self::STORAGE_URL,
            'app.locale' => self::LOCALE,
            'app.fallback_locale' => self::FALLBACK_LOCALE,
            'app.faker_locale' => self::FAKER_LOCALE,
            'app.timezone' => self::TIMEZONE,
            'app.fallback_timezone' => self::FALLBACK_TIMEZONE,
            'app.currency' => self::CURRENCY,
            'app.fallback_currency' => self::FALLBACK_CURRENCY,
            'app.cipher' => self::CIPHER,
            'app.key' => self::KEY,
            'app.previous_keys' => self::PREVIOUS_KEYS,
            'app.maintenance.driver' => self::MAINTENANCE_DRIVER,
            'app.maintenance.store' => self::MAINTENANCE_STORE,
            default => null,
        };
    }

    /**
     * Converts an enum case to its corresponding config key.
     *
     * @param self|string $env
     *
     * @return string
     */
    public static function toKey($env)
    {
        $case = is_string($env) ? self::tryFrom($env) : $env;

        return match ($env) {
            self::NAME => 'app.name',
            self::VERSION => 'app.version',
            self::INSTALL => 'app.install',
            self::ENV => 'app.env',
            self::DEBUG => 'app.debug',
            self::URL => 'app.url',
            self::ASSET_URL => 'app.asset_Url',
            self::STORAGE_URL => 'app.storage_url',
            self::LOCALE => 'app.locale',
            self::FALLBACK_LOCALE => 'app.fallback_locale',
            self::FAKER_LOCALE => 'app.faker_locale',
            self::TIMEZONE => 'app.timezone',
            self::FALLBACK_TIMEZONE => 'app.fallback_timezone',
            self::CURRENCY => 'app.currency',
            self::FALLBACK_CURRENCY => 'app.fallback_currency',
            self::CIPHER => 'app.cipher',
            self::KEY => 'app.key',
            self::PREVIOUS_KEYS => 'app.previous_keys',
            self::MAINTENANCE_DRIVER => 'app.maintenance.driver',
            self::MAINTENANCE_STORE => 'app.maintenance.store',
            default => null,
        };
    }

    /**
     * Returns all config keys mapped from the enum cases.
     *
     * @return array<string>
     */
    public static function keys($forLarawise = true)
    {
        $cases = $forLarawise
            ? self::cases()
            : array_filter(self::cases(), fn($case) => ! self::isCustom($case));

        return array_map(fn($case) => self::toKey($case), $cases);
    }

    /**
     * Returns all .env keys defined in this enum.
     *
     * @param bool $forLarawise
     *
     * @return array<string>
     */
    public static function values($forLarawise = false)
    {
        $cases = $forLarawise
            ? self::cases()
            : array_filter(self::cases(), fn($case) => ! self::isCustom($case));

        return array_column($cases, 'value');
    }

    /**
     * Returns a map of env keys to config keys.
     *
     * @param bool $forLarawise
     *
     * @return array<string, string>
     */
    public static function map($forLarawise = false)
    {
        return array_combine(self::values($forLarawise), self::keys($forLarawise));
    }

    /**
     * Returns a map of config keys to env keys.
     *
     * @param bool $forLarawise
     *
     * @return array<string, string>
     */
    public static function reverseMap($forLarawise = false)
    {
        return array_combine(self::keys($forLarawise), self::values($forLarawise));
    }

    /**
     * Determines whether the given enum case is custom-defined for Larawise.
     *
     * @param self $case
     *
     * @return bool
     */
    public static function isCustom($case)
    {
        return in_array($case, [
            self::INSTALL,
            self::PREVIOUS_KEYS,
            self::STORAGE_URL,
            self::FALLBACK_TIMEZONE,
            self::FALLBACK_CURRENCY,
        ]);
    }
}
