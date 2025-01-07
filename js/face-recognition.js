const model_url = 'js/libs/models';
let selectedFile = null;

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
    const imageUpload = document.getElementById('imageUpload');
    const captureButton = document.getElementById('capture');
    const faceDataDiv = document.getElementById('faceData');

    imageUpload.addEventListener('change', async (e) => {
        if (e.target.files.length > 0) {
            selectedFile = e.target.files[0];
            faceDataDiv.innerHTML = '<p>Imagen cargada. Haz clic en "Analizar Cara" para procesar.</p>';
        }
    });

    captureButton.addEventListener('click', analyzeFace);
}

async function analyzeFace() {
    const faceDataDiv = document.getElementById('faceData');
    
    if (!selectedFile) {
        faceDataDiv.innerHTML = '<p class="text-danger">Por favor, selecciona una imagen primero.</p>';
        return;
    }

    try {
        // Crear una imagen temporal para el procesamiento
        const img = await faceapi.bufferToImage(selectedFile);
        
        // Detectar cara en la imagen
        const detection = await faceapi.detectSingleFace(img)
            .withFaceLandmarks()
            .withFaceDescriptor();

        if (detection) {
            // Obtener el descriptor facial y formatearlo para mostrar
            const descriptor = Array.from(detection.descriptor);
            const formattedDescriptor = descriptor.map(n => n.toFixed(7));
            
            // Mostrar el descriptor
            faceDataDiv.innerHTML = `
                <p class="text-success mb-2">¡Cara detectada correctamente!</p>
                <p class="mb-2">Descriptor facial (array de ${descriptor.length} números):</p>
                <div style="max-height: 200px; overflow-y: auto; background: #f8f9fa; padding: 10px; border-radius: 5px; font-family: monospace; font-size: 0.8em;">
                    [${formattedDescriptor.join(',\n ')}]
                </div>
            `;
        } else {
            faceDataDiv.innerHTML = '<p class="text-danger">No se detectó ninguna cara en la imagen. Por favor, intenta con otra imagen.</p>';
        }
    } catch (error) {
        console.error('Error al analizar la cara:', error);
        faceDataDiv.innerHTML = '<p class="text-danger">Error al procesar la imagen. Por favor, intenta con otra imagen.</p>';
    }
}