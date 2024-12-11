document.addEventListener("DOMContentLoaded", function () {
    obtenerEstados();

    /* Listener para cuando se seleccione un estado */
    document.getElementById("estado").addEventListener("change", function () {
        mostrarMunicipios(this.value);
    });

    /* Listener para cuando se seleccione un municipio */
    document.getElementById("municipio").addEventListener("change", function () {
        // Obtener el ID del municipio y estado seleccionado
        const selectMunicipio = document.getElementById("municipio");
        const selectEstado = document.getElementById("estado");
        const municipioId = selectMunicipio.value;
        const estadoId = selectEstado.value;

        mostrarParroquias(estadoId, municipioId);
    });
});

/**
 * Realiza una peticion AJAX GET a backend/get-direcciones.php para obtener
 * todas las direcciones en formato JSON.
 *
 * @returns {undefined}
 */
function obtenerEstados() {
    $.ajax({
        url: 'backend/get-direcciones.php',
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            console.log(response);
            estados = response;
            mostrarEstados(response);
        },
        error: function (xhr, status, error) {
            console.error('Error al obtener las direcciones:', error);
        }
    });
}

function mostrarEstados(estados) {
    const selectElement = document.getElementById("estado");
    estados.forEach(estado => {
        const option = document.createElement("option");
        option.value = estado.id_estado;
        option.textContent = estado.estado;
        selectElement.appendChild(option);
    })
}



function mostrarMunicipios(estadoId) {
    const selectElement = document.getElementById("municipio");
    selectElement.innerHTML = ""; // Limpiar opciones existentes

    const estado = estados.find(estado => estado.id_estado == estadoId);

    if (!estado || !estado.municipios) {
        console.error('No se encontraron municipios para el estado seleccionado');
        return;
    }

    let municipiosArray;

    if (Array.isArray(estado.municipios)) {
        // Si ya es un array, lo usamos directamente
        municipiosArray = estado.municipios;
    } else if (typeof estado.municipios === 'object') {
        // Si es un objeto, lo convertimos a array
        municipiosArray = Object.values(estado.municipios);
    } else {
        console.error('Formato de municipios no reconocido');
        return;
    }

    municipiosArray.forEach(municipio => {
        const option = document.createElement("option");
        option.value = municipio.id_municipio;
        option.textContent = municipio.municipio;
        selectElement.appendChild(option);
    });
}

function mostrarParroquias(estadoId, municipioId) {
    const selectElement = document.getElementById("parroquia");
    selectElement.innerHTML = ""; // Limpiar opciones existentes

    const estado = estados.find(estado => estado.id_estado == estadoId);

    let municipiosArray;

    if (Array.isArray(estado.municipios)) {
        // Si ya es un array, lo usamos directamente
        municipiosArray = estado.municipios;
    } else if (typeof estado.municipios === 'object') {
        // Si es un objeto, lo convertimos a array
        municipiosArray = Object.values(estado.municipios);
    } else {
        console.error('Formato de municipios no reconocido');
        return;
    }

    const municipio = municipiosArray.find(municipio => municipio.id_municipio == municipioId);

    if (!municipio || !municipio.parroquias) {
        console.error('No se encontraron parroquias para el municipio seleccionado');
        return;
    }

    let parroquiasArray;

    if (Array.isArray(municipio.parroquias)) {
        // Si ya es un array, lo usamos directamente
        parroquiasArray = municipio.parroquias;
    } else if (typeof municipio.parroquias === 'object') {
        // Si es un objeto, lo convertimos a array
        parroquiasArray = Object.values(municipio.parroquias);
    } else {
        console.error('Formato de parroquias no reconocido');
        return;
    }

    parroquiasArray.forEach(parroquia => {
        const option = document.createElement("option");
        option.value = parroquia.id_parroquia;
        option.textContent = parroquia.parroquia;
        selectElement.appendChild(option);
    });
}