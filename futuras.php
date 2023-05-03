<?php
require_once('include.php');

if (!isset($_SESSION)) {
    session_start();
}

$user = new Usuario();
$user->loadById($_SESSION['_id_usuario']);

?>

<body class="sb-nav-fixed">
    <?php require_once('nav.php'); ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="loading-spinner" id="loading-spinner">
                <div class="animated unload base" style="background-color: rgb(242, 242, 242, 0.6); width: 100%; height: 100vh;" data-animation="fadeOut" data-delay="10"></div>
                <img src="./img/loading.gif" id="hourglass" style="width: 100px;">
            </div>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Próximas Consultas</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="index.php">Início</a></li>
                    <li class="breadcrumb-item active">Próximas Consultas</li>
                </ol>
                <hr>

                <?php
                if ($user->getTipo() == 1) {
                    $futuras = Agendamento::ListaProximasMedico($user->getId());
                } else {
                    $futuras = Agendamento::ListaProximasPaciente($user->getId());
                }

                if ($futuras['num'] < 1) {
                    echo "<span class='mt-3'><b>Não há agendamentos futuros.</b></span><hr><br><span class='mt-3'><b>Não encontrou seu agendamento?</b> Verifique seus agendamentos <a href='pendentes.php'>pendentes</a>.</span>";
                } else if ($user->getTipo() == 1) {
                ?>

                    <div class="card mb-4">
                        <div class="card-header">
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>Número</th>
                                        <th>Paciente</th>
                                        <th>Data</th>
                                        <th>Hora</th>
                                        <th>Especialidade</th>
                                        <th>Cancelar</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Número</th>
                                        <th>Paciente</th>
                                        <th>Data</th>
                                        <th>Hora</th>
                                        <th>Especialidade</th>
                                        <th>Cancelar</th>
                                    </tr>
                                </tfoot>
                                <tbody>

                                    <?php
                                    foreach ($futuras['dados'] as $agendamento) {
                                        $paciente = new Usuario();
                                        $paciente->loadById($agendamento['id_usuario']);
                                        $paciente = $paciente->getNome();
                                        $datahora = explode("-", $agendamento['dataconsulta']);
                                        $datahora = $datahora[2] . "/" . $datahora[1] . "/" . $datahora[0];
                                        $hora = explode(":", $agendamento['horaconsulta']);
                                        $hora = $hora[0] . ":" . $hora[1];
                                        $especialidade = $agendamento['especialidade'];
                                    ?>
                                        <tr>
                                            <td style="text-align: center; vertical-align: middle;"><b><?php echo $agendamento['id']; ?></b></td>
                                            <td style="text-align: center; vertical-align: middle;"><b><?php echo $paciente; ?></b></td>
                                            <td style="text-align: center; vertical-align: middle;"><b><?php echo $datahora; ?></b></td>
                                            <td style="text-align: center; vertical-align: middle;"><b><?php echo $hora; ?></b></td>
                                            <td style="text-align: center; vertical-align: middle;"><b><?php echo $especialidade; ?></b></td>
                                            <td style="text-align: center; vertical-align: middle;"><a class="btn btn-danger btn-block cancelarag" data-id="<?php echo $agendamento['id']; ?>">Cancelar</a></td>
                                        </tr>
                                    <?php } ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="row">
                        <?php
                        foreach ($futuras['dados'] as $agendamento) {
                            $medico = new Usuario();
                            $medico->loadById($agendamento['id_medico']);
                            $imgperfil = $medico->getImgperfil();
                            if ($imgperfil == "") {
                                $imgperfil = "notfound.jpg";
                            }
                            $medico = $medico->getNome();
                            $datahora = explode("-", $agendamento['dataconsulta']);
                            $datahora = $datahora[2] . "/" . $datahora[1] . "/" . $datahora[0];
                            $hora = explode(":", $agendamento['horaconsulta']);
                            $datahora = $datahora . " - " . $hora[0] . ":" . $hora[1];
                            $especialidade = $agendamento['especialidade'];
                        ?>
                            <div class="col-4" id="ag_<?php echo $agendamento['id']; ?>">
                                <div class="card border-dark mb-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-6 col-md-6 col-lg-7">
                                                <b>Médico:</b><br> <?php echo $medico . "<br><b>Data Consulta:</b><br>" . $datahora . "<br><b>Especialidade:</b><br>" . $especialidade; ?>
                                            </div>
                                            <div class="col-sm-3 col-md-3 col-lg-2">
                                                <div class="circle">
                                                    <img class="profile-pic" src="imgperfil/<?php echo $imgperfil; ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <button type="button" class="btn btn-danger cancelarag" data-id="<?php echo $agendamento['id']; ?>">Cancelar</button>
                                        <!-- <a class="small text-white stretched-link modalpaciente" href="#">Ver Detalhes</a> -->
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <hr>
                        <span class="mt-3"><b>Não encontrou seu agendamento?</b> Verifique seus agendamentos <a href="pendentes.php">pendentes</a>.</span>
                    </div>
                <?php
                } ?>

            </div>

        </main>
        <?php include_once("footer.php"); ?>
    </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/simple-datatables.js"></script>
    <script src="js/datatables-simple-demo.js"></script>
    <script src="js/scripts.js"></script>
    <?php
    include_once('scripts.php');
    ?>
</body>

</html>