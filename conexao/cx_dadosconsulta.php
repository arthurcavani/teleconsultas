<?php
require_once(dirname(dirname(__FILE__)) . "/classes/Usuario.class.php");
require_once(dirname(dirname(__FILE__)) . "/classes/Medico.class.php");
require_once(dirname(dirname(__FILE__)) . "/classes/Consulta.class.php");
if (!isset($_SESSION)) {
  session_start();
}

$consulta = new Consulta();
$consulta->loadById($_POST['idc']);

$user = new Usuario();
$user->loadById($_SESSION['_id_usuario']);
$permission = false;

$tipologado = $user->getTipo();

if ($user->getTipo() == 1 && $consulta->getId() > 0 && $consulta->getId_medico() == $_SESSION['_id_usuario']){
    $permission = true;
} else if ($user->getTipo() == 2 && $consulta->getId() > 0 && $consulta->getId_usuario() == $_SESSION['_id_usuario']){
  $permission = true;
}

if ($permission) {
  $paciente = new Usuario();
  $paciente->loadById($consulta->getId_usuario());

  $medico = new Usuario();
  $medico->loadById($consulta->getId_medico());
  $especialidade = new Medico();
  $especialidade->loadById($consulta->getId_medico());
  $especialidade = $especialidade->getEspecialidade();

  $data = new DateTime($consulta->getDtiniciada());
  $data = $data->format('d/m/Y');

  echo json_encode(array(
    "paciente" => $paciente->getNome(),
    "medico" => $medico->getNome(),
    "cid" => $consulta->getCid(),
    "diagnostico" => $consulta->getDiagnostico(),
    "data" => $data,
    "especialidade" => $especialidade,
    "obs" => $consulta->getObservacoes(),
    "tipologado" => $tipologado
  ), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
} else {
  echo "0";
}
