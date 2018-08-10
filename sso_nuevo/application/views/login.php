<br>
<div class="container">
	<div class="row">
		<div class="col-xs-12 col-md-7 col-md-offset-2">
			<div class="panel panel-primary">
				<div class="panel-heading">Autenticación</div>
				<div class="panel-body">
							<form  action="<?php echo base_url(); ?>usuario/login" method="post">
								<div class="card card-primary">
									<div class="card-header">

									</div>
									<div class="card-body">
										<div class="form-group">
											<label for="email">Cedula</label>
											<input type="number" class="form-control" id="email" name="email">
										</div>
										<div class="form-group">
											<label for="password">Clave</label>
											<input type="password" class="form-control" id="password" name="password">
										</div>
									</div>
									<div class="card-footer">
										<div class="row">
											<div class="col-sm-12">
												<button type="submit" class="btn btn-primary">Entrar</button>		
												
												<div class="pull-right">
													<a class="btn btn-default" href="<?php echo base_url(); ?>usuario/olvido">¿ Olvidaste la contraseña ? </a>	
													<a href="<?php echo base_url(); ?>usuario/nuevo" class="btn btn-warning ">Registrarse</a>		
												</div>
											</div>
										</div>

									</div>
									<?php
									if (isset($_GET["app"])){
										?>
										<input type="hidden" value="<?php echo $_GET["app"]; ?>" name="app" id="app">
										<?php 
									}
									?>
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

