<?php

require_once __DIR__.'/../bootstrap.php';

if($env === 'development') {
	$app->run();
} else {
	$app['http_cache']->run();
}

