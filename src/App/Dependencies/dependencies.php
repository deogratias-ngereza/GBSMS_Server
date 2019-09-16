<?php
// DIC configuration

$container = $app->getContainer();

$container['media_upload_directory'] = __DIR__ . '\..\..\..\public\pods_uploads';
// view renderer -php view
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};


// Register Twig View helper --twig only
$container['view'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    $view = new \Slim\Views\Twig($settings['template_path'], [
        'cache' => false
    ]);
    
    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $c['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new \Slim\Views\TwigExtension($c['router'], $basePath));
    return $view;
};



// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};



// connect to db with Illuminate larvel --multiple connection
$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);
$capsule->addConnection($container['settings']['db2'], 'db2');
$capsule->setAsGlobal();
$capsule->bootEloquent();
/// END connect to db
// to accsess the $capsule with our container from our controllers
$container['db'] = function($container) use ($capsule){
    return $capsule;
};



/*
    CUSTOME ERROR
*/
    /*
$container['errorHandler'] = function ($container) {
    return function ($request, $response, $exception) use ($container) {
        return $container['response']->withStatus(500)
                             ->withHeader('Content-Type', 'text/html')
                             ->write('<h3>-- Something went wrong! --</h3>');
    };
};
*/
// get the app's di-container
//$c = $app->getContainer();
/*$container['phpErrorHandler'] = function ($container) {
    return function ($request, $response, $error) use ($container) {
        return $container['response']
            ->withStatus(500)
            ->withHeader('Content-Type', 'text/html')
            ->write('Something went wrong!');
    };
};
$container['errorHandler'] = function ($container) {
    return function ($request, $response, $exception) use ($container) {
        return $container['response']->withStatus(500)
                             ->withHeader('Content-Type', 'text/html')
                             ->write('<h3>-- Something went wrong! Ask help(grand123grand1@gmail.com) --</h3>');
    };
};*/


?>