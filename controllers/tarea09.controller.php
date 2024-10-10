<?php

function analyseData(mixed $data): array
{
    $ret = array();
    $notaMediaTrimestres = array();
    foreach ($data as $asignatura => $alumnos) {
        foreach ($alumnos as $nombreAlumno => $notas) {
            $notaMediaTrimestres[$asignatura][$nombreAlumno] = round(array_sum($notas) / count($notas), 2);
        }
        $ret[$asignatura]['media'] = array_sum($notaMediaTrimestres[$asignatura]) / count($notaMediaTrimestres[$asignatura]);
        $ret[$asignatura]['suspensos'] = array_filter($notaMediaTrimestres[$asignatura], function (int $item) {
            return $item < 5;
        });
        $ret[$asignatura]['aprobados'] = array_filter($notaMediaTrimestres[$asignatura], function (int $item) {
            return $item >= 5;
        });
        $ret[$asignatura]['max'] = ['alumno' => 'nobody', 'nota' => null];
        $ret[$asignatura]['min'] = ['alumno' => 'nobody', 'nota' => null];
        foreach ($notaMediaTrimestres[$asignatura] as $nombreAlumno => $notaMedia) {
            if ($notaMedia > $ret[$asignatura]['max']['nota'] || $ret[$asignatura]['max']['nota'] === null) {
                $ret[$asignatura]['max'] = ['alumno' => $nombreAlumno, 'nota' => $notaMedia];
            }
            if ($notaMedia < $ret[$asignatura]['min']['nota'] || $ret[$asignatura]['min']['nota'] === null) {
                $ret[$asignatura]['min'] = ['alumno' => $nombreAlumno, 'nota' => $notaMedia];
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