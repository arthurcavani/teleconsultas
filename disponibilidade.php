<?php
require_once('include.php');

if (!isset($_SESSION)) {
    session_start();
}

$usuario = new Usuario();
$usuario->loadById($_SESSION['_id_usuario']);
if ($usuario->getTipo() != 1) {
    header("Location: index.php");
}

$disp = new Disponibilidade();
$disp->loadById($_SESSION['_id_usuario']);

?>

<body class="sb-nav-fixed">
    <?php require_once('nav.php'); ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Disponibilidade de Agenda</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="index.php">Início</a></li>
                    <li class="breadcrumb-item active">Disponibilidade de Agenda</li>
                </ol>
                <div class="row">
                    <div class="col-sm">
                        <fieldset>
                            <legend>Dias da semana</legend>
                            <div>
                                <input type="checkbox" id="seg" <?php if ($disp->getSeg()) echo "checked"; ?>>
                                <label for="seg">Segunda-feira</label>
                            </div>
                            <div>
                                <input type="checkbox" id="ter" <?php if ($disp->getTer()) echo "checked"; ?>>
                                <label for="ter">Terça-feira</label>
                            </div>
                            <div>
                                <input type="checkbox" id="qua" <?php if ($disp->getQua()) echo "checked"; ?>>
                                <label for="qua">Quarta-feira</label>
                            </div>
                            <div>
                                <input type="checkbox" id="qui" <?php if ($disp->getQui()) echo "checked"; ?>>
                                <label for="qui">Quinta-feira</label>
                            </div>
                            <div>
                                <input type="checkbox" id="sex" <?php if ($disp->getSex()) echo "checked"; ?>>
                                <label for="sex">Sexta-feira</label>
                            </div>
                            <div>
                                <input type="checkbox" id="sab" <?php if ($disp->getSab()) echo "checked"; ?>>
                                <label for="sab">Sábado</label>
                            </div>
                            <div>
                                <input type="checkbox" id="dom" <?php if ($disp->getDom()) echo "checked"; ?>>
                                <label for="dom">Domingo</label>
                            </div>
                        </fieldset>
                    </div>
                    <div class="col-sm">
                        <fieldset>
                            <legend>Horário de Atendimento</legend>
                            <div>
                                <input type="time" id="primeirac" name="primeirac" value="<?php echo $disp->getPrimeira_consulta(); ?>">
                                <label for="primeirac">Primeira Consulta</label>
                            </div>
                            <div>
                                <input type="time" id="ultimac" name="ultimac" value="<?php echo $disp->getUltima_consulta(); ?>">
                                <label for="ultimac">Última Consulta</label>
                            </div>
                            <div>
                                <input type="time" id="iniciopausa" name="iniciopausa" value="<?php echo $disp->getInicio_pausa(); ?>">
                                <label for="iniciopausa">Início Pausa</label>
                            </div>
                            <div>
                                <input type="time" id="fimpausa" name="fimpausa" value="<?php echo $disp->getFim_pausa(); ?>">
                                <label for="fimpausa">Fim Pausa</label>
                            </div>
                            <div>
                                <input type="text" id="duracao" style="width: 75px;" name="numonly" value="<?php echo $disp->getDuracao_consulta(); ?>">
                                <label for="duracao">Duração Consulta (minutos)</label>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <div class="mt-4 mb-0">
                    <div class="d-grid"><a class="btn btn-primary btn-block" id="btnalteradisp">Alterar</a></div>
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