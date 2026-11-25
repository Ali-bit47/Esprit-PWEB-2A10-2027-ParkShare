<?php

define('APP_NAME', 'ParkShare');
define('APP_DEBUG', (getenv('PS_DEBUG') ?: '0') === '1'); 


define('DB_HOST', getenv('PS_DB_HOST') ?: 'localhost');
define('DB_PORT', getenv('PS_DB_PORT') ?: '3306');
define('DB_NAME', getenv('PS_DB_NAME') ?: 'parkshare');
define('DB_USER', getenv('PS_DB_USER') ?: 'root');
define('DB_PASS', getenv('PS_DB_PASS') !== false ? (string) getenv('PS_DB_PASS') : '');


define('SESSION_LIFETIME', 1800);   
define('MAX_LOGIN_ATTEMPTS', 5);   
define('LOCK_MINUTES', 15);       


define('USERS_PER_PAGE', 10);
