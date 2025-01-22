<div class="modal fade" id="editarEmpleadoModal" tabindex="-1" aria-labelledby="editarEmpleadoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editarEmpleadoModalLabel">Editar empleado</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="editarEmpleadoForm">
          <div class="d-flex flex-column p-3">
            <h5 class="mb-3 text-primary border-bottom pb-2">Información Personal</h5>
            <div class="mb-2">
                <label for="edit-tipo-usuario" class="form-label"><strong>Tipo de usuario:</strong></label>
                <input type="text" id="edit-tipo-usuario" name="tipo_usuario" class="form-control" readonly>
            </div>
            <div class="mb-2">
                <label for="edit-nombre" class="form-label"><strong>Nombre:</strong></label>
                <input type="text" id="edit-nombre" name="nombre" class="form-control" required>
            </div>
            <div class="mb-2">
                <label for="edit-apellido" class="form-label"><strong>Apellido:</strong></label>
                <input type="text" id="edit-apellido" name="apellido" class="form-control" required>
            </div>
            <div class="mb-2">
                <label for="edit-cedula" class="form-label"><strong>Cedula:</strong></label>
                <input type="text" id="edit-cedula" name="cedula" class="form-control" required>
            </div>
            <div class="mb-2">
                <label for="edit-email" class="form-label"><strong>Email:</strong></label>
                <input type="email" id="edit-email" name="email" class="form-control" required>
            </div>
            <div class="mb-2">
                <label for="edit-telefono" class="form-label"><strong>Telefono:</strong></label>
                <input type="tel" id="edit-telefono" name="telefono" class="form-control" required>
            </div>
            <div class="mb-2">
                <label for="edit-fecha-registro" class="form-label"><strong>Fecha de registro:</strong></label>
                <input type="text" id="edit-fecha-registro" name="fecha_ingreso" class="form-control" readonly>
            </div>

            <h5 class="mb-3 text-primary border-bottom pb-2 mt-3">Información Laboral</h5>
            <div class="mb-2">
                <label for="edit-cargo" class="form-label"><strong>Cargo:</strong></label>
                <input type="text" id="edit-cargo" name="cargo" class="form-control" required>
            </div>
            <div class="mb-2">
                <label for="edit-area" class="form-label"><strong>Area:</strong></label>
                <input type="text" id="edit-area" name="area" class="form-control" required>
            </div>
            <div class="mb-2">
                <label for="edit-salario" class="form-label"><strong>Salario:</strong></label>
                <input type="number" id="edit-salario" name="salario_base" class="form-control" required>
            </div>

            <h5 class="mb-3 text-primary border-bottom pb-2 mt-3">Dirección</h5>
            <div class="mb-2">
                <label for="edit-estado" class="form-label"><strong>Estado:</strong></label>
                <select class="form-select" id="edit-estado" name="estado" required>
                    <option value="" disabled selected>Seleccione un estado</option>
                </select>
            </div>
            <div class="mb-2">
                <label for="edit-municipio" class="form-label"><strong>Municipio:</strong></label>
                <select class="form-select" id="edit-municipio" name="municipio" required disabled>
                    <option value="" disabled selected>Seleccione un municipio</option>
                </select>
            </div>
            <div class="mb-2">
                <label for="edit-parroquia" class="form-label"><strong>Parroquia:</strong></label>
                <select class="form-select" id="edit-parroquia" name="parroquia" required disabled>
                    <option value="" disabled selected>Seleccione una parroquia</option>
                </select>
            </div>
            <div class="mb-2">
                <label for="edit-calle" class="form-label"><strong>Calle:</strong></label>
                <input type="text" id="edit-calle" name="calle" class="form-control" required>
            </div>
            <div class="mb-2">
                <label for="edit-codigo-postal" class="form-label"><strong>Código postal:</strong></label>
                <input type="text" id="edit-codigo-postal" name="zip" class="form-control" required>
            </div>
            <div class="mb-2">
                <label for="edit-tipo-vivienda" class="form-label"><strong>Tipo de vivienda:</strong></label>
                <input type="text" id="edit-tipo-vivienda" name="vivienda" class="form-control" required>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="guardarEmpleado">Guardar cambios</button>
      </div>
    </div>
  </div>
</div>
