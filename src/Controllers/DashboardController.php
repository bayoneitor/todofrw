<?php

namespace App\Controllers;

use App\Controller;
use App\Request;
use App\View;
use App\Model;
use App\Session;
use App\Tasks;

final class DashboardController extends Controller implements View, Model
{
    public function __construct(Request $request, Session $session)
    {
        parent::__construct($request, $session);
    }
    public function index()
    {
        $web = BASE;

        if (!isset($_SESSION["user"])) {
            header('Location: ' . $web);
        } else {
            $uname = null;
            $email = null;
            $id = null;
            Session::defaultSess($uname, $email, $id);
            $tasks = new Tasks;
            $tasks = $tasks->selectAllTasksUser($id);
            $dataview = ['title' => "Tareas", 'controller' => "dashboard", 'web' => $web, 'uname' => "$uname", 'email' => "$email", 'tasks' => $tasks, 'action' => 'default', 'css' => 'dashboard'];
            $this->render($dataview, 'dashboard');
        }
    }
    public function add()
    {
        $web = BASE;

        if (!isset($_SESSION["user"])) {
            header('Location: ' . $web . '');
        } else {
            $uname = null;
            $email = null;
            $id = null;
            Session::defaultSess($uname, $email, $id);
            $tasks = new Tasks;
            $tasks = $tasks->selectAllTasksUser($id);
            $dataview = ['title' => "Tareas", 'controller' => "dashboard", 'web' => $web, 'uname' => "$uname", 'email' => "$email", 'tasks' => $tasks, 'action' => 'add', 'css' => 'dashboard'];
            $this->render($dataview, 'dashboard');
        }
    }
    public function remove()
    {
        $web = BASE;

        if (!isset($_SESSION["user"])) {
            header('Location: ' . $web . '');
        } else {
            $uname = null;
            $email = null;
            $id = null;
            Session::defaultSess($uname, $email, $id);
            $params = $this->request->getParams();
            $idTask = $params['id'];
            $tasks = new Tasks;

            $tasks = $tasks->selectOneUserTask($idTask);
            $dataview = ['title' => "Tareas", 'controller' => "dashboard", 'web' => $web, 'uname' => "$uname", 'email' => "$email", 'tasks' => $tasks, 'action' => 'remove', 'css' => 'dashboard', 'idTask' => $idTask];
            $this->render($dataview, 'dashboard');
        }
    }
    public function edit()
    {
        $web = BASE;

        if (!isset($_SESSION["user"])) {
            header('Location: ' . $web . '');
        } else {
            $uname = null;
            $email = null;
            $id = null;
            Session::defaultSess($uname, $email, $id);
            $tasks = new Tasks;
            $params = $this->request->getParams();
            $idTask = $params['id'];
            $tasks = $tasks->selectOneUserTask($idTask);
            $dataview = ['title' => "Tareas", 'controller' => "dashboard", 'web' => $web, 'uname' => "$uname", 'email' => "$email", 'tasks' => $tasks, 'action' => 'edit', 'css' => 'dashboard', 'idTask' => $idTask];
            $this->render($dataview, 'dashboard');
        }
    }
    public function action()
    {
        $web = BASE;

        if (!isset($_SESSION["user"])) {
            header('Location: ' . $web . '');
        } else {
            $uname = null;
            $email = null;
            $id = null;
            Session::defaultSess($uname, $email, $idUser);
            $db = $this->getDB();
            if ($db) {
                $task = new Tasks;
                //Miramos si ha entrado por el boton de añadit o actualizar, ya que al final lo que cambia es el sql lo demás igual
                if (isset($_POST['add-button']) || isset($_POST['edit-button'])) {
                    // Miramos que ninguno este vacio
                    if (filter_input(INPUT_POST, 'description') != null || filter_input(INPUT_POST, 'date') != null) {
                        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
                        $date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_SPECIAL_CHARS);

                        //Miramos si es el boton de añadir, si es así le hacemos un inser si no, miramos que sea el de editar
                        if (isset($_POST['add-button'])) {
                            //FUNCION TASKS
                            $sql = $task->insertTask($description, $idUser, $date);
                        } else if (isset($_POST['edit-button'])) {
                            $idTask = filter_input(INPUT_POST, 'idTask', FILTER_SANITIZE_SPECIAL_CHARS);
                            //FUNCION TASKS
                            $sql = $task->updateTask($description, $date, $idTask, $idUser);
                        }

                        if ($sql) {
                            header('Location: ' . $web . 'dashboard#error');
                        } else {
                            header('Location: ' . $web . 'dashboard#success');
                        }
                    }
                    //Miramos si ha entrado por enlace y si es así miramos que sea el de delete y que tenga el id
                } else if (isset($_POST['remove-button'])) {
                    if (filter_input(INPUT_POST, 'idTask') != null) {
                        $idTask = filter_input(INPUT_POST, 'idTask', FILTER_SANITIZE_SPECIAL_CHARS);

                        $sql = $task->deleteTask($idTask, $idUser);

                        if ($sql) {
                            header('Location: ' . $web . 'dashboard#error');
                        } else {
                            header('Location: ' . $web . 'dashboard#success');
                        }
                    } else {
                        header('Location: ' . $web . 'dashboard#error');
                    }
                } else {
                    header('Location: ' . $web . 'dashboard#error');
                }
            } else {
                header('Location: ' . $web . 'dashboard');
            }
        }
    }
}
