<?php
require_once('include.php');

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['_id_usuario']) && $_SESSION['_id_usuario'] > 0) {
    $user = new Usuario();
    $user->loadById($_SESSION['_id_usuario']);
    $nomeuser = $user->getNome();

    if ($user->getTipo() != 1) {
        header("Location: index.php");
        exit();
    }
} else {
    Usuario::sair();
    header("Location: login.php");
    exit();
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
                <h1 class="mt-4">Cadastrar Médico</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="index.php">Início</a></li>
                    <li class="breadcrumb-item active">Cadastrar Médico</li>
                </ol>
                <hr>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-floating mb-3 mb-md-0">
                            <input class="form-control" id="inputnome" type="text" placeholder="Nome completo" />
                            <label for="inputnome">Nome completo</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input class="form-control" id="inputcpf" type="text" placeholder="CPF" onkeydown="javascript: fMasc( this, mCPF );" maxlength="14" />
                            <label for="inputLastName">CPF</label>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-floating mb-3 mb-md-0">
                            <select class="form-control" id="selectsexo">
                                <option value="0" disabled selected>Selecione</option>
                                <option value="M">MASCULINO</option>
                                <option value="F">FEMININO</option>
                            </select>
                            <label for="selectsexo">Sexo</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input class="form-control" id="inputdatanasc" type="text" placeholder="Data de nascimento" maxlength="10" onkeypress="mascaraData(this);" />
                            <label for="inputdatanasc">Data de nascimento</label>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-floating mb-3 mb-md-0">
                            <input class="form-control" id="inputcrm" type="text" placeholder="CRM" />
                            <label for="inputcrm">CRM</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input class="form-control" id="inputespecialidade" type="text" placeholder="Especialidade" />
                            <label for="inputespecialidade">Especialidade</label>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-floating mb-3 mb-md-0">
                            <input class="form-control" id="inputemail" type="text" placeholder="E-Mail" />
                            <label for="inputemail">E-Mail</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input class="form-control telefone" id="inputtel" type="text" placeholder="Telefone" maxlength="15" />
                            <label for="inputtel">Telefone com DDD</label>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-floating mb-3 mb-md-0">
                            <input class="form-control" id="inputsenha" type="password" placeholder="Crie uma senha" />
                            <label for="inputsenha">Senha</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-3 mb-md-0">
                            <input class="form-control" id="inputconfirmapw" type="password" placeholder="Confirme a senha" />
                            <label for="inputconfirmapw">Confirme a senha</label>
                        </div>
                    </div>
                </div>
                <div class="mt-4 mb-0">
                    <div class="d-grid"><a class="btn btn-primary btn-block" id="btncadmed">Cadastrar</a></div>
                </div>
                </form>

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