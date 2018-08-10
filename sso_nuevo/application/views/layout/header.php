<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <script src="<?php echo base_url() ?>assets/vendor/plugins/jquery/jquery.min.js"></script>
  
     <link rel="stylesheet" href="<?php echo base_url() ?>assets/vendor/plugins/bootstrap-3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/vendor/plugins/jquery-toast/css/jquery.toast.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/vendor/plugins/datatables/dataTables.bootstrap.min.css">
  
    <title> <?php if(isset($title)) echo $title; ?> - SSO Vanguardia</title>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <style>
      .active > a, .active > a:hover, .navbar-inverse .navbar-nav>.open>a, .navbar-inverse .navbar-nav>.open>a:focus, .navbar-inverse .navbar-nav>.open>a:hover{
        background: #367fa9 !important;
      }
    html {
        height: 100%;
    }
    body {
        min-height: 100%;
    }
    </style>
    <script>
       var $BASE_URL = "<?= base_url() ?>";
    </script>
</head>
<body>


<?php if(isset($_SESSION["cedula"])){ ?>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="<?= base_url('usuario/bienvenido') ?>">SSO</a>
    </div>
    <ul class="nav navbar-nav" >
      <?php if($_SESSION["rol"] == ROL_ADMINISTRADOR){ ?>
        <li class="active"><a href="<?= base_url('usuario/listar') ?>">Usuarios</a></li>
      <?php } ?>
    </ul>
    
    <ul class="nav navbar-nav navbar-right">
      
      <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-user"></span> <span id="enlace-nombre"><?= $_SESSION["nombre"]; ?> <?= $_SESSION["apellidos"]; ?></span> <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="<?= base_url('usuario/actualizar_datos') ?>">Modificar datos</a></li>
          <li><a href="#" class="cambiar-contrasenia-general">Cambiar contraseña</a></li>
        </ul>
      </li>


      <li><a href="<?= base_url('usuario/logout') ?>"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
    </ul>
  </div>
</nav>


<div id="userModalChangePasswordGeneral" class="modal fade">
    <div class="modal-dialog">
        <form action="" method="POST" id="form-change-password-general" onsubmit="return false">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" name="cerrar" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Cambiar contraseña</h4>
                </div>
                <div class="modal-body">            
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="">Contraseña Actual (*)</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                    <input type="password" name="password-general-actual" id="change-password-general-actual" class="form-control password" placeholder="Contraseña Actual">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="">Nueva Contraseña (*)</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                    <input type="password" name="password-general" id="change-password-general" class="form-control password" placeholder="Nueva Contraseña">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="">Repetir Contraseña (*)</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                    <input type="password" name="change-password-repit-general" id="change-password-repit-general" class="form-control password_repit" placeholder="Repetir Contraseña">
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                </div>
                <div class="modal-footer">
                    <input type="submit" name="change_password_button" id="change-password-button-general" class="btn-flat btn btn-primary change-password-button-general" value="Cambiar contraseña" />
                    <button type="button" name="cerrar" class="btn-flat btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php } ?>