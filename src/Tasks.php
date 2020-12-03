<?php

namespace App;

use App\Controller;

class Tasks extends Controller
{
    public function __construct()
    {
    }
    public function selectAllTasksUser($idUser)
    {
        $db = $this->getDB();
        if ($db) {
            return $db->selectWhereWithJoin('task', 'users', ['task.id', 'task.description', 'task.due_date'], 'user', 'id', ['task.user', $idUser]);
        }
    }
    public function selectOneUserTask($idTask)
    {
        $db = $this->getDB();
        if ($db) {
            //Se podria mejorar el WHERE por que solo tiene un parametro y no mira el user
            return $db->selectWhereWithJoin('task', 'users', ['task.id', 'task.description', 'task.due_date'], 'user', 'id', ['task.id', $idTask]);
        }
    }
    public function insertTask($description, $id, $date)
    {
        $db = $this->getDB();
        if ($db) {
            $db->insert('task', ['description' => $description, 'user' => $id, 'due_date' => $date]);
        }
    }
    public function updateTask($description, $date, $idTask, $idUser)
    {
        $db = $this->getDB();
        if ($db) {
            $db->update('task', ['description' => $description, 'due_date' => $date], ["id" => $idTask, "user" => $idUser]);
        }
    }
    public function deleteTask($idTask, $idUser)
    {
        $db = $this->getDB();
        if ($db) {
            $db->delete('task', ["id" => $idTask, "user" => $idUser]);
        }
    }
}
