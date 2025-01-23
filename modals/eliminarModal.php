<div class="modal fade" id="eliminarModal" tabindex="-1" aria-labelledby="eliminarModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="eliminarModalLabel">Seleccionar motivo para eliminar</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="form-check mb-2">
          <input class="form-check-input" type="radio" name="motivo" id="renuncia" value="renuncia">
          <label class="form-check-label" for="renuncia">
            Renuncia
          </label>
        </div>
        <div class="form-check mb-2">
          <input class="form-check-input" type="radio" name="motivo" id="despido" value="despido">
          <label class="form-check-label" for="despido">
            Despido
          </label>
        </div>
        <div class="form-check mb-2">
          <input class="form-check-input" type="radio" name="motivo" id="otro" value="otro">
          <label class="form-check-label" for="otro">
            Otro
          </label>
        </div>
        <div class="mb-3" id="otroInput" style="display: none;">
          <input type="text" class="form-control" id="otroMotivo" placeholder="Especifique el motivo">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" id="eliminarEmpleado" onclick=eliminarEmpleado()>Eliminar empleado</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>