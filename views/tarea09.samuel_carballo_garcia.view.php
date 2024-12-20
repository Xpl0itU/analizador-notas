<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tarea 09</h1>
</div>

<!-- Content Row -->
<?php if (isset($data['resultado'])) { ?>
    <div class="row">
        <div class="col-12 col-lg-6">
            <div class="alert alert-success">
                <p><strong>TODO APROBADO</strong></p>
                <ul>
                    <?php foreach ($data['resultado']['alumnos_todo_aprobado'] as $alumno) { ?>
                        <li><?php echo $alumno ?></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="alert alert-warning">
                <p><strong>UNA O MÁS SUSPENSAS</strong></p>
                <ul>
                    <?php foreach ($data['resultado']['alumnos_algun_suspenso'] as $alumno) { ?>
                        <li><?php echo $alumno ?></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="alert alert-info">
                <p><strong>PROMOCIONAN</strong></p>
                <ul>
                    <?php foreach ($data['resultado']['alumnos_promocionan'] as $alumno) { ?>
                        <li><?php echo $alumno ?></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="alert alert-danger">
                <p><strong>NO PROMOCIONAN</strong></p>
                <ul>
                    <?php foreach ($data['resultado']['alumnos_no_promocionan'] as $alumno) { ?>
                        <li><?php echo $alumno ?></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="alert alert-success">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Categoría</th>
                        <?php foreach ($data['resultado']['tabla'] as $key => $value) { ?>
                            <th><?php echo $key ?></th>
                        <?php } ?>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th>Media</th>
                        <?php foreach ($data['resultado']['tabla'] as $value) { ?>
                            <td><?php echo $value['media'] ?></td>
                        <?php } ?>
                    </tr>
                    <tr>
                        <th>Suspensos</th>
                        <?php foreach ($data['resultado']['tabla'] as $value) { ?>
                            <td><?php echo count($value['suspensos']) ?></td>
                        <?php } ?>
                    </tr>
                    <tr>
                        <th>Aprobados</th>
                        <?php foreach ($data['resultado']['tabla'] as $value) { ?>
                            <td><?php echo count($value['aprobados']) ?></td>
                        <?php } ?>
                    </tr>
                    <tr>
                        <th>Máxima nota</th>
                        <?php foreach ($data['resultado']['tabla'] as $value) { ?>
                            <td><?php echo $value['max']['alumno'] . ': ' . $value['max']['nota'] ?></td>
                        <?php } ?>
                    </tr>
                    <tr>
                        <th>Mínima nota</th>
                        <?php foreach ($data['resultado']['tabla'] as $value) { ?>
                            <td><?php echo $value['min']['alumno'] . ': ' . $value['min']['nota'] ?></td>
                        <?php } ?>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php } ?>

<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Analizar notas en JSON</h6>
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <div class="mb-3">
                        <textarea name="datos" class="form-control"></textarea>
                        <input type="submit" value="Enviar" name="enviar" class="btn btn-primary">
                    </div>
                    <p class="text-danger"><?php if (isset($data['errores'])) {
                            foreach ($data['errores'] as $error) {
                                echo $error;
                                ?>
                                <br/>
                            <?php }
                        } ?></p>
                </form>
            </div>
        </div>
    </div>
</div>
