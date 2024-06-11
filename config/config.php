<?php

    define('BASEPATH', 'http://localhost/intuji-assignment/');
    define('DB_HOST', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'intuji-assignment-calendar');

    if(!session_id()) session_start(); 

    // Google API configuration 
    define('GOOGLE_CLIENT_ID', '531272548723-c10nvch722hjd0id57dmnb2m4btohmg2.apps.googleusercontent.com'); 
    define('GOOGLE_CLIENT_SECRET', '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'); 
    define('GOOGLE_OAUTH_SCOPE', 'https://www.googleapis.com/auth/calendar'); 
    define('REDIRECT_URI', 'http://localhost/intuji-assignment/controllers/google_calendar_event_sync.php'); 

    // $googleOauthURL = 'https://accounts.google.com/o/oauth2/auth?scope=' . urlencode(GOOGLE_OAUTH_SCOPE) . '&redirect_uri=' . REDIRECT_URI . '&response_type=code&client_id=' . GOOGLE_CLIENT_ID . '&access_type=online'; 
?>