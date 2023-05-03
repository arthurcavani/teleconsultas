<?php
include_once('include.php');
?>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="loading-spinner" id="loading-spinner">
                    <div class="animated unload base" style="background-color: rgb(242, 242, 242, 0.6); width: 100%; height: 100vh;" data-animation="fadeOut" data-delay="10"></div>
                    <img src="./img/loading.gif" id="hourglass" style="width: 100px;">
                </div>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Criar uma conta</h3>
                                </div>
                                <div class="card-body">
                                    <form>
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
                                                    <input class="form-control" id="inputdatanasc" type="text" placeholder="Data de nascimento" maxlength="10" onkeypress="mascaraData(this)" />
                                                    <label for="inputdatanasc">Data de nascimento</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <select class="form-control" id="selectecivil">
                                                        <option value="0" disabled selected>Selecione</option>
                                                        <?php
                                                        $ecivil = CRUD::Select('estadocivil', 'id ASC');
                                                        foreach ($ecivil['dados'] as $finalcivil) {
                                                            echo '<option value="' . $finalcivil['id'] . '">' . $finalcivil['ec'] . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                    <label for="selectecivil">Estado civil</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <select class="form-control" id="selectnacionalidade">
                                                        <option value="0" disabled selected>Selecione</option>
                                                        <?php
                                                        $paises = CRUD::Select('nacionalidade', 'id ASC');
                                                        foreach ($paises['dados'] as $pais) {
                                                            echo '<option value="' . $pais['id'] . '">' . $pais['paisNome'] . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                    <label for="selectnacionalidade">Nacionalidade</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <select class="form-control" id="selectprof">
                                                        <option value="0" disabled selected>Selecione</option>
                                                        <?php
                                                        $profs = CRUD::Select('profissao', 'id ASC');
                                                        foreach ($profs['dados'] as $prof) {
                                                            echo '<option value="' . $prof['id'] . '">' . $prof['prof'] . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                    <label for="selectprof">Profissão</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input class="form-control telefone" id="inputtel" type="text" placeholder="Telefone" maxlength="15" />
                                                    <label for="inputtel">Telefone com DDD</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputemail" type="text" placeholder="E-Mail" />
                                            <label for="inputemail">E-Mail</label>
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
                                            <div class="d-grid"><a class="btn btn-primary btn-block" id="btncad">Cadastrar</a></div>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small"><a href="login.php">Já possui cadastro? Fazer login</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Direitos Reservados &copy; Teleconsultas</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <?php
    include_once('scripts.php');
    ?>
</body>

</html>