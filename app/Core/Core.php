<?php

Class Core 
{
    public function run($routes)
    {
        $baseDir = dirname(__DIR__) . '/Controllers/';

        $url = '/';

        isset($_GET['url']) ? $url .= $_GET['url'] : '';

        ($url != '/') ? $url = rtrim($url, '/') : $url;

        $url = strtolower ($url);
        
        $routerFound = false;

        foreach($routes as $path => $controller){
            $pattern = '#^'.preg_replace('/{id}/','(\w+)', $path).'$#';

            if (preg_match($pattern, $url, $matches)){
                array_shift($matches);
                $routerFound = true;
                [$currentController, $action] = explode('@', $controller);
                require_once $baseDir."$currentController.php";
                $newController = new $currentController();
                $newController->$action($matches);
            }
        }

    }
}