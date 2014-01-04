<?php

try {
	$config = new Phalcon\Config\Adapter\Ini(__DIR__ . '/app/config/config.ini');

	//Register an autoloader
	$loader = new \Phalcon\Loader();
	$loader->registerDirs(
		array(
		    __DIR__ . $config->application->controllersDir,
		    __DIR__ . $config->application->modelsDir,
		    __DIR__ . $config->application->componentsDir,
		    __DIR__ . $config->application->pluginsDir,
		    __DIR__ . $config->application->cashiersDir,
		)
	)->register();

	//Create a DI
	$di = new Phalcon\DI\FactoryDefault();

	$di->set("router", function() {
		require __DIR__ . '/app/config/routes.php';
		return $router;
	});

	//Set the database service
	$di->set('db', function() use ($config) {
		return new \Phalcon\Db\Adapter\Pdo\Mysql(array(
		    "host" => $config->mysql->host,
		    "username" => $config->mysql->username,
		    "password" => $config->mysql->password,
		    "dbname" => $config->mysql->name,
		));
	});

    //Set the mongo service
    $di->set('mongo', function() use ($config) {
        $mongo = new Mongo($config->mongo->cstr);
        return $mongo->selectDb($config->mongo->db);
    });

    //Set collection manager
    $di->set('collectionManager', function() {
        $modelsManager = new Phalcon\Mvc\Collection\Manager();
        return $modelsManager;
    });

	//Setting up the view component
	$di->set('view', function() {
		$view = new \Phalcon\Mvc\View();
		$view->setViewsDir('app/views/');
		return $view;
	});

	//Handle the request
	$application = new \Phalcon\Mvc\Application();
	$application->setDI($di);
	echo $application->handle()->getContent();
} catch (\Phalcon\Exception $e) {
	echo "PhalconException: ", $e->getMessage();
}
