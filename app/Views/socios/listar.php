            <!-- Tabla de clientes -->
            <div class="table-responsive">
                <?php if (empty($listarClientes)): ?>
                    <div class="alert alert-warning text-center" role="alert">
                        <i class="bi bi-exclamation-circle-fill me-2"></i>
                        No hay clientes registrados aún.
                    </div>
                <?php else: ?>
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Foto</th>
                                <th>Nombre</th>
                                <th>Paterno</th>
                                <th>Materno</th>
                                <th>Edad</th>
                                <th>Teléfono</th>
                                <th>Desc. Médica</th>
                                <th>Contacto Familiar</th>
                                <th>Categoría</th>
                                <th>QR</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody class="table-dark">
                            <?php foreach ($listarClientes as $c): ?>
                                <tr>
                                    <td data-label="ID"><?= htmlspecialchars($c['id_cliente']) ?></td>
                                    <td data-label="Foto">
                                        <?php //tamano de la foto y lo que contiene la tabla 
                                        if (!empty($c['foto'])): ?>
                                            <img src="/pagos_gym/assets/fotos/<?= htmlspecialchars($c['foto']) ?>"
                                                alt="Foto cliente"
                                                class="img-thumbnail"
                                                width="80"
                                                style="cursor: pointer"
                                                onclick="mostrarFotoModal('/pagos_gym/assets/fotos/<?= htmlspecialchars($c['foto']) ?>')">
                                        <?php else: ?>
                                            <span class="text-info">Sin foto</span>
                                        <?php endif; ?>
                                    </td>
                                    <td data-label="Nombre"><?= htmlspecialchars($c['nombre']) ?></td> <!--aqui se traen los parametros del php-->
                                    <td data-label="Apellido1"><?= htmlspecialchars($c['apellido1']) ?></td>
                                    <td data-label="Apellido2"><?= htmlspecialchars($c['apellido2'] ?? '') ?></td>
                                    <td data-label="Edad"><?= htmlspecialchars($c['edad'] ?? '') ?></td>
                                    <td data-label="Telefono"><?= htmlspecialchars($c['numero_telefono'] ?? '') ?></td>
                                    <td data-label="Contacto familiar"><?= htmlspecialchars($c['contacto_familiar'] ?? '') ?></td>
                                    <td data-label="Descripción médica"><?= htmlspecialchars($c['descripcion_medica'] ?? '') ?></td>
                                    <td data-label="Categoria"><?= htmlspecialchars($c['nombre_categoria'] ?? '') ?></td>
                                    <td data-label="QR">
                                        <?php //tamano de la foto y lo que contiene la tabla 
                                        if (!empty($c['qr'])): ?>
                                            <img src="/pagos_gym/assets/qr/<?= htmlspecialchars($c['qr']) ?>"
                                                alt="Foto qr"
                                                class="img-thumbnail"
                                                width="80"
                                                style="cursor: pointer"
                                                onclick="mostrarFotoModal('/pagos_gym/assets/qr/<?= htmlspecialchars($c['qr']) ?>')">
                                        <?php else: ?>
                                            <span class="text-muted">Sin qr</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <!-- Botón editar -->
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editarModal<?= $c['id_cliente'] ?>">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>

                                        <!-- Modal editar cliente -->
                                        <div class="modal fade" id="editarModal<?= $c['id_cliente'] ?>" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-scroll="true">
                                            <div class="modal-dialog modal-dialog modal-dialog-scrollable">
                                                <form action="/pagos_gym/php/cliente.php" method="POST" class="modal-content bg-dark text-light" enctype="multipart/form-data">
                                                    <div class="modal-header border-0 " style="background: linear-gradient(135deg, #1a1a1a 0%, #343a40 100%);">
                                                        <h5 class="modal-title text-danger fw-bold"><i class="bi bi-person-gear me-2"></i>Editar Cliente</h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <div class="modal-body" style="background: linear-gradient(135deg, #2c3e50 0%, #1a1a1a 100%); color: #fff;">
                                                        <input type="hidden" name="accion" value="editar">
                                                        <input type="hidden" name="id_cliente" value="<?= $c['id_cliente'] ?>">

                                                        <div class="row">
                                                            <!-- Columna izquierda - Foto -->
                                                            <div class="col-md-5 mb-3">
                                                                <div class="card bg-dark border-danger h-100">
                                                                    <div class="card-body text-center">
                                                                        <h5 class="card-title text-danger mb-3">Foto del Cliente</h5>

                                                                        <?php if (!empty($c['foto'])): ?>
                                                                            <a href="#" onclick="mostrarFotoModal('/pagos_gym/assets/fotos/<?= htmlspecialchars($c['foto']) ?>')">
                                                                                <img src="/pagos_gym/assets/fotos/<?= htmlspecialchars($c['foto']) ?>"
                                                                                    alt="Foto actual"
                                                                                    class="img-thumbnail mb-3 shadow"
                                                                                    style="cursor: pointer; max-height: 300px; transition: transform 0.3s;"
                                                                                    onmouseover="this.style.transform='scale(1.05)'"
                                                                                    onmouseout="this.style.transform='scale(1)'">
                                                                            </a>
                                                                            <p class="text-warning small">Haz click para ampliar</p>
                                                                        <?php else: ?>
                                                                            <div class="bg-secondary rounded p-5 mb-3 text-center">
                                                                                <i class="bi bi-person-x-fill" style="font-size: 3rem; color: #495057;"></i>
                                                                                <p class="mt-2">Sin foto registrada</p>
                                                                            </div>
                                                                        <?php endif; ?>

                                                                        <div class="mt-3">
                                                                            <label class="form-label text-danger">Cambiar Foto</label>
                                                                            <input type="file" name="foto" class="form-control bg-dark text-white border-secondary" accept="image/*">
                                                                            <small class="text-muted">Formatos: JPG, PNG, GIF (Máx. 2MB)</small>
                                                                        </div>
                                                                        <!-- Input oculto fuera del modal 
                                                                        <input type="file" id="foto_<?= $c['id_cliente'] ?>" name="foto" accept="image/*" style="display:none"> -->

                                                                        <!-- Botón dentro del modal 
                                                                        <div class="mt-3">
                                                                            <label for="foto_<?= $c['id_cliente'] ?>" class="btn btn-primary w-100">
                                                                                <i class="bi bi-upload me-2"></i> Cambiar Foto
                                                                                </label>
                                                                            <small class="text-muted d-block mt-2">Formatos: JPG, PNG, GIF (Máx. 500kb)</small>
                                                                        </div> -->

                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Columna derecha - Datos -->
                                                            <div class="col-md-7">
                                                                <div class="card bg-dark border-primary h-100">
                                                                    <div class="card-body">
                                                                        <h5 class="card-title modal-text  mb-4">Datos del Cliente</h5>

                                                                        <div class="mb-3">
                                                                            <label class="form-label modal-text ">ID Cliente</label>
                                                                            <input type="text" class="form-control bg-secondary text-white" value="<?= htmlspecialchars($c['id_cliente']) ?>" readonly>
                                                                        </div>

                                                                        <div class="mb-3">
                                                                            <label class="form-label modal-text">Nombre*</label>
                                                                            <input type="text" name="nombre" class="form-control bg-dark text-white border-primary"
                                                                                value="<?= htmlspecialchars($c['nombre']) ?>" required>
                                                                        </div>

                                                                        <div class="mb-3">
                                                                            <label class="form-label modal-text">Apellido Paterno*</label>
                                                                            <input type="text" name="apellido1" class="form-control bg-dark text-white border-primary"
                                                                                value="<?= htmlspecialchars($c['apellido1']) ?>" required>
                                                                        </div>

                                                                        <div class="mb-3">
                                                                            <label class="form-label modal-text">Apellido Materno</label>
                                                                            <input type="text" name="apellido2" class="form-control bg-dark text-white border-primary"
                                                                                value="<?= htmlspecialchars($c['apellido2'] ?? '') ?>">
                                                                        </div>

                                                                        <div class="mb-3">
                                                                            <label class="form-label modal-text"> Edad </label>
                                                                            <input type="text" name="edad" class="form-control bg-dark text-white border-primary"
                                                                                value="<?= htmlspecialchars($c['edad'] ?? '') ?>">
                                                                        </div>

                                                                        <div class="mb-3">
                                                                            <label class="form-label modal-text"> Numero Telefonico </label>
                                                                            <input type="number" name="numero_telefono" class="form-control bg-dark text-white border-primary"
                                                                                value="<?= htmlspecialchars($c['numero_telefono'] ?? '') ?>">
                                                                        </div>


                                                                        <div class="mb-3">
                                                                            <label class="form-label modal-text"> Descripcion Medica </label>
                                                                            <input type="text" name="descripcion_medica" class="form-control bg-dark text-white border-primary"
                                                                                value="<?= htmlspecialchars($c['descripcion_medica'] ?? '') ?>">
                                                                        </div>

                                                                        <div class="mb-3">
                                                                            <label class="form-label modal-text "> Contacto Familiar </label>
                                                                            <input type="number" name="contacto_familiar" class="form-control bg-dark text-white border-primary"
                                                                                value="<?= htmlspecialchars($c['contacto_familiar'] ?? '') ?>">
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label class="form-label modal-text">Categoría</label>
                                                                            <select class="form-select" name="categoria" id="categoria">
                                                                                <option selected disabled>--Seleccionar categoria--</option>
                                                                                <?php foreach ($categorias as $cat): ?>
                                                                                    <option value="<?= $cat['id_categoria'] ?>"
                                                                                        <?= $cat['id_categoria'] == $c['id_categoria'] ? 'selected' : '' ?>>
                                                                                        <?= $cat['nombre'] ?>
                                                                                    </option>
                                                                                <?php endforeach; ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer border-0" style="background: linear-gradient(135deg, #1a1a1a 0%, #343a40 100%);">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                            <i class="bi bi-x-circle me-2"></i>Cancelar
                                                        </button>
                                                        <button type="submit" class="btn btn-success">
                                                            <i class="bi bi-check-circle-fill me-2"></i>Guardar Cambios
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </tr>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>