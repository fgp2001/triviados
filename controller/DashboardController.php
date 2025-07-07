<?php

require_once("libs/jpgraph/src/jpgraph.php");
require_once("libs/jpgraph/src/jpgraph_bar.php");
require_once ("libs/jpgraph/src/jpgraph_line.php");
require_once ("libs/dompdf/autoload.inc.php");
use Dompdf\Dompdf;
use Dompdf\Options;

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
    private function graficar($datos, $titulo, $rutaSalida = null){
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

        if ($rutaSalida) {
            if (empty($totales)) {
                error_log("⚠️ El gráfico '$titulo' no tiene datos.");
                return;
            }

            error_log("✅ Generando gráfico '$titulo' en $rutaSalida");
            $graph->Stroke($rutaSalida);
        } else {
            $graph->Stroke();
        }
    }
    private function graficar2($datos, $colCategoria, $colValor, $titulo, $rutaSalida = null){
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
        if ($rutaSalida) {
            $graph->Stroke($rutaSalida);
        } else {
            $graph->Stroke();
        }
    }
    public function generarGraficosParaPDF($periodo) {
        $graficos = [];

        $graficos['partidas'] = 'media/graficos/partidas_'.$periodo.'.png';
        $this->graficar(
            $this->model->obtenerPartidasTotalesPorPeriodo($periodo),
            "Partidas totales por $periodo",
            $graficos['partidas']
        );

        $graficos['usuarios'] = 'media/graficos/usuarios_'.$periodo.'.png';
        $this->graficar(
            $this->model->obtenerUsuariosTotalesPorPeriodo($periodo),
            "Usuarios totales por $periodo",
            $graficos['usuarios']
        );

        $graficos['preguntas'] = 'media/graficos/preguntas_'.$periodo.'.png';
        $this->graficar(
            $this->model->obtenerPreguntasTotalesPorPeriodo($periodo),
            "Preguntas totales por $periodo",
            $graficos['preguntas']
        );

        $graficos['porcentaje'] = 'media/graficos/porcentaje_'.$periodo.'.png';
        $this->graficar2(
            $this->model->obtenerPorcentajeDePreguntasCorrectasPorUsuarioPorPeriodo($periodo),
            'nombre_usuario',
            'porcentaje_correctas',
            "Porcentaje de respuestas correctas por $periodo",
            $graficos['porcentaje']
        );

        $graficos['usuarios_pais'] = 'media/graficos/usuarios_pais_'.$periodo.'.png';
        $this->graficar2(
            $this->model->obtenerCantidadDeUsuariosPorPaisPorPeriodo($periodo),
            'pais',
            'cantidad',
            "Cantidad de usuarios por país por $periodo",
            $graficos['usuarios_pais']
        );

        $graficos['usuarios_sexo'] = 'media/graficos/usuarios_sexo_'.$periodo.'.png';
        $this->graficar2(
            $this->model->obtenerCantidadDeUsuariosPorSexoPorPeriodo($periodo),
            'sexo',
            'cantidad',
            "Cantidad de usuarios por sexo por $periodo",
            $graficos['usuarios_sexo']
        );

        $graficos['usuarios_edad'] = 'media/graficos/usuarios_edad_'.$periodo.'.png';
        $this->graficar2(
            $this->model->obtenerCantidadDeUsuariosPorGrupoDeEdadPorPeriodo($periodo),
            'grupo_edad',
            'cantidad',
            "Cantidad de usuarios por grupo de edad por $periodo",
            $graficos['usuarios_edad']
        );

        return $graficos;
    }
    public function generarPDF()
    {
        $options = new Options();
        $options->set('isRemoteEnabled', true); // permite cargar imágenes locales
        $options->set('chroot', realpath(__DIR__ . '/../')); // base segura para imágenes

        $dompdf = new Dompdf($options);
        $periodo = $_GET['periodo'] ?? 'mes';

        $rutas = $this->generarGraficosParaPDF($periodo);

        $html = '<h1>Reporte de estadísticas por ' . ucfirst($periodo) . '</h1>';
        foreach ($rutas as $titulo => $rutaRelativa) {
            $rutaAbsoluta = realpath($rutaRelativa);

            if ($rutaAbsoluta && file_exists($rutaAbsoluta)) {
                $html .= '<h3>' . ucfirst($titulo) . '</h3>';
                $html .= '<img src="file://' . $rutaAbsoluta . '" width="600"><br><br>';
            } else {
                $html .= '<p><strong>Error al cargar: ' . htmlspecialchars($rutaRelativa) . '</strong></p>';
            }
        }

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        usleep(500000);
        $dompdf->render();
        $dompdf->stream("reporte_$periodo.pdf", ["Attachment" => false]);

        foreach ($rutas as $ruta) {
            if (file_exists($ruta)) {
                unlink($ruta);
            }
        }
    }


    public function show()
    {
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