<?php
namespace App\services;

use App\main\App;
use App\entities\User;

class Auth
{
    private $app;

    public function __construct()
    {
        $this->app = App::call();
    }

    /**
     * Вход в систему
     *
     * @param Request $request
     * @return array
     */
    public function login(Request $request)
    {
        $params = $request->getParams('post', 'auth');

        $errors = [
            'error' => 'Не верный логин или пароль.',
            'login' => $params['login']
        ];
        $user = $this->app->userRepository->getUserByLogin($params['login']);
        if (empty($user)) {
            return $errors;
        }

        $verify = password_verify($params['password'] . $user->sol, $user->password);

        if (!$verify) {
            return $errors;
        }

        $token = $this->createToken($user);
        $request->setSession('token', $token);
        $request->setSession('userId', $user->id);

        return [];
    }

    /**
     * Создает токен
     *
     * @param User $user
     * @return string
     */
    private function createToken(User $user)
    {
        $token = md5(uniqid(substr($user->sol, 0,5)));
        $user->token = $token;
        $this->app->userRepository->save($user);
        return $token;
    }

    /**
     * Проверка валидности токена
     *
     * @param $token
     * @return User|null
     */
    public function getUserByToken($token)
    {
        $user = $this->app->userRepository->getUserByToken($token);
        return $user;
    }

    /**
     * Проверка доступа
     *
     * @param Request $request
     * @return bool
     */
    public function hasAccess(Request $request)
    {
        if (empty($request->getControllerName())) {
            return true;
        }

        $token = $request->getSession('token');
        if (empty($token)) {
            return false;
        }

        $user = $this->getUserByToken($token);
        if (empty($user)) {
            return false;
        }

        return true;
    }

    /**
     * Выход из системы
     *
     * @param Request $request
     */
    public function logout(Request $request)
    {
        $token = $request->getSession('token');

        $userRepository = $this->app->userRepository;
        $user = $userRepository->getUserByToken($token);

        if (empty($user)) {
            return;
        }

        $user->token = '';
        $userRepository->save($user);
    }
}
