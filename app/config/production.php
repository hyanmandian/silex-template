<?php

return array(
	'config' => array(
		'debug' => TRUE,
		'charset' => 'UTF-8',
		'locale' => 'pt-BR',
		'timezone' => 'America/Sao_Paulo',
		'database'  =>  array(
			'driver' => 'pdo_mysql',
			'host' => 'localhost',
			'dbname' => 'cms',
			'user' => 'root',
			'password'  =>  '',
			'port' => 3306,
		),
		'mail' => array(
	    	'host' => 'smtp.gmail.com',
		    'port' => '465',
		    'username' => 'email@gmail.com',
		    'password' => 'senha',
		    'encryption' => 'ssl',
		    'auth_mode' => 'login',
		),
	),
);