<br>
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-md-7 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">Registro</div>
                <div class="panel-body">
                            <form action="<?php echo base_url(); ?>usuario/registrar" id="form_ingresar_usuario"   method="post" onsubmit="return false">
            <div class="card card-success">
              
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="cedula">Cedula</label>
                                <input type="text" class="form-control required" id="cedula" name="cedula">
                            </div>
                            <div class="form-group">
                                <label for="password">Clave</label>
                                <input type="password" class="form-control password" id="change_password" name="password">
                            </div>
                            <div class="form-group">
                                <label for="password">Confirmar Clave</label>
                                <input type="password" class="form-control password_repit"  id="repetir-password" name="repetir-password">
                            </div>
                        </div>
                        <div class="col-sm-6">        
                            <div class="form-group">
                                <label for="nombre">Nombres</label>
                                <input type="text" class="form-control required" id="nombre" name="nombre">
                            </div>
                            <div class="form-group">
                                <label for="nombre">Apellidos</label>
                                <input type="text" class="form-control required" id="apellidos" name="apellidos">
                            </div>
                            <div class="form-group">
                                <label for="email">Correo</label>
                                <input type="email" class="form-control required" id="email" name="email">
                            </div>
                        </div>
                    </div>
                    
                    
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <a class="btn btn-default pull-right" href="<?php echo base_url('usuario/') ?>" >Volver</a>
                        </div>
                    </div>
                    
                </div>
            </div>
        </form>
                            <br>
                            <?php 

                            if (isset($error)){
                                ?>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="alert alert-danger alert-dismissible">
                                            <?php echo $error; ?>
                                        </div>
                                    </div>

                                </div>
                                <?php 
                            }
                            if (isset($mensaje)){
                                ?>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="alert alert-warning alert-dismissible">
                                            <?php echo $mensaje; ?>
                                        </div>
                                    </div>

                                </div>
                                <?php 
                            }
                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

