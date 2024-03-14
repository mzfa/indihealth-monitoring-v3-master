<?php

return [

    'directories' => [

        /*
         * Here you can specify which directories need to be cleanup. All files older than
         * the specified amount of minutes will be deleted.
         */

        /*
        'path/to/a/directory' => [
            'deleteAllOlderThanMinutes' => 60 * 24,
        ],
        */
        storage_path('app/backups') => [
            'deleteAllOlderThanMinutes' => 1440*6,
        ],
        storage_path('app/temp_excel') => [
            'deleteAllOlderThanMinutes' => 525960*3,
        ],

        storage_path('app/temp_pdf') => [
            'deleteAllOlderThanMinutes' => 525960*3,
        ],

        storage_path('logs') => [
            'deleteAllOlderThanMinutes' => 86400*550,
        ],

        // storage_path('framework/laravel-excel') => [
        //     'deleteAllOlderThanMinutes' => 1440*3,
        // ],
    ],

    /*
     * If a file is older than the amount of minutes specified, a cleanup policy will decide if that file
     * should be deleted. By default every file that is older that the specified amount of minutes
     * will be deleted.
     *
     * You can customize this behaviour by writing your own clean up policy.  A valid policy
     * is any class that implements `Spatie\DirectoryCleanup\Policies\CleanupPolicy`.
     */
    'cleanup_policy' => \Spatie\DirectoryCleanup\Policies\DeleteEverything::class,
];
