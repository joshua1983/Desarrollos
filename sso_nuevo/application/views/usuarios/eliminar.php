<div id="userModaleliminar" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" name="cerrar" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title eliminar-text-usuario">Estas seguro de eliminar el usuario</h4>
            </div>
            <form action="<?= base_url("usuario/eliminar") ?>" id="form_usuario_eliminar" method="post" onsubmit="return false">
                <input type="hidden" id="id_cedula_eliminar">
                <div class="modal-footer">
                    <input type="submit" name="eliminar" id="eliminar" class="btn btn-danger eliminar btn-flat" value="Eliminar" />
                    <button type="button" name="cerrar" class="btn btn-default btn-flat" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>