<?php
require_once('include.php');

if (!isset($_SESSION)) {
    session_start();
}

$user = new Usuario();
$user->loadById($_SESSION['_id_usuario']);
if ($user->getTipo() != 1) {
    header("Location: index.php");
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
                <h1 class="mt-4">Lista de Pacientes</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="index.php">Início</a></li>
                    <li class="breadcrumb-item active">Lista de Pacientes</li>
                </ol>
                <hr>

                <?php
                $pacientes = Paciente::ListaPacientes();

                if ($pacientes['num'] < 1) {
                    echo "<span class='mt-3'><b>Não há pacientes cadastrados.</b></span><hr>";
                } else {
                ?>

                    <div class="card mb-4">
                        <!-- <div class="card-header">
                        </div> -->
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Sexo</th>
                                        <th>Data Nascimento</th>
                                        <th>E-Mail</th>
                                        <th>Detalhes</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Sexo</th>
                                        <th>Data Nascimento</th>
                                        <th>E-Mail</th>
                                        <th>Detalhes</th>
                                    </tr>
                                </tfoot>
                                <tbody>

                                    <?php
                                    foreach ($pacientes['dados'] as $paciente) {
                                        $nome = $paciente['nome'];
                                        if ($paciente['sexo'] == 'M') {
                                            $sexo = "Masculino";
                                        } else {
                                            $sexo = "Feminino";
                                        }
                                        $datanasc = explode("-", $paciente['datanasc']);
                                        $datanasc = $datanasc[2] . "/" . $datanasc[1] . "/" . $datanasc[0];
                                        $email = $paciente['email'];
                                    ?>
                                        <tr>
                                            <td style="text-align: center; vertical-align: middle;"><b><?php echo $nome; ?></b></td>
                                            <td style="text-align: center; vertical-align: middle;"><b><?php echo $sexo; ?></b></td>
                                            <td style="text-align: center; vertical-align: middle;"><b><?php echo $datanasc; ?></b></td>
                                            <td style="text-align: center; vertical-align: middle;"><b><?php echo $email; ?></b></td>
                                            <td style="text-align: center; vertical-align: middle;"><a class="btn btn-primary btn-block detalhespaciente" data-id="<?php echo $paciente['id']; ?>">Detalhes</a></td>
                                        </tr>
                                    <?php } ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php } ?>

            </div>
            <div class="modal fade" tabindex="-1" id="modal-detalhepaciente">
                <div class="modal-dialog modal-dialog-centered modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Detalhes do Paciente</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="d-flex justify-content-center mb-3">
                                <div class="circle">
                                    <img class="profile-pic" id="imgperf" src="">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <input class="form-control" id="inputnome" type="text" placeholder="Nome completo" value="" />
                                        <label for="inputnome">Nome completo</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input class="form-control" id="inputcpf" type="text" placeholder="CPF" onkeydown="javascript: fMasc( this, mCPF );" maxlength="14" value="" />
                                        <label for="inputcpf">CPF</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <input class="form-control" id="inputsexo" type="text" placeholder="Sexo" maxlength="8" value="" />
                                        <label for="inputsexo">Sexo</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input class="form-control" id="inputdatanasc" type="text" placeholder="Data de nascimento" maxlength="10" onkeypress="mascaraData(this)" value="" />
                                        <label for="inputdatanasc">Data de nascimento</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <input class="form-control" id="inputemail" type="text" placeholder="E-Mail" value="" />
                                        <label for="inputemail">E-Mail</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input class="form-control" id="inputtel" type="text" placeholder="Telefone" value="" />
                                        <label for="inputtel">Telefone</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <input class="form-control" id="inputprofissao" type="text" placeholder="Profissão" value="" />
                                        <label for="inputprofissao">Profissão</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input class="form-control" id="inputecivil" type="text" placeholder="Estado Civil" value="" />
                                        <label for="inputecivil">Estado Civil</label>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <a href='' id="btnconsultas"><button type="button" class="btn btn-primary">Consultas do Paciente</button></a>
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