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
                <h1 class="mt-4">Aguardando Aprovação</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="index.php">Início</a></li>
                    <li class="breadcrumb-item active">Aguardando Aprovação</li>
                </ol>
                <hr>
                <?php
                if ($user->getTipo() == 1) {
                    $pendentes = Agendamento::ListaPendentesMedico($user->getId());
                } else {
                    $pendentes = Agendamento::ListaPendentesPaciente($user->getId());
                }

                if ($pendentes['num'] < 1) {
                    echo "<span class='mt-3'><b>Não há agendamentos pendentes.</b></span><hr>";
                } else {
                ?>

                    <div class="row mt-4">
                        <?php
                        if ($user->getTipo() == 1) {
                            foreach ($pendentes['dados'] as $agendamento) {
                                $paciente = new Usuario();
                                $paciente->loadById($agendamento['id_usuario']);
                                $imgperfil = $paciente->getImgperfil();
                                if ($imgperfil == "") {
                                    $imgperfil = "notfound.jpg";
                                }
                                $paciente = $paciente->getNome();
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
                                                    <b>Paciente:</b><br> <?php echo $paciente . "<br><b>Data Consulta:</b><br>" . $datahora . "<br><b>Especialidade:</b><br>" . $especialidade; ?>
                                                </div>
                                                <div class="col-sm-3 col-md-3 col-lg-2">
                                                    <div class="circle">
                                                        <img class="profile-pic" src="imgperfil/<?php echo $imgperfil; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer d-flex align-items-center justify-content-between">
                                            <button type="button" class="btn btn-success aprovarag" data-id="<?php echo $agendamento['id']; ?>">Aprovar</button>
                                            <button type="button" class="btn btn-danger cancelarag" data-id="<?php echo $agendamento['id']; ?>">Cancelar</button>
                                            <!-- <a class="small text-white stretched-link modalmedico"  href="#">Ver Detalhes</a> -->
                                        </div>
                                    </div>
                                </div>
                            <?php }
                        } else {
                            foreach ($pendentes['dados'] as $agendamento) {
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
                                                <div class="col-sm-6 col-md-6 col-lg-5">
                                                    <div class="circle">
                                                        <img class="profile-pic" src="imgperfil/<?php echo $imgperfil; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer d-flex align-items-center justify-content-between">
                                            <button type="button" class="btn btn-danger cancelarag" data-id="<?php echo $agendamento['id']; ?>">Cancelar</button>
                                        </div>
                                    </div>
                                </div>
                        <?php }
                        }
                        ?>


                    </div>
                <?php } ?>
                <h2 class="mt-5">Agendamentos Cancelados</h1>
                    <?php
                    if ($user->getTipo() == 1) {
                        $pendentes = Agendamento::ListaRecusadosMedico($user->getId());
                    } else {
                        $pendentes = Agendamento::ListaRecusadosPaciente($user->getId());
                    }

                    if ($pendentes['num'] < 1) {
                        if ($user->getTipo() == 1) {
                            echo "<hr><span class='mt-3'><b>Não há agendamentos cancelados no último mês.</b></span>";
                        } else {
                            echo "<hr><span class='mt-3'><b>Não há agendamentos cancelados nos últimos três meses.</b></span>";
                        }
                    } else {
                    ?>
                        <div class="row mt-4">
                            <?php
                            if ($user->getTipo() == 1) {
                                foreach ($pendentes['dados'] as $agendamento) {
                                    $paciente = new Usuario();
                                    $paciente->loadById($agendamento['id_usuario']);
                                    $paciente = $paciente->getNome();
                                    $datahora = explode("-", $agendamento['dataconsulta']);
                                    $datahora = $datahora[2] . "/" . $datahora[1] . "/" . $datahora[0];
                                    $hora = explode(":", $agendamento['horaconsulta']);
                                    $datahora = $datahora . " - " . $hora[0] . ":" . $hora[1];
                                    $especialidade = $agendamento['especialidade'];
                            ?>
                                    <div class="col-xl-3 col-md-6" id="ag_<?php echo $agendamento['id']; ?>">
                                        <div class="card bg-danger text-white mb-4">
                                            <div class="card-body">Paciente: <?php echo $paciente . "<br>Data Consulta: " . $datahora . "<br>Especialidade: " . $especialidade; ?></div>
                                        </div>
                                    </div>
                                <?php }
                            } else {
                                foreach ($pendentes['dados'] as $agendamento) {
                                    $medico = new Usuario();
                                    $medico->loadById($agendamento['id_medico']);
                                    $medico = $medico->getNome();
                                    $datahora = explode("-", $agendamento['dataconsulta']);
                                    $datahora = $datahora[2] . "/" . $datahora[1] . "/" . $datahora[0];
                                    $hora = explode(":", $agendamento['horaconsulta']);
                                    $datahora = $datahora . " - " . $hora[0] . ":" . $hora[1];
                                    $especialidade = $agendamento['especialidade'];
                                ?>
                                    <div class="col-xl-3 col-md-6" id="ag_<?php echo $agendamento['id']; ?>">
                                        <div class="card bg-danger text-white mb-4">
                                            <div class="card-body">Médico: <?php echo $medico . "<br>Data Consulta: " . $datahora . "<br>Especialidade: " . $especialidade; ?></div>
                                        </div>
                                    </div>
                            <?php }
                            }
                            ?>


                        </div>
                    <?php } ?>
            </div>
            <div class="modal fade" tabindex="-1" id="modal-paciente">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Detalhes do agendamento</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Médico: <span id="lblmedico"></span></p>
                            <p>Especialidade: <span id="lblespecialidadep"></span></p>
                            <p>Data da consulta: <span id="lbldatap"></span></p>
                            <p>Hora da consulta: <span id="lblhorap"></span></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" id="btncancelarp">Cancelar agendamento</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" tabindex="-1" id="modal-medico">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Detalhes do agendamento</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Paciente: <span id="lblpaciente"></span></p>
                            <p>Especialidade: <span id="lblespecialidadem"></span></p>
                            <p>Data da consulta: <span id="lbldatam"></span></p>
                            <p>Hora da consulta: <span id="lblhoram"></span></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" id="btncancelarp">Cancelar agendamento</button>
                            <button type="button" class="btn btn-success" id="btncancelarp">Aprovar agendamento</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                </div>
            </div>

        </main>
        <?php include_once("footer.php"); ?>
    </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <?php
    include_once('scripts.php');
    ?>
</body>

</html>