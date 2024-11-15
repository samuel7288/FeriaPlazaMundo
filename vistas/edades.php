<?php 
session_start();
if(isset($_SESSION['usuario'])){

	?>


	<!DOCTYPE html>
	<html>
	<head>
		<title>Edades</title>
		<?php require_once "menu.php"; ?>
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
	</head>
	<body>
		<div class="container">
			<h1>Edades</h1>
			<div class="row">
				<div class="col-sm-4">
					<form id="frmEdades">
						<label>Nombre</label>
						<input type="text" class="form-control input-sm" id="nombre" name="nombre">
						<label>Edad Minima</label>
						<input type="text" class="form-control input-sm" id="edadMin" name="edadMin">
						<label>Edad Maxima</label>
						<input type="text" class="form-control input-sm" id="edadMax" name="edadMax">						
						<p></p>
						<span class="btn btn-primary" id="btnAgregarEdad">Agregar</span>
					</form>
				</div>
				<div class="col-sm-8">
					<div id="tablaEdadesLoad"></div>
				</div>
			</div>
		</div>

		<!-- Button trigger modal -->


		<!-- Modal -->
		<div class="modal fade" id="abremodalEdadesUpdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog modal-sm" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Actualizar Edad</h4>
					</div>
					<div class="modal-body">
						<form id="frmEdadesU">
							<input type="text" hidden="" id="idedadU" name="idedadU">
							<label>Nombre</label>
							<input type="text" class="form-control input-sm" id="nombreU" name="nombreU">
							<label>Edad Minima</label>
							<input type="text" class="form-control input-sm" id="edadMinU" name="edadMinU">
							<label>Edad Maxima</label>
							<input type="text" class="form-control input-sm" id="edadMaxU" name="edadMaxU">							
						</form>
					</div>
					<div class="modal-footer">
						<button id="btnAgregarEdadU" type="button" class="btn btn-primary" data-dismiss="modal">Actualizar</button>

					</div>
				</div>
			</div>
		</div>

	</body>
	</html>

	<script type="text/javascript">
		function agregaDatosEdad(idedad){

			$.ajax({
				type:"POST",
				data:"idedad=" + idedad,
				url:"../procesos/edades/obtenDatosEdad.php",
				success:function(r){
					dato=jQuery.parseJSON(r);
					$('#idedadU').val(dato['id_edad']);
					$('#nombreU').val(dato['nombre']);
					$('#edadMinU').val(dato['edadMin']);
					$('#edadMax').val(dato['edadMax']);					

				}
			});
		}

		function eliminarEdad(idedad){
			alertify.confirm('¿Desea eliminar este Rango de Edad?', function(){ 
				$.ajax({
					type:"POST",
					data:"idedad=" + idedad,
					url:"../procesos/edades/eliminarEdad.php",
					success:function(r){
						if(r==1){
							$('#tablaEdadesLoad').load("edades/tablaEdades.php");
							alertify.success("Eliminado con exito!!");
						}else{
							alertify.error("No se pudo eliminar :(");
						}
					}
				});
			}, function(){ 
				alertify.error('Cancelo !')
			});
		}
	</script>

	<script type="text/javascript">
		$(document).ready(function(){

			$('#tablaEdadesLoad').load("edades/tablaEdades.php");

			$('#btnAgregarEdad').click(function(){

				vacios=validarFormVacio('frmEdades');

				if(vacios > 0){
					alertify.alert("Debes llenar todos los campos!!");
					return false;
				}

				datos=$('#frmEdades').serialize();

				$.ajax({
					type:"POST",
					data:datos,
					url:"../procesos/edades/agregaEdad.php",
					success:function(r){

						if(r==1){
							$('#frmEdades')[0].reset();
							$('#tablaEdadesLoad').load("edades/tablaEdades.php");
							alertify.success("Edad agregado con exito :D");
						}else{
							alertify.error("No se pudo agregar edad");
						}
					}
				});
			});
		});
	</script>

	<script type="text/javascript">
		$(document).ready(function(){
			$('#btnAgregarEdadU').click(function(){
				datos=$('#frmEdadesU').serialize();

				$.ajax({
					type:"POST",
					data:datos,
					url:"../procesos/edades/actualizaEdad.php",
					success:function(r){

						if(r==1){
							$('#frmEdades')[0].reset();
							$('#tablaEdadesLoad').load("edades/tablaEdades.php");
							alertify.success("Edad actualizado con exito :D");
						}else{
							alertify.error("No se pudo actualizar edad");
						}
					}
				});
			})
		})
	</script>


	<?php 
}else{
	header("location:../index.php");
}
?>