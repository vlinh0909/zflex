<?php
/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
// Code được viết bởi : https://www.facebook.com/vulinh007;
chdir(__DIR__);
define('ZFLEX_DB_PREFIX','zflex_');
define('PATH','http://localhost/zflex/');
define('PATH_PUBLIC','http://localhost/zflex/public/');
// Decline static file requests back to the PHP built-in webserver
if (php_sapi_name() === 'cli-server' && is_file(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))) {
    return false;
}

// Setup autoloading
require 'init_autoloader.php';

// Run the application!
Zend\Mvc\Application::init(require 'config/application.config.php')->run();
