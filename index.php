<?php 
	
	require_once "clases/Conexion.php";
	$obj= new conectar();
	$conexion=$obj->conexion();

	$sql="SELECT * from usuarios where email='admin'";
	$result=mysqli_query($conexion,$sql);
	$validar=0;
	if(mysqli_num_rows($result) > 0){
		$validar=1;
	}
 ?>


<!DOCTYPE html>
<html>
<head>
	<title>Login de usuario</title>
	<link rel="stylesheet" type="text/css" href="librerias/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="vistas/css/style.css">
	<script src="librerias/jquery-3.2.1.min.js"></script>
	<script src="js/funciones.js"></script>
</head>
<body class="login-body">
	<div class="container">
		<div class="row justify-content-center align-items-center min-vh-100">
			<div class="col-sm-4"></div>
			<div class="col-sm-4">
				<div class="panel panel-primary login-panel">
					<div class="panel-heading login-header">
						<h3 class="text-center">Sistema de ventas y almacén</h3>
					</div>
					<div class="panel-body login-body-content">
						<div class="text-center mb-4">
							<img src="img/ventas.jpg" class="login-logo" height="190" alt="Logo">
						</div>
						<form id="frmLogin" class="login-form">
							<div class="form-group">
								<label for="usuario">Usuario</label>
								<input type="text" class="form-control input-sm" name="usuario" id="usuario">
							</div>
							<div class="form-group">
								<label for="password">Password</label>
								<input type="password" name="password" id="password" class="form-control input-sm">
							</div>
							<div class="form-group text-center mt-4">
								<button type="button" class="btn btn-primary btn-sm btn-login" id="entrarSistema">Entrar</button>
								<?php if(!$validar): ?>
									<a href="registro.php" class="btn btn-danger btn-sm btn-register">Registrar</a>
								<?php endif; ?>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-sm-4"></div>
		</div>
	</div>
</body>
</html>

<script type="text/javascript">
	$(document).ready(function(){
		$('#entrarSistema').click(function(){

		vacios=validarFormVacio('frmLogin');

			if(vacios > 0){
				alert("Debes llenar todos los campos!!");
				return false;
			}

		datos=$('#frmLogin').serialize();
		$.ajax({
			type:"POST",
			data:datos,
			url:"procesos/regLogin/login.php",
			success:function(r){

				if(r==1){
					window.location="vistas/inicio.php";
				}else{
					alert("No se pudo acceder :(");
				}
			}
		});
	});
	});
</script>