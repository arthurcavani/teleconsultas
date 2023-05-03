<?php
require_once(dirname(dirname(__FILE__)) . "/classes/Usuario.class.php");
if (!isset($_SESSION)) {
    session_start();
}
if (
    isset($_POST['nome']) && isset($_POST['telefone']) && isset($_POST['cpf']) && isset($_POST['novasenha']) && isset($_POST['sexo']) && isset($_POST['datanasc']) && isset($_POST['email'])
    && isset($_POST['estadocivil']) && isset($_POST['profissao']) && isset($_POST['nacionalidade'])
) {
    extract($_POST);

    if (isset($_SESSION['_id_usuario'])) {
        $idusuario = $_SESSION['_id_usuario'];
        $user = new Usuario();
        $user->loadById($idusuario);
        $datanascf = explode("/", $datanasc);
        $datanasc = $datanascf[2] . "-" . $datanascf[1] . "-" . $datanascf[0];
        $update = CRUD::UpdateAjax("usuario", "nome = \"$nome\", cpf = \"$cpf\", sexo = \"$sexo\", datanasc = \"$datanasc\" WHERE id = {$idusuario}");
        $update = CRUD::UpdateAjax("telefone", "tel = \"$telefone\" WHERE id_usuario = {$idusuario}");

        if ($user->getTipo() == 2) {
            $update = CRUD::UpdateAjax("paciente", "id_estadocivil = \"$estadocivil\", id_profissao = \"$profissao\", nacionalidade = \"$nacionalidade\" WHERE id_usuario = {$idusuario}");
        }

        if ($novasenha != 0) {
            $updatesenha = Usuario::alteraSenha($idusuario, $novasenha);
        }

        if ($user->getEmail() != $email) {
            if (Usuario::emailDisponivel($email)) {
                CRUD::UpdateAjax("usuario", "email = \"$email\" WHERE id = {$idusuario}");
                echo "1";
            } else echo "3";
        } else echo "1";
    } else echo "2";
} else echo "2";
