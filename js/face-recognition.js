const model_url = 'js/libs/models';

// Load all required models
Promise.all([
    faceapi.loadSsdMobilenetv1Model(model_url),
    faceapi.loadFaceLandmarkModel(model_url),
    faceapi.loadFaceRecognitionModel(model_url)
]).then(initializeCamera)
.catch(error => {
    console.error('Error loading face recognition models:', error);
});

async function initializeCamera() {
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const captureButton = document.getElementById('capture');
    const faceDataDiv = document.getElementById('faceData');
    
    try {
        // Solicitar acceso a la cámara
        const stream = await navigator.mediaDevices.getUserMedia({ 
            video: true 
        });
        video.srcObject = stream;
        
        console.log('Cámara inicializada correctamente');

        // Comenzar detección en tiempo real cuando el video esté listo
        video.addEventListener('play', () => {
            detectFaceRealTime();
        });

        // Agregar evento de captura de rostros
        captureButton.addEventListener('click', () => captureFace());
        
    } catch (error) {
        console.error('Error al acceder a la cámara:', error);
    }
}

async function detectFaceRealTime() {
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const context = canvas.getContext('2d');

    // Función recursiva para detección continua
    async function detect() {
        const detections = await faceapi.detectAllFaces(video)
            .withFaceLandmarks()
            .withFaceDescriptors();

        // Limpiar canvas
        context.clearRect(0, 0, canvas.width, canvas.height);

        if (detections.length > 0) {
            // Redimensionar las detecciones al tamaño del canvas
            const displaySize = { width: canvas.width, height: canvas.height };
            const resizedDetections = faceapi.resizeResults(detections, displaySize);

            // Dibujar rectángulo para cada cara detectada
            resizedDetections.forEach(detection => {
                const box = detection.detection.box;
                context.strokeStyle = '#00ff00';
                context.lineWidth = 2;
                context.strokeRect(box.x, box.y, box.width, box.height);
            });
        }

        // Continuar el loop de detección
        requestAnimationFrame(detect);
    }

    detect();
}

async function captureFace() {
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const faceDataDiv = document.getElementById('faceData');
    
    try {
        // Detectar cara en el frame actual
        const detections = await faceapi.detectAllFaces(video)
            .withFaceLandmarks()
            .withFaceDescriptors();
        
        if (detections.length === 0) {
            faceDataDiv.innerHTML = 'No se detectó ninguna cara en la imagen';
            return;
        }
        
        // Obtener el descriptor facial (array de 128 números)
        const faceDescriptor = Array.from(detections[0].descriptor);
        
        // Guardar en localStorage para uso futuro
        localStorage.setItem('faceDescriptor', JSON.stringify(faceDescriptor));
        
        // Mostrar el descriptor de manera legible
        faceDataDiv.innerHTML = `
            <p>Descriptor facial guardado (128 características):</p>
            <div style="max-height: 150px; overflow-y: auto; font-family: monospace; font-size: 0.8em; background: #f8f9fa; padding: 10px; border-radius: 5px;">
                [${faceDescriptor.map(n => n.toFixed(4)).join(', ')}]
            </div>
        `;
        
        console.log("Descriptor facial guardado:", faceDescriptor);
    } catch (error) {
        console.error('Error al detectar la cara:', error);
        faceDataDiv.innerHTML = 'Error al procesar la imagen';
    }
}