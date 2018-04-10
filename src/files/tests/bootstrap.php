<?php

$root = getcwd();

require_once($root . '/vendor/autoload.php');

error_reporting(0);

define('WP_TESTS', true);
define('WP_ENV', getenv('WP_ENV'));

// Set common headers, to prevent warnings from plugins
$_SERVER['SERVER_PROTOCOL'] = 'HTTP/1.0';
$_SERVER['HTTP_USER_AGENT'] = '';
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REMOTE_ADDR'] = '127.0.0.1';
$_SERVER['HTTP_HOST'] = getenv('BASE_URL');

/* Load WordPress */

// bypass loading theme templates.
define('WP_USE_THEMES', false);

require($root . '/cms/wp-blog-header.php');