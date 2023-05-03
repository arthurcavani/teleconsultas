<?php
require_once("vendor/autoload.php");
require_once("classes/config.php");
require_once("classes/DB.class.php");
// include_once('classes/PHPMailerAutoload.php');
// require_once("classes/class.upload.php");
//include_once("classes/Geral.class.php");
require_once("classes/CRUD.class.php");
require_once("classes/Usuario.class.php");
require_once("classes/Endereco.class.php");
require_once("classes/Paciente.class.php");
require_once("classes/Medico.class.php");
require_once("classes/Telefone.class.php");
require_once("classes/Agendamento.class.php");
require_once("classes/Consulta.class.php");
require_once("classes/Disponibilidade.class.php");
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Teleconsultas">
  <meta name="author" content="Teleconsultas">
  <META NAME="KEYWORDS" CONTENT="Teleconsultas">
  <META NAME="KEYWORDS" CONTENT="Teleconsultas">
  <META NAME="LANGUAGE" CONTENT="PT-BR">
  <title>Teleconsultas</title>
  <link href="css/styles.css" rel="stylesheet" />
  <meta property="og:image" content="./img/logo.png">
  <link rel="icon" type="image/png" sizes="26x26" href="./img/logo.png" alt="Teleconsultas" title="Teleconsultas">
  <script src="./js/toastr.min.js"></script>
  <link href="./assets/node_modules/toast-master/css/jquery.toast.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <script type="text/javascript" src="./js/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
  <script src="./js/toastr.min.js"></script>
  <script src="./js/bootbox.js"></script>
  <script src="./js/maskbrphone.js"></script>
  <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
</head>