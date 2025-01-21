const model_url = 'js/libs/models';
const nextButton = document.getElementById('next-step');

// Load all required models
Promise.all([
    faceapi.loadSsdMobilenetv1Model(model_url),
    faceapi.loadFaceLandmarkModel(model_url),
    faceapi.loadFaceRecognitionModel(model_url)
]).then(initialize)
.catch(error => {
    console.error('Error loading face recognition models:', error);
});

async function initialize() {
    const imagenInput = document.getElementById('imagen');
    const statusReconocimiento = document.getElementById('face-status');

    imagenInput.addEventListener('change', async (e) => {
        if (e.target.files.length > 0) {
            // Mostrar mensaje de loading y deshabilitar el boton
            statusReconocimiento.textContent = 'Procesando...';
            nextButton.disabled = true;
            const selectedFile = e.target.files[0];
            await analyzeFace(selectedFile);
        }
    });

}

async function analyzeFace(imagenFile) {
    const descriptorInput = document.getElementById('descriptor_facial');
    const statusReconocimiento = document.getElementById('face-status');

    try {
        // Crear una imagen temporal para el procesamiento
        const img = await faceapi.bufferToImage(imagenFile);
        
        // Detectar cara en la imagen
        const detection = await faceapi.detectSingleFace(img)
            .withFaceLandmarks()
            .withFaceDescriptor();

        if (detection) {
            // Obtener el descriptor facial
            const descriptor = Array.from(detection.descriptor);
            
            // Insertar el descriptor en el campo de entrada
            descriptorInput.value = JSON.stringify(descriptor);

            // Mostrar mensaje de exito y habilitar el boton
            statusReconocimiento.textContent = 'Rostro detectado';
            nextButton.disabled = false;
        } else {
            statusReconocimiento.textContent = 'No se detectó ninguna cara en la imagen. Por favor, intenta con otra imagen.';
        }
    } catch (error) {
        console.error('Error al analizar la cara:', error);
        statusReconocimiento.textContent = 'Error al procesar la imagen. Por favor, intenta con otra imagen.';
    }
}