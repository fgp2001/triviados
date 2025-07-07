<?php

require_once("libs/jpgraph/src/jpgraph.php");
require_once("libs/jpgraph/src/jpgraph_bar.php");
require_once ("libs/jpgraph/src/jpgraph_line.php");

class DashboardController{
    private $model;
    private $view;

    public function __construct($model, $view){
        $this->model = $model;
        $this->view = $view;
    }
    public function graficarPartidasTotalesPorPeriodo() {
        $this->renderGraficoPorPeriodo('obtenerPartidasTotalesPorPeriodo', 'Partidas totales');
    }
    public function graficarUsuariosTotalesPorPeriodo() {
        $this->renderGraficoPorPeriodo('obtenerUsuariosTotalesPorPeriodo', 'Usuarios totales');
    }
    public function graficarPreguntasTotalesPorPeriodo() {
        $this->renderGraficoPorPeriodo('obtenerPreguntasTotalesPorPeriodo', 'Preguntas totales');
    }
    public function graficarPorcentajeDePreguntasCorrectasPorUsuarioPorPeriodo(){
        $this->renderGraficoPorCategoriaPorPeriodo('obtenerPorcentajeDePreguntasCorrectasPorUsuarioPorPeriodo', 'nombre_usuario', 'porcentaje_correctas',"Porcentaje de preguntas correctar por Usuario");
    }
    public function graficarCantidadDeUsuariosPorPaisPorPeriodo(){
        $this->renderGraficoPorCategoriaPorPeriodo('obtenerCantidadDeUsuariosPorPaisPorPeriodo', 'pais', 'cantidad',"Usuarios por pais");

    }
    public function graficarCantidadDeUsuariosPorSexoPorPeriodo(){
        $this->renderGraficoPorCategoriaPorPeriodo('obtenerCantidadDeUsuariosPorSexoPorPeriodo', 'sexo', 'cantidad',"Usuarios por sexo");
    }
    public function graficarCantidadDeUsuariosPorGrupoDeEdadPorPeriodo(){
        $this->renderGraficoPorCategoriaPorPeriodo('obtenerCantidadDeUsuariosPorGrupoDeEdadPorPeriodo', 'grupo_edad', 'cantidad',"Usuarios por grupo de edad");
    }
    private function renderGraficoPorPeriodo($metodoModelo, $titulo) {
        $periodo = $_GET['periodo'] ?? 'mes';
        $datos = $this->model->$metodoModelo($periodo);
        $this->graficar($datos, "$titulo por $periodo");
    }
    private function renderGraficoPorCategoriaPorPeriodo($metodoModelo, $colCategoria, $colValor, $titulo) {
        $periodo = $_GET['periodo'] ?? 'mes';
        $datos = $this->model->$metodoModelo($periodo);
        $this->graficar2($datos, $colCategoria, $colValor, "$titulo por $periodo");
    }
    private function graficar($datos, $titulo){
        $fechas = [];
        $totales = [];
        foreach ($datos as $dato) {
            $fechas[] = $dato['formato'];
            $totales[] = (int)$dato['total'];
        }

        $maxValor = max($totales);
        $graph = new Graph(600, 400);
        $graph->SetScale("textlin");
        $graph->title->Set($titulo);
        $graph->yaxis->scale->SetAutoMax($maxValor * 1.2);

        $graph->xaxis->SetTickLabels($fechas);
        $graph->xaxis->SetLabelAngle(50);

        $barplot = new BarPlot($totales);
        $graph->Add($barplot);

        $graph->Stroke();
    }
    private function graficar2($datos, $colCategoria, $colValor, $titulo){
        $periodos = [];
        $valoresPorCategoria = [];

        foreach ($datos as $dato) {
            $categoria = $dato[$colCategoria];
            $periodo = $dato['formato'];
            $valor = floatval($dato[$colValor]);

            if (!in_array($periodo, $periodos)) {
                $periodos[] = $periodo;
            }

            if (!isset($valoresPorCategoria[$categoria])) {
                $valoresPorCategoria[$categoria] = [];
            }

            $valoresPorCategoria[$categoria][$periodo] = $valor;
        }

        foreach ($valoresPorCategoria as $categoria => &$valores) {
            foreach ($periodos as $periodo) {
                if (!isset($valores[$periodo])) {
                    $valores[$periodo] = 0;
                }
            }
            ksort($valores);
        }

        $maxValor = 0;
        foreach ($valoresPorCategoria as $valores) {
            $maxEnCategoria = max($valores);
            if ($maxEnCategoria > $maxValor) {
                $maxValor = $maxEnCategoria;
            }
        }

        $graph = new Graph(600, 400);
        $graph->SetScale("textlin");
        $graph->title->Set($titulo);
        $graph->xaxis->SetTickLabels($periodos);
        $graph->xaxis->SetLabelAngle(50);
        $graph->yaxis->scale->SetAutoMax($maxValor * 1.2);

        $colores = ['red','blue','green','orange','purple','brown'];

        $i = 0;
        $plots = [];
        foreach ($valoresPorCategoria as $categoria => $valores) {
            $plot = new BarPlot(array_values($valores));
            $plot->SetLegend($categoria);
            $plot->SetFillColor($colores[$i % count($colores)]);
            $plots[] = $plot;
            $i++;
        }

        $group = new GroupBarPlot($plots);
        $graph->Add($group);
        $graph->Stroke();
}




    public function show() {
        $periodo = $_GET['periodo'] ?? 'mes';
        $urlPartidasTotales = "/triviados/Dashboard/graficarPartidasTotalesPorPeriodo?periodo=" . urlencode($periodo);
        $urlUsuariosTotales = "/triviados/Dashboard/graficarUsuariosTotalesPorPeriodo?periodo=" . urlencode($periodo);
        $urlPreguntasTotales = "/triviados/Dashboard/graficarPreguntasTotalesPorPeriodo?periodo=" . urlencode($periodo);
        $urlPorcentajePreguntasPorUsuario = "/triviados/Dashboard/graficarPorcentajeDePreguntasCorrectasPorUsuarioPorPeriodo?periodo=" . urlencode($periodo);
        $urlCantidadUsuariosPorPais = "/triviados/Dashboard/graficarCantidadDeUsuariosPorPaisPorPeriodo?periodo=" . urlencode($periodo);
        $urlCantidadUsuariosPorSexo = "/triviados/Dashboard/graficarCantidadDeUsuariosPorSexoPorPeriodo?periodo=" . urlencode($periodo);
        $urlCantidadUsuariosPorGrupoDeEdad = "/triviados/Dashboard/graficarCantidadDeUsuariosPorGrupoDeEdadPorPeriodo?periodo=" . urlencode($periodo);


        $this->view->render("Dashboard",
            ['periodo' => $periodo,
            'grafico_partidas_totales' => $urlPartidasTotales,
            'grafico_usuarios_totales' => $urlUsuariosTotales,
            'grafico_preguntas_totales' => $urlPreguntasTotales,
            'grafico_porcentaje_preguntas_usuarios' => $urlPorcentajePreguntasPorUsuario,
            'grafico_cantidad_usuarios_por_pais' => $urlCantidadUsuariosPorPais,
            'grafico_cantidad_usuarios_por_sexo' => $urlCantidadUsuariosPorSexo,
            'grafico_cantidad_usuarios_por_grupo_edad' => $urlCantidadUsuariosPorGrupoDeEdad]);
    }

}