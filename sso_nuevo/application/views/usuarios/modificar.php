<div id="userModalupdate" class="modal fade">
    <div class="modal-dialog">
        <form action="<?= base_url('usuario/guardar_datos') ?>" class="form" id="form_usuario_modificar" onsubmit="return false">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" name="cerrar" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title title-modificar-usuario">Modificar usuario</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="nombre">Nombres</label>
                                <input type="text" class="form-control required" id="nombre_update" name="nombre" placeholder="Ingresa el nombre">
                            </div>
                            <div class="form-group">
                                <label for="nombre">Apellidos</label>
                                <input type="text" class="form-control required" id="apellidos_update" name="apellidos" placeholder="Ingresa el apellido">
                            </div>
                            <div class="form-group">
                                <label for="email">Correo</label>
                                <input type="email" class="form-control email_safe" id="correo_update" name="email" placeholder="Ingresa el correo">
                                <input type="hidden" id="validar_modificacion_admin" value="1">
                                <input type="hidden" id="id_cedula_update">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="usuario_id_update" id="usuario_id_update" />
                    <input type="submit" name="update" id="update_button" class="btn btn-success btn-flat" value="Modificar" />
                    <button type="button" name="cerrar" class="btn btn-default btn-flat" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </form>
    </div>
</div>