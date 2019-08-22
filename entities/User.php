<?php
namespace App\entities;

/**
 * Class User
 * @package App\models
 */
class User extends Entity
{
    /**@var string*/
    public $id;

    /**@var string*/
    public $login;

    /**@var string*/
    public $password;

    /**@var string*/
    public $sol;

    /**@var string*/
    public $token;
}
