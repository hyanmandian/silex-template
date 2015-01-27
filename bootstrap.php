<?php 

require_once __DIR__.'/vendor/autoload.php';

$app = new Silex\Application();

$env = getenv('APP_ENV');

$app->register(new Igorw\Silex\ConfigServiceProvider(__DIR__."/app/config/" . $env . ".php"));
$app->register(new Igorw\Silex\ConfigServiceProvider(__DIR__."/app/routes.php"));

date_default_timezone_set($app['config']['timezone']);

$app['debug'] = $app['config']['debug'];

$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

$app->register(new Silex\Provider\SessionServiceProvider());

$app->register(new Silex\Provider\SwiftmailerServiceProvider(), array(
    'swiftmailer.options' => $app['config']['mail'],
));

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/app/view',
    'twig.options' => array(
        'cache' => __DIR__.'/app/storage/cache',
    ),
));

$app->register(new Silex\Provider\HttpCacheServiceProvider(), array(
    'http_cache.cache_dir' => __DIR__.'/app/storage/cache/',
));

$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => __DIR__.'/app/storage/log/application.log',
));

$app->register(new Silex\Provider\DoctrineServiceProvider, array(
    "db.options" => $app['config']['database'],
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

foreach($app['router'] as $name => $route) {
    $app->mount($route['pattern'], new $route['controller']);
}