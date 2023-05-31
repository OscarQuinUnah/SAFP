$(document).ready(function(){

    $('#btnSend').click(function(){

        var errores = '';

        // Validado Nombre ==============================
        if( $('#names').val() == '' ){
            errores += '<p>Escriba un Nombre</p>';
            $('#names').css("border-bottom-color", "#F14B4B")
        } else{
            $('#names').css("border-bottom-color", "#d1d1d1")
        }

        // Validado Correo ==============================
        if( $('#email').val() == '' ){
            errores += '<p>Ingrese un Correo</p>';
            $('#email').css("border-bottom-color", "#F14B4B")
        } else{
            $('#email').css("border-bottom-color", "#d1d1d1")
        }

        // Validado Asunto ==============================
        if( $('#asunto').val() == '' ){
            errores += '<p>Escriba el Asunto</p>';
            $('#asunto').css("border-bottom-color", "#F14B4B")
        } else{
            $('#asunto').css("border-bottom-color", "#d1d1d1")
        }

        // Validado Mensaje ==============================
        if( $('#mensaje').val() == '' ){
            errores += '<p>Escriba un Mensaje</p>';
            $('#mensaje').css("border-bottom-color", "#F14B4B")
        } else{
            $('#mensaje').css("border-bottom-color", "#d1d1d1")
        }

        // ENVIANDO MENSAJE ============================
        if( errores == '' == false){
            var mensajeAdvertencia = '<div class="modal_Advertencia">'+
                                    '<div class="mensaje_modal">'+
                                        '<h3>Errores encontrados</h3>'+
                                        '<h4>Para enviar un mensaje debes llenar los siguientes campos: </h4>'+
                                        errores+
                                        '<span id="btnClose">Cerrar</span>'+
                                    '</div>'+
                                '</div>'

            $('body').append(mensajeAdvertencia);
        }

        // CERRANDO MODAL ==============================
        $('#btnClose').click(function(){
            $('.modal_Advertencia').remove();
        });
    });

});
