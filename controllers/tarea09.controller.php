<?php
declare(strict_types=1);

function analyseData(mixed $data): array
{
    $ret = array();
    $notaMediaTrimestres = array();
    $suspensosPorAlumno = array();

    foreach ($data as $asignatura => $alumnos) {
        foreach ($alumnos as $nombreAlumno => $notas) {
            $notaMediaTrimestres[$asignatura][$nombreAlumno] = round(array_sum($notas) / count($notas), 2);

            if (!isset($suspensosPorAlumno[$nombreAlumno])) {
                $suspensosPorAlumno[$nombreAlumno] = 0;
            }

            if ($notaMediaTrimestres[$asignatura][$nombreAlumno] < 5) {
                $suspensosPorAlumno[$nombreAlumno]++;
            }
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
                $ret['tabla'][$asignatura]['max'] = ['alumno' => $nombreAlumno, 'nota' => $notaMedia];
            }
            if ($notaMedia < $ret['tabla'][$asignatura]['min']['nota'] || $ret['tabla'][$asignatura]['min']['nota'] === null) {
                $ret['tabla'][$asignatura]['min'] = ['alumno' => $nombreAlumno, 'nota' => $notaMedia];
            }
        }
    }

    $ret['alumnos_todo_aprobado'] = array_keys(array_filter($suspensosPorAlumno, function ($suspensos) {
        return $suspensos === 0;
    }));

    $ret['alumnos_algun_suspenso'] = array_keys(array_filter($suspensosPorAlumno, function ($suspensos) {
        return $suspensos > 0;
    }));

    $ret['alumnos_promocionan'] = array_keys(array_filter($suspensosPorAlumno, function ($suspensos) {
        return $suspensos <= 1;
    }));

    $ret['alumnos_no_promocionan'] = array_keys(array_filter($suspensosPorAlumno, function ($suspensos) {
        return $suspensos >= 2;
    }));

    return $ret;
}

function checkData(mixed $data): array {
    $errores = [];

    if (!is_array($data)) {
        $errores[] = 'El dato proporcionado no es un array válido';
        return $errores;
    }

    if (empty($data)) {
        $errores[] = 'No hay asignaturas en los datos';
        return $errores;
    }

    foreach ($data as $asignatura => $alumnos) {
        if (!is_array($alumnos)) {
            $errores[] = "La asignatura '$asignatura' no contiene un array de alumnos válido";
            continue;
        }

        if (empty($alumnos)) {
            $errores[] = "La asignatura '$asignatura' no tiene alumnos";
            continue;
        }

        foreach ($alumnos as $nombreAlumno => $notas) {
            if (!is_string($nombreAlumno)) {
                $errores[] = "En la asignatura '$asignatura' hay un nombre de alumno que no es texto";
            }

            if (!is_array($notas)) {
                $errores[] = "El alumno '$nombreAlumno' en la asignatura '$asignatura' no tiene un array de notas válido";
                continue;
            }

            foreach ($notas as $i => $nota) {
                if (!is_numeric($nota)) {
                    $errores[] = "La nota $i del alumno '$nombreAlumno' en la asignatura '$asignatura' no es un número";
                    continue;
                }

                if ($nota < 0 || $nota > 10) {
                    $errores[] = "La nota $i del alumno '$nombreAlumno' en la asignatura '$asignatura' no está entre 0 y 10";
                }
            }
        }
    }

    return $errores;
}

if (isset($_POST['datos'])) {
    $parsed_data = json_decode(filter_var($_POST['datos'], FILTER_SANITIZE_SPECIAL_CHARS), associative: true);
    $data['errores'] = checkData($parsed_data);
    if ($parsed_data) {
        if (empty($data['errores'])) {
            $data['resultado'] = analyseData($parsed_data);
        }
    }
}

$_customJs = array("vendor/datatables/jquery.dataTables.min.js", "vendor/datatables/dataTables.bootstrap4.min.js", "assets/pages/js/tablas.view.js");

include 'views/templates/header.php';
include 'views/tarea09.view.php';
include 'views/templates/footer.php';