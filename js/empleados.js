function generarConstancia(){
    const empleadoId = $('#empleadoModal').attr('data-empleado-id');
    console.log('Generar constancia para el empleado con ID: ' + empleadoId);
    
    $.ajax({
        url: 'backend/constancia.php',
        type: 'POST',
        data: {
            empleadoId: empleadoId
        },
        success: function(response) {
            console.log(response.pdf_url);
            if (response.success) {
                // Abrir la constancia en una nueva ventana
                window.open(response.pdf_url, '_blank', 'noopener,noreferrer');
            }else{
                alert('Error al generar la constancia' + response.error);
            }
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
            alert('Error del servidor al generar la constancia: ' + xhr.responseJSON.error);
        }
    })
}

function obtenerInfoEmpleado(){
    //Leer la informacion del modal empleadoModal
    const empleadoId = $('#empleadoModal').attr('data-empleado-id');
    
    return {
        id: empleadoId,
        tipo_usuario: $('#tipo-usuario').text(),
        nombre: $('#nombre').text(),
        apellido: $('#apellido').text(),
        cedula: $('#cedula').text(),
        email: $('#email').text(),
        telefono: $('#telefono').text(),
        fecha_registro: $('#fecha-registro').text(),
        cargo: $('#cargo').text(),
        area: $('#area').text(),
        salario: $('#salario').text(),
        estado: $('#estado').text(),
        municipio: $('#municipio').text(),
        parroquia: $('#parroquia').text(),
        calle: $('#calle').text(),
        codigo_postal: $('#codigo-postal').text(),
        tipo_vivienda: $('#tipo-vivienda').text()
    };
}

async function obtenerSelectDeEstados(estadoNombre = '', municipioNombre = '', parroquiaNombre = '') {
    try {
        const response = await fetch('backend/get-direcciones2.php');
        const data = await response.json();
        if (data.status === 'success') {
            // Obtener los elementos select
            const estadoSelect = document.getElementById('edit-estado');
            const municipioSelect = document.getElementById('edit-municipio');
            const parroquiaSelect = document.getElementById('edit-parroquia');

            // Limpiar y popular el select de estados
            estadoSelect.innerHTML = '<option value="" disabled selected>Seleccione un estado</option>';
            data.data.forEach(estado => {
                const option = document.createElement('option');
                option.value = estado.id;
                option.textContent = estado.nombre;
                estadoSelect.appendChild(option);
                
                // Si este es el estado que buscamos, seleccionarlo y cargar sus municipios
                if (estado.nombre === estadoNombre) {
                    option.selected = true;
                    
                    // Habilitar y popular municipios
                    municipioSelect.disabled = false;
                    municipioSelect.innerHTML = '<option value="" disabled selected>Seleccione un municipio</option>';
                    estado.municipios.forEach(municipio => {
                        const mOption = document.createElement('option');
                        mOption.value = municipio.id;
                        mOption.textContent = municipio.nombre;
                        mOption.dataset.parroquias = JSON.stringify(municipio.parroquias);
                        municipioSelect.appendChild(mOption);
                        
                        // Si este es el municipio que buscamos, seleccionarlo y cargar sus parroquias
                        if (municipio.nombre === municipioNombre) {
                            mOption.selected = true;
                            
                            // Habilitar y popular parroquias
                            parroquiaSelect.disabled = false;
                            parroquiaSelect.innerHTML = '<option value="" disabled selected>Seleccione una parroquia</option>';
                            municipio.parroquias.forEach(parroquia => {
                                const pOption = document.createElement('option');
                                pOption.value = parroquia.id;
                                pOption.textContent = parroquia.nombre;
                                parroquiaSelect.appendChild(pOption);
                                
                                // Si esta es la parroquia que buscamos, seleccionarla
                                if (parroquia.nombre === parroquiaNombre) {
                                    pOption.selected = true;
                                }
                            });
                        }
                    });
                }
            });

            // Almacenar los datos completos para uso en los listeners
            estadoSelect.dataset.direcciones = JSON.stringify(data.data);

            // Agregar listeners para cambios
            estadoSelect.addEventListener('change', function() {
                const estadoId = this.value;
                const direcciones = JSON.parse(this.dataset.direcciones);
                const estadoSeleccionado = direcciones.find(e => e.id === estadoId);

                // Resetear y habilitar select de municipios
                municipioSelect.innerHTML = '<option value="" disabled selected>Seleccione un municipio</option>';
                municipioSelect.disabled = false;

                // Resetear y deshabilitar select de parroquias
                parroquiaSelect.innerHTML = '<option value="" disabled selected>Seleccione una parroquia</option>';
                parroquiaSelect.disabled = true;

                if (estadoSeleccionado && estadoSeleccionado.municipios) {
                    estadoSeleccionado.municipios.forEach(municipio => {
                        const option = document.createElement('option');
                        option.value = municipio.id;
                        option.textContent = municipio.nombre;
                        option.dataset.parroquias = JSON.stringify(municipio.parroquias);
                        municipioSelect.appendChild(option);
                    });
                }
            });

            municipioSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const parroquias = JSON.parse(selectedOption.dataset.parroquias || '[]');

                // Resetear y habilitar select de parroquias
                parroquiaSelect.innerHTML = '<option value="" disabled selected>Seleccione una parroquia</option>';
                parroquiaSelect.disabled = false;

                parroquias.forEach(parroquia => {
                    const option = document.createElement('option');
                    option.value = parroquia.id;
                    option.textContent = parroquia.nombre;
                    parroquiaSelect.appendChild(option);
                });
            });

            return data.data;
        } else {
            throw new Error(data.message || 'Error al obtener las direcciones');
        }
    } catch (error) {
        console.error('Error al obtener direcciones:', error);
        throw error;
    }
}

async function editarEmpleado() {
    try {
        // Obtener la información del empleado
        const infoEmpleado = obtenerInfoEmpleado();
        if (!infoEmpleado) {
            throw new Error('No se pudo obtener la información del empleado');
        }

        // Cargar los selects de dirección con los valores actuales del empleado
        await obtenerSelectDeEstados(infoEmpleado.estado, infoEmpleado.municipio, infoEmpleado.parroquia);

        // Llenar el resto de los campos del formulario
        $('#edit-tipo-usuario').val(infoEmpleado.tipo_usuario);
        $('#edit-nombre').val(infoEmpleado.nombre);
        $('#edit-apellido').val(infoEmpleado.apellido);
        $('#edit-cedula').val(infoEmpleado.cedula);
        $('#edit-email').val(infoEmpleado.email);
        $('#edit-telefono').val(infoEmpleado.telefono);
        $('#edit-fecha-registro').val(infoEmpleado.fecha_registro);
        $('#edit-cargo').val(infoEmpleado.cargo);
        $('#edit-area').val(infoEmpleado.area);
        $('#edit-salario').val(infoEmpleado.salario);
        $('#edit-calle').val(infoEmpleado.calle);
        $('#edit-codigo-postal').val(infoEmpleado.codigo_postal);
        $('#edit-tipo-vivienda').val(infoEmpleado.tipo_vivienda);
        $('#guardarEmpleado').on('click', function() {
            enviarForm(infoEmpleado.id);
        });

        // Cerrar el modal de vista
        $('#empleadoModal').modal('hide');

        // Mostrar el modal de edición
        $('#editarEmpleadoModal').modal('show');
    } catch (error) {
        console.error('Error:', error);
        alert('Error al cargar el formulario de edición');
    }
}

function enviarForm(id) {
    const formData = {
        id: id,
        tipo_usuario: $('#edit-tipo-usuario').val(),
        nombre: $('#edit-nombre').val(),
        apellido: $('#edit-apellido').val(),
        cedula: $('#edit-cedula').val(),
        email: $('#edit-email').val(),
        telefono: $('#edit-telefono').val(),
        fecha_ingreso: $('#edit-fecha-registro').val(),
        estado: $('#edit-estado').val(),
        municipio: $('#edit-municipio').val(),
        parroquia: $('#edit-parroquia').val(),
        calle: $('#edit-calle').val(),
        zip: $('#edit-codigo-postal').val(),
        vivienda: $('#edit-tipo-vivienda').val(),
        cargo: $('#edit-cargo').val(),
        area: $('#edit-area').val(),
        salario_base: $('#edit-salario').val()
    };

    $.ajax({
        url: 'backend/editar-empleado.php',
        type: 'POST',
        data: formData,
        complete: function() {
            location.reload();
        }
    });
}

function eliminarEmpleadoModal() {
    const empleadoId = $('#empleadoModal').attr('data-empleado-id');
    
    // Remover el foco de cualquier elemento dentro del modal
    document.activeElement.blur();
    
    // Ocultar el empleadoModal usando el evento hidden.bs.modal
    const empleadoModal = bootstrap.Modal.getInstance(document.getElementById('empleadoModal'));
    empleadoModal.hide();
    
    // Esperar a que el primer modal se oculte completamente antes de mostrar el segundo
    $('#empleadoModal').on('hidden.bs.modal', function () {
        // Añadir el id al modal de eliminar
        $('#eliminarModal').attr('data-empleado-id', empleadoId);
        // Mostrar el eliminarModal
        $('#eliminarModal').modal('show');
        // Remover el event listener para evitar duplicados
        $(this).off('hidden.bs.modal');
    });
}

async function eliminarEmpleado() {
    const empleadoId = $('#eliminarModal').attr('data-empleado-id');
    let motivoSeleccionado = document.querySelector('input[name="motivo"]:checked').value;
    if (motivoSeleccionado === 'otro') {
        motivoSeleccionado = $('#otroMotivo').val()
    }
    
    try {
        // Primero generar el PDF
        await generarEliminarEmpleadoPdf(empleadoId, motivoSeleccionado);
        
        // Luego eliminar el empleado
        await $.ajax({
            url: 'backend/eliminar-empleado.php',
            type: 'POST',
            data: {
                empleadoId: empleadoId,
            }
        });

        // Cerrar el modal y recargar la página
        $('#eliminarModal').modal('hide');
        location.reload();
        
    } catch (error) {
        console.error('Error:', error);
        alert('Ocurrió un error durante el proceso');
    }
}

async function generarEliminarEmpleadoPdf(empleadoId, motivoSeleccionado){
    return new Promise((resolve, reject) => {
        $.ajax({
            url: 'backend/eliminar-empleado-pdf.php',
            type: 'POST',
            data: {
                empleadoId: empleadoId,
                motivo: motivoSeleccionado
            },
            success: function(response) {
                if (response.success) {
                    window.open(response.pdf_url, '_blank', 'noopener,noreferrer');
                    resolve(response);
                } else {
                    reject('Error al generar pdf: ' + response.error);
                }
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                reject('Error del servidor al generar pdf: ' + xhr.responseJSON.error);
            }
        });
    });
}

function diasLibresModal(){
    const empleadoId = $('#empleadoModal').attr('data-empleado-id');
    
    // Remover el foco de cualquier elemento dentro del modal
    document.activeElement.blur();
    
    // Ocultar el empleadoModal usando el evento hidden.bs.modal
    const empleadoModal = bootstrap.Modal.getInstance(document.getElementById('empleadoModal'));
    empleadoModal.hide();
    
    // Esperar a que el primer modal se oculte completamente antes de mostrar el segundo
    $('#empleadoModal').on('hidden.bs.modal', function () {
        // Añadir el id al modal de dias libres
        $('#diasLibresModal').attr('data-empleado-id', empleadoId);

        // Inicializar daterangepicker
        $('#daterange').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY',
                separator: ' - ',
                applyLabel: 'Aplicar',
                cancelLabel: 'Cancelar',
                daysOfWeek: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']
            }
        });

        // Mostrar el modal
        $('#diasLibresModal').modal('show');
        
        // Remover el event listener para evitar duplicados
        $(this).off('hidden.bs.modal');
    });
}

async function asignarDiasLibres(){
    const empleadoId = $('#diasLibresModal').attr('data-empleado-id');
    const fechaInicio = $('#daterange').val().split(' - ')[0];
    const fechaFin = $('#daterange').val().split(' - ')[1];

    console.log('Enviando datos:', { empleadoId, fechaInicio, fechaFin }); // Debug

    $.ajax({
        url: 'backend/dias-libres.php',
        type: 'POST',
        data: {
            empleadoId: empleadoId,
            fechaInicio: fechaInicio,
            fechaFin: fechaFin
        },
        success: function(response) {
            console.log('Respuesta:', response); // Debug
            try {
                if (response.success) {
                    $('#diasLibresModal').modal('hide');
                    // Recargar la tabla
                    location.reload();
                } else {
                    alert('Error: ' + (response.error || 'Error desconocido'));
                }
            } catch (e) {
                console.error('Error al procesar respuesta:', e);
                alert('Error al procesar la respuesta del servidor');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error AJAX:', error);
            alert('Error al comunicarse con el servidor');
        }
    });
}

// Manejo de radio buttons en el modal de eliminar
document.querySelectorAll('input[name="motivo"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const otroInput = document.getElementById('otroInput');
        if (this.value === 'otro') {
            otroInput.style.display = 'block';
        } else {
            otroInput.style.display = 'none';
            document.getElementById('otroMotivo').value = '';
        }
    });
});
