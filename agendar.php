<?php
require_once('include.php');

if (!isset($_SESSION)) {
    session_start();
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
                <h1 class="mt-4">Agendar consulta</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="index.php">Início</a></li>
                    <li class="breadcrumb-item active">Agendar consulta</li>
                </ol>
                <hr>
                <div class="col-md-6 mb-3">
                    <div class="form-floating mb-3 mb-md-0">
                        <select class="form-control" id="selectmedico">
                            <option value="0" disabled selected>Selecione um médico</option>
                            <?php
                            $medicos = Medico::ListarMedicos();
                            foreach ($medicos['dados'] as $medico) {
                                $user = new Usuario();
                                $user->loadById($medico['id_usuario']);
                            ?>
                                <option value="<?php echo $medico['id_usuario']; ?>"><?php echo $user->getNome() . " - " . $medico['especialidade']; ?></option>
                            <?php } ?>
                        </select>
                        <label for="selectmedico">Médico</label>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-floating mb-3 mb-md-0">
                        <select class="form-control" id="selectdia">
                            <option value="0" disabled selected>Selecione uma data</option>
                        </select>
                        <label for="selectdia">Data da consulta</label>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-floating mb-3 mb-md-0">
                        <select class="form-control" id="selecthora">
                            <option value="0" disabled selected>Selecione um horário</option>
                        </select>
                        <label for="selecthora">Horário da consulta</label>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-floating mb-3 mb-md-0">
                        <a class="btn btn-primary btn-block" id="btnagendar">Solicitar agendamento</a>
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