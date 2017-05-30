<?php

function dd()
{
	echo '<pre>';
	array_map(function ($x) {
		print_r($x);
	}, func_get_args());
		die;
}


define('PROJECT_URL', 'http://icover-task-custom.local/');

define('PROJECT_ROOT', __DIR__);

define('ASSETS_ROOT', PROJECT_URL.'assets');

define('VIEW_ROOT', PROJECT_ROOT . DIRECTORY_SEPARATOR . 'src'. DIRECTORY_SEPARATOR . 'Views');