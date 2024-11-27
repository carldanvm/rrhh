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
            <tr id="${empleado.id}" onclick="infoEmpleado(${empleado.id})">
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

async function infoEmpleado(id) {
    console.log("Clicked: " + id);

    //Obtener informacion del empleado
    $.ajax({
        url: 'backend/info-empleado.php',
        type: 'POST',
        data:{
            empleadoId: id
        },
        success: function(response) {
            console.log(response);

            llenarModal(response);
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
        }
    })


    

}

function llenarModal(response) {
    // Campos del modal
    let tipoUsuario = $('#empleadoModal #tipo-usuario');
    let nombre = $('#empleadoModal #nombre');
    let apellido = $('#empleadoModal #apellido');
    let cedula = $('#empleadoModal #cedula');
    let email = $('#empleadoModal #email');
    let telefono = $('#empleadoModal #telefono');
    let fechaRegistro = $('#empleadoModal #fecha-registro');
    
    let cargo = $('#empleadoModal #cargo');
    let area = $('#empleadoModal #area');
    let salario = $('#empleadoModal #salario');
    
    let estado = $('#empleadoModal #estado');
    let ciudad = $('#empleadoModal #ciudad');
    let municipio = $('#empleadoModal #municipio');
    let calle = $('#empleadoModal #calle');
    let codigoPostal = $('#empleadoModal #codigo-postal');
    let tipoVivienda = $('#empleadoModal #tipo-vivienda');

    // Vaciar modal
    tipoUsuario.val('');
    nombre.val('');
    apellido.val('');
    cedula.val('');
    email.val('');
    telefono.val('');
    fechaRegistro.val('');
    
    cargo.val('');
    area.val('');
    salario.val('');
    
    estado.val('');
    ciudad.val('');
    municipio.val('');
    calle.val('');
    codigoPostal.val('');
    tipoVivienda.val('');

    // Llenar modal
    tipoUsuario.text(response.tipo_usuario);
    nombre.text(response.nombre);
    apellido.text(response.apellido); 
    cedula.text(response.cedula);
    email.text(response.email);
    telefono.text(response.telefono);
    fechaRegistro.text(response.fecha_ingreso);
    
    cargo.text(response.cargo);
    area.text(response.area);
    salario.text(response.salario_base);
    
    estado.text(response.estado);
    ciudad.text(response.ciudad);
    municipio.text(response.municipio);
    calle.text(response.calle);
    codigoPostal.text(response.zip);
    tipoVivienda.text(response.vivienda);


    // Abrir modal
    $('#empleadoModal').modal('show');
}
