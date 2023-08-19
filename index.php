<?php

class Router
{
    private function simpleRoute($file, $route)
    {

        //replacing first and last forward slashes
        //$_REQUEST['uri'] will be empty if req uri is /

        if(!empty($_REQUEST['uri']))
        {
            $route = preg_replace("/(^\/)|(\/$)/","",$route);
            $reqUri =  preg_replace("/(^\/)|(\/$)/","",$_REQUEST['uri']);
        }
        else
        {
            $reqUri = "/";
        }

        if($reqUri == $route)
        {
            $params = [];
            include(__DIR__ . "/pages/" . $file);
            exit();

        }

    }

    public function call($route, $file)
    {
        //will store all the parameters value in this array
        $params = [];

        //will store all the parameters names in this array
        $paramKey = [];

        //finding if there is any {?} parameter in $route
        preg_match_all("/(?<={).+?(?=})/", $route, $paramMatches);

        //if the route does not contain any param call simpleRoute();
        if(empty($paramMatches[0]))
        {
            $this->simpleRoute($file,$route);
            return;
        }

        //setting parameters names
        foreach($paramMatches[0] as $key)
        {
            $paramKey[] = $key;
        }

       
        //replacing first and last forward slashes
        //$_REQUEST['uri'] will be empty if req uri is /

        if(!empty($_REQUEST['uri']))
        {
            $route = preg_replace("/(^\/)|(\/$)/","",$route);
            $reqUri =  preg_replace("/(^\/)|(\/$)/","",$_REQUEST['uri']);
        }
        else
        {
            $reqUri = "/";
        }

        //exploding route address
        $uri = explode("/", $route);

        //will store index number where {?} parameter is required in the $route 
        $indexNum = []; 

        //storing index number, where {?} parameter is required with the help of regex
        foreach($uri as $index => $param)
        {
            if(preg_match("/{.*}/", $param)){
                $indexNum[] = $index;
            }
        }

        //exploding request uri string to array to get
        //the exact index number value of parameter from $_REQUEST['uri']
        $reqUri = explode("/", $reqUri);

        //running for each loop to set the exact index number with reg expression
        //this will help in matching route
        foreach($indexNum as $key => $index)
        {

             //in case if req uri with param index is empty then return
            //because url is not valid for this route
            if(empty($reqUri[$index]))
            {
                return;
            }

            //setting params with params names
            $params[$paramKey[$key]] = $reqUri[$index];

            //this is to create a regex for comparing route address
            $reqUri[$index] = "{.*}";
        }

        //converting array to sting
        $reqUri = implode("/",$reqUri);

        //replace all / with \/ for reg expression
        //regex to match route is ready !
        $reqUri = str_replace("/", '\\/', $reqUri);

        //now matching route with regex
        if(preg_match("/$reqUri/", $route))
        {
            include(__DIR__ . "/pages/" . $file);
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
$router->call('/budget/{type}', 'budget.php');
$router->call('/budget/{year}/{month}', 'budget.php');
$router->call('/budget/{year}/{month}/{type}', 'budget.php');
$router->call('/transactions', 'transactions.php');
$router->call('/transactions/{year}/{month}', 'transactions.php');
$router->call('/reports', 'reports.php');
$router->call('/test', 'test.php');
$router->pageNotFound();

?>