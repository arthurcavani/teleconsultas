<?php
require_once(dirname(dirname(__FILE__)) . "/classes/Agendamento.class.php");
require_once(dirname(dirname(__FILE__)) . "/classes/Medico.class.php");
if (!isset($_SESSION)) {
  session_start();
}
if ($_SESSION['_id_usuario'] < 1 || !isset($_SESSION['_id_usuario'])) {
  echo "-1";
  exit();
}
extract($_POST);
$dataf = explode("/", $dataf);
$dataf1 = $dataf[2] . "-" . $dataf[1] . "-" . $dataf[0];
$horaf1 = $horaf . ":00";
$especialidade = new Medico();
$especialidade->loadById($id_medico);
$especialidade = $especialidade->getEspecialidade();
$_SESSION['msg'] = "Pedido de agendamento enviado!";
echo Agendamento::novoAgendamento($_SESSION['_id_usuario'], $id_medico, $dataf1, $horaf1, $especialidade);
