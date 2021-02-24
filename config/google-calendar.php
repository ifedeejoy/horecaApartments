<?php

use Illuminate\Support\Facades\Auth as Auth;

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
            'credentials_json' => storage_path('app/keys/service-account-credentials.json'),
        ],

        /*
         * Authenticate with actual google user account.
         */
        'oauth' => [
            /*
             * Path to the json file containing the oauth2 credentials.
             */
            'credentials_json' => storage_path('/app/keys/oauth-credentials.json'),

            /*
             * Path to the json file containing the oauth2 token.
             */
            // 'token_json' => Auth::user()->googleAcount->token,
        ],
    ],

    /*
     *  The id of the Google Calendar that will be used by default.
     */
    'calendar_id' => env('GOOGLE_CALENDAR_ID'),
];
