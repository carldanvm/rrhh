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
                window.open(response.pdf_url, '_blank');
            }else{
                alert('Error al generar la constancia' + (response.error || ''));
            }
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
            alert('Error al generar la constancia');
        }
    })
}