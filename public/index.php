<?php

/* find the time zone of the country u are looking for */
ini_set('date.timezone', 'Africa/Nairobi');
/*
error_reporting(-1);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);*/




if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

require __DIR__ . '/../vendor/autoload.php';

session_start();
// Instantiate the app
$settings = require __DIR__ . '/../src/App/Settings/settings.php';
$app = new \Slim\App($settings);


// Set up dependencies
require __DIR__ . '/../src/App/Dependencies/dependencies.php';

// Register middleware
require __DIR__ . '/../src/App/Middlewares/middlewares.php';
require __DIR__ . '/../src/App/Middlewares/op-mob-middlewares.php';
require __DIR__ . '/../src/App/Middlewares/cust-mob-middlewares.php';

require __DIR__ . '/../src/App/Middlewares/gateway-sms-api.php';
 
// Register routes
require __DIR__ . '/../src/App/Routes/routes.php';




// Run app
$app->run();


