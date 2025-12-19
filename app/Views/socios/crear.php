            
<?php include_once (APP_URL.'Views/partials/head.php');?>         
            
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="section-title">Clientes</h2>
                <!-- Botón que activa el modal -->
                <a href="#" class="btn btn-custom" data-bs-toggle="modal" data-bs-target="#modalNuevoCliente">
                    <i class="bi bi-person-plus-fill me-2"></i>Nuevo Cliente
                </a>
            </div>

            <!-- Modal Nuevo Cliente -->
            <div class="modal fade" id="modalNuevoCliente" tabindex="-1" aria-labelledby="modalNuevoClienteLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="?controlador=socio&accion=crearSocio" method="POST" enctype="multipart/form-data" class="modal-content bg-dark text-light">
                        <div class="modal-header border-0">
                            <h5 class="modal-title">Registrar Nuevo Cliente</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>

                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="nombre" class="form-label modal-text">Nombre*</label>
                                <input type="text" class="form-control" name="nombre" id="nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="apellido1" class="form-label modal-text ">Primer Apellido*</label>
                                <input type="text" class="form-control" name="apellido1" id="apellido1" required>
                            </div>
                            <div class="mb-3">
                                <label for="apellido2" class="form-label modal-text">Segundo Apellido</label>
                                <input type="text" class="form-control" name="apellido2" id="apellido2">
                            </div>
                            <div class="mb-3">
                                <label for="edad" class="form-label modal-text">Edad</label> <!--REVISAR SON LOS PARAMETROS DEL FORMULARIO CUANDO REGISTRAMOS A UN NUEVO USUARIO-->
                                <input type="number" class="form-control" name="edad" id="edad" min="10" max="100">
                            </div>
                            <div class="mb-3">
                                <label for="numero_telefono" class="form-label modal-text ">Numero Telefonico </label>
                                <input type="text" inputmode="numeric" class="form-control" name="numero_telefono" id="numero_telefono" pattern="[0-9]{10}">
                            </div>
                            <div class="mb-3">
                                <label for="contacto_familiar" class="form-label modal-text ">Contacto Familiar </label>
                                <input type="text" inputmode="numeric" class="form-control" name="contacto_familiar" id="contacto_familiar" pattern="[0-9]{10}">
                            </div>
                            <div class="mb-3">
                                <label for="descripcion_medica" class="form-label modal-text ">Descripcion del Cliente</label>
                                <input type="text" class="form-control" name="descripcion_medica" id="descripcion_medica">
                            </div>
                            <!--
                        <div class="mb-3">
                            <label for="qr" class="form-label modal-text ">QR</label>
                            <input type="text" class="form-control" name="qr" id="qr">
                        </div> 
                        -->
                            <div class="mb-3">
                                <label class="form-label modal-text">Nivel del Cliente</label>
                                <select class="form-select" name="categoria" id="categoria">
                                    <option value="" selected>--Seleccionar categoria--</option>
                                    <?php foreach ($categorias as $c): ?>
                                        <option value="<?= $c['id_categoria'] ?>"><?= $c['nombre'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>


                            <div class="mb-3">
                                <label class="form-label modal-text">Foto del Cliente (Opcional)</label><br>
                                <div class="d-flex flex-column gap-2">
                                    <button type="button" id="btnActivarCamara" class="btn btn-outline-danger">
                                        <i class="bi bi-camera-fill me-2"></i>Activar Cámara
                                    </button>
                                    <!--
                                    <button type="button" class="btn btn-secondary" id="switchCamera">
                                        <i class="bi bi-arrow-repeat me-2"></i>Cambiar cámara
                                         </button> -->
                                    <video id="videoNuevo" width="320" height="240" autoplay class="d-none rounded"></video>
                                    <button type="button" id="btnTomarFoto" class="btn btn-outline-primary d-none" onclick="tomarFoto()">
                                        <i class="bi bi-camera me-2"></i>Tomar Foto
                                    </button>
                                    <input type="hidden" name="foto" id="fotoInput">
                                    <div id="fotoPreview" class="text-center"></div>

                                    <!-- Opción para subir archivo 
                                    <div class="mt-2">
                                        <label class="form-label text-danger">O subir archivo:</label>
                                        <input type="file" name="foto_archivo" class="form-control" accept="image/*">
                                    </div>-->
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="submit" class="btn btn-custom" name="accion" value="registrar">
                                <i class="bi bi-check-circle-fill me-2"></i>Registrar
                            </button>
                        </div>
                    </form>
                </div>
            </div>