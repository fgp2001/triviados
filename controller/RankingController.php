<?php

class RankingController
{
    private $model;
    private $view;

    public function __construct($model, $view){
        $this->model = $model;
        $this->view = $view;
    }


    public function show() {
        $rankingPuntaje = $this->model->obtenerRankingPorPuntaje();

        $this->view->render("Ranking", [
            'ranking_puntaje' => $rankingPuntaje
        ]);
        }
}