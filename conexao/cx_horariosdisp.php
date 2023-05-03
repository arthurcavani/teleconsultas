<?php
require_once(dirname(dirname(__FILE__)) . "/classes/Agendamento.class.php");
if (!isset($_SESSION)) {
  session_start();
}
extract($_POST);
$dataf = explode("/", $dataf);
$dataf1 = $dataf[2] . "-" . $dataf[1] . "-" . $dataf[0];
echo json_encode(Agendamento::DispDia($dataf1, $idm), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

