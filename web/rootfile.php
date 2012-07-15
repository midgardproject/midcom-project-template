<?php
define('OPENPSA2_THEME_ROOT', __DIR__ . '/../themes/');
define('MIDCOM_ROOT', __DIR__ . '/../vendor/openpsa/midcom/lib');
define('OPENPSA2_PREFIX', '/');

header('Content-Type: text/html; charset=utf-8');

$GLOBALS['midcom_config_local'] = array();
$GLOBALS['midcom_config_local']['person_class'] = 'openpsa_person';

//This file you have to provide
include '../config.inc.php';

// Include the MidCOM environment
require MIDCOM_ROOT . '/midcom.php';

$loader = require '../vendor/autoload.php';
$loader->register();

// Insert custom setup (out-of-tree components and such) here

// Start request processing
$midcom = midcom::get();
$midcom->codeinit();
$midcom->content();
$midcom->finish();
?>