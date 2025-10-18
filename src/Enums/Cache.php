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
enum Cache: string
{
    /**
     * **Reference :** cache.default
     */
    case STORE = 'CACHE_STORE';

    /**
     * **Reference :** cache.stores.database.connection
     */
    case CONNECTION = 'DB_CACHE_CONNECTION';

    /**
     * **Reference :** cache.stores.database.table
     */
    case TABLE = 'DB_CACHE_TABLE';

    /**
     * **Reference :** cache.stores.database.lock_connection
     */
    case LOCK_CONNECTION = 'DB_CACHE_LOCK_CONNECTION';

    /**
     * **Reference :** cache.stores.database.lock_table
     */
    case LOCK_TABLE = 'DB_CACHE_LOCK_TABLE';

    /**
     * **Reference :** cache.stores.memcached.persistent_id
     */
    case MEMCACHED_PERSISTENT_ID = 'MEMCACHED_PERSISTENT_ID';

    /**
     * **Reference :** cache.stores.memcached.sasl
     */
    case MEMCACHED_USERNAME = 'MEMCACHED_USERNAME';

    /**
     * **Reference :** cache.stores.memcached.sasl
     */
    case MEMCACHED_PASSWORD = 'MEMCACHED_PASSWORD';

    /**
     * **Reference :** cache.stores.memcached.servers.0.host
     */
    case MEMCACHED_HOST = 'MEMCACHED_HOST';

    /**
     * **Reference :** cache.stores.memcached.servers.0.port
     */
    case MEMCACHED_PORT = 'MEMCACHED_PORT';

    /**
     * **Reference :** cache.stores.redis.connection
     */
    case REDIS_CONNECTION = 'REDIS_CACHE_CONNECTION';

    /**
     * **Reference :** cache.stores.redis.lock_connection
     */
    case REDIS_LOCK_CONNECTION = 'REDIS_CACHE_LOCK_CONNECTION';

    /**
     * **Reference :** cache.stores.dynamodb.key
     */
    case AWS_ACCESS_KEY_ID = 'AWS_ACCESS_KEY_ID';

    /**
     * **Reference :** cache.stores.dynamodb.secret
     */
    case AWS_SECRET_ACCESS_KEY = 'AWS_SECRET_ACCESS_KEY';

    /**
     * **Reference :** cache.stores.dynamodb.region
     */
    case AWS_DEFAULT_REGION = 'AWS_DEFAULT_REGION';

    /**
     * **Reference :** cache.stores.dynamodb.table
     */
    case DYNAMODB_TABLE = 'DYNAMODB_CACHE_TABLE';

    /**
     * **Reference :** cache.stores.dynamodb.endpoint
     */
    case DYNAMODB_ENDPOINT = 'DYNAMODB_ENDPOINT';

    /**
     * **Reference :** cache.prefix
     */
    case CACHE_PREFIX = 'CACHE_PREFIX';

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
            'cache.default' => self::STORE,
            'cache.stores.database.connection' => self::CONNECTION,
            'cache.stores.database.table' => self::TABLE,
            'cache.stores.database.lock_connection' => self::LOCK_CONNECTION,
            'cache.stores.database.lock_table' => self::LOCK_TABLE,
            'cache.stores.memcached.persistent_id' => self::MEMCACHED_PERSISTENT_ID,
            'cache.stores.memcached.sasl' => self::MEMCACHED_USERNAME,
            'cache.stores.memcached.sasl' => self::MEMCACHED_PASSWORD,
            'cache.stores.memcached.servers.0.host' => self::MEMCACHED_HOST,
            'cache.stores.memcached.servers.0.port' => self::MEMCACHED_PORT,
            'cache.stores.redis.connection' => self::REDIS_CONNECTION,
            'cache.stores.redis.lock_connection' => self::REDIS_LOCK_CONNECTION,
            'cache.stores.dynamodb.key' => self::AWS_ACCESS_KEY_ID,
            'cache.stores.dynamodb.secret' => self::AWS_SECRET_ACCESS_KEY,
            'cache.stores.dynamodb.region' => self::AWS_DEFAULT_REGION,
            'cache.stores.dynamodb.table' => self::DYNAMODB_TABLE,
            'cache.stores.dynamodb.endpoint' => self::DYNAMODB_ENDPOINT,
            'cache.prefix' => self::CACHE_PREFIX,
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
            self::STORE => 'cache.default',
            self::CONNECTION => 'cache.stores.database.connection',
            self::TABLE => 'cache.stores.database.table',
            self::LOCK_CONNECTION => 'cache.stores.database.lock_connection',
            self::LOCK_TABLE => 'cache.stores.database.lock_table',
            self::MEMCACHED_PERSISTENT_ID => 'cache.stores.memcached.persistent_id',
            self::MEMCACHED_USERNAME => 'cache.stores.memcached.sasl',
            self::MEMCACHED_PASSWORD => 'cache.stores.memcached.sasl',
            self::MEMCACHED_HOST => 'cache.stores.memcached.servers.0.host',
            self::MEMCACHED_PORT => 'cache.stores.memcached.servers.0.port',
            self::REDIS_CONNECTION => 'cache.stores.redis.connection',
            self::REDIS_LOCK_CONNECTION => 'cache.stores.redis.lock_connection',
            self::AWS_ACCESS_KEY_ID => 'cache.stores.dynamodb.key',
            self::AWS_SECRET_ACCESS_KEY => 'cache.stores.dynamodb.secret',
            self::AWS_DEFAULT_REGION => 'cache.stores.dynamodb.region',
            self::DYNAMODB_TABLE => 'cache.stores.dynamodb.table',
            self::DYNAMODB_ENDPOINT => 'cache.stores.dynamodb.endpoint',
            self::CACHE_PREFIX => 'cache.prefix',
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
