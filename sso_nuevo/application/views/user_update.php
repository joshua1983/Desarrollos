<div class="container">
  
    <div class="row">
        <div class="col-xs-12 col-md-7 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">Actualizar datos</div>
                <div class="panel-body">
                    <form action="<?= base_url('usuario/guardar_datos') ?>" id="form_usuario_modificar" onsubmit="return false">
                        <table class="table table-user-information">
                            <tbody>
                                <tr>
                                    <td>Cedula:</td>
                                    <td>
                                        <input type="text" readonly="readonly" name="cedula" id="cedula" value="<?php echo $_SESSION["cedula"]; ?>" class="form-control required " />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Nombre:</td>
                                    <td>
                                        <input type="text" name="nombre" id="nombre_update" value="<?php echo $_SESSION["nombre"]; ?>" class="form-control required " />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Apellidos:</td>
                                    <td>
                                        <input type="text" name="apellidos" id="apellidos_update" value="<?php echo $_SESSION["apellidos"]; ?>" class="form-control required " />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Correo:</td>
                                    <td>
                                        <input type="mail" name="correo" id="correo_update" value="<?php echo $_SESSION["correo"]; ?>" class="form-control email_safe" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    
                    <a class="btn btn-default pull-right" href="<?php echo base_url('usuario/bienvenido') ?>" >Volver</a>
                    <button type="submit" id="guardar" class="btn btn-warning">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
