function comenzarRegistro() {
    // Obtener los datos del formulario
    let cedula = $('input[name="cedula"]').val();
    let password = $('input[name="password"]').val();

    // Realizar la solicitud AJAX
    $.ajax({
        url: 'backend/comenzar-registro.php',
        type: 'POST',
        data: {
            cedula: cedula,
            password: password
        },
        success: function(response) {
            console.log(response);

            //Ocultar mensaje de error #error-registro-hora
            $("#error-registro-hora").text('');

            // Mostrar mensaje de bienvenida y boton para confirmar registro
            confirmarRegistro(response);
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
            $("#error-registro-hora").text(xhr.responseJSON.error);
        }
    });
}

function confirmarRegistro(response) {
    // Mostrar mensaje de bienvenida e informacion del registro
    $("#mensaje-bienvenida").html('Bienvenido ' + response.nombre + ', por favor confirma tu registro');

    let tipo_registro = response.registro;

    // Eliminar botones anteriores
    $(".boton-confirmar").remove();
    
    if (tipo_registro == 'entrada') {
        $("#info-registro").html('Confirma tu entrada');
        $("#confirmar-registro").append('<button type="button" class="boton-confirmar" onclick="crearRegistro(\'entrada\', ' +response.id+ ')">Confirmar Entrada</button>');
    } else if (tipo_registro == 'salida') {
        $("#info-registro").html('Confirma tu salida, entraste a las ' + response.hora_entrada);
        $("#confirmar-registro").append('<button type="button" class="boton-confirmar" onclick="crearRegistro(\'salida\', ' +response.id+ ')">Confirmar Salida</button>');
    }

    $("#comenzar-registro").hide();
    $("#confirmar-registro").show();
 
}

function crearRegistro(tipo_registro, usuario_id) {
    $.ajax({
        url: 'backend/crear-registro.php',
        type: 'POST',
        data: {
            tipo_registro: tipo_registro,
            usuario_id: usuario_id
        },
        success: function(response) {
            console.log(response);

            //Ocultar $confirmar-registro y mostrar $comenzar-registro
            $("#confirmar-registro").hide();
            $("#comenzar-registro").show();

            // Mostrar mensaje de exito
            $("#mensaje-exito-horas").text(response.mensaje);
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
        }
    })
}

function cancelarRegistro() {
    $("#comenzar-registro").show();
    $("#confirmar-registro").hide();
}
