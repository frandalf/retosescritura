<?php 
    include_once("includes/config.php");
    include_once("includes/CRUD.php");
    session_start();
    
    if(!isset($_SESSION['user_id'])){
        header('Location: views/login.php');
        exit;
    }
    
    if (isset($_POST)) {
        var_dump($_POST);
        $fallos_permitidos = $_POST['fallos_permitidos'];
        $fallos_consecutivos = $_POST['fallos_consecutivos'];
        $premiosCada = $_POST['premiosCada'];
        $premio1 = '';
        $premio2 = '';
        $premio3 = '';
        $premio4 = '';
        $premio5 = '';
        $premio6 = '';
        $premio7 = '';
        $premio8 = '';
        $premio9 = '';
        $premio10 = '';


        if($_POST['descansar'] == "on") {
            $descansar = 1;
        } else {
            $descansar = 0;
        }

        if (isset($_POST['premio1'])) {
            $premio1 = $_POST['premio1'];
        }
        if (isset($_POST['premio2'])) {
            $premio2 = $_POST['premio2'];
        }
        if (isset($_POST['premio3'])) {
            $premio3 = $_POST['premio3'];
        }
        if (isset($_POST['premio4'])) {
            $premio4 = $_POST['premio4'];
        }
        if (isset($_POST['premio5'])) {
            $premio5 = $_POST['premio5'];
        }
        if (isset($_POST['premio6'])) {
            $premio6 = $_POST['premio6'];
        }
        if (isset($_POST['premio7'])) {
            $premio7 = $_POST['premio7'];
        }
        if (isset($_POST['premio8'])) {
            $premio8 = $_POST['premio8'];
        }
        if (isset($_POST['premio9'])) {
            $premio9 = $_POST['premio9'];
        }
        if (isset($_POST['premio10'])) {
            $premio10 = $_POST['premio10'];
        }


        
        
        if (empty(getUserPremios($dbConn))) {
            addUserPremio($dbConn, $premio1, $premio2, $premio3, $premio4, $premio5, $premio6, $premio7, $premio8, $premio9, $premio10);
        } else {
            updateUserPremio($dbConn, $premio1, $premio2, $premio3, $premio4, $premio5, $premio6, $premio7, $premio8, $premio9, $premio10);
        }
        updateConfig($dbConn, $fallos_permitidos, $fallos_consecutivos, $descansar, $premiosCada);
       

        // Evitamos el repost con reload recargando la página
        unset($_POST['fallos_permitidos']);
        unset($_POST['fallos_consecutivos']);
        unset($_POST['descansar']);
        unset($_POST['premiosCada']);
        unset($_POST['premio1']);
        unset($_POST['premio2']);
        unset($_POST['premio3']);
        unset($_POST['premio4']);
        unset($_POST['premio5']);
        unset($_POST['premio6']);
        unset($_POST['premio7']);
        unset($_POST['premio8']);
        unset($_POST['premio9']);
        unset($_POST['premio10']);
        unset($_POST);
    
    }

   
    header('Location: index.php');

   
?>