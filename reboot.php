<?php 
include_once("includes/config.php");
include_once("includes/CRUD.php");
session_start();

if(!isset($_SESSION['user_id'])){
    header('Location: views/login.php');
    exit;
}

if (isset($_POST)) {
    $insertarDia = true;
    $post_Palabras = 0;
    $post_Tipo = "";
    $post_Proyecto = "";


    if (isset($_POST['palabras'])) {
        $post_Palabras = $_POST['palabras'];
        if ($post_Palabras == "" || $post_Palabras == null || empty($post_Palabras))  {
            $post_Palabras = 0;
        }
    } else {
        $insertarDia = false;
    }
    
    if (isset($_POST['tipo'])) {
        $post_Tipo = $_POST['tipo'];
    } else {
        $insertarDia = false;
    }

    if (isset($_POST['proyecto'])) {
        $post_Proyecto = $_POST['proyecto'];
    } else {
        $insertarDia = false;
    }

    $editar = false;
    if (isset($_POST['editar'])) {
        //Editamos día
        $editar = true;
        $idDia = getLastIdDia($dbConn);
        echo $idDia;
        updateDia($dbConn, $idDia, $post_Palabras, $post_Tipo, $post_Proyecto);
    } else {
        // Insertamos día
        if ($insertarDia) {
            addDiaHoy($dbConn, $post_Palabras, $post_Tipo, $post_Proyecto);
        }
    }

    


/*
    // Insertamos día
    if ($insertarDia) {
        addDiaHoy($dbConn, $post_Palabras, $post_Tipo, $post_Proyecto);
    }
*/

    $numDiasActuales = getNumDias($dbConn);
    $recordPersonal = getRecordPersonal($dbConn);

    if ($numDiasActuales > $recordPersonal) {
        updateRecordPersonal($dbConn, $numDiasActuales);
    } else {
        updateDiasActuales($dbConn, $numDiasActuales);
    }


    
    $_POST['palabras'] = null;
    $_POST['tipo'] = null;
    unset($_POST['palabras']);
    unset($_POST['tipo']);
    
    // Evitamos el repost con reload recargando la página
    unset($_POST['palabras']);
    unset($_POST['tipo']);
    unset($_POST);
    header('Location: index.php');
    

}



?>