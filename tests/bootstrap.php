<?php

$am = \AspectMock\Kernel::getInstance();
$am->init([
	"debug" => true,
	"includePaths" => [__DIR__ . "/../src", __DIR__ . "/../vendor/guzzlehttp",  __DIR__ . "/../vendor/egulias"],
	"cacheDir"  => sys_get_temp_dir() . "/viva-php"
]);