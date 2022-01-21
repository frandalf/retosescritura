<?php
 

 include('../includes/config.php');
 session_start();


if (isset($_POST['register'])) {

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_hash = password_hash($password, PASSWORD_BCRYPT);
    $status = 1; //Todo DECIDIR SI USAR VALIDADO. SI ES ASÍ, CAMBIAR A 0
 
    $query = $dbConn->prepare("SELECT * FROM user WHERE email=:email");
    $query->bindParam("email", $email, PDO::PARAM_STR);
    $query->execute();
 
    if ($query->rowCount() > 0) {
        echo '<p class="error">El email ya está registrado</p>';
    }
 
    $query = $dbConn->prepare("SELECT * FROM user WHERE username=:username");
    $query->bindParam("username", $username, PDO::PARAM_STR);
    $query->execute();
 
    if ($query->rowCount() > 0) {
        echo '<p class="error">El nombre de usuario ya existe</p>';
    }
    
    $registrado = false;
    if ($query->rowCount() == 0) {
        $query = $dbConn->prepare("INSERT INTO user(username,email,password,status,record) VALUES (:username,:email,:password,:status,0);");
        $query->bindParam("username", $username, PDO::PARAM_STR);
        $query->bindParam("status", $status, PDO::PARAM_INT);
        $query->bindParam("email", $email, PDO::PARAM_STR);
        $query->bindParam("password", $password_hash, PDO::PARAM_STR);
        
        $lastId = 0;
        if ($query->execute()) {
            $lastId = $dbConn->lastInsertId();
            echo '<p class="success">Se ha registrado correctamente</p>';
            echo '<br><a href="../index.php">Ir al inicio</a>';
            $registrado = true;
        } else {
            echo '<p class="error">Algo ha ido mal :(</p>';
        }
        // Guardamos la configuración inicial
        if ($registrado) {
            $query = $dbConn->prepare("INSERT INTO user_config (user_id,fallos_permitidos,fallos_consecutivos,findes_libres,meta_tiempo,meta_palabras_diarias,meta_palabras_totales) 
                VALUES (:user_id, 2, 2, 0, 60, 0, 0);");
            $query->bindParam("user_id", $lastId, PDO::PARAM_STR);
            $result = $query->execute();
            
        }
    }
}
 
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/login.css">
    <title>Escribe o remo</title>
</head>
<body>
<form method="post" action="" name="signup-form">
    <div class="form-element">
        <label>Username</label>
        <input type="text" name="username" pattern="[a-zA-Z0-9]+" required />
    </div>
    <div class="form-element">
        <label>Email</label>
        <input type="email" name="email" required />
    </div>
    <div class="form-element">
        <label>Password</label>
        <input type="password" name="password" required />
    </div>
    <button type="submit" name="register" value="register">Register</button>
</form>
</body>
</html>