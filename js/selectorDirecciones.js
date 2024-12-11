$(document).ready(function() {
    obtenerEstados();
})

/**
 * Realiza una peticion AJAX GET a backend/get-direcciones.php para obtener
 * todas las direcciones en formato JSON.
 *
 * @returns {undefined}
 */
function obtenerEstados() {
    $.ajax({
        url: 'backend/get-direcciones.php',
        type: 'POST',
        dataType: 'json',
        data: {
            get: "estados"
        },
        success: function(response) {
            console.log(response);
        },
        error: function(xhr, status, error) {
            console.error('Error al obtener las direcciones:', error);
        }
    });
}