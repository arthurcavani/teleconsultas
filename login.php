<?php
include_once('include.php');

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['_id_usuario'])) {
    $user = new Usuario();
    $user->loadById($_SESSION['_id_usuario']);
    if ($user->getId() > 0){
    header("Location: index.php");
    } else {
        Usuario::sair();
    }
}
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
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Entrar</h3>
                                </div>
                                <div class="card-body">
                                    <form>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputEmail" type="email" placeholder="nome@exemplo.com" />
                                            <label for="inputEmail">E-mail</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputPassword" type="password" placeholder="Password" />
                                            <label for="inputPassword">Senha</label>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <a class="small" href="password.html">Esqueceu a senha?</a>
                                            <a class="btn btn-primary" id="loginbtn">Login</a>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small"><a href="cadastro.php">Criar uma conta</a></div>
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
    <script>
        document.getElementById('inputPassword').onkeypress = function(e) {
            if (!e) e = window.event;
            if (e.keyCode == '13') {
                $("#loginbtn").click();
                return false;
            }
        }
        document.getElementById('inputEmail').onkeypress = function(e) {
            if (!e) e = window.event;
            if (e.keyCode == '13') {
                $("#loginbtn").click();
                return false;
            }
        }
    </script>
    <?php
    include_once('scripts.php');
    ?>

</body>

</html>