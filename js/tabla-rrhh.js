$(document).ready(function() {
    getEmpleados();
})

function getEmpleados() {
    $.ajax({
        url: 'backend/get-empleados.php',
        type: 'GET',
        success: function(response) {
            console.log(response);

            llenarTabla(response);
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
        }
    })
}

function llenarTabla(response) {
    let tabla = $("#tabla-empleados");
    let empleados = response;

    empleados.forEach(empleado => {
        let fila = `
            <tr>
                <td>${empleado.id}</td>
                <td>${empleado.tipo_usuario}</td>
                <td>${empleado.nombre}</td>
                <td>${empleado.apellido}</td>
                <td>${empleado.cedula}</td>
                <td>${empleado.email}</td>
                <td>${empleado.fecha_ingreso}</td>
            </tr>
        `

        tabla.append(fila);
    })

}