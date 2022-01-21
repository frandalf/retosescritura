<?php 
    function setModalDia($dbConn, $accion) {
        ?>
            <div class="botonCrear text-center"><button class="btn btn-primary" data-bs-toggle="modal" id="addDiaButton" data-bs-target="#addDiaModal"><?= $accion ?> día</button></div>

            <!-- Modal ADD DÍA -->
            <div class="modal fade" id="addDiaModal" tabindex="-1" aria-labelledby="addDiaModalLabel" aria-hidden="true">
            <div class="modal-dialog  modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addDiaModalLabel"><?= $accion ?> el día de hoy</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="reboot.php" method="post" id="form_add">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12">
                                        <label for="tipo" class=""><b>Selecciona el tipo de trabajo:</b></label>
                                        <select name="tipo" id="add_tipo" class="form-control" >
                                            <option value="1" selected>Número de palabras</option>
                                            <option value="2" >Planificación</option>
                                            <option value="3" >Corrección</option>
                                            <option value="4" >Documentación</option>
                                        </select>
                                        <br>
                                    </div>
                          
                                    <div class="col-12">
                                        <label for="palabras" id="label_palabrasEscritas" class=""><b id="escritas">Palabras escritas (obligatorio):</b></label>
                                        <input id="add_palabras" class="form-control" name="palabras" type="number" value="0" placeholder="Opcional">
                                        <br>
                                    </div>

                                    <div class="col-12">
                                        <label for="proyecto" class=""><b>Nombre del texto o proyecto:</b></label>
                                        <input id="add_proyecto" class="form-control" name="proyecto" type="text" value="" placeholder="Opcional">
                                        <br>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <button type="button" id="boton_add_dia" class="btn btn-primary" data-toggle="modal" data-target="#modal_add_dia"><?= $accion ?></button>
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
            <!-- !Modal-->
        <?php 
    }

?>