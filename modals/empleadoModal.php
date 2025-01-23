<div class="modal fade" id="empleadoModal" tabindex="-1" aria-labelledby="empleadoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="empleadoModalLabel">Informacion del empleado</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="d-flex flex-column p-3">
          <h5 class="mb-3 text-primary border-bottom pb-2">Información Personal</h5>
          <div class="mb-2"><strong>Tipo de usuario:</strong> <span id="tipo-usuario" class="text-secondary"></span></div>
          <div class="mb-2"><strong>Nombre:</strong> <span id="nombre" class="text-secondary"></span></div>
          <div class="mb-2"><strong>Apellido:</strong> <span id="apellido" class="text-secondary"></span></div>
          <div class="mb-2"><strong>Cedula:</strong> <span id="cedula" class="text-secondary"></span></div>
          <div class="mb-2"><strong>Email:</strong> <span id="email" class="text-secondary"></span></div>
          <div class="mb-2"><strong>Telefono:</strong> <span id="telefono" class="text-secondary"></span></div>
          <div class="mb-2"><strong>Fecha de registro:</strong> <span id="fecha-registro" class="text-secondary"></span></div>

          <h5 class="mb-3 text-primary border-bottom pb-2 mt-3">Información Laboral</h5>
          <div class="mb-2"><strong>Cargo:</strong> <span id="cargo" class="text-secondary"></span></div>
          <div class="mb-2"><strong>Area:</strong> <span id="area" class="text-secondary"></span></div>
          <div class="mb-2"><strong>Salario:</strong> <span id="salario" class="text-secondary"></span></div>

          <h5 class="mb-3 text-primary border-bottom pb-2 mt-3">Dirección</h5>
          <div class="mb-2"><strong>Estado:</strong> <span id="estado" class="text-secondary"></span></div>

          <div class="mb-2"><strong>Municipio:</strong> <span id="municipio" class="text-secondary"></span></div>
          <div class="mb-2"><strong>Parroquia:</strong> <span id="parroquia" class="text-secondary"></span></div>
          <div class="mb-2"><strong>Calle:</strong> <span id="calle" class="text-secondary"></span></div>
          <div class="mb-2"><strong>Código postal:</strong> <span id="codigo-postal" class="text-secondary"></span></div>
          <div class="mb-2"><strong>Tipo de vivienda:</strong> <span id="tipo-vivienda" class="text-secondary"></span></div>

        </div>
      </div>
      <div class="modal-footer">
        <div class="dropdown">
          <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            Acciones
          </button>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item text-success" href="#" onclick="diasLibresModal()">
              Asignar días libres
            </a></li>
            <li><a class="dropdown-item text-warning" href="#" onclick="editarEmpleado()">
              Editar empleado
            </a></li>
            <li><a class="dropdown-item text-primary" href="#" onclick="generarConstancia()">
              Generar constancia
            </a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-danger" href="#" onclick="eliminarEmpleadoModal()">
              Eliminar empleado
            </a></li>
          </ul>
        </div>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>