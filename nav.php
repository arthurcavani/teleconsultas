<?php
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['_id_usuario']) && $_SESSION['_id_usuario'] > 0) {
    $user = new Usuario();
    $user->loadById($_SESSION['_id_usuario']);
    if ($user->getId() < 1) {
        Usuario::sair();
        header("Location: login.php");
        exit();
    }
    $nomeuser = $user->getNome();
} else {
    Usuario::sair();
    header("Location: login.php");
    exit();
}

?>
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3" href="index.php">Teleconsultas</a>
    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
    <!-- Navbar Search-->
    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        <!-- <div class="input-group">
            <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
            <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
        </div> -->
    </form>
    <!-- Navbar-->
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="meusdados.php">Meu Perfil</a></li>
                <li>
                    <hr class="dropdown-divider" />
                </li>
                <li><a class="dropdown-item" href="logout.php">Sair</a></li>
            </ul>
        </li>
    </ul>
</nav>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <a class="nav-link" href="index.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
                        Início
                    </a>
                    <div class="sb-sidenav-menu-heading">Consultas</div>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                        <div class="sb-nav-link-icon"><i class="fas fa-calendar"></i></div>
                        Minhas consultas
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <?php
                            if ($user->getTipo() == 2) {
                            ?>
                                <a class="nav-link" href="agendar.php">Agendar</a>
                            <?php } ?>
                            <a class="nav-link" href="futuras.php">Próximas</a>
                            <a class="nav-link" href="pendentes.php">Aguardando aprovação</a>
                            <a class="nav-link" href="passadas.php">Passadas</a>
                        </nav>
                    </div>

                    <?php
                    if ($user->getTipo() == 1) {
                    ?>
                        <div class="sb-sidenav-menu-heading">Pacientes</div>
                        <a class="nav-link" href="pacientes.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                            Listar
                        </a>

                        <div class="sb-sidenav-menu-heading">Médicos</div>
                        <a class="nav-link" href="medicos.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                            Listar
                        </a>
                        <a class="nav-link" href="cadastro-medico.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                            Cadastrar
                        </a>
                    <?php } ?>

                    <div class="sb-sidenav-menu-heading">Meus dados</div>

                    <a class="nav-link" href="meusdados.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                        Dados Pessoais
                    </a>
                    <?php
                    if ($user->getTipo() == 1) {
                    ?>
                        <a class="nav-link" href="disponibilidade.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Disponibilidade
                        </a>
                    <?php } ?>
                </div>
            </div>
            <div class="sb-sidenav-footer">
                <div class="small">Bem vindo(a),</div>
                <?php echo $nomeuser; ?>
            </div>
        </nav>
    </div>