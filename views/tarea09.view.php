<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tarea 09</h1>

</div>

<!-- Content Row -->
<?php if (isset($data['resultado'])) { ?>
    <div class="row">
        <div class="col-12">
            <div class="alert alert-success">
                <table class="table table-striped table-bordered">
                    <?php foreach ($data['resultado'] as $key => $value) { ?>
                        <tr>
                            <th>Asignatura</th>
                            <th><?php echo $key ?></th>
                        </tr>
                        <tr>
                            <th>Media</th>
                            <td><?php echo $value['media'] ?></td>
                        <tr>
                        <th>Suspensos</th>
                        <?php foreach ($value['suspensos'] as $alumnoSuspenso => $notaSuspenso) { ?>
                            <tr>
                                <td><?php echo $alumnoSuspenso . ': ' . $notaSuspenso ?></td>
                            </tr>
                        <?php } ?>
                        </tr>
                        <tr>
                        <th>Aprobados</th>
                        <?php foreach ($value['aprobados'] as $alumnoAprobado => $notaAprobado) { ?>
                            <tr>
                                <td><?php echo $alumnoAprobado . ': ' . $notaAprobado ?></td>
                            </tr>
                        <?php } ?>
                        </tr>
                        <tr>
                            <th>Máxima nota</th>
                            <td><?php echo $value['max']['alumno'] . ': ' . $value['max']['nota'] ?></td>
                        </tr>
                        <tr>
                            <th>Mínima nota</th>
                            <td><?php echo $value['min']['alumno'] . ': ' . $value['min']['nota'] ?></td>
                        </tr>
                        <tr>
                            <td colspan="2"><hr/></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
    <?php
}
?>
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Analizar notas en JSON</h6>
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <div class="mb-3">
                        <textarea name="datos" class="form-control"></textarea>
                        <input type="submit" value="Enviar" name="enviar" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

