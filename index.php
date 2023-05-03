<?php
require_once('include.php');

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['_id_usuario']) && $_SESSION['_id_usuario'] > 0) {
    $user = new Usuario();
    $user->loadById($_SESSION['_id_usuario']);
    $nomeuser = $user->getNome();

    if ($user->getTipo() == 1) {
        $consultadia = Agendamento::ListaDiaMedico($user->getId());
    } else {
        $consultadia = Agendamento::ListaDiaPaciente($user->getId());
    }
} else {
    Usuario::sair();
    header("Location: login.php");
    exit();
}

// Criar aviso para quando tiver uma consulta iniciada, onde terá um botão acessar que leva para a página iniciarconsulta.php
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
                <h1 class="mt-4">Início</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Inicío</li>
                </ol>
                <hr>
                <h3>Bem vindo(a), <?php echo $nomeuser; ?>!</h3>
                <br>
                <span class="mt-3">Suas consultas do dia de hoje:</span>
                <?php

                if ($consultadia['num'] < 1) {
                    echo "<hr><span class='mt-3'><b>Não há agendamentos para o dia de hoje.</b></span><hr><br><span class='mt-3'><b>Não encontrou seu agendamento?</b> Verifique seus agendamentos <a href='pendentes.php'>pendentes</a> e <a href='futuras.php'>futuros</a>.</span>";
                } else {
                ?>
                    <div class="row mt-4">
                        <?php
                        if ($user->getTipo() == 1) {
                            foreach ($consultadia['dados'] as $agendamento) {
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
                                            <button type="button" class="btn btn-success iniciarconsulta" data-id="<?php echo $agendamento['id']; ?>">Iniciar</button>
                                            <button type="button" class="btn btn-danger cancelarag" data-id="<?php echo $agendamento['id']; ?>">Cancelar</button>
                                            <!-- <a class="small text-white stretched-link modalmedico"  href="#">Ver Detalhes</a> -->
                                        </div>
                                    </div>
                                </div>
                            <?php }
                        } else {
                            foreach ($consultadia['dados'] as $agendamento) {
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
                                if ($agendamento['confirmado'] == 2) {
                                    $iniciada = true;
                                    $cardbody = "<b>Médico:</b><br>" . $medico . "<br><b>Data Consulta:</b><br>" . $datahora . "<br><b>Especialidade:</b><br>" . $especialidade . "<br><b>Consulta iniciada:</b> Sim";
                                } else {
                                    $iniciada = false;
                                    $cardbody = "<b>Médico:</b><br>" . $medico . "<br><b>Data Consulta:</b><br>" . $datahora . "<br><b>Especialidade:</b><br>" . $especialidade . "<br><b>Consulta iniciada:</b> Não";
                                }
                            ?>
                                <div class="col-4" id="ag_<?php echo $agendamento['id']; ?>">
                                    <div class="card border-dark mb-4">
                                    <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-6 col-md-6 col-lg-7">
                                                    <?php echo $cardbody; ?>
                                                </div>
                                                <div class="col-sm-3 col-md-3 col-lg-2">
                                                    <div class="circle">
                                                        <img class="profile-pic" src="imgperfil/<?php echo $imgperfil; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer d-flex align-items-center justify-content-between">
                                            <?php if ($iniciada) { ?>
                                                <button type="button" class="btn btn-success p-acessarvideo" data-id="<?php echo $agendamento['id']; ?>">Acessar</button>
                                            <?php } else { ?>
                                                <button type="button" class="btn btn-danger cancelarag" data-id="<?php echo $agendamento['id']; ?>">Cancelar</button>
                                            <?php } ?>
                                            <!-- <a class="small text-white stretched-link modalpaciente" href="#">Ver Detalhes</a> -->
                                        </div>
                                    </div>
                                </div>
                        <?php }
                        }
                        ?>


                    </div>
                <?php } ?>
            </div>
            <div class="modal fade" tabindex="-1" id="modal-paciente">
                <div class="modal-dialog modal-fullscreen">
                    <div class="modal-content">
                        <div class="modal-body">
                            <iframe src="" width="100%" height="100%" style="border:none;" id="pframevideo" allow="camera;microphone;autoplay;display-capture;encrypted-media">
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
    <script src="js/scripts.js"></script>
    <?php
    include_once('scripts.php');
    if (isset($_SESSION['msg'])){
    ?>
    <script>toastr.success("<?php echo $_SESSION['msg']; ?>");</script>
    <?php } 
    unset($_SESSION['msg']);
    ?>
</body>

</html>