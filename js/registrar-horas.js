function confirmarRegistro(usuario_id, tipo_registro) {
    $.ajax({
        url: 'backend/crear-registro.php',
        type: 'POST',
        data: {
            tipo_registro: tipo_registro,
            usuario_id: usuario_id
        },
        success: function(response) {
            console.log(response);
            // Mostrar mensaje de éxito
            $("#mensaje-exito-horas")
                .removeClass("d-none")
                .removeClass("alert-danger")
                .addClass("alert-success")
                .text(response.mensaje + " - " + response.fecha);

            // Deshabilitar botones para evitar doble click
            $("#confirmar-registro, #cancelar-registro").prop('disabled', true);

            // Esperar 2 segundos y recargar la página
            setTimeout(function() {
                location.reload();
            }, 5000);
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
            $("#mensaje-exito-horas")
                .removeClass("d-none")
                .addClass("alert-danger")
                .text("Error al registrar. Por favor, intente nuevamente.");
        }
    })
}
