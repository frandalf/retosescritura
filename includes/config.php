<?php
    /* BASES DE DATOS */
    define('USER', 'u377048490_arbitro');
    define('PASSWORD', 'w6o,2v,G!Oot');
    define('HOST', '185.224.138.152');
    define('DATABASE', 'u377048490_retosescritura');

    date_default_timezone_set("Europe/Madrid");
   // echo date_default_timezone_get();
    echo "<script>console.log('".date_default_timezone_get()."')</script>";
    $current_date = date('d/m/Y == H:i:s');
    echo "<script>console.log('".$current_date."')</script>";
    
    try {
        $dbConn = new PDO("mysql:host=".HOST.";dbname=".DATABASE, USER, PASSWORD);
        $dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $dbConn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    } catch (PDOException $e) {
        exit("Error: " . $e->getMessage());
    }


    /* OTRAS CONFIGURACIONES */
    define('FALLOS_PERMITIDOS', 2);
    define('FALLOS_CONSECUTIVOS', 2);
    define('FINDES_LIBRES', 0);
    define('DEBUG_MODE',true);


    
?>