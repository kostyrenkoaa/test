<?php
namespace App\controllers;

use App\main\App;
use App\services\TwigRender;
use App\services\Request;

abstract class Controller
{
    private $action;
    protected $request;
    protected $defaultAction = 'index';

    /**
     * @var TwigRender;
     */
    protected $render;
    /**
     * @var App
     */
    protected $app;

    public function __construct(TwigRender $render, Request $request, App $app)
    {
        $this->request = $request;
        $this->render = $render;
        $this->app = $app;
    }

    public function run($action)
    {
        $this->action = $action ?: $this->defaultAction;
        $method = $this->action . 'Action';
        if (method_exists($this, $method)) {
            $this->$method();
        } else {
            $this->redirect('/');
        }
    }

    public function render($template, $params = [])
    {
        return $this->render->render($template, $params);
    }

    protected function getId()
    {
        return (int)$this->request->getParams('get', 'id');
    }

    public function redirect($path = '')
    {
        if (empty($path)) {
            $path = $_SERVER['HTTP_REFERER'];
        }
        return header('Location: ' . $path);
    }

    protected function isPost()
    {
        return $this->request->getRequestMethod() == "POST";
    }
}
