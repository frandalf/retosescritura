    $(window).on('load', function() {
        $('#loading').hide();
        
        if (hayPremio) {
            $('#showPremioModal').modal('show');
          //  $('#addRankingModal').modal('show');
        }
        


        var cuboHeight = $('.cubo').width()
        $('.cubo').width(cuboHeight);
        $('.cubo').css('max-height',cuboHeight);
        for (let i = 0; i < 60; i++) {
            $('.cubo' + i).append('<div class="numCubo">Día ' + (i+1) +'</div>');            
        }
       
        
        $('.box').height(cuboHeight);
        $('.box').css('max-height',cuboHeight);        
        $('.divCube').css('height',(cuboHeight * 0.33));        
       /* $('.box').html('<div class="divCube" style="height: ' + (cuboHeight * 0.33) + 
        'px">Prueba1</div><div class="divCube" style="height: ' + (cuboHeight * 0.33) + 
        'px">Prueba2</div><div class="divCube" style="height: ' + (cuboHeight * 0.33) + 
        'px">Prueba3</div>');*/


        // Contamos días seguidos
        let numDias = $('.cuboPasado').length
        $('#diasSeguidos').val(numDias);
        
        function showAddModal() {
            //alert("Ya se ha introducido el día de hoy :P ");
            let id = $('.cuboActivo').attr('dataid');
                        
            if ( $('.cuboActivo').hasClass('cuboPasado')) {
                //alert("Ya se ha introducido el día de hoy :P ");
                let tipo =  $('.cuboActivo').attr('datatipo');
                let proyecto =  $('.cuboActivo').attr('dataproyecto');
                let palabrasEscritas = $('div.cuboContainer.cuboPasado.cuboActivo > div > div.divCube.divWords').html();
                $('#addDiaModal').modal('show');
                $('#add_palabras').val(palabrasEscritas);
                $('#add_proyecto').val(proyecto);
                $('#add_tipo option[value='+tipo+']').attr('selected','selected')
                let input = $("<input>")
                    .attr("type", "hidden")
                    .attr("name", "editar").val("true");
                $('#form_add').append(input);

            } else {
                let proyecto = "";
                if (id > 0) {
                    let lastProyect = $('.cubo' + id).attr('data-bs-original-title');
                    let position = lastProyect.indexOf("para")+5;
                    proyecto = lastProyect.substring(position);
                }
            
                $('#addDiaModal').modal('show');
                $('#add_proyecto').val(proyecto);
            }
        }
        $('.cuboActivo').on('click', function() {
            showAddModal();            
        });

        $('#addDiaButton').on('click', function(e) {
            e.preventDefault();
            showAddModal();
        });

        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })


        /* GESTIÓN DE MODALES */

            /* ADD DIA */
            $('#add_tipo').on('change', function() {
                if (this.value == 1) {
                    $('#escritas').html('Palabras escritas (obligatorio):' );
                } else {
                    $('#escritas').html('Palabras escritas (opcional):');
                }

            });



            $('#boton_add_dia').on('click', function() {

                if ($( "#add_tipo option:selected" ).val() == 1 && ($( "#add_palabras" ).val() == "" || $( "#add_palabras" ).val() == 0)) {
                    alert("El campo 'Palabras Escritas' es obligatorio");
                } else {
                    $('#loading').css("display", "block");
                    $('#form_add').submit(); 
                }                
            });

            $('#boton_edit_dia').on('click', function() {
                $('#loading').css("display", "block");
            });

            /* CONFIG */
            $('#boton_borrar').on('click', function() {
                if (confirm("¿Está seguro de borrar todo el progreso de escritura? Esta acción no se puede deshacer")) {
                    txt = "Borrando";
                } else {
                    txt = "No se ha borrado nada";
                }

                if (txt == "Borrando") {
                    window.location.href = "deleteAll.php";
                }
            });

            $('#editDescansar').change(function() {
                selected_value = $("input[name='descansar']:checked").val();
                if ( selected_value != "on") {
                    alert("¡Cuidado! Si ya tenías activo descansar los fines de semana, los que ya han pasado se convertirán en fallos y podría borrar tu progreso");
                }
               
            });

            /* RANKING */
            $('#verRanking').on('click', function() {
                $('#addRankingModal').modal('show');
            });
            
            

    });
    /*$('.box').text('hola \n hola2');*/

