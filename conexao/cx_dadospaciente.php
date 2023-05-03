<?php
require_once(dirname(dirname(__FILE__)) . "/classes/Usuario.class.php");
require_once(dirname(dirname(__FILE__)) . "/classes/Paciente.class.php");
require_once(dirname(dirname(__FILE__)) . "/classes/Telefone.class.php");
if (!isset($_SESSION)) {
  session_start();
}
$adm = new Usuario();
$adm->loadById($_SESSION['_id_usuario']);
if ($adm->getTipo() == 1) {
  if (isset($_POST['idu'])) {
    extract($_POST);
    $paciente = new Usuario();
    $paciente->loadById($idu);
    $imgperfil = $paciente->getImgperfil();
    if ($imgperfil == "") {
      $imgperfil = "notfound.jpg";
  }
    $paciente2 = new Paciente();
    $paciente2->loadById($idu);
    $tel = new Telefone();
    $tel->loadByIdUser($idu);
    if ($paciente->getId() > 0 && $paciente2->getId_usuario() > 0) {
      $sexo = $paciente->getSexo();
      if ($sexo == 'M'){
        $sexo = 'Masculino';
      } else {
        $sexo = 'Feminino';
      }

      echo json_encode(array(
        "id" => $paciente->getId(),
        "nome" => $paciente->getNome(),
        "cpf" => $paciente->getCpf(),
        "sexo" => $sexo,
        "datanasc" => $paciente->getDatanasc(),
        "email" => $paciente->getEmail(),
        "ecivil" => Paciente::getEcivilString($paciente2->getId_estadocivil()),
        "profissao" => Paciente::getProfString($paciente2->getId_profissao()),
        "telefone" => $tel->getTel(),
        "imgperfil" => $imgperfil
      ), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    } else {
      echo "0";
    }
  } else {
    echo "0";
  }
} else {
  echo "0";
}
