<?php
/**
 * api.php
 *
 * Copyright 2003-2013, Moxiecode Systems AB, All rights reserved.
 */
error_reporting(E_ALL);
ini_set('display_errors',true);
ini_set('html_errors',true);
ini_set('error_reporting',E_ALL ^ E_NOTICE);
require_once('./classes/MOXMAN.php');

define("MOXMAN_API_FILE", __FILE__);

$context = MOXMAN_Http_Context::getCurrent();
$pluginManager = MOXMAN::getPluginManager();
foreach ($pluginManager->getAll() as $plugin) {
	if ($plugin instanceof MOXMAN_Http_IHandler) {
		$plugin->processRequest($context);
	}
}
