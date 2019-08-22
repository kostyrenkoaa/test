<?php
namespace App\controllers;

use App\main\App;

/**
 * Class HomeController Отвечает за авторизацию пользователя и его выход из сессии
 * @package App\controllers
 */
class HomeController extends Controller
{
    /**
     * Авторизация пользователя
     */
    public function indexAction()
    {
        $form = [];
        if ($this->isPost()) {
            $form = $this->app->authService->login($this->request);
            if (empty($form)) {
                return $this->redirect('/office');
            }
        }

        $params = [
            'form' => $form,
        ];

        echo $this->render('home', $params);
    }

    /**
     * Выход пользователя
     */
    public function logoutAction()
    {
        $this->app->authService->logout($this->request);
        return $this->redirect('/');
    }
}
