<?php
require_once('include.php');

if (!isset($_SESSION)) {
    session_start();
}

?>

<body class="sb-nav-fixed">
    <?php require_once('nav.php');
    $usuario = new Usuario();
    $usuario->loadById($_SESSION['_id_usuario']);
    $imgperfil = $usuario->getImgperfil();
    if ($imgperfil == "") {
        $imgperfil = "notfound.jpg";
    }
    if ($usuario->getTipo() == 2) {
        $paciente = new Paciente();
        $paciente->loadById($_SESSION['_id_usuario']);
    } else {
        $medico = new Medico();
        $medico->loadById($_SESSION['_id_usuario']);
    }
    ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Meus Dados</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="index.php">Início</a></li>
                    <li class="breadcrumb-item active">Meus Dados</li>
                </ol>
                <div class="mt-3">
                    <form method="POST" action="upload.php" enctype="multipart/form-data" id="formimg">
                        <div class="row">
                            <div class="small-12 medium-2 large-2 columns">
                                <div class="circle">
                                    <img class="profile-pic" src="imgperfil/<?php echo $imgperfil; ?>">
                                </div>
                                <div>
                                    <label class="btnup" for="fileToUpload">
                                    <i class="fa fa-camera"></i>
                                        <input type="file" accept="image/*" name="fileToUpload" id="fileToUpload" class="isVisuallyHidden" onchange="document.getElementById('formimg').submit();" />
                                    </label>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="row mt-4 mb-3">
                    <div class="col-md-6">
                        <div class="form-floating mb-3 mb-md-0">
                            <input type="hidden" id="tipouser" value="<?php echo $usuario->getTipo(); ?>" />
                            <input class="form-control" id="inputnome" type="text" placeholder="Nome completo" value="<?php echo $usuario->getNome(); ?>" />
                            <label for="inputnome">Nome completo</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input class="form-control" id="inputcpf" type="text" placeholder="CPF" onkeydown="javascript: fMasc( this, mCPF );" maxlength="14" value="<?php echo $usuario->getCpf(); ?>" />
                            <label for="inputcpf">CPF</label>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-floating mb-3 mb-md-0">
                            <select class="form-control" id="selectsexo">
                                <?php
                                $masc = '';
                                $fem = '';
                                if ($usuario->getSexo() == 'M') {
                                    $masc = 'selected';
                                } else {
                                    $fem = 'selected';
                                }
                                ?>
                                <option value="M" <?php echo $masc; ?>>MASCULINO</option>
                                <option value="F" <?php echo $fem; ?>>FEMININO</option>
                            </select>
                            <label for="selectsexo">Sexo</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input class="form-control" id="inputdatanasc" type="text" placeholder="Data de nascimento" maxlength="10" onkeypress="mascaraData(this)" value="<?php echo $usuario->getDatanasc(); ?>" />
                            <label for="inputdatanasc">Data de nascimento</label>
                        </div>
                    </div>
                </div>
                <?php if ($usuario->getTipo() == 2) {
                    $profissao = '';
                ?>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-floating mb-3 mb-md-0">
                                <select class="form-control" id="selectecivil">
                                    <?php
                                    $ecivil = CRUD::Select('estadocivil', 'id ASC');
                                    foreach ($ecivil['dados'] as $finalcivil) {
                                        if ($finalcivil['id'] == $paciente->getId_estadocivil()) {
                                            echo '<option value="' . $finalcivil['id'] . '" selected>' . $finalcivil['ec'] . '</option>';
                                        } else {
                                            echo '<option value="' . $finalcivil['id'] . '">' . $finalcivil['ec'] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                                <label for="selectecivil">Estado civil</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-control" id="selectnacionalidade">
                                    <?php
                                    $paises = CRUD::Select('nacionalidade', 'id ASC');
                                    foreach ($paises['dados'] as $pais) {
                                        if ($pais['id'] == $paciente->getNacionalidade()) {
                                            echo '<option value="' . $pais['id'] . '" selected>' . $pais['paisNome'] . '</option>';
                                        } else {
                                            echo '<option value="' . $pais['id'] . '">' . $pais['paisNome'] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                                <label for="selectnacionalidade">Nacionalidade</label>
                            </div>
                        </div>
                    </div>
                <?php } else $profissao = 'disabled'; ?>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-floating mb-3 mb-md-0">
                            <select class="form-control" id="selectprof" <?php echo $profissao; ?>>
                                <?php
                                $profs = CRUD::Select('profissao', 'id ASC');
                                if ($usuario->getTipo() == 2) {
                                    foreach ($profs['dados'] as $prof) {
                                        if ($prof['id'] == $paciente->getId_profissao()) {
                                            echo '<option value="' . $prof['id'] . '" selected>' . $prof['prof'] . '</option>';
                                        } else {
                                            echo '<option value="' . $prof['id'] . '">' . $prof['prof'] . '</option>';
                                        }
                                    }
                                } else {
                                    foreach ($profs['dados'] as $prof) {
                                        if ($prof['id'] == 362) {
                                            echo '<option value="' . $prof['id'] . '" selected>' . $prof['prof'] . '</option>';
                                        } else {
                                            echo '<option value="' . $prof['id'] . '">' . $prof['prof'] . '</option>';
                                        }
                                    }
                                }

                                $tel = new Telefone();
                                $tel->loadByIdUser($_SESSION['_id_usuario']);
                                ?>
                            </select>
                            <label for="selectprof">Profissão</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input class="form-control telefone" id="inputtel" type="text" placeholder="Telefone" maxlength="15" value="<?php echo $tel->getTel(); ?>" />
                            <label for="inputtel">Telefone com DDD</label>
                        </div>
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input class="form-control" id="inputemail" type="text" placeholder="E-Mail" value="<?php echo $usuario->getEmail(); ?>" />
                    <label for="inputemail">E-Mail</label>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-floating mb-3 mb-md-0">
                            <input class="form-control" id="inputsenha" type="password" placeholder="Crie uma senha" />
                            <label for="inputsenha">Nova Senha</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-3 mb-md-0">
                            <input class="form-control" id="inputconfirmasenha" type="password" placeholder="Confirme a senha" />
                            <label for="inputconfirmapw">Confirme a nova senha</label>
                        </div>
                    </div>
                </div>
                <div class="mt-4 mb-0">
                    <div class="d-grid"><a class="btn btn-primary btn-block" id="btnalteradados">Alterar</a></div>
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
    if (isset($_SESSION['msg']) && isset($_SESSION['tipomsg'])) {
    ?>
        <script>
            toastr.<?php echo $_SESSION['tipomsg']; ?>("<?php echo $_SESSION['msg']; ?>");
        </script>
    <?php }
    unset($_SESSION['msg']);
    unset($_SESSION['tipomsg']);
    ?>
</body>

</html>