<?php

namespace app\controllers;

class HomeController
{
    /**
     * pagina principal de bienvenida
     */
    public function index(): void
    {
        global $blade;
        echo $blade->render('home');
    }
}
