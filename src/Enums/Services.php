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
enum Services: string
{
    /**
     * **Reference :** session.driver
     */
    case RESEND_KEY = 'RESEND_KEY';

    /**
     * **Reference :** session.lifetime
     */
    case AWS_ACCESS_KEY_ID = 'AWS_ACCESS_KEY_ID';

    /**
     * **Reference :** session.expire_on_close
     */
    case AWS_SECRET_ACCESS_KEY = 'AWS_SECRET_ACCESS_KEY';

    /**
     * **Reference :** session.encrypt
     */
    case AWS_DEFAULT_REGION = 'AWS_DEFAULT_REGION';

    /**
     * **Reference :** session.connection
     */
    case SLACK_BOT_USER_OAUTH_TOKEN = 'SLACK_BOT_USER_OAUTH_TOKEN';

    /**
     * **Reference :** session.table
     */
    case SLACK_BOT_USER_DEFAULT_CHANNEL = 'SLACK_BOT_USER_DEFAULT_CHANNEL';

    /**
     * Converts a config key (e.g. 'session.driver') to its corresponding enum case.
     *
     * @param string $key The config key to resolve.
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
     * @param self $env The enum case to resolve.
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
    public static function keys()
    {
        return array_map(fn($case) => self::toKey($case), self::cases());
    }

    /**
     * Returns all .env keys defined in this enum.
     *
     * @return array<string>
     */
    public static function values()
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Returns a map of env keys to config keys.
     *
     * @return array<string, string>
     */
    public static function map()
    {
        return array_combine(self::values(), self::keys());
    }

    /**
     * Returns a map of config keys to env keys.
     *
     * @return array<string, string>
     */
    public static function reverseMap()
    {
        return array_combine(self::keys(), self::values());
    }
}
