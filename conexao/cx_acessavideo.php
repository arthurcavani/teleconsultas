<?php
require_once(dirname(dirname(__FILE__)) . "/classes/Consulta.class.php");
require_once(dirname(dirname(__FILE__)) . "/classes/Agendamento.class.php");
require_once(dirname(dirname(__FILE__)) . "/classes/Usuario.class.php");
require_once(dirname(dirname(__FILE__)) . "/classes/Medico.class.php");
require_once(dirname(dirname(__FILE__)) . "/classes/Paciente.class.php");
if (!isset($_SESSION)) {
  session_start();
}
if ($_SESSION['_id_usuario'] < 1 || !isset($_SESSION['_id_usuario']) || !isset($_POST['ida'])) {
  echo "-1";
  exit();
}

extract($_POST);

$user = new Usuario();
$user->loadById($_SESSION['_id_usuario']);
$consulta = new Consulta();
$consulta->loadById($ida);
$agendamento = new Agendamento();
$agendamento->loadById($ida);
if ($agendamento->getId() < 1) {
  echo "-1";
  exit();
}


if ($_SESSION['_id_usuario'] != $agendamento->getId_usuario() && $_SESSION['_id_usuario'] != $agendamento->getId_medico()) {
  echo "-1";
  exit();
}

if ($consulta->getId() < 1) {
  if ($user->getTipo() == 1) {
    $hash = Consulta::GeraHash();
    $now = new DateTime();
    $now->setTimezone(new DateTimeZone('America/Sao_Paulo'));
    $now = $now->format('Y-m-d H:i:s');
    $idsala = Consulta::CriaSala($ida, $hash);
    CRUD::InsertAjax("consulta", "id = $ida, id_usuario = " . $agendamento->getId_usuario() . ", id_medico = " . $agendamento->getId_medico() . ", idsala = $idsala, dtiniciada = '$now'");
    CRUD::UpdateAjax("agendamento", "confirmado = 2 WHERE id = {$ida}");
    echo Consulta::GeraLinkSala($_SESSION['_id_usuario'], $idsala, Consulta::GeraHash());
  } else {
    echo "0";
  }
} else {
  $hash = Consulta::GeraHash();
  echo Consulta::GeraLinkSala($_SESSION['_id_usuario'], $consulta->getIdsala(), $hash);
}
