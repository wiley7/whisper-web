<?php
$noauth = true;
if($_SERVER['PHP_AUTH_USER']=='icyleaf' && $_SERVER['PHP_AUTH_PW']=='kakawei'){
    $noauth = false;
}
if ($noauth){
    header("WWW-Authenticate: Basic realm=\"Login\"");
    header("HTTP/1.0 401 Unauthorized");
    echo <<<EOB
                <html><body>
                <h1>拒绝访问!</h1>
            <big><a href='$PHP_SELF'>登录</a></big>
                </body></html>
EOB;
    exit;
}


try {
	$config = new Phalcon\Config\Adapter\Ini(__DIR__ . '/app/config/config.ini');

	//Register an autoloader
	$loader = new \Phalcon\Loader();
	$loader->registerDirs(
		array(
		    __DIR__ . $config->application->controllersDir,
		    __DIR__ . $config->application->modelsDir,
		)
	)->register();

	//Create a DI
	$di = new Phalcon\DI\FactoryDefault();

	$di->set("router", function() {
		require __DIR__ . '/app/config/routes.php';
		return $router;
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
