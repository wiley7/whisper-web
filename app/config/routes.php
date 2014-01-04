<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 *
 * @author xiaochao@playcrab.com
 */
$router = new \Phalcon\Mvc\Router();

$router->add("/:controller/:action/", array(
    "controller" => 1,
    "action" => 2,
));

//echo $router->getControllerName();
//echo $router->getActionName();
//$res = $router->getParams();
//var_dump($res);
return $router;
