<?php

$config = [
    'APP_NAME' => getenv('APP_NAME') ?: 'Fosa',
    'APP_DEFAULT_LANG' => getenv('DEFAULT_LANG') ?: 'en-EN',
    'APP_ENV' => getenv('ENV') ?: 'dev',

    'SSL' => getenv('SSL') ?: false,

    'HOST' => getenv('R_HOST') ?: 'localhost',
    'PORT' => getenv('R_PORT') ?: 8085,
    
    'TRANSLATION_PARAM_TOKEN' => '%%',
];