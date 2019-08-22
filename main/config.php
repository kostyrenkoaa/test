<?php
return [
    'name' => 'Тестовый я',
    'defaultController' => 'home',

    'components' => [
        'db' => [
            'class' => \App\services\Db::class,
            'config' => [
                'driver' => 'mysql',
                'db' => 'testw',
                'host' => 'localhost',
                'user' => 'homestead',
                'password' => 'secret',
                'charset' => 'utf8'
            ]
        ],
        'render' => [
            'class' => \App\services\TwigRender::class
        ],
        'userRepository' => [
            'class' => \App\repositories\UserRepository::class
        ],
        'bankAccountRepository' => [
            'class' => \App\repositories\BankAccountRepository::class
        ],
        'operationLogRepository' => [
            'class' => \App\repositories\OperationLogRepository::class
        ],
        'authService' => [
            'class' => \App\services\Auth::class
        ],
        'sumService' => [
            'class' => \App\services\SumService::class
        ],
        'currencyServices' => [
            'class' => \App\services\CurrencyService::class
        ],
        'currencyRepository' => [
            'class' => \App\repositories\CurrencyRepository::class
        ],
        'chargeService' => [
            'class' => \App\services\ChargeService::class
        ],
    ],
];