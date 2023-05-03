<?php
require_once(dirname(dirname(__FILE__)) . "/classes/Agendamento.class.php");
if (!isset($_SESSION)) {
  session_start();
}
extract($_POST);
$ag = new Agendamento();
$ag->loadById($ida);
if ($ag->getId() < 0) {
  echo "-1";
} else {
  echo $ag->getConfirmado();
}

