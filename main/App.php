<?php
namespace App\main;

use App\controllers\Controller;
use App\repositories\BankAccountRepository;
use App\repositories\CurrencyRepository;
use App\repositories\OperationLogRepository;
use App\repositories\UserRepository;
use App\services\Auth;
use App\services\ChargeService;
use App\services\CurrencyService;
use App\services\Db;
use App\services\SumService;
use \App\services\TwigRender;

/**
 * Class App
 * @package App\main
 *
 * @property Db $db
 * @property TwigRender $render
 * @property UserRepository $userRepository
 * @property Auth $authService
 * @property BankAccountRepository $bankAccountRepository
 * @property OperationLogRepository $operationLogRepository
 * @property SumService $sumService
 * @property CurrencyService $currencyServices
 * @property CurrencyRepository $currencyRepository
 * @property ChargeService $chargeService
 */
class App
{
    private static $item;

    protected function __construct() {}
    protected function __clone() {}
    protected function __wakeup() {}

    public static function getInstance()
    {
        if (empty(static::$item)) {
            static::$item = new static();
        }
        return static::$item;
    }

    static public function call():App
    {
        return static::getInstance();
    }

    public $config = [];
    private $components = [];

    public function run($config)
    {
        $this->config = $config;
        $this->runController();
    }

    private function runController()
    {
        $request = new \App\services\Request();

        if (! $this->authService->hasAccess($request)) {
            return header('Location: /');
        }

        $controllerName = $request->getControllerName() ?: $this->config['defaultController'];
        $actionName = $request->getActionName();

        $controllerName = 'App\\controllers\\' . ucfirst($controllerName) . 'Controller';

        if (class_exists($controllerName)) {
            $render = App::call()->render;
            $controller = new $controllerName($render, $request, App::call());

            /** @var Controller $controller*/
            $controller->run($actionName);
        } else {
            header('Location: /');
        }
    }

    public function __get(string $name)
    {
        if (array_key_exists($name, $this->components)) {
            return $this->components[$name];
        }

        if (array_key_exists($name, $this->config['components'])) {
            $class = $this->config['components'][$name]['class'];
            if (! class_exists($class)) {
                return null;
            }
            if (array_key_exists('config', $this->config['components'][$name])) {
                $config = $this->config['components'][$name]['config'];
                $component = new $class($config);
            } else {
                $component = new $class();
            }
            $this->components[$name] = $component;
            return $component;
        }
        return null;
    }
}
