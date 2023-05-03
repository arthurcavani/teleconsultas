<?php
require_once(dirname(dirname(__FILE__)) . "/classes/Usuario.class.php");
if (!isset($_SESSION)) {
  session_start();
}

if (isset($_POST['login']) && isset($_POST['senha'])) {
  extract($_POST);


  $usuario = new Usuario();
  $usuario->logar(trim($login), $senha);

  if ($usuario->getId() > 0) {    
    echo $usuario->getTipo();
  } else {
    echo "-1";
  }
} else {
  echo "-2";
}
