<?php 
    /* SELECTS */
        function getStatus($dbConn) {
            //$result = $connection->query("SELECT * FROM concurso ORDER BY fecha_fin DESC");
            $user_id = $_SESSION['user_id'];
            $stmt = $dbConn->prepare("SELECT status FROM user WHERE id=:user_id");
            $stmt->execute(['user_id' => $user_id]); 
            $data = $stmt->fetchAll();
            
            return $data;
        }

        function getDias($dbConn, $limit = 60) {
            $resultado = "";
            $registros = 0;
            try {
                $user_id = $_SESSION['user_id'];
                $stmt = $dbConn->prepare("SELECT * FROM user_dias WHERE user_id=:user_id LIMIT :limit");
                $stmt->bindparam(':user_id', $user_id);
                $stmt->bindparam(':limit', $limit);
                $stmt->execute();
                $resultado = $stmt->fetchAll();

                $registros = $stmt->rowCount();

            } catch(Exception $e) {
               // $resultado = $e->getMessage();
                echo "<script>console.log('".$e->getMessage()."')</script>";
            }
        
            $resultadoFinal =  ['resultado' => $resultado, 'registros' => $registros];
            return $resultadoFinal;
        }

        function getNumDias($dbConn) {
            //$result = $connection->query("SELECT * FROM concurso ORDER BY fecha_fin DESC");
            $user_id = $_SESSION['user_id'];
            $stmt = $dbConn->prepare("SELECT count(*) FROM user_dias WHERE user_id=:user_id");
            $stmt->execute(['user_id' => $user_id]); 
            $number_of_rows = $stmt->fetchColumn();
            
            return $number_of_rows;
        }

        function getRecordPersonal($dbConn) {
            //$result = $connection->query("SELECT * FROM concurso ORDER BY fecha_fin DESC");
            $user_id = $_SESSION['user_id'];
            $stmt = $dbConn->prepare("SELECT record FROM user WHERE id=:user_id");
            $stmt->execute(['user_id' => $user_id]); 
            $number_of_rows = $stmt->fetchColumn();
            
            return $number_of_rows;
        }



        function getConfig($dbConn) {
            $resultado = "";
            try {
                $user_id = $_SESSION['user_id'];
                $stmt = $dbConn->prepare("SELECT * FROM user_config WHERE user_id=:user_id");
                $stmt->bindparam(':user_id', $user_id);
                $stmt->execute();
                $resultado = $stmt->fetch();


            } catch(Exception $e) {
               // $resultado = $e->getMessage();
                echo "<script>console.log('".$e->getMessage()."')</script>";
            }
        
            
            return $resultado;
        }

        function getLastIdDia($dbConn) {
            //$result = $connection->query("SELECT * FROM concurso ORDER BY fecha_fin DESC");
            $user_id = $_SESSION['user_id'];
            $stmt = $dbConn->prepare("SELECT id FROM user_dias WHERE user_id=:user_id ORDER BY id DESC LIMIT 1");
            $stmt->execute(['user_id' => $user_id]); 
            $number_of_rows = $stmt->fetchColumn();
            
            return $number_of_rows;
        }

        
        function getListaRecord($dbConn) {
            //$result = $connection->query("SELECT * FROM concurso ORDER BY fecha_fin DESC");
            $stmt = $dbConn->prepare("SELECT id, username, record FROM `user` WHERE status = 1 ORDER BY record DESC, username ASC");
            $stmt->execute(); 
            $result = $stmt->fetchAll();
            
            return $result;
        }

        function getUserPremios($dbConn) {
            //$result = $connection->query("SELECT * FROM concurso ORDER BY fecha_fin DESC");
            $user_id = $_SESSION['user_id'];
            $stmt = $dbConn->prepare("SELECT premio1, premio2, premio3, premio4, premio5, premio6, premio7, premio8, premio9, premio10 FROM user_premios WHERE user_id=:user_id");
            $stmt->execute(['user_id' => $user_id]); 
            $number_of_rows = $stmt->fetch();
            
            return $number_of_rows;
        }

        function getEmpiezaDiaPremios($dbConn) {
            //$result = $connection->query("SELECT * FROM concurso ORDER BY fecha_fin DESC");
            $user_id = $_SESSION['user_id'];
            $stmt = $dbConn->prepare("SELECT empieza_dia FROM user_premios WHERE user_id=:user_id");
            $stmt->execute(['user_id' => $user_id]); 
            $number_of_rows = $stmt->fetchColumn();
            
            return $number_of_rows;
        }

        
    /* INSERTS */

        function addDiaHoy($dbConn, $palabras, $tipo, $proyecto) {

            $user_id = $_SESSION['user_id'];
            $resultado = "";
            $fecha = $date = date('Y-m-d H:i:s');

            try {
                $sql = "INSERT INTO user_dias (user_id, palabras, tipo, proyecto, fecha) 
                VALUES (:user_id, :palabras, :tipo, :proyecto, :fecha)";
                $query = $dbConn->prepare($sql);
                $query->bindparam(':user_id', $user_id);
                $query->bindparam(':palabras', $palabras);
                $query->bindparam(':tipo', $tipo);
                $query->bindparam(':fecha', $fecha);
                $query->bindparam(':proyecto', $proyecto);

                $query->execute();

                
            }
            catch(Exception $e) {
                $resultado = $e->getMessage();
                echo "<script>console.log('".$e->getMessage()."')</script>";
            }


        }


        function addUserPremio($dbConn, $premio1, $premio2, $premio3, $premio4, $premio5, $premio6, $premio7, $premio8, $premio9, $premio10) {

            $user_id = $_SESSION['user_id'];
            $resultado = "";

            try {
                $sql = "INSERT INTO user_premios (user_id, premio1, premio2, premio3, premio4, premio5, premio6, premio7, premio8, premio9, premio10) 
                VALUES (:user_id, :premio1, :premio2, :premio3, :premio4, :premio5, :premio6, :premio7, :premio8, :premio9, :premio10)";
                $query = $dbConn->prepare($sql);
                $query->bindparam(':user_id', $user_id);
                $query->bindparam(':premio1', $premio1);
                $query->bindparam(':premio2', $premio2);
                $query->bindparam(':premio3', $premio3);
                $query->bindparam(':premio4', $premio4);
                $query->bindparam(':premio5', $premio5);
                $query->bindparam(':premio6', $premio6);
                $query->bindparam(':premio7', $premio7);
                $query->bindparam(':premio8', $premio8);
                $query->bindparam(':premio9', $premio9);
                $query->bindparam(':premio10', $premio10);

                $query->execute();

                
            }
            catch(Exception $e) {
                $resultado = $e->getMessage();
                echo "<script>console.log('".$e->getMessage()."')</script>";
            }


        }
      

    /* UPDATES */
        function updateConfig($dbConn, $fallos_permitidos, $fallos_consecutivos, $descansar, $premiosCada) {

            $user_id = $_SESSION['user_id'];
            $resultado = "";
            try {
                $sql = "UPDATE user_config SET fallos_permitidos=:fallos_permitidos, fallos_consecutivos=:fallos_consecutivos, findes_libres=:descansar, premios_cada=:premios_cada
                WHERE user_id = :user_id";
                $query = $dbConn->prepare($sql);
                $query->bindparam(':user_id', $user_id);
                $query->bindparam(':fallos_permitidos', $fallos_permitidos);
                $query->bindparam(':fallos_consecutivos', $fallos_consecutivos);
                $query->bindparam(':descansar', $descansar);
                $query->bindparam(':premios_cada', $premiosCada);
                $query->execute();
            }
            catch(Exception $e) {
                echo $e->getMessage();
                $resultado = $e->getMessage();
                echo "<script>console.log('".$e->getMessage()."')</script>";
            }
   

        }

        function updateUserPremio($dbConn, $premio1, $premio2, $premio3, $premio4, $premio5, $premio6, $premio7, $premio8, $premio9, $premio10) {

            $user_id = $_SESSION['user_id'];
            $resultado = "";

            try {
                $sql = "UPDATE user_premios SET premio1= :premio1, premio2= :premio2, premio3= :premio3, premio4= :premio4, premio5= :premio5, premio6= :premio6,premio7= :premio7,premio8= :premio8,premio9= :premio9,premio10= :premio10 
                WHERE user_id = :user_id";
                $query = $dbConn->prepare($sql);
                $query->bindparam(':user_id', $user_id);
                $query->bindparam(':premio1', $premio1);
                $query->bindparam(':premio2', $premio2);
                $query->bindparam(':premio3', $premio3);
                $query->bindparam(':premio4', $premio4);
                $query->bindparam(':premio5', $premio5);
                $query->bindparam(':premio6', $premio6);
                $query->bindparam(':premio7', $premio7);
                $query->bindparam(':premio8', $premio8);
                $query->bindparam(':premio9', $premio9);
                $query->bindparam(':premio10', $premio10);
                $query->execute();

                
            }
            catch(Exception $e) {
                $resultado = $e->getMessage();
                echo "<script>console.log('".$e->getMessage()."')</script>";
            }


        }

        function updateRecordPersonal($dbConn, $numDiasActuales) {
            $user_id = $_SESSION['user_id'];
            $resultado = "";
            try {
                $sql = "UPDATE user SET record=:record, dias_actuales=:dias WHERE id = :user_id";
                $query = $dbConn->prepare($sql);
                $query->bindparam(':user_id', $user_id);
                $query->bindparam(':record', $numDiasActuales);
                $query->bindparam(':dias', $numDiasActuales);
                $query->execute();
            }
            catch(Exception $e) {
                echo $e->getMessage();
                $resultado = $e->getMessage();
                echo "<script>console.log('".$e->getMessage()."')</script>";
            }
        }

        function updateDiasActuales($dbConn, $numDiasActuales) {
            $user_id = $_SESSION['user_id'];
            $resultado = "";
            try {
                $sql = "UPDATE user SET dias_actuales=:dias WHERE id = :user_id";
                $query = $dbConn->prepare($sql);
                $query->bindparam(':user_id', $user_id);
                $query->bindparam(':dias', $numDiasActuales);
                $query->execute();
            }
            catch(Exception $e) {
                echo $e->getMessage();
                $resultado = $e->getMessage();
                echo "<script>console.log('".$e->getMessage()."')</script>";
            }
        }

        function updateDia($dbConn, $id, $palabras, $tipo, $proyecto) {
            $user_id = $_SESSION['user_id'];
            $resultado = "";
            try {
                $sql = "UPDATE user_dias SET palabras=:palabras, tipo=:tipo, proyecto=:proyecto WHERE user_id=:user_id AND id=:id";
                $query = $dbConn->prepare($sql);
                $query->bindparam(':user_id', $user_id);
                $query->bindparam(':palabras', $palabras);
                $query->bindparam(':tipo', $tipo);
                $query->bindparam(':proyecto', $proyecto);
                $query->bindparam(':id', $id);
                $query->execute();
            }
            catch(Exception $e) {
                echo $e->getMessage();
                $resultado = $e->getMessage();
                echo "<script>console.log('".$e->getMessage()."')</script>";
            }
        }


       
    
    
    /* DELETES */
        function deleteDiasUser($dbConn) {   
            updateDiasActuales($dbConn, 0);

            $user_id = $_SESSION['user_id'];
            $sql = "DELETE FROM user_dias WHERE user_id=:user_id";
            $query = $dbConn->prepare($sql);
            $query->bindparam(':user_id', $user_id);
            $query->execute();
            
        
        }

?>