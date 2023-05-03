<?php
require_once("classes/Usuario.class.php");
if (!isset($_SESSION)) {
  session_start();
}

if (!isset($_SESSION['_id_usuario']) || $_SESSION['_id_usuario'] < 1) {
  header("Location: login.php");
  exit();
}

$target_dir = "imgperfil\\";
$source_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$imageFileType = strtolower(pathinfo($source_file, PATHINFO_EXTENSION));
$target_file = $target_dir . $_SESSION["_id_usuario"] . "." . $imageFileType;

$uploadOk = 1;

//Checar se é uma imagem 
if (isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if ($check !== false) {
    $uploadOk = 1;
  } else {
    $uploadOk = 0;
    $_SESSION['msg'] = 'Arquivo inválido';
    $_SESSION['tipomsg'] = 'warning';
  }
}

if (file_exists($target_file)) {
  chmod($target_file, 0755);
  unlink($target_file);
}

if ($_FILES["fileToUpload"]["size"] / 1024 > 5000) {
$uploadOk = 0;
$_SESSION['msg'] = 'Limite de 5mb excedido';
$_SESSION['tipomsg'] = 'warning';
}

if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
  $uploadOk = 0;
  $_SESSION['msg'] = 'Selecione uma imagem jpg, jpeg ou png';
  $_SESSION['tipomsg'] = 'warning';
}

if ($uploadOk == 0) {
  header("Location: meusdados.php");
  exit();
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    $_SESSION['msg'] = 'Imagem de perfil alterada';
    $_SESSION['tipomsg'] = 'success';
    Usuario::alteraImgPerfil($_SESSION["_id_usuario"] . "." . $imageFileType, $_SESSION["_id_usuario"]);
    header("Location: meusdados.php");
  } else {
    $_SESSION['msg'] = 'Erro ao fazer upload';
    $_SESSION['tipomsg'] = 'warning';
    header("Location: meusdados.php");
  }
}

