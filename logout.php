<?php
require_once("classes/Usuario.class.php");
if (!isset($_SESSION)){
    session_start();
  }
Usuario::sair();
header('Location: login.php');
