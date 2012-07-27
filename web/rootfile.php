<?php
$basedir = dirname(__DIR__) . '/';

define('OPENPSA2_THEME_ROOT', $basedir . 'themes/');
define('MIDCOM_ROOT', $basedir . 'vendor/openpsa/midcom/lib');
define('OPENPSA2_PREFIX', '/');

header('Content-Type: text/html; charset=utf-8');

$GLOBALS['midcom_config_local'] = array();
$GLOBALS['midcom_config_local']['person_class'] = 'openpsa_person';

//This file you have to provide
if (file_exists($basedir . 'config.inc.php'))
{
    include $basedir . 'config.inc.php';
}
else
{
    include $basedir . 'tools/bootstrap.php';
    $bootstrapper = new bootstrap($basedir);
    $bootstrapper->run();
}

// Include the MidCOM environment
require MIDCOM_ROOT . '/midcom.php';

$loader = require $basedir . 'vendor/autoload.php';
$loader->register();

// Insert custom setup (out-of-tree components and such) here

// Start request processing
$midcom = midcom::get();
$midcom->codeinit();
$midcom->content();
$midcom->finish();
?>
