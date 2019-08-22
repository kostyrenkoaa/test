<?php
namespace App\services;

class Request
{
    private $requestString;
    private $controllerName;
    private $actionName;
    private $params;

    public function __construct()
    {
        session_start();
        $this->requestString = $_SERVER['REQUEST_URI'];
        $this->parseRequest();
    }

    /**
     * @return mixed
     */
    public function getRequestString()
    {
        return $this->requestString;
    }

    /**
     * @return mixed
     */
    public function getControllerName()
    {
        return $this->controllerName;
    }

    /**
     * @return mixed
     */
    public function getActionName()
    {
        return $this->actionName;
    }

    /**
     * @param string $method
     * @param string $key
     * @return array|null
     */
    public function getParams(string $method, $key = '')
    {
        if (empty($key)) {
            return $this->params[$method];
        }
        return array_key_exists($key, $this->params[$method])
            ? $this->params[$method][$key]
            : null;
    }

    public function parseRequest()
    {
        $pattern = "#(?P<controller>\w+)[/]?(?P<action>\w+)?[/]?[?]?(?P<params>.*)#ui";
        $this->params['post'] = $_POST;
        $this->params['get'] = $_GET;
        if (preg_match_all($pattern, $this->requestString, $matches)) {
            $this->controllerName = $matches['controller'][0];
            $this->actionName = $matches['action'][0];
        }
    }

    public function setSession($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function getSession($key = '')
    {
        if (empty($key)) {
            return $_SESSION;
        }

        return array_key_exists($key, $_SESSION)
            ? $_SESSION[$key]
            : [];
    }

    public function getRequestMethod()
    {
        return $_SERVER["REQUEST_METHOD"];
    }

    public function sessionWriteClose()
    {
        session_write_close();
    }
}