<?php 

require_once __DIR__.'/vendor/autoload.php';

$app = new Silex\Application();
$config = require_once __DIR__ . '/app/config/app.php';
$database = require_once __DIR__ . '/app/config/database.php';

date_default_timezone_set($config['timezone']);

$app['debug'] = $config['debug'];

$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/view',
));

$app->register(new Silex\Provider\DoctrineServiceProvider, array(
    "db.options" => $database,
));

$app->register(new Dflydev\Silex\Provider\DoctrineOrm\DoctrineOrmServiceProvider, array(
    'orm.proxies_dir' => sys_get_temp_dir() . '/' . md5(__DIR__ . getenv('APPLICATION_ENV')),
    'orm.em.options' => array(
        'mappings' => array(
            array(
                'type' => 'annotation',
                'namespace' => 'Model\Entities',
                'path' => __DIR__ . '/app/Model/Entities',
                'use_simple_annotation_reader' => false,
            )
        )
    ),
));

$routes = require_once __DIR__ . '/app/routes.php';

foreach($routes as $name => $route) {
    $app->mount($route['pattern'], new $route['controller']);
}