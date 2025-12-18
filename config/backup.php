<?php

return [

    'backup' => [

        'name' => env('APP_NAME', 'laravel-backup'),

        'source' => [

            'files' => [

                'include' => [

                    base_path(),

                ],

                'exclude' => [

                    base_path('vendor'),

                    base_path('node_modules'),

                ],

                'follow_links' => false,

            ],

            'databases' => [

                'sqlite',

            ],

        ],

        'destination' => [

            'disks' => [

                'local',

            ],

        ],

        'temporary_directory' => storage_path('app/backup-temp'),

    ],

    'notifications' => [

        'notifications' => [

            // Spatie\Backup\Notifications\Notifications\BackupHasFailed::class => ['mail'],

            // Spatie\Backup\Notifications\Notifications\UnreadNotifications::class => ['slack'],

        ],

        'notifiable' => Spatie\Backup\Notifications\Notifiable::class,

        'mail' => [

            'to' => 'your@email.com',

        ],

        'slack' => [

            'webhook_url' => 'https://hooks.slack.com/services/...',

        ],

    ],

    'monitor_backups' => [

        [

            'name' => env('APP_NAME', 'laravel-backup'),

            'disks' => ['local'],

            'health_checks' => [

                Spatie\Backup\Tasks\Monitor\HealthChecks\MaximumAgeInDays::class => 1,

                Spatie\Backup\Tasks\Monitor\HealthChecks\MaximumStorageInMegabytes::class => 5000,

            ],

        ],

    ],

    'cleanup' => [

        'strategy' => Spatie\Backup\Tasks\Cleanup\Strategies\DefaultStrategy::class,

        'default_strategy' => [

            'keep_all_backups_for_days' => 7,

            'keep_daily_backups_for_days' => 16,

            'keep_weekly_backups_for_days' => 60,

            'keep_monthly_backups_for_days' => 365,

            'keep_yearly_backups_for_days' => 1825,

            'delete_oldest_backups_when_using_more_megabytes_than' => 5000,

        ],

    ],

];