<?php
 

    include('../includes/config.php');
    session_start();

    if(!isset($_SESSION['user_id'])){
    //  exit;
    } else {
    //   header('Location: includes/disconect.php');
    }
    
    if (isset($_POST['login'])) {
    
        $username = $_POST['username'];
        $password = $_POST['password'];
     
        $query = $dbConn->prepare("SELECT * FROM user WHERE username=:username");
        $query->bindParam("username", $username, PDO::PARAM_STR);
        $query->execute();
    
        $result = $query->fetch(PDO::FETCH_ASSOC);
    
        if (!$result) {
            echo '<p class="error">El usuario o contraseña son incorrectos</p>';
        } else if($result['status'] == 0){
            echo '<p class="error">Tu usuario está inactivo. Ponte en contacto con frandalf.software@gmail.com</p>';
        } else {
            if (password_verify($password, $result['password'])) {
                $_SESSION['user_id'] = $result['id'];
                $_SESSION['username'] = $result['username'];
                echo '<p class="success">Conexión correcta</p>';
                header('Location: ../index.php');
            } else {
                echo '<p class="error">El usuario o contraseña son incorrectos</p>';
            }
        }
    }
 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="../assets/media/logo.png"/>
    <link rel="stylesheet" href="../assets/css/login.css">
    <title>Escribe o remo</title>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css'>
    
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <form method="post" action="" name="signin-form">      
                    <img src="../assets/media/logo.png" alt="">          
                    <h3>Escribe o Remo</h3>
                    <div class="form-element">
                        <label>Usuario</label>
                        <input type="text" name="username" pattern="[a-zA-Z0-9]+" required />
                    </div>
                    <div class="form-element">
                        <label>Contraseña</label>
                        <input type="password" name="password" required />
                    </div>
                    <button type="submit" name="login" value="login">Log In</button>
                    <br>
                    <br>
                    <span class="register">Si no tienes una cuenta, regístrate <a href="register.php">aquí</a></span>
                </form>
            </div>
           
        </div>
    </div>
    

    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js'></script>
        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js'></script>
        <script src="https://kit.fontawesome.com/a6ffb7523b.js" crossorigin="anonymous"></script>
</body>
</html>