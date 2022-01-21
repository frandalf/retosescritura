<?php 

include_once("includes/config.php");
include_once("includes/CRUD.php");
session_start();

if(!isset($_SESSION['user_id'])){
    header('Location: views/login.php');
    exit;
}
deleteDiasUser($dbConn);

header('Location: index.php');
?>