<?php 
    function setModalConfig($dbConn) {
        $configUser = getConfig($dbConn);
        $fallosPermitidos = $configUser['fallos_permitidos'];
        $fallosConsecutivos = $configUser['fallos_consecutivos'];
        $findesLibres = $configUser['findes_libres'];
        $premiosCada = $configUser['premios_cada'];

        $premios = getUserPremios($dbConn);
        $arrayPremios = [];
        $premio1 = "";
        $premio2 = "";
        $premio3 = "";
        $premio4 = "";
        $premio5 = "";

        if (!empty($premios)) {
            for ($i=1; $i <= 5 ; $i++) { 
               if (!empty(trim($premios['premio'.$i]))) {
                array_push($arrayPremios,$premios['premio'.$i]);
               }

               switch ($i) {
                   case 1:
                    $premio1 = $premios['premio'.$i];
                    break;
                   case 2:
                    $premio2 = $premios['premio'.$i];
                    break;
                   case 3:
                    $premio3 = $premios['premio'.$i];
                    break;
                   case 4:
                    $premio4 = $premios['premio'.$i];
                    break;
                   case 5:
                    $premio5 = $premios['premio'.$i];
                    break;
               }

               
            }
        }

        
        if ($findesLibres == 0) {
            $textoFindes = "";
        } else {
            $textoFindes = "checked";
        }
    ?>
    <div class="modal fade" id="editDiaModal" tabindex="-1" aria-labelledby="editDiaModal" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDiaModal">Edita tu configuración, <?= $_SESSION['username'] ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="edit.php" method="post" id="form_edit">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="text-center">
                                    <b>Fallos permitidos antes de borrar todo:</b>
                                </div>
                                
                                <div class="col-12 col-md-6">
                                    <label for="fallos_permitidos" class=" text-center"><b>Salteados:</b></label>
                                    <select name="fallos_permitidos" id="edit_fallos_permitidos" class="form-control form-control-sm" >
                                         <?php 
                                            for ($i=1; $i <= 6; $i++) { 
                                                if ($fallosPermitidos == $i) {
                                                    echo "<option value='$i' selected>$i</option>";
                                                } else {
                                                    echo "<option value='$i' >$i</option>";
                                                }                                                
                                            }
                                        ?>
                                    </select>
                                    <br>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label for="fallos_consecutivos" class="text-center"><b>Consecutivos:</b></label>
                                    <select name="fallos_consecutivos" id="edit_fallos_consecutivos" class="form-control form-control-sm" >
                                        <?php 
                                            for ($i=1; $i <= 3; $i++) { 
                                                if ($fallosConsecutivos == $i) {
                                                    echo "<option value='$i' selected>$i</option>";
                                                } else {
                                                    echo "<option value='$i' >$i</option>";
                                                }                                                
                                            }
                                        ?>
                                    </select>
                                    <br>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="editDescansar" name="descansar" <?= $textoFindes ?>>
                                        <label class="form-check-label" for="flexSwitchCheckDefault"><b>Descansar los fines de semana</b></label>
                                    </div>
                                    <br>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label for="premiosCada"><b>Recompensas cada:</b></label>
                                    <select name="premiosCada" id="edit_fallos_consecutivos" class="form-control form-control-sm" >
                                        <?php 
                                            $premioSelected7 = "";
                                            $premioSelected10 = "";
                                            $premioSelected15 = "";
                                            $premioSelected30 = "";
                                            $premioSelected60 = "";
                                            switch ($premiosCada) {
                                                case '7':
                                                    $premioSelected7 = "selected";
                                                    break;
                                                case '10':
                                                    $premioSelected10 = "selected";
                                                    break;
                                                case '15':
                                                    $premioSelected15 = "selected";
                                                    break;
                                                case '30':
                                                    $premioSelected30 = "selected";
                                                    break;
                                                case '60':
                                                    $premioSelected60 = "selected";
                                                    break;
                                                default:
                                                    $premioSelected15 = "selected";
                                                    break;
                                            }
                                        ?>
                                        <option value='7' <?=$premioSelected7?>>7 días</option>";
                                        <option value='10'<?=$premioSelected10?> >10 días</option>";
                                        <option value='15'<?=$premioSelected15?> >15 días</option>";
                                        <option value='30'<?=$premioSelected30?> >30 días</option>";
                                        <option value='60'<?=$premioSelected60?> >60 días</option>";
                                        
                                       
                                    </select>
                                                                        
                                </div>
                                <div class="col-12 row">
                                    <b>Lista de recompensas:</b><br><span class="aclaracion">Elige (¡si quieres!) hasta 5 recompensas. En los días marcados para ellas, el sistema elegirá una de forma aleatoria</span>
                                    <br>
                                    <div class="col-12 col-md-6">
                                        <label for="premio1" class=""><b>Recompensa 1:</b></label>
                                        <input id="premio1" class="form-control form-control-sm" name="premio1" type="text" value="<?=$premio1?>" placeholder="Ej: Pedir pizza">
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label for="premio2" class=""><b>Recompensa 2:</b></label>
                                        <input id="premio2" class="form-control form-control-sm" name="premio2" type="text" value="<?=$premio2?>" placeholder="Ej: Comprar un libro">
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label for="premio3" class=""><b>Recompensa 3:</b></label>
                                        <input id="premio3" class="form-control form-control-sm" name="premio3" type="text" value="<?=$premio3?>" placeholder="Ej: Empezar Malaz">
                                    </div>
                                    <div class="col-12 col-md-6">
                                    <label for="premio4" class=""><b>Recompensa 4:</b></label>
                                    <input id="premio4" class="form-control form-control-sm" name="premio4" type="text" value="<?=$premio4?>" placeholder="Ej: Conquistar el mundo">
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label for="premio5" class=""><b>Recompensa 5:</b></label>
                                        <input id="premio5" class="form-control form-control-sm" name="premio5" type="text" value="<?=$premio5?>" placeholder=". . .">
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label for="premio5" class=""><b>Recompensa 6:</b></label>
                                        <input id="premio5" class="form-control form-control-sm" name="premio5" type="text" value="<?=$premio5?>" placeholder=". . .">
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label for="premio5" class=""><b>Recompensa 7:</b></label>
                                        <input id="premio5" class="form-control form-control-sm" name="premio5" type="text" value="<?=$premio5?>" placeholder=". . .">
                                    </div>
                                    <div class="col-12 col-md-6">
                                         <label for="premio5" class=""><b>Recompensa 8:</b></label>
                                        <input id="premio5" class="form-control form-control-sm" name="premio5" type="text" value="<?=$premio5?>" placeholder=". . .">
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label for="premio5" class=""><b>Recompensa 9:</b></label>
                                        <input id="premio5" class="form-control form-control-sm" name="premio5" type="text" value="<?=$premio5?>" placeholder=". . .">
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label for="premio5" class=""><b>Recompensa 10:</b></label>
                                        <input id="premio5" class="form-control form-control-sm" name="premio5" type="text" value="<?=$premio5?>" placeholder=". . .">
                                    </div>
 
                                </div>
                                <br> 
                                <div class="col-12 text-center">
                                    <div class="col-12 text-center">
                                    <br> 
                                        <button type="submit" id="boton_edit_dia" class="btn btn-primary" data-toggle="modal" data-target="#modal_edit_dia">Guardar cambios</button>
                                        <hr>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-center">
                                    <button type="button" id="boton_borrar" class="btn btn-danger" data-toggle="modal" data-target="#modal_borrar">Empezar de nuevo</button>                                
                                </div>
                                <div class="col-12 text-center">
                                    <br>
                                    <a href="includes/disconect.php">Desconectar</a>
                                </div>
                            </div>
                        </div>                            
                    </form>


                </div>      
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <!--<button type="button" class="btn btn-primary">Save changes</button>-->
                </div>
            </div>
        </div>
    </div>
      
        <?php 


    }

?>