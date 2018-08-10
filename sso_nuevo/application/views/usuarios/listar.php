<br>
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">Usuarios registrados</div>
                <div class="panel-body">
                    <div class="box">
                    <div class="box-header">
                        
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <?php include('crear.php'); ?>
                        <br><br>
                        <div class="table-responsive">
                            <table id="usuarios_activos" class="table table-bordered" style="min-width: 100%">
                                <thead>
                                    <tr>
                                        <th>Cédula</th>
                                        <th>Nombre</th>
                                        <th>Apellido</th>
                                        <th>Correo</th> 
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                </div>
            </div>
        </div>
    </div>
</div>  
<?php include('modificar.php') ?>
<?php include('eliminar.php') ?>
<?php include('cambiar_password.php') ?>