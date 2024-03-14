<?php

return [

    'default_auth_profile' => env('GOOGLE_CALENDAR_AUTH_PROFILE', 'service_account'),

    'auth_profiles' => [

        /*
         * Authenticate using a service account.
         */
        'service_account' => [
            /*
             * Path to the json file containing the credentials.
             */
            'credentials_json' => storage_path('app/google-calendar/idh-gc-59611417c6f0.json'),
        ],

        /*
         * Authenticate with actual google user account.
         */
        'oauth' => [
            /*
             * Path to the json file containing the oauth2 credentials.
             */
            'credentials_json' => storage_path('app/google-calendar/client_secret_1096967273038-412ulob0m7rdee75i2rmirfd9lslc8ei.apps.googleusercontent.com.json'),

            /*
             * Path to the json file containing the oauth2 token.
             */
            'token_json' => "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",
        ],
    ],

    /*
     *  The id of the Google Calendar that will be used by default.
     */
    'calendar_id' =>'irfa.backend@gmail.com',

     /*
     *  The email address of the user account to impersonate.
     */
    'user_to_impersonate' => env('GOOGLE_CALENDAR_IMPERSONATE'),
];
