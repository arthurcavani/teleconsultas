<?php
if (!isset($_SESSION)) {
  session_start();
}
include("login.php");
?>


<header>
  <div class="navbar navbar-dark navbar-style shadow-sm p-0 justify-content-between" id="menu">
    <div class="container">
      <a href="index.php" class="navbar-brand">
        <div class="logo-ajust">
          <img src="./img/logo_final.png" class="LogoImg">
        </div>
      </a>


      <?php if (isset($_SESSION['_id_usuario'])) {
        $usercontrol = "block";
        $dologin = "none";
        $user = new Usuario();
        $user->loadById($_SESSION['_id_usuario']);
        $rsp = Pedido::verificaAberto($user->getIdusuario());
        if ($rsp != false) {
          $acompanhar = "block";
        } else {
          $acompanhar = "none";
        }

        if ($user->getAdmin() == "1") {
          $admincontrol = "block";
        } else {
          $admincontrol = "none";
        }
      } else {
        $rsp = 0;
        $acompanhar = "none";
        $usercontrol = "none";
        $admincontrol = "none";
        $dologin = "block";
      }
      ?>

      <div class="dropdown" id="dropmenu">

        <!-- <button class="dropbtn" onclick="document.getElementById('dropd').style.display='block'" onmouseover="document.getElementById('dropd').style.display='block'">Menu</button> -->


        <img src="./img/burgmenu.svg" class="styleburgermenu"
          onclick="document.getElementById('dropd').style.display='block'"
          onmouseover="document.getElementById('dropd').style.display='block'">

        <div class="dropdown-content" id="dropd">

          <a id="acompanhar" onclick="window.location.href = 'visualizar.php?idp=<?php echo $rsp; ?>';"
            style="display: <?php echo $acompanhar; ?>;">
            <img src="./img/ultimop.gif" style="cursor: pointer;"
              onclick="window.location.href = 'visualizar_pedido.php?idp=<?php echo $rsp; ?>';" height="20" whidth="20">
            <span id="menucol">Último pedido</span>
          </a>

          <a data-target="#login" data-toggle="modal" id="dologin" onclick="modalAnimate3()"
            style="display: <?php echo $dologin; ?>;">
            <img src="./img/login.png" class="mr-1" style="cursor: pointer;" onclick="modalAnimate3()" height="17"
              whidth="17">
            <span id="menucol">Login</span></a>

          <a data-target="#login" data-toggle="modal" id="docad" onclick="modalAnimate2()"
            style="display: <?php echo $dologin; ?>;">
            <img src="./img/cadastrar.png" class="mr-1" style="cursor: pointer;" onclick="modalAnimate2()" height="18"
              whidth="18">
            <span id="menucol">Cadastrar</span></a>

          <a onclick="modalcpf()" id="visup" style="display: <?php echo $dologin; ?>;">
            <img src="./img/pedidos.png" class="mr-1" style="cursor: pointer;" onclick="modalcpf()" height="18"
              whidth="18">
            <span id="menucol">Pedidos</span></a>

          <a href="meu_perfil.php" id="meusp" style="display: <?php echo $usercontrol; ?>;">
            <img src="./img/pedidos.png" class="mr-1" style="cursor: pointer;" height="18" whidth="18">
            <span id="menucol">Meus pedidos</span></a>

          <a href="meu_perfil.php?p=perfil" id="meuperf" style="display: <?php echo $usercontrol; ?>;">
            <img src="./img/user.png" class="mr-1" style="cursor: pointer;" height="18" whidth="18">
            <span id="menucol">Meu perfil</span></a>

          <a href="admin.php" id="admincontrol" style="display: <?php echo $admincontrol; ?>;">
            <img src="./img/admin.png" class="mr-2" style="cursor: pointer;" height="16" whidth="16">
            <span id="menucol">Admin</span></a>

          <a href="logout.php" id="logoutp" class="logout" style="display: <?php echo $usercontrol; ?>;">
            <img src="./img/logout.png" class="mr-1" style="cursor: pointer;" height="18" whidth="18">
            <span id="menucol">Sair</span></a>
        </div>
      </div>
    </div>
  </div>

</header>