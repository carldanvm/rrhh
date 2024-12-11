<?php
require('rrhh/fpdf/fpdf.php');

// Función para convertir números a palabras en español
function numero_a_palabras($num) {
    $f = new NumberFormatter("es", NumberFormatter::SPELLOUT);
    return $f->format($num);
}

// Verificar si se han recibido los datos del empleado
if (isset($_GET['nombre']) && isset($_GET['apellido']) && isset($_GET['cedula']) && isset($_GET['telefono']) && isset($_GET['fecha_ingreso']) && isset($_GET['cargo']) && isset($_GET['salario_base'])) {
    // Obtener la información del empleado desde la URL
    $nombre = $_GET['nombre'];
    $apellido = $_GET['apellido'];
    $cedula = $_GET['cedula'];
    $telefono = $_GET['telefono'];
    $fecha_ingreso = $_GET['fecha_ingreso'];
    $cargo = $_GET['cargo'];
    $salario = $_GET['salario_base'];
    $salario_en_palabras = numero_a_palabras($salario);

    // Crear el documento PDF
    class PDF extends FPDF {
        // Pie de página
        function Footer() {
            $this->SetY(-15);
            $this->SetFont('Arial', 'I', 8);
            $this->Cell(0, 10, 'Microsoft. Caracas, Venezuela. Telefono: (0212) 1234567', 0, 0, 'C');
        }
    }

    $pdf = new PDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 12);

    // Logo de la empresa
    $pdf->Image('img/LogoMicrosoft.jpg', 10, 10, 30);

    // Fecha
    $pdf->SetXY(160, 10);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'Fecha: ' . date('d-m-Y'), 0, 1, 'R');

    // Título de la constancia
    $pdf->Ln(20);
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'Constancia de Trabajo', 0, 1, 'C');
    $pdf->Ln(10);

    // Texto de la constancia de trabajo
    $pdf->SetFont('Arial', '', 12);
    $texto = "Por medio de la presente, se hace constar que el Sr./Sra. " . $nombre . " " . $apellido . ", 
    con cédula de identidad número " . $cedula . "y número de teléfono " . $telefono . ", 
    labora en nuestra empresa en el cargo de " . $cargo . " desde el " . date('d-m-Y', strtotime($fecha_ingreso))
    . " con un salario mensual de " . $salario . " (" . $salario_en_palabras . ") dolares estadounidenses.
    \n\nEsta constancia se expide a solicitud del interesado, a los efectos que estime conveniente.";

    $pdf->MultiCell(0, 10, $texto);
    $pdf->Ln(20);

    // Firma
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Atentamente,', 0, 1, 'C');
    $pdf->Ln(10);
    $pdf->Cell(0, 10, 'Pepito Perez', 0, 1, 'C');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'Gerente de Recursos Humanos', 0, 1, 'C');

    // Salida del PDF
    $pdf->Output('D', 'constancia_trabajo.pdf');
} else {
    echo "Faltan datos del empleado";
}
?>
