<?php 
    function setModalPremio($dbConn) {
        ?>
            <!-- Modal ADD PREMIO -->
            <div class="modal fade" id="showPremioModal" tabindex="-1" aria-labelledby="showPremioModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="showDiaModalLabel"><img id="congrats_izq" src="./assets/media/congrats.png" alt=""> ¡Enhorabuena! <img src="./assets/media/congrats.png" alt=""></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <span class="aclaracion">¡Has desbloqueado una recompensa!</span>  
                        </div>
                        <br>
                        <?php 
                            $premios = getUserPremios($dbConn);
                            $premioEncontrado = false;

                            while (!$premioEncontrado) {
                                $premio = array_rand($premios, 1);
                                if ($premios[$premio] != "") {
                                    $premioEncontrado = true;
                                }
                            }
                        ?>
                        <div class="text-center">
                            <h2>Has desbloqueado:</h2>
                            <h3>-=[<span class="color_azul primary"> <?= $premios[$premio] ?> </span>]=-</h3>
                            <br>
                            <button class="btn btn-success">Canjear</button>
                            <br>
                            <br>
                            
                            <img class="cuboPremio" src="./assets/media/winner.gif" alt="">
                            <br>
                            <br>
                        </div>
                        

                        
                       
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


    }

?>