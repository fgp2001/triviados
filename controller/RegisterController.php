<?php

class RegisterController
{
    private $model;
    private $view;

    public function __construct($model, $view)
    {
        $this->model = $model;
        $this->view = $view;
    }
    function show(){
        $this->view->render("Register");
    }
}