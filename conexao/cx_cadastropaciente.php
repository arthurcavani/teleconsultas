<?php
require_once(dirname(dirname(__FILE__)) . "/classes/Usuario.class.php");
if (!isset($_SESSION)) {
  session_start();
}

if (!isset($_POST)) {
  echo "0";
  exit();
}
extract($_POST);
$senha_check = $_POST['senha'];


if (Usuario::emailDisponivel($_POST['email'])){
  if (strlen($senha_check) < 6) {
    echo "3";
  } else {
    $datanascf = explode("/", $datanasc);
    $datanasc = $datanascf[2] . "-" . $datanascf[1] . "-" . $datanascf[0];
    $novo = Usuario::novoPaciente($nome, $cpf, $senha, $sexo, $datanasc, $email, $estadocivil, $profissao, $nacionalidade, $tel);   
    $user = new Usuario();
    $user->logar($_POST['email'], $senha_check);
    if ($user->getId() > 0){
    echo "1";
    } else {
      echo "4";
    }

  }

} else {
  echo "2";
}


