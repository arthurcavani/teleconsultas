<?php
require_once('include.php');

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_GET['ida'])) {
    header("Location: index.php");
    exit();
} else {
    $ag = new Agendamento();
    $ag->loadById($_GET['ida']);
    if ($ag->getId() < 0) {
        header("Location: index.php");
        exit();
    } else {
        if ($_SESSION['_id_usuario'] != $ag->getId_medico()) {
            header("Location: index.php");
            exit();
        }
    }
}

$idpaciente = $ag->getId_usuario();
$pacientenome = new Usuario();
$pacientenome->loadById($idpaciente);
$pacientenome = $pacientenome->getNome();
$medico = $ag->getId_medico();
$dataconsultaf = $ag->getDataconsulta();
$dataconsultaf = explode("-", $dataconsultaf);
$dataconsulta = $dataconsultaf[2] . "/" . $dataconsultaf[1] . "/" . $dataconsultaf[0];
$horaconsultaf = $ag->getHoraconsulta();
$horaconsultaf = explode(":", $horaconsultaf);
$horaconsulta = $horaconsultaf[0] . ":" . $horaconsultaf[1];
$especialidade = $ag->getEspecialidade();

$consulta = new Consulta();
$consulta->loadById($_GET['ida']);
if ($consulta->getId() > 0) {
    $iniciada = true;
    $titulo = "Dados da Consulta";
} else {
    $iniciada = false;
    $titulo = "Iniciar Consulta";
}

$finalizada = false;

if ($ag->getConfirmado() == 3) {
    $finalizada = true;
}

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
                <h1 class="mt-4"><?php echo $titulo; ?></h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="index.php">Início</a></li>
                    <li class="breadcrumb-item active"><?php echo $titulo; ?></li>
                </ol>
                <hr>
                <div class="card mb-4">
                    <div class="card-body">
                        <h4 class="mb-2">Dados da Consulta</h4>
                        <hr>
                        <input type="hidden" id="idagendamento" value="<?php echo $_GET['ida']; ?>">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" name="" id="paciente" value="<?php echo $pacientenome; ?>" readonly>
                                    <label for="paciente">Paciente</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input class="form-control" name="" id="inputespecialidade" value="<?php echo $especialidade; ?>" readonly>
                                    <label for="inputespecialidade">Especialidade</label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" name="" id="horarioag" value="<?php echo $dataconsulta . " - " . $horaconsulta ?>" readonly>
                                    <label for="horarioag">Horário Agendamento</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">

                                    <?php if ($iniciada) {
                                        $datahorainiciada = new Consulta();
                                        $datahorainiciada->loadById($_GET['ida']);
                                        $cid = $datahorainiciada->getCid();
                                        $diagnostico = $datahorainiciada->getDiagnostico();
                                        $obs = $datahorainiciada->getObservacoes();
                                        $datahorainiciada = new DateTime($datahorainiciada->getDtiniciada());
                                        $datahorainiciada = $datahorainiciada->format('d/m/Y - H:i');
                                    ?>
                                        <input class="form-control" name="" id="horarioiniciada" value="<?php echo $datahorainiciada; ?>" readonly>
                                        <label for="horarioiniciada">Horário Iniciada</label>
                                    <?php } else {
                                        $cid = "";
                                        $diagnostico = "";
                                        $obs = "";
                                    ?>
                                        <input class="form-control" name="" id="horarioiniciada" readonly>
                                        <label for="horarioiniciada">Horário Iniciada</label>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" name="" id="cid" value="<?php echo $cid; ?>" <?php if ($cid != '') echo "readonly"; ?>>
                                    <label for="cid">CID</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input class="form-control" name="" id="diagnostico" value="<?php echo $diagnostico; ?>" <?php if ($diagnostico != '') echo "readonly"; ?>>
                                    <label for="diagnostico">Diagnóstico</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-floating mb-3 mb-md-0">
                                    <textarea class="form-control" id="observacao" style="height: 180px;" <?php if ($obs != "") echo "readonly"; ?>><?php echo $obs; ?></textarea>
                                    <label for="observacao">Observações</label>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer align-items-center justify-content-between">
                            <?php
                            $salvar = false;
                            if ($cid == "" || $diagnostico == "" || $obs == "") {
                                if ($iniciada) {
                                    $salvar = true;
                                }
                            }
                            if ($finalizada == false) {
                                $btnlabel = "Acessar videoconferência";
                            } else {
                                $btnlabel = "Acessar consulta";
                            } ?>
                            <button type="button" class="btn btn-success" id="btnacessarvideo" onclick="acessarvideo(<?php echo $_GET['ida']; ?>);"><?php echo $btnlabel; ?></button>
                            <?php if ($salvar) { ?>
                                <button type="button" class="btn btn-primary" id="btnsalvarc">Salvar dados</button>
                            <?php } ?>

                        </div>
                    </div>
                </div>
                <div class="modal fade" tabindex="-1" id="modal-medico">
                    <div class="modal-dialog modal-fullscreen">
                        <!-- modal-dialog-centered -->
                        <div class="modal-content">
                            <div class="modal-body">
                                <iframe src="" width="100%" height="100%" style="border:none;" id="framevideo" allow="camera;microphone;autoplay;display-capture;encrypted-media;allow-same-origin;allow-forms;allow-modals;allow-popups;allow-scripts">
                                </iframe>
                            </div>
                            <div class="modal-footer align-items-left">
                                <?php if ($finalizada) { ?>
                                    <button type="button" class="btn btn-danger" onclick="location.reload();">Sair</button>
                                <?php } else { ?>
                                    <button type="button" class="btn btn-danger" id="btnfinalizarconsulta">Finalizar Consulta</button>
                                <?php } ?>
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