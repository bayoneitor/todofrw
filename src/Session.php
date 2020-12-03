<?php

namespace App;

final class Session
{
    protected $id;

    public function __construct()
    {
        $status = session_status();
        if ($status == PHP_SESSION_DISABLED) {
            throw new \LogicException('Sessions are disabled.');
        }
        if ($status == PHP_SESSION_NONE) {
            session_start();
            $this->id = session_id();
        }
    }
    public static function
    defaultSess(&$uname = null, &$email = null, &$id = null)
    {
        if (self::exists('user')) {
            $uname = $_SESSION["user"][0];
            $email = $_SESSION["user"][1];
            $id = $_SESSION["user"][2];
        }
    }
    public function get($key)
    {
        if (array_key_exists($key, $_SESSION)) {
            return $_SESSION[$key];
        }
        return null;
    }
    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }
    public function delete($key)
    {
        if (array_key_exists($key, $_SESSION)) {
            unset($_SESSION[$key]);
            return true;
        }
        return false;
    }
    public function exists($key)
    {
        return array_key_exists($key, $_SESSION);
    }
    public static function logout()
    {
        session_unset();
        session_destroy();

        setcookie("email", ' ', time() - 1, BASE);
    }
    //Falta session destroy
}
