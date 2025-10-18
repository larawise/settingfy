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
enum Auth: string
{
    /**
     * **Reference :** auth.defaults.guard
     */
    case GUARD = 'AUTH_GUARD';

    /**
     * **Reference :** auth.defaults.passwords
     */
    case PASSWORD_BROKER = 'AUTH_PASSWORD_BROKER';

    /**
     * **Reference :** auth.passwords.*.table (for **Larawise**)
     */
    case PASSWORD_TABLE = 'AUTH_PASSWORD_TABLE';

    /**
     * **Reference :** auth.passwords.*.expire (for **Larawise**)
     */
    case PASSWORD_EXPIRE = 'AUTH_PASSWORD_EXPIRE';

    /**
     * **Reference :** auth.passwords.*.throttle (for **Larawise**)
     */
    case PASSWORD_THROTTLE = 'AUTH_PASSWORD_THROTTLE';

    /**
     * **Reference :** auth.passwords.*.table
     */
    case PASSWORD_RESET_TOKEN_TABLE = 'AUTH_PASSWORD_RESET_TOKEN_TABLE';

    /**
     * **Reference :** app.password_timeout
     */
    case PASSWORD_TIMEOUT = 'AUTH_PASSWORD_TIMEOUT';

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
            'auth.defaults.guard' => self::GUARD,
            'auth.defaults.passwords' => self::PASSWORD_BROKER,
            'auth.passwords.*.table' => self::PASSWORD_TABLE,
            'auth.passwords.*.expire' => self::PASSWORD_EXPIRE,
            'auth.passwords.*.throttle' => self::PASSWORD_THROTTLE,
            'auth.passwords.web.table' => self::PASSWORD_RESET_TOKEN_TABLE,
            'auth.maintenance.store' => self::PASSWORD_TIMEOUT,
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

        return match ($case) {
            self::GUARD => 'auth.defaults.guard',
            self::PASSWORD_BROKER => 'auth.defaults.passwords',
            self::PASSWORD_TABLE => 'auth.passwords.*.table',
            self::PASSWORD_EXPIRE => 'auth.passwords.*.expire',
            self::PASSWORD_THROTTLE => 'auth.passwords.*.throttle',
            self::PASSWORD_RESET_TOKEN_TABLE => 'auth.passwords.web.table',
            self::PASSWORD_TIMEOUT => 'auth.maintenance.store',
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
            self::PASSWORD_TABLE,
            self::PASSWORD_EXPIRE,
            self::PASSWORD_THROTTLE
        ]);
    }
}
