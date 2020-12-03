<?php

namespace App\Controllers;

use App\Controller;
use App\Request;
use App\Session;

final class IndexController extends Controller
{
    public function __construct(Request $request, Session $session)
    {
        parent::__construct($request, $session);
    }
    public function index()
    {
        $uname = null;
        $email = null;
        $id = null;
        Session::defaultSess($uname, $email, $id);

        $dataview = ['title' => "Todo List", 'controller' => "index", 'web' => BASE];
        if ($uname != null) {
            $dataview += ['uname' => "$uname", 'email' => "$email"];
        }
        $this->render($dataview, 'index');
    }
}
