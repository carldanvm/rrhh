const model_url = "js/libs/models";

// Load all required models
Promise.all([
  faceapi.loadSsdMobilenetv1Model(model_url),
  faceapi.loadFaceLandmarkModel(model_url),
  faceapi.loadFaceRecognitionModel(model_url),
])
  .then(() => {
    console.log("Modelos cargados correctamente");
  })
  .catch((error) => {
    console.error("Error loading face recognition models:", error);
  });

let stream = null;
let videoElement = null;
let canvasElement = null;
let processingComplete = false;
let faceDescriptors = [];
const REQUIRED_DESCRIPTORS = 3;
const DESCRIPTOR_THRESHOLD = 0.6; // Umbral para considerar que es la misma persona (menor a 0.6)
let lastDetectionTime = 0;

// Función para calcular la distancia euclidiana entre dos descriptores
function euclideanDistance(descriptor1, descriptor2) {
  return faceapi.euclideanDistance(descriptor1, descriptor2);
}

// Función para verificar si un descriptor es similar a los existentes
function isSimilarToExisting(newDescriptor) {
  if (faceDescriptors.length === 0) return true;
  
  // Comprobar la similitud con todos los descriptores existentes
  return faceDescriptors.every(existingDescriptor => 
    euclideanDistance(newDescriptor, existingDescriptor) < DESCRIPTOR_THRESHOLD
  );
}

async function startFaceRecognition() {
  try {
    videoElement = document.getElementById("videoElement");
    canvasElement = document.getElementById("canvasElement");
    const videoContainer = document.getElementById("video-container");
    const formularioRegistro = document.getElementById("formulario-registro-horas");
    const statusDisplay = document.getElementById("status-display");

    // Ocultar el formulario y mostrar el contenedor de video
    formularioRegistro.classList.add("d-none");
    videoContainer.classList.remove("d-none");

    // Resetear variables y mensajes
    processingComplete = false;
    faceDescriptors = [];
    statusDisplay.textContent = "Posicione su rostro frente a la cámara";

    // Obtener acceso a la cámara
    stream = await navigator.mediaDevices.getUserMedia({
      video: {
        width: { ideal: 640 },
        height: { ideal: 480 },
        facingMode: "user",
        frameRate: { ideal: 30 } // Agregado frameRate para mejor fluidez
      },
    });

    // Asignar el stream al elemento de video
    videoElement.srcObject = stream;

    // Esperar a que el video esté completamente cargado y reproduciéndose
    await new Promise((resolve) => {
      videoElement.onloadeddata = async () => {
        await videoElement.play();
        await new Promise(resolve => setTimeout(resolve, 100));
        console.log("Video cargado y reproduciendo");
        resolve();
      };
    });

    // Configurar el canvas después de que el video esté listo
    const displaySize = {
      width: videoElement.videoWidth,
      height: videoElement.videoHeight,
    };
    faceapi.matchDimensions(canvasElement, displaySize);

    // Función para dibujar el rectángulo y landmarks en el rostro
    function drawFaceDetection(detection, displaySize) {
      const canvas = document.getElementById("canvasElement");
      const context = canvas.getContext("2d");
      
      // Limpiar el canvas
      context.clearRect(0, 0, canvas.width, canvas.height);
      
      // Dibujar el rectángulo
      const box = detection.detection.box;
      context.beginPath();
      context.lineWidth = 3;
      context.strokeStyle = "#00ff00";
      context.rect(box.x, box.y, box.width, box.height);
      context.stroke();
      
      // Dibujar los landmarks
      const landmarks = detection.landmarks;
      context.fillStyle = "#00ff00";
      for (const point of landmarks.positions) {
        context.beginPath();
        context.arc(point.x, point.y, 2, 0, 2 * Math.PI);
        context.fill();
      }
    }

    // Iniciar la detección facial
    const startDetection = async () => {
      if (videoElement.paused || videoElement.ended || processingComplete) return;

      try {
        console.log("Iniciando detección facial");
        // Detectar cara en la imagen
        const detection = await faceapi
          .detectSingleFace(videoElement)
          .withFaceLandmarks()
          .withFaceDescriptor();

        if (detection && !processingComplete) {
          const descriptor = detection.descriptor;
          
          // Dibujar el rectángulo en el rostro
          const displaySize = { width: videoElement.width, height: videoElement.height };
          drawFaceDetection(detection, displaySize);
          
          // Verificar si el descriptor es similar a los existentes
          if (isSimilarToExisting(descriptor)) {
            faceDescriptors.push(descriptor);
            document.getElementById("status-display").textContent = 
              `Rostro detectado (${faceDescriptors.length}/${REQUIRED_DESCRIPTORS})`;
            
            // Si tenemos suficientes descriptores similares
            if (faceDescriptors.length >= REQUIRED_DESCRIPTORS) {
              processingComplete = true;
              document.getElementById("status-display").textContent = 
                "¡Captura completada!";
              await processDetection(faceDescriptors);
            }
          }
        } else {
          // Limpiar el canvas si no hay detección
          const canvas = document.getElementById("canvasElement");
          const context = canvas.getContext("2d");
          context.clearRect(0, 0, canvas.width, canvas.height);
        }
      } catch (error) {
        console.error("Error en la detección:", error);
      }

      if (!processingComplete) {
        requestAnimationFrame(startDetection);
      }
    };

    requestAnimationFrame(startDetection);

  } catch (error) {
    console.error("Error al acceder a la cámara:", error);
    document.getElementById("status-display").textContent =
      "Error al acceder a la cámara. Por favor, asegúrese de dar los permisos necesarios.";
    stopFaceRecognition();
  }
}

function stopFaceRecognition() {
  processingComplete = true;

  // Limpiar el canvas
  const canvas = document.getElementById("canvasElement");
  const context = canvas.getContext("2d");
  context.clearRect(0, 0, canvas.width, canvas.height);

  // Detener todos los tracks del stream
  if (stream) {
    stream.getTracks().forEach((track) => track.stop());
  }

  // Limpiar el source del video
  if (videoElement) {
    videoElement.srcObject = null;
  }

  // Mostrar nuevamente el formulario y ocultar el contenedor de video
  document
    .getElementById("formulario-registro-horas")
    .classList.remove("d-none");
  document.getElementById("video-container").classList.add("d-none");
  
  // Reiniciar el mensaje de estado
  document.getElementById("status-display").textContent = "Posicione su rostro frente a la cámara";
}

async function processDetection(descriptors) {
  console.log("Descriptores faciales capturados:", descriptors);
  // Aquí puedes procesar los descriptores como necesites
  stopFaceRecognition();
  validarRostro(descriptors);
}

async function validarRostro(descriptors){
    $.ajax({
        url: 'backend/validar-rostro.php',
        type: 'POST',
        data: {
            descriptores: descriptors
        },
        success: function(response) {
            // Verificar si la respuesta fue exitosa
            if (response.success) {
                console.log(response);
                // Crear mensaje de bienvenida o despedida según el tipo de registro
                const mensaje = response.tipo_registro === "entrada" 
                    ? "Bienvenido " + response.usuario_nombre + " " + response.usuario_apellido + "."
                    : "Hasta luego " + response.usuario_nombre + " " + response.usuario_apellido + ".";
                // Mostrar mensaje de éxito
                $("#mensaje-exito-horas").removeClass("alert-danger d-none").addClass("alert-success")
                    .text(mensaje);
                // Ocultar botón de inicio de reconocimiento facial
                $("#startFaceRecognition").addClass("d-none");
                // Mostrar y configurar botón de confirmación
                $("#confirmar-registro")
                    .removeClass("d-none")
                    .attr("onclick", `confirmarRegistro(${response.usuario_id}, '${response.tipo_registro}')`)
                    .text("Confirmar "+ response.tipo_registro);
                // Mostrar y configurar botón de cancelación
                $("#cancelar-registro")
                    .removeClass("d-none")
                    .text("Cancelar");
                // Ocultar título de registro
                $("#titulo-registro").addClass("d-none");
            } else {
                // Si la respuesta no fue exitosa, mostrar mensaje de error
                console.log(response);
                $("#mensaje-exito-horas").removeClass("alert-success d-none").addClass("alert-danger")
                    .text("Usuario no identificado.");
            }
        },
        error: function(xhr, status, error) {
            console.error("Error en la validación:", error);
            $("#mensaje-exito-horas").removeClass("alert-success d-none").addClass("alert-danger")
                .text("Error en el sistema. Por favor, intente nuevamente");
        }
    });
}
