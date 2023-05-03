<?php
require_once(dirname(dirname(__FILE__)) . "/classes/Usuario.class.php");
require_once(dirname(dirname(__FILE__)) . "/classes/Disponibilidade.class.php");
if (!isset($_SESSION)) {
    session_start();
}

$user = new Usuario();
$user->loadById($_SESSION['_id_usuario']);
$disp = new Disponibilidade();
$disp->loadById($_SESSION['_id_usuario']);

if (
    isset($_POST['seg']) && isset($_POST['ter']) && isset($_POST['qua']) && isset($_POST['qui']) && isset($_POST['sex']) && isset($_POST['sab']) && isset($_POST['dom'])
    && isset($_POST['duracao']) && isset($_POST['primeira']) && isset($_POST['ultima']) && isset($_POST['iniciop']) && isset($_POST['fimp']) && ($user->getTipo() == 1)
) {
    extract($_POST);
    $idusuario = $_SESSION['_id_usuario'];
    if ($disp->getId_medico() > 0) {
        $update = CRUD::UpdateAjax("disponibilidade", 
        "duracao_consulta = \"$duracao\", primeira_consulta = \"$primeira\", ultima_consulta = \"$ultima\", inicio_pausa = \"$iniciop\", fim_pausa = \"$fimp\", seg = \"$seg\", ter = \"$ter\", qua = \"$qua\", qui = \"$qui\", sex = \"$sex\", sab = \"$sab\", dom = \"$dom\" WHERE id_medico = {$idusuario}");
        echo "1";
    } else {
        $newid = CRUD::InsertAjax("disponibilidade", "id_medico = \"$idusuario\", duracao_consulta = \"$duracao\", primeira_consulta = \"$primeira\", ultima_consulta = \"$ultima\", inicio_pausa = \"$iniciop\", fim_pausa = \"$fimp\", seg = \"$seg\", ter = \"$ter\", qua = \"$qua\", qui = \"$qui\", sex = \"$sex\", sab = \"$sab\", dom = \"$dom\"");
        echo "1";
    }
} else echo "2";
