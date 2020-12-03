<?php

namespace App\Controllers;

use App\Controller;
use App\Request;
use App\View;
use App\Model;
use App\User;
use App\Session;

final class UserController extends Controller implements View, Model
{
    public function __construct(Request $request, Session $session)
    {
        parent::__construct($request, $session);
    }
    public function index()
    {
        $web = BASE;
        if (!isset($_SESSION["user"])) {
            header('Location: ' . $web . '');
        } else {
            $uname = null;
            $email = null;
            $id = null;
            Session::defaultSess($uname, $email, $id);

            $dataview = ['title' => "Usuario", 'controller' => "index", 'web' => BASE, 'uname' => "$uname", 'email' => "$email"];
            $this->render($dataview, 'user');
        }
    }
    public function login()
    {
        $web = BASE;
        if (isset($_SESSION["user"])) {
            header('Location: ' . $web . '');
        } else {
            $dataview = ['title' => "Login", 'controller' => 'login', 'web' => $web];
            $this->render($dataview, 'login');
        }
    }
    public function register()
    {
        $web = BASE;
        if (isset($_SESSION["user"])) {
            header('Location: ' . $web . '');
        } else {
            $dataview = ['title' => "Register", 'controller' => 'register', 'web' => $web];
            $this->render($dataview, 'register');
        }
    }
    public function logout()
    {
        Session::logout();
        $web = BASE;
        header('Location: ' . $web . '');
    }
    public function logaction()
    {
        $web = BASE;
        //Primero miramos que no este la session definida
        if (!isset($_SESSION["user"])) {
            //Miramos si viene por login y si viene por cookie le damos otros parametros arriba
            if (isset($_POST['login-button'])) {
                // Miramos que ninguno este vacio
                if (filter_input(INPUT_POST, 'inputEmail') != null || filter_input(INPUT_POST, 'inputPassword') != null) {

                    $email = filter_input(INPUT_POST, 'inputEmail', FILTER_SANITIZE_SPECIAL_CHARS);
                    $pwd = filter_input(INPUT_POST, 'inputPassword', FILTER_SANITIZE_SPECIAL_CHARS);
                    $db = $this->getDB();
                    if ($db) {
                        //Selecciona el email
                        $userDB = new User();
                        $log = $userDB->auth($db, $email, $pwd);

                        if ($log == true) {
                            if (isset($_POST['remember-me'])) {
                                //Recordamos el email
                                setcookie("email", $email, time() + 60 * 60 * 24 * 365, $web);
                            } else {
                                setcookie("email", "", time() - 1, $web);
                            }
                            header('Location: ' . $web . 'index#success');
                        } else {
                            header('Location: ' . $web . 'user/login#error=notExists');
                        }
                    } else {
                        //Error conexion BD
                        header('Location: ' . $web . 'user/login#error=db');
                    }
                } else {
                    //Elementos vacios
                    header('Location: ' . $web . 'user/login#error=emptyfields');
                }
            } else {
                header('Location: ' . $web . '');
            }
        } else {
            header('Location: ' . $web . '');
        }
    }

    public function regaction()
    {
        $web = BASE;
        if (!isset($_SESSION["user"])) {
            //Miramos si entrar por el boton register
            if (isset($_POST['register-button'])) {
                // Miramos que ninguno este vacio
                if (
                    filter_input(INPUT_POST, 'inputUser') != null &&
                    filter_input(INPUT_POST, 'inputEmail') != null &&
                    filter_input(INPUT_POST, 'inputPassword') != null
                ) {
                    $db = $this->getDB();
                    if ($db) {

                        $user = filter_input(INPUT_POST, 'inputUser', FILTER_SANITIZE_SPECIAL_CHARS);
                        $email = filter_input(INPUT_POST, 'inputEmail', FILTER_SANITIZE_SPECIAL_CHARS);
                        $pwd = filter_input(INPUT_POST, 'inputPassword', FILTER_SANITIZE_SPECIAL_CHARS);

                        $userDB = new User();
                        $insert = $userDB->newUser($pwd, $user, $email);

                        if ($insert) {
                            header('Location: ' . $web . 'login#success');
                        } else {
                            header('Location: ' . $web . 'register#error=insert');
                        }
                    } else {
                        //Error conexion BD
                        header('Location: ' . $web . 'register#error=db');
                    }
                } else {
                    //error vacio
                    header('Location: ' . $web . 'register#error=emptyfields');
                }
            } else {
                header('Location: ' . $web . '');
            }
        } else {
            header('Location: ' . $web . '');
        }
    }
}
