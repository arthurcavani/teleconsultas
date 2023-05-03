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
                <h1 class="mt-4">Consultas Passadas</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="index.php">Início</a></li>
                    <li class="breadcrumb-item active">Consultas Passadas</li>
                </ol>
                <hr>
                <?php
                if ($user->getTipo() == 1) {
                    $passadas = Agendamento::ListaPassadasMedico($user->getId());
                } else {
                    $passadas = Agendamento::ListaGeralPassadasPaciente($user->getId());
                }

                if ($passadas['num'] < 1) {
                    echo "<span class='mt-3'><b>Não há consultas passadas já finalizadas.</b></span><hr>";
                } else {

                    if ($user->getTipo() == 1) { ?>
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
                                            <th>Detalhes</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Número</th>
                                            <th>Paciente</th>
                                            <th>Data</th>
                                            <th>Hora</th>
                                            <th>Especialidade</th>
                                            <th>Detalhes</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>

                                        <?php
                                        foreach ($passadas['dados'] as $agendamento) {
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
                                                <td style="text-align: center; vertical-align: middle;"><a class="btn btn-primary btn-block detalhesconsulta" data-id="<?php echo $agendamento['id']; ?>">Detalhes</a></td>
                                            </tr>
                                        <?php } ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                    <?php
                    } else { ?>
                        <div class="card mb-4">
                            <div class="card-header">
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>Número</th>
                                            <th>Médico</th>
                                            <th>Data</th>
                                            <th>Hora</th>
                                            <th>Especialidade</th>
                                            <th>Detalhes</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Número</th>
                                            <th>Médico</th>
                                            <th>Data</th>
                                            <th>Hora</th>
                                            <th>Especialidade</th>
                                            <th>Detalhes</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>

                                        <?php
                                        foreach ($passadas['dados'] as $agendamento) {
                                            $medico = new Usuario();
                                            $medico->loadById($agendamento['id_medico']);
                                            $medico = $medico->getNome();
                                            $datahora = explode("-", $agendamento['dataconsulta']);
                                            $datahora = $datahora[2] . "/" . $datahora[1] . "/" . $datahora[0];
                                            $hora = explode(":", $agendamento['horaconsulta']);
                                            $hora = $hora[0] . ":" . $hora[1];
                                            $especialidade = $agendamento['especialidade'];
                                        ?>
                                            <tr>
                                                <td style="text-align: center; vertical-align: middle;"><b><?php echo $agendamento['id']; ?></b></td>
                                                <td style="text-align: center; vertical-align: middle;"><b><?php echo $medico; ?></b></td>
                                                <td style="text-align: center; vertical-align: middle;"><b><?php echo $datahora; ?></b></td>
                                                <td style="text-align: center; vertical-align: middle;"><b><?php echo $hora; ?></b></td>
                                                <td style="text-align: center; vertical-align: middle;"><b><?php echo $especialidade; ?></b></td>
                                                <td style="text-align: center; vertical-align: middle;"><a class="btn btn-primary btn-block detalhesconsulta" data-id="<?php echo $agendamento['id']; ?>">Detalhes</a></td>
                                            </tr>
                                        <?php } ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php
                    }
                    ?>



                <?php } ?>

            </div>
            <?php include_once("modal_detalhesconsulta.php"); ?>
            <div class="modal fade" tabindex="-1" id="modal-paciente">
                <div class="modal-dialog modal-fullscreen">
                    <div class="modal-content">
                        <div class="modal-body">
                            <iframe src="" width="100%" height="100%" style="border:none;" id="framevideo" allow="camera;microphone;autoplay;display-capture;encrypted-media">
                            </iframe>
                        </div>
                        <div class="modal-footer align-items-center">
                            <button type="button" class="btn btn-danger" onclick="location.reload();" >Sair</button>
                        </div>
                    </div>
                </div>
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