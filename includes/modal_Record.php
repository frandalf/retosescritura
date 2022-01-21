<?php 
    function setModalRanking($dbConn) {
        ?>
            <!-- Modal ADD DÍA -->
            <div class="modal fade" id="addRankingModal" tabindex="-1" aria-labelledby="addRankingModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addDiaModalLabel">Ranking de días escritos</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <span class="aclaracion">Registro creado de los records personales de los escritores</span>  
                        </div>
                        
                        <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Posición</th>
                                        <th scope="col">Días</th>
                                        <th scope="col">Escritor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        //var_dump(getListaRecord($dbConn));
                                        $listaRanking = getListaRecord($dbConn);
                                        $posicion = 1;
                                        $lastRecord = 0;
                                        $sizeRanking = sizeof($listaRanking);
                                        $mostrar = 10;
                                        $usuarioMostrado = false;
                                        $posicionUser = 0;
                                        $recordUser = 0;
                                        $usernameUser = "";
                                        $posicionUsuario = 0;

                                        
                                        for ($i=0; $i < $sizeRanking; $i++) { 
                                            $record = $listaRanking[$i]['record'];
                                            $username = $listaRanking[$i]['username'];
                                            $id = $listaRanking[$i]['id'];

                                            if ($i > 0 && $record < $lastRecord) {
                                                $posicion++; 
                                            }
                                            if($id == $_SESSION['user_id']) {
                                                $username = "<b class='usuario'>$username</b>";
                                                $posicionUsuario = $posicion;

                                                $posicionUser = $posicion;
                                                $recordUser = $record;
                                                $usernameUser = $username;
                                                if ( $i < $mostrar) {
                                                    $usuarioMostrado = true;
                                                }
                                                
                                            }
                                            if ($posicion == 1) {
                                                $username = "<img class='medalla' src='./assets/media/m_oro.png'> $username";
                                            } else if ($posicion == 2) {
                                                $username = "<img class='medalla' src='./assets/media/m_plata.png'> $username";
                                            } else if ($posicion == 3) {
                                                $username = "<img class='medalla' src='./assets/media/m_bronce.png'> $username";
                                            }
                                            
                                            if ($record > 0 && $i < $mostrar) {
                                                ?>
                                                    <tr>
                                                        <th scope="row"> <?= $posicion ?> </th>
                                                        <td> <?= $record ?> </td>
                                                        <td> <?= $username ?></td>
                                                    </tr>
                                                <?php 
                                            }
                                            $lastRecord = $record;
                                        }
                                        
                                        if (!$usuarioMostrado) {
                                            ?>  
                                                <tr>
                                                    <td colspan="3" class="text-center">. . .</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row"> <?= $posicionUser ?> </th>
                                                    <td> <?= $recordUser ?> </td>
                                                    <td> <?= $usernameUser ?></td>
                                                </tr>
                                            <?php 
                                        }
                                    ?>                        
                            </tbody>
                        </table>
                    </div>      
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <!--<button type="button" class="btn btn-primary">Save changes</button>-->
                    </div>
                </div>
            </div>
            </div>
            <!-- !Modal-->
        <?php 

        return $posicionUsuario;
    }

?>