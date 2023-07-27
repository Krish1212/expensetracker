<?php

class Router
{
    public function call($route, $file)
    {
        if(!empty($_REQUEST['uri']))
        {
            $route = preg_replace("/(^\/)|(\/$)/","",$route);
            $reqUri =  preg_replace("/(^\/)|(\/$)/","",$_REQUEST['uri']);
        }
        else
        {
            $reqUri = "/";
        }

        if($reqUri == $route )
        {
            //on match include the file.
            include(__DIR__ . "/pages/" . $file);
            //exit because route address matched.
            exit();
        }
    }
    public function pageNotFound()
    {
        //on match include the file.
        include(__DIR__ . "/pages/404.php");
        //exit because route address matched.
        exit();
    }
}

$router = new Router();
$router->call('/', 'dashboard.php');
$router->call('/budget', 'budget.php');
$router->call('/transactions', 'transactions.php');
$router->call('/reports', 'reports.php');
$router->pageNotFound();

?>