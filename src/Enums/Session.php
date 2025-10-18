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
enum Session: string
{
    /**
     * **Reference :** session.driver
     */
    case DRIVER = 'SESSION_DRIVER';

    /**
     * **Reference :** session.lifetime
     */
    case LIFETIME = 'SESSION_LIFETIME';

    /**
     * **Reference :** session.expire_on_close
     */
    case EXPIRE_ON_CLOSE = 'SESSION_EXPIRE_ON_CLOSE';

    /**
     * **Reference :** session.encrypt
     */
    case ENCRYPT = 'SESSION_ENCRYPT';

    /**
     * **Reference :** session.connection
     */
    case CONNECTION = 'SESSION_CONNECTION';

    /**
     * **Reference :** session.table
     */
    case TABLE = 'SESSION_TABLE';

    /**
     * **Reference :** session.store
     */
    case STORE = 'SESSION_STORE';

    /**
     * **Reference :** session.cookie
     */
    case COOKIE = 'SESSION_COOKIE';

    /**
     * **Reference :** session.path
     */
    case PATH = 'SESSION_PATH';

    /**
     * **Reference :** session.domain
     */
    case DOMAIN = 'SESSION_DOMAIN';

    /**
     * **Reference :** session.secure
     */
    case SECURE_COOKIE = 'SESSION_SECURE_COOKIE';

    /**
     * **Reference :** session.http_only
     */
    case HTTP_ONLY = 'SESSION_HTTP_ONLY';

    /**
     * **Reference :** session.same_site
     */
    case SAME_SITE = 'SESSION_SAME_SITE';

    /**
     * **Reference :** session.partitioned
     */
    case PARTITIONED_COOKIE = 'SESSION_PARTITIONED_COOKIE';

    /**
     * Converts a config key (e.g. 'session.driver') to its corresponding enum case.
     *
     * @param string $key
     *
     * @return self|null
     */
    public static function fromKey($key)
    {
        return match ($key) {
            'session.driver' => self::DRIVER,
            'session.lifetime' => self::LIFETIME,
            'session.expire_on_close' => self::EXPIRE_ON_CLOSE,
            'session.encrypt' => self::ENCRYPT,
            'session.connection' => self::CONNECTION,
            'session.table' => self::TABLE,
            'session.store' => self::STORE,
            'session.cookie' => self::COOKIE,
            'session.path' => self::PATH,
            'session.domain' => self::DOMAIN,
            'session.secure' => self::SECURE_COOKIE,
            'session.http_only' => self::HTTP_ONLY,
            'session.same_site' => self::SAME_SITE,
            'session.partitioned' => self::PARTITIONED_COOKIE,
            default => null,
        };
    }

    /**
     * Converts an enum case to its corresponding config key.
     *
     * @param self $env
     *
     * @return string
     */
    public static function toKey($env)
    {
        $case = is_string($env) ? self::tryFrom($env) : $env;

        return match ($case) {
            self::DRIVER => 'session.driver',
            self::LIFETIME => 'session.lifetime',
            self::EXPIRE_ON_CLOSE => 'session.expire_on_close',
            self::ENCRYPT => 'session.encrypt',
            self::CONNECTION => 'session.connection',
            self::TABLE => 'session.table',
            self::STORE => 'session.store',
            self::COOKIE => 'session.cookie',
            self::PATH => 'session.path',
            self::DOMAIN => 'session.domain',
            self::SECURE_COOKIE => 'session.secure',
            self::HTTP_ONLY => 'session.http_only',
            self::SAME_SITE => 'session.same_site',
            self::PARTITIONED_COOKIE => 'session.partitioned',
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
        return false;
    }
}
