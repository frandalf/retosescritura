<?php 
    //header('Location: ../index.php');
   // session_unset();
    ob_start();
    session_start();
    session_unset();
    session_regenerate_id(true);
    session_unset();
    session_destroy();
    session_write_close();
    setcookie(session_name(),'',0,'/');
   
 //   header('Location: ../views/login.php');
    header('Location: ../index.php');
    
    
?>