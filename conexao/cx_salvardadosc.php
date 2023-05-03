<?php
require_once(dirname(dirname(__FILE__)) . "/classes/Usuario.class.php");
require_once(dirname(dirname(__FILE__)) . "/classes/Agendamento.class.php");
if (!isset($_SESSION)) {
    session_start();
}
if (
    isset($_POST['ida']) && isset($_POST['cid']) && isset($_POST['diagnostico']) && isset($_POST['obs'])) {
    extract($_POST);
    $ag = new Agendamento();
    $ag->loadById($ida);
    if ($ag->getId_medico() == $_SESSION["_id_usuario"]){
        $update = CRUD::UpdateAjax("consulta", "cid = \"$cid\", diagnostico = \"$diagnostico\", observacoes = \"$obs\" WHERE id = {$ida}");
        if ($update != false){
            echo "1";
        } else echo "0";
    } else echo "0";
} else echo "0";
