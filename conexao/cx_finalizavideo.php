<?php
require_once(dirname(dirname(__FILE__)) . "/classes/Consulta.class.php");
require_once(dirname(dirname(__FILE__)) . "/classes/Agendamento.class.php");
require_once(dirname(dirname(__FILE__)) . "/classes/Usuario.class.php");
require_once(dirname(dirname(__FILE__)) . "/classes/Medico.class.php");
require_once(dirname(dirname(__FILE__)) . "/classes/Paciente.class.php");
if (!isset($_SESSION)) {
  session_start();
}
if (!isset($_SESSION['_id_usuario']) || $_SESSION['_id_usuario'] < 1 || !isset($_POST['ida'])) {
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
if ($agendamento->getId() < 1 || $consulta->getId() < 1) {
  echo "-1";
  exit();
}

if ($_SESSION['_id_usuario'] != $agendamento->getId_medico()) {
  echo "-1";
  exit();
}

$now = new DateTime();
$now->setTimezone(new DateTimeZone('America/Sao_Paulo'));
$now = $now->format('Y-m-d H:i:s');
$update = CRUD::UpdateAjax("agendamento", "confirmado = 3 WHERE id = {$ida}");
if ($update != false) {
  $update = CRUD::UpdateAjax("consulta", "dtfinalizada = '$now' WHERE id = {$ida}");
  if ($update != false) {
    echo "1";
  } else {
    CRUD::UpdateAjax("agendamento", "confirmado = 2 WHERE id = {$ida}");
    echo "-1";
  }
} else echo "-1";
