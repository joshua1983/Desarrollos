<br>
<div class="container">
	<div class="row">
		<div class="col-xs-12 col-md-7 col-md-offset-2">
			<div class="panel panel-primary">
				<div class="panel-heading">Recuperación de clave</div>
				<div class="panel-body">
							<form action="<?php echo base_url(); ?>usuario/restaurar" method="post">
								<div class="card card-primary">
									
									<div class="card-body">
										<div class="form-group">
											<label for="email">Correo</label>
											<input type="email" class="form-control" id="email" name="email">
										</div>
									</div>
					                <div class="card-footer">
										<div class="row">
											<div class="col-sm-12">
												<button type="submit" class="btn btn-primary">Recuperar</button>
												<a class="btn btn-default pull-right" href="<?php echo base_url('usuario/') ?>" >Volver</a>
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

