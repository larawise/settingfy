<?php

return [
    /*
    |--------------------------------------------------------------------------
    | ℹ️ Settingfy (Driver)
    |--------------------------------------------------------------------------
    |
    | This value determines which storage driver Settingfy will use to
    | persist and retrieve settings. It defines the underlying mechanism
    | for configuration management.
    |
    | Supported: "database", "redis"
    |
    */
    'driver'                                    => env('SETTINGFY_DRIVER', 'database'),

    /*
    |--------------------------------------------------------------------------
    | ℹ️ Settingfy (Connection)
    |--------------------------------------------------------------------------
    |
    | When using the "database" or "redis" settingfy drivers, you may specify a
    | connection that should be used to manage these settings. This should
    | correspond to a connection in your database configuration options.
    |
    */
    'connection'                                => env('SETTINGFY_CONNECTION'),

    /*
    |--------------------------------------------------------------------------
    | ℹ️ Settingfy (Table)
    |--------------------------------------------------------------------------
    |
    | When using the "database" session driver, you may specify the table to
    | be used to store sessions. Of course, a sensible default is defined
    | for you; however, you're welcome to change this to another table.
    |
    */
    'table'                                     => env('SETTINGFY_TABLE', 'settings'),

    /*
    |--------------------------------------------------------------------------
    | ℹ️ Settingfy (Encrypt)
    |--------------------------------------------------------------------------
    |
    | This section defines which setting keys should be encrypted before being
    | stored in the database. These keys typically contain sensitive information
    | such as API tokens, credentials, or private configuration values.
    |
    */
    'encrypt'                                   => (bool) env('SETTINGFY_ENCRYPT', false),

    /*
    |--------------------------------------------------------------------------
    | ℹ️ Settingfy (Encrypted)
    |--------------------------------------------------------------------------
    |
    | Defines which setting keys should be encrypted when encryption is enabled.
    | Supports dot-notation and wildcard patterns (e.g. "api.*", "mail.password").
    | If left empty, all keys will be encrypted by default.
    |
    */
    'encrypt_only'                              => [
        ...array_filter(
            explode(',', env('SETTINGFY_ENCRYPT_ONLY', ''))
        ),
    ],

    /*
    |--------------------------------------------------------------------------
    | ℹ️ Settingfy (Guarded)
    |--------------------------------------------------------------------------
    |
    | Defines which setting keys are protected from modification at runtime.
    | Guarded keys cannot be updated via the `set()` method and are considered
    | immutable once loaded. Supports dot-notation and wildcard patterns.
    |
    */
    'guarded'                                       => [
        ...array_filter(
            explode(',', env('SETTINGFY_GUARDED', ''))
        ),
    ],

    /*
    |--------------------------------------------------------------------------
    | ℹ️ Settingfy (Queue)
    |--------------------------------------------------------------------------
    |
    | This section controls how Settingfy events are dispatched.
    | If enabled, events will be queued using Laravel's queue system.
    | You can also specify a custom queue name for isolation and priority control.
    |
    */
    'queue'                                     => [
        'status'    => env('SETTINGFY_QUEUE', false),
        'name'      => env('SETTINGFY_QUEUE_NAME', 'settingfy'),
    ],
];
