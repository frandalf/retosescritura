<?php 
    include_once("includes/config.php");
    include_once("includes/CRUD.php");
    include_once("includes/helpers.php");
    include_once 'includes/modal_addDia.php';
    include_once 'includes/modal_Record.php';
    include_once 'includes/modal_editConfig.php';
    include_once 'includes/modal_premio.php';
    
    session_start();

    if(!isset($_SESSION['user_id'])){
        header('Location: views/login.php');
        exit;
    }

    // Comprobamos status:
    $status = getStatus($dbConn)[0]['status'];
    if ($status == 0) {
        header('Location: includes/disconect.php');
    }
    
    


?>

<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel="shortcut icon" type="image/png" href="assets/media/logo.png"/>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css'>
    <link rel='stylesheet' href='assets/css/index.css'>
    <title>Escribe o remo</title>
</head>
<body>
    <?php 

        $posicionUsuario = setModalRanking($dbConn);
        setLoading();
    ?>

    <div class="container">


        <?php        
           
            setConfig($dbConn, $posicionUsuario);
        ?>

        <div class="text-center col-12">
            <h2>Reto de escritura: ¡escribe 60 días (o más) y sigue tu progreso!</h2>
        </div>

        <?php 
            $diaCreado = setCubos($dbConn);  
        ?>

    

        <br><br><br>
        <?php 
            if ($diaCreado == "false") {
                require_once 'includes/modal_addDia.php';
                setModalDia($dbConn, "Añadir");
            } else {
                setModalDia($dbConn, "Editar");
            }



            
            
        
        ?>
    </div>
   <!-- -->

    <!-- MODAL EDIT -->
    <?php 
       setModalConfig($dbConn);
       setModalPremio($dbConn);
    ?>
    <!-- !Modal-->

<!-- SCRIPTS -->
    <script src='https://code.jquery.com/jquery-3.6.0.js' integrity='sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=' crossorigin='anonymous'></script>
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js'></script>
    <script src="https://kit.fontawesome.com/a6ffb7523b.js" crossorigin="anonymous"></script>
    <script src='assets/js/index.js'></script>

</body>
</html>