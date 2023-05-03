<?php
require_once(dirname(dirname(__FILE__)) . "/classes/Agendamento.class.php");
if (!isset($_SESSION)) {
  session_start();
}
extract($_POST);
echo json_encode(Agendamento::ProxDisp($idm), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

