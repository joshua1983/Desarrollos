<div id="userModalChangePassword" class="modal fade">
    <div class="modal-dialog">
        <form action="" method="POST" id="form_change_password" onsubmit="return false">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" name="cerrar" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Cambiar contraseña</h4>
                </div>
                <div class="modal-body">            
                    <div class="row">
                        <div class="col-md-6">
                            <label for="">Contraseña (*)</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                <input type="password" name="password" id="change_password_update" class="form-control password" placeholder="Contraseña">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="">Repetir Contraseña (*)</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                <input type="password" name="change_password_repit" id="change_password_repit" class="form-control password_repit" placeholder="Contraseña">
                                <input type="hidden" name="cedula_usuario_change" id="cedula_usuario_change" class="cedula_usuario_change" value="">
                            </div>
                        </div>
                    </div>
                    <br>
                </div>
                <div class="modal-footer">
                    <input type="submit" name="change_password_button" id="change_password_button" class="btn btn-primary change_password_submit btn-flat" value="Cambiar contraseña" />
                    <button type="button" name="cerrar" class="btn btn-default btn-flat" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </form>
    </div>
</div>