<?php

use Inspirational\config\Database;

function autoloader($classname)
{
	$lastSlash = strpos($classname, '\\');
	$classname = substr($classname, $lastSlash + 1);
	$directory = str_replace('\\', '/', $classname);
	$filename = __DIR__ . '/../../' . $directory . '.php';

	/** @noinspection PhpIncludeInspection */
	require_once $filename;
}

spl_autoload_register('autoloader');

$db = new Database();
