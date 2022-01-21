<?php 
    include_once("includes/config.php");
    include_once("includes/CRUD.php");

    function ifStringNullOrEmpty($str){
        return (!isset($str) || trim($str) === '');
    }

    function setCubos($dbConn) {
        $dias = getDias($dbConn, $limit = 60);

        $numRegistros = 0;
        $estadoCubo = "cuboInactivo";
        $palabras = "Palabras";
        $tipo = 1;
        $proyecto = "";
        $diaSemana = 1;
        $finSemana = false;
        $fecha = "Fecha";
        $icono = "fas fa-question";        
        $fechaActual = date("d/m/y");
           $fechaInicial = false;
        $hoyYaMostrado = false;
        $diasFallados = [];
        $fechasGuardadas = [];
        $fallosConsecutivos = 0;
        $diaCreado = false;
        $diasConPremio = [];
        $numDiaActual = 0;
        

        $configUser = getConfig($dbConn);
        $fallosPermitidos = $configUser['fallos_permitidos'];
        $fallosConsecutivos = $configUser['fallos_consecutivos'];
        $findesLibres = $configUser['findes_libres'];
        $premiosCada = $configUser['premios_cada'];
        $empiezaPremio = getEmpiezaDiaPremios($dbConn);
        $diaPremio = $premiosCada +  $empiezaPremio;
        ///$diaPremio--;
     
        
        
        echo "<script>console.log('$fallosPermitidos')</script>";

        if(!$dias) {
            echo "No hay registros";
        } else {
            $numRegistros =  $dias['registros'];
            
            echo '<pre>';
           // var_dump($dias);
            echo '</pre>';
        }

        if ($dias['registros'] > 0) {
            for ($i=0; $i < count($dias['resultado']); $i++) { 
                $arrayResultado = ['id' => $i,
                    'fecha' => $dias['resultado'][$i]['fecha'], 
                    'palabras' => $dias['resultado'][$i]['palabras'],
                    'proyecto' => $dias['resultado'][$i]['proyecto'],
                    'tipo' => $dias['resultado'][$i]['tipo']
                ];
                array_push($fechasGuardadas, $arrayResultado);

                if($numRegistros == 0) {
                    $fechaInicial = date('Y/m/d');
                } else {                
                    $fechaInicial = $dias['resultado'][0]['fecha'];
                }
            }    
        } else {
            $fechaInicial = date('Y/m/d');   
        }

        $diaSemana = isWeekend($fechaInicial);
      
        
       

        // Pintamos los 60 cubos:
        for ($i=0; $i < 60; $i++) { 
            if ($i == 0) {
                echo "<div class='row'>";
            } 
            
            if ($diaSemana > 5) {
                $finSemana = true;
            } else {
                $finSemana = false;
            }
           
            

            $fecha =  date('d/m/y',(strtotime($fechaInicial) + (86400*$i)));
            
            
            $fechaEncontrada = false;

            // Recorremos las fechas guardadas en la BD para compararlas
            foreach ($fechasGuardadas as $key => $value) {
                $fechaBD = date('d/m/y',strtotime($value['fecha']));
                $id = $value['id'];
                

                if ($fecha == $fechaBD) {
                    $palabras = $value['palabras'];
                    $tipo = $value['tipo'];
                    $proyecto = $value['proyecto'];
                } 



                if($fechaBD  == $fecha) {
                    $fechaEncontrada = true;
                } 
            }

            if($numRegistros > 0) {
                
                if ($fechaActual == $fecha){
                    
                    $estadoCubo = "cuboActivo";
                    $icono = "fas fa-question";
                    $hoyYaMostrado = true;
                    $fallosConsecutivos = 0;
                    $numDiaActual = $i;
                    if ($fechaEncontrada) {
                        $estadoCubo = "cuboPasado cuboActivo";
                        $icono = "fas fa-check"; 
                        $diaCreado = true;
                    }
                } else if ($fechaEncontrada) {
                    if ($findesLibres == 1 && $diaSemana > 5) {
                        $estadoCubo = "cuboFinde";
                        $icono = "fas fa-tree";
                        $proyecto = "";
                        $tipo = 0;
                        addDiaHoy($dbConn, $palabras, $tipo, $proyecto);
                    } else {
                        $estadoCubo = "cuboPasado";
                        $icono = "fas fa-check"; 
                        $fallosConsecutivos = 0;   
                    }                 
                } else if ($fechaActual > $fecha && !$hoyYaMostrado){
                    if ($findesLibres == 1 && $diaSemana > 5) {
                        $estadoCubo = "cuboFinde";
                        $palabras = "Finde";
                        $icono = "fas fa-tree";
                        $proyecto = "";
                        $tipo = 0;
                    } else {
                        $estadoCubo = "cuboFallido";
                        $palabras = 0;
                        $icono = "fas fa-times";
                        $proyecto = "";
                        $tipo = 0;
                        $fallosConsecutivos++;
                    }
                   

                    if($fallosConsecutivos >= $fallosPermitidos) {                     
                        $fallosConsecutivos = 0;
                        echo "<script>alert('Has fallado el máximo de días estipulado. Todo el avance será borrado :(');</script>";
                        deleteDiasUser($dbConn);
                        echo "<script>location.reload();</script>";
                        die();
                      
                        
                    }
                    array_push($diasFallados,$fecha);
                } else if ($hoyYaMostrado) {
                    if ($findesLibres == 1 && $diaSemana > 5) {
                        $estadoCubo = "cuboFinde";
                        $palabras = "Finde";
                        $icono = "fas fa-tree";
                        $proyecto = "";
                        $tipo = 0;
                    } else {
                        $estadoCubo = "cuboInactivo";
                        $palabras = "Palabras";
                        $icono = "fas fa-question";
                        $fallosConsecutivos = 0;
                        $proyecto = "";
                        $tipo = 0;
                    }
                }
            } else {
                if ($i == 0){
                    $estadoCubo = "cuboActivo";
                    $palabras = "Palabras";
                    $icono = "fas fa-question";
                    $hoyYaMostrado = true;
                    $fallosConsecutivos = 0;
                    if ($fechaEncontrada) {
                        $estadoCubo = "cuboPasado cuboActivo";
                        $diaCreado = true;
                    }
                } else {
                    if ($findesLibres == 1 && $diaSemana > 5) {
                        $estadoCubo = "cuboFinde";
                        $palabras = "Finde";
                        $icono = "fas fa-tree";
                        $proyecto = "";
                        $tipo = 0;
                    } else {
                        $estadoCubo = "cuboInactivo";
                        $palabras = "Palabras";
                        $icono = "fas fa-question";
                        $fallosConsecutivos = 0;
                        $proyecto = "";
                        $tipo = 0;
                    }
                }
            }

            // Preparamos el tipo y el proyecto para el tooltip
            $proyectoTexto = "";
            $tipoTexto = "";

            switch ($tipo) {
                case 1:
                    $tipoTexto = "Palabras escritas";
                    break;
                case 2:
                    $tipoTexto = "Planificación";
                    break;
                case 3:
                    $tipoTexto = "Corrección";
                    break;
                case 4:
                    $tipoTexto = "Documentación";
                    break;
                
                default:
                    $tipoTexto = false;
                    break;
            }

            if ($proyecto != "") {
                $proyectoTexto = "para $proyecto";
            }

            
            
            $tooltip = "data-toggle='tooltip' data-placement='top' title='$tipoTexto  $proyectoTexto'";
            if (!$tipoTexto) {
                $tooltip = "";
            }


            $cssPremio = "a";
            // Gestionamos los premios
            if ($i !=0 && $i+1 == $diaPremio || (DEBUG_MODE && $i==3)) {
                $diaPremio = $premiosCada +  $diaPremio;
                $palabras = "¡Premio!";
                $cssPremio = "cuboPremio";
                array_push($diasConPremio,$i);
            }

            // Comprobamos si es hoy día de premio para mostrar el modal y activar el botón
            if ($i == $numDiaActual) { //ToDo falta comprobar si se ha dejado atrás un premio. Falta añadir, tras el FOR, un setDiasPremiosDados en una nueva tabla de la BD
                echo "<script>hayPremio = true;</script>";
            }
            

      
            

          
            

            ?>
                <div contenteditable="true" dia="<?=$i+1?>" class="col-lg-1 col-md-3 col-6 cubo cubo<?=$i?>" <?= $tooltip ?>>
                    <div dia="<?=$i+1?>" class='cuboContainer <?= $estadoCubo; ?> <?=$cssPremio; ?>' dataid="<?=$i?>" datafecha="<?=$fecha?>" dataTipo="<?=$tipo?>" dataProyecto="<?=$proyecto?>">
                        <div class="box">
                            <div class="divCube divWords" disabled><?= $palabras  ?></div>
                            <div class="divCube divIcon" disabled><i class="<?=$icono?>"></i></div>
                            <div class="divCube divFecha" disabled><?= $fecha  ?></div>
                        </div>
                    </div>
                </div>
            <?php 

            $tipoTexto = "";
            $proyectoTexto = "";
            $tipo = "";
            $proyecto = "";

            if ($i==59) {
                echo "</div>";
            }

            if ($diaSemana == 7) {
                $diaSemana = 1;
            } else {
                $diaSemana++;
            }
        
        }  //Fin for

        if(!$diaCreado) {
            $diaCreado = "false";
        } else {
            $diaCreado = "true;";
        }
        
        return $diaCreado;


    } //Fin setCubos

    function setFechaSpain($fecha) {
        $resultado = date("d/m/y", strtotime($fecha));
        return $resultado;
    }

    function setLoading() {
        ?>  
            <div id="loading">
                <div id="circle">
                    <div class="loader">
                        <div class="loader">
                            <div class="loader">
                            <div class="loader">

                            </div>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        <?php 
    }

    function diasDiferencia($ultimaFecha,$fechaBD) {
     //   echo "<script>console.log('$ultimaFecha')</script>";
      //  echo "<script>console.log('$fechaBD')</script>";
        $ultimaFecha = strtotime($ultimaFecha);
        $fechaBD = strtotime($fechaBD);
        $diff = $fechaBD - $ultimaFecha;
        $diff = round($diff / (60 * 60 * 24));
      //  echo "<script>console.log('Diff: $fechaBD - $ultimaFecha = $diff')</script>";
        return $diff;
    }

    function isWeekend($date) {
        $fecha =  date('Y/m/d',(strtotime($date)));
        return (date('w', strtotime($fecha)));
    }

    function setConfig($dbConn,$posicionUsuario) {
        $configUser = getConfig($dbConn);
        $fallosPermitidos = $configUser['fallos_permitidos'];
        $fallosConsecutivos = $configUser['fallos_consecutivos'];
        $findesLibres = $configUser['findes_libres'];
        $metaTiempo = $configUser['meta_tiempo'];
        $metaPalabrasDiarias = $configUser['meta_palabras_diarias'];
        $metaPalabrasTotales = $configUser['meta_palabras_totales'];
        $recordPersonal = getRecordPersonal($dbConn);

        if ($findesLibres == 0) {
            $textoFindes = "(Los findes cuentan)";
        } else {
            $textoFindes = "(Los findes libres)";
        }



        ?>
             <div class="text-center beta">
                    APLICACIÓN EN ESTADO BETA. PUEDE PETAR (Y PETARÁ) - v0.4 - <a href="version.html">Más info</a>
                </div>
                <div class="row">
                    <div class="col-12 opciones_user container-fluid">
                        <form action="" method="" id="opcionesUserForm">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12 col-md-4 col-lg-2">
                                        <label for="fallosPermitidos" class="">Fallos permitidos:</label>
                                        <input id="fallosPermitidos" class="text-center form-control form-control-sm" name="fallosPermitidos" type="text" type="fallosPermitidos" value="<?=$fallosPermitidos?> <?=$textoFindes?>" disabled>
                                    </div>
                                    <div class="col-12 col-md-4 col-lg-2">
                                        <label for="fallosSeguidos" class="">Máx. fallos seguidos:</label>
                                        <input id="fallosSeguidos" class="text-center form-control form-control-sm" name="fallosSeguidos" type="number" type="fallosPermitidos" value="<?=$fallosConsecutivos?>" disabled>
                                    </div>
                                    <div class="col-12 col-md-4 col-lg-2">
                                        <label for="diasSeguidos" class="">Días seguidos:</label>
                                        <input id="diasSeguidos" class="text-center form-control form-control-sm" name="diasSeguidos" type="number" type="fallosPermitidos" value="0" disabled>
                                    </div>
                                    <div class="col-12 col-md-4 col-lg-2">
                                        <label for="recordPersonal" class="">Record personal:</label>
                                        <input id="recordPersonal" class="text-center form-control form-control-sm" name="recordPersonal" type="number" type="fallosPermitidos" value="<?=$recordPersonal?>" disabled>
                                    </div>
                                    <div class="col-12 col-md-4 col-lg-2">
                                        <label for="posicionRanking" class="">Posición ranking: <a href="#" id="verRanking">Ver</a></label>
                                        <input id="posicionRanking" class="text-center form-control form-control-sm" name="posicionRanking" type="number" type="fallosPermitidos" value="<?=$posicionUsuario?>" disabled>
                                        <!--<button type="submit" class="btn btn-success" data-toggle="modal" data-target="#modal_ranking">Ver</button>-->
                                    </div>
                                    <div class="col-12 col-md-4 col-lg-2">
                                        <div class="col-12 text-center">                                    
                                            <button type="button" id="boton_editar" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editDiaModal">Editar</button>
                                        </div>
                                    </div>
                                    <div class="col-12 text-center"></div>
                                </div>
                            </div>                            
                        </form>
                    </div>  
                </div>
        <?php 
    }

?>