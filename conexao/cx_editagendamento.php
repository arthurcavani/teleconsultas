<?php
require_once(dirname(dirname(__FILE__)) . "/classes/Agendamento.class.php");
require_once(dirname(dirname(__FILE__)) . "/classes/Usuario.class.php");
if (!isset($_SESSION)) {
  session_start();
}
extract($_POST);
$user = new Usuario();
$user->loadById($_SESSION['_id_usuario']);

if ($operacao == 1) {
  if ($user->getTipo() == 1) {
    Agendamento::AprovaAgendamento($ida);
    echo "1";
  } else {
    echo "-1";
  }
} else {
  if ($user->getTipo() == 1) {
    Agendamento::CancelaAgendamentoMedico($ida);
    echo "1";
  } else {
    Agendamento::CancelaAgendamentoPaciente($ida, $user->getId());
    echo "1";
  }
}
