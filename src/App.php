<?php

namespace App;

use App\Request;
use Exception;

final class App
{
    static protected $action;
    static protected $req;
    static protected $session;
    public static function run()
    {
        self::$session = new Session();
        $routes = self::getRoutes();
        //Obtener tres parámetros: controlador, accion, [parametros]
        //url friendly: http://app/controlador/accion/param1/val1/param2/val2
        self::$req = new Request;

        $controller = self::$req->getController();
        self::$action = self::$req->getAction();
        self::dispatch($controller, $routes);
    }

    private static function dispatch(String $controller, array $routes): void
    {
        try {
            if (in_array($controller, $routes)) {
                //nombre del controlador
                //instancia del controlador
                //llamada a la funcion accion
                //dispatcher
                $nameController = '\\App\Controllers\\' . ucfirst($controller) . 'Controller';
                $objContr = new $nameController(self::$req, self::$session);
                //Comprobar si existe la acción metodo en el objeto
                if (is_callable([$objContr, self::$action])) {
                    call_user_func([$objContr, self::$action]);
                } else {
                    call_user_func([$objContr, 'error']);
                }
            } else {
                throw new Exception("Ruta no disponible");
            }
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }
    /**
     * @return array
     * return registered route array
     */
    static function getRoutes()
    {
        $dir = __DIR__ . '/Controllers';
        $handle = opendir($dir);
        while (($entry = readdir($handle)) != false) {
            if ($entry != "." && $entry != "..") {
                $routes[] = strtolower(substr($entry, 0, -14));
            }
        }
        return $routes;
    }
}
