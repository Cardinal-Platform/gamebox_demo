<?php

class Router
{
    private static $routerTable = array(
        'GET' => array('NotFound' => 'NotFound/index'),
        'POST' => array('NotFound' => 'NotFound/index'),
    );

    private $urlPath;
    private $handlerFile;
    private $handlerMethod;

    public function __construct()
    {
        $this->pathProcessor();
        // include the file.
        require_once('../handler/Handler.php');
        require_once('../handler/' . $this->handlerFile . '.php');

        $handler = new $this->handlerFile();
        $handler->{$this->handlerMethod}();
    }

    public static function GET(string $path, string $handler)
    {
        $path = trim($path, '/');
        self::$routerTable['GET'][$path] = $handler;
    }

    public static function POST(string $path, string $handler)
    {
        $path = trim($path, '/');
        self::$routerTable['POST'][$path] = $handler;
    }

    private function pathProcessor()
    {
        $urlPathInfo = @explode('/', $_SERVER['PATH_INFO']);
        $this->urlPath = @$urlPathInfo[1];
        if ($this->urlPath == null) {
            // default handler
            $this->urlPath = '';
        }

        $requestMethod = $_SERVER['REQUEST_METHOD'];

        // check the router table
        if (!isset(self::$routerTable[$requestMethod][$this->urlPath])) {
            $this->urlPath = 'NotFound';
        }

        $route = explode('/', self::$routerTable[$requestMethod][$this->urlPath]);
        $this->handlerFile = $route[0];
        $this->handlerMethod = $route[1];
    }
}