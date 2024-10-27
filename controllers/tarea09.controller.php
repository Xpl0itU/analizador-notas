<?php

function analyseData(mixed $data): array
{
    $ret = array();
    $notaMediaTrimestres = array();
    foreach ($data as $asignatura => $alumnos) {
        foreach ($alumnos as $nombreAlumno => $notas) {
            $notaMediaTrimestres[$asignatura][$nombreAlumno] = round(array_sum($notas) / count($notas), 2);
        }
        $ret['tabla'][$asignatura]['media'] = array_sum($notaMediaTrimestres[$asignatura]) / count($notaMediaTrimestres[$asignatura]);
        $ret['tabla'][$asignatura]['suspensos'] = array_filter($notaMediaTrimestres[$asignatura], function (int|float $item) {
            return $item < 5;
        });
        $ret['tabla'][$asignatura]['aprobados'] = array_filter($notaMediaTrimestres[$asignatura], function (int|float $item) {
            return $item >= 5;
        });
        $ret['tabla'][$asignatura]['max'] = ['alumno' => 'nobody', 'nota' => null];
        $ret['tabla'][$asignatura]['min'] = ['alumno' => 'nobody', 'nota' => null];
        foreach ($notaMediaTrimestres[$asignatura] as $nombreAlumno => $notaMedia) {
            if ($notaMedia > $ret['tabla'][$asignatura]['max']['nota'] || $ret['tabla'][$asignatura]['max']['nota'] === null) {
                $ret[$asignatura]['max'] = ['alumno' => $nombreAlumno, 'nota' => $notaMedia];
            }
            if ($notaMedia < $ret['tabla'][$asignatura]['min']['nota'] || $ret['tabla'][$asignatura]['min']['nota'] === null) {
                $ret['tabla'][$asignatura]['min'] = ['alumno' => $nombreAlumno, 'nota' => $notaMedia];
            }
        }
    }
    return $ret;
}

if (isset($_POST['datos'])) { // TODO: Validate JSON data
    $parsed_data = json_decode($_POST['datos'], associative: true);
    if ($parsed_data) {
        $data['resultado'] = analyseData($parsed_data);
    }
}

$_customJs = array("vendor/datatables/jquery.dataTables.min.js", "vendor/datatables/dataTables.bootstrap4.min.js", "assets/pages/js/tablas.view.js");

include 'views/templates/header.php';
include 'views/tarea09.view.php';
include 'views/templates/footer.php';