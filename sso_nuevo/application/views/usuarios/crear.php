<button type="button" id="add_button" title="Nuevo" data-tooltip="tooltip" data-toggle="modal" data-target="#userModal" class="btn btn-primary btn-flat">Nuevo</button>
<div id="userModal" class="modal fade">
    <div class="modal-dialog">
        <form action="<?php echo base_url(); ?>usuario/registrar" method="POST" id="form_ingresar_usuario" class="ajax-crear-formulario" onsubmit="return false">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Agregar usuario</h4>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="cedula">Cédula</label>
                                <input type="text" class="form-control required" id="cedula" name="cedula" placeholder="Ingresa la cédula">
                            </div>
                            <div class="form-group">
                                <label for="password">Clave</label>
                                <input type="password" class="form-control password" id="change_password" name="password" placeholder="Ingresa la clave">
                            </div>   
                            <div class="form-group">
                                <label for="nombre">Nombres</label>
                                <input type="text" class="form-control required" id="nombre" name="nombre" placeholder="Ingresa el nombre">
                            </div>
                            <div class="form-group">
                                <label for="nombre">Apellidos</label>
                                <input type="text" class="form-control required" id="apellidos" name="apellidos" placeholder="Ingresa el apellido">
                            </div>
                            <div class="form-group">
                                <label for="email">Correo</label>
                                <input type="email" class="form-control email_safe" id="email" name="email" placeholder="Ingresa el correo">
                                <input type="hidden" id="validar_ingreso_admin" value="1">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <input type="submit" name="action" id="action" class="btn btn-primary btn-flat" value="Agregar" />
                    <button type="button" name="cerrar" class="btn btn-default btn-flat" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </form>
    </div>
</div>