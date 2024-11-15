<?php 
session_start();
if(isset($_SESSION['usuario'])){

	?>


	<!DOCTYPE html>
	<html>
	<head>
		<title>Ticket</title>
		<?php require_once "menu.php"; ?>
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
		<?php require_once "../clases/Conexion.php"; 
		$c= new conectar();
		$conexion=$c->conexion();
		$sql="SELECT id_categoria,nombreCategoria
		from categorias";
		$result=mysqli_query($conexion,$sql);
		?>
	</head>
	<body>
		<div class="container">
			<h1>Ticket</h1>
			<div class="row">
				<div class="col-sm-4">
					<form id="frmTickets" enctype="multipart/form-data">
						<label>Categoria</label>
						<select class="form-control input-sm" id="categoriaSelect" name="categoriaSelect">
							<option value="A">Selecciona Categoria</option>
							<?php while($ver=mysqli_fetch_row($result)): ?>
								<option value="<?php echo $ver[0] ?>"><?php echo $ver[1]; ?></option>
							<?php endwhile; ?>
						</select>
						<label>Nombre</label>
						<input type="text" class="form-control input-sm" id="nombre" name="nombre">
						<label>Descripcion</label>
						<input type="text" class="form-control input-sm" id="descripcion" name="descripcion">
						<label>Cantidad Disponible</label>
						<input type="text" class="form-control input-sm" id="cantidad" name="cantidad">
						<label>Precio</label>
						<input type="text" class="form-control input-sm" id="precio" name="precio">
						<label>Imagen</label>
						<input type="file" id="imagen" name="imagen">
						<p></p>
						<span id="btnAgregaTicket" class="btn btn-primary">Agregar</span>
					</form>
				</div>
				<div class="col-sm-8">
					<div id="tablaTicketsLoad"></div>
				</div>
			</div>
		</div>

		<!-- Button trigger modal -->
		
		<!-- Modal -->
		<div class="modal fade" id="abremodalUpdateTicket" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog modal-sm" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Actualiza Ticket</h4>
					</div>
					<div class="modal-body">
						<form id="frmTicketsU" enctype="multipart/form-data">
							<input type="text" id="idTicket" hidden="" name="idTicket">
							<label>Categoria</label>
							<select class="form-control input-sm" id="categoriaSelectU" name="categoriaSelectU">
								<option value="A">Selecciona Categoria</option>
								<?php 
								$sql="SELECT id_categoria,nombreCategoria
								from categorias";
								$result=mysqli_query($conexion,$sql);
								?>
								<?php while($ver=mysqli_fetch_row($result)): ?>
									<option value="<?php echo $ver[0] ?>"><?php echo $ver[1]; ?></option>
								<?php endwhile; ?>
							</select>
							<label>Nombre</label>
							<input type="text" class="form-control input-sm" id="nombreU" name="nombreU">
							<label>Descripcion</label>
							<input type="text" class="form-control input-sm" id="descripcionU" name="descripcionU">
							<label>Cantidad</label>
							<input type="text" class="form-control input-sm" id="cantidadU" name="cantidadU">
							<label>Precio</label>
							<input type="text" class="form-control input-sm" id="precioU" name="precioU">
							
						</form>
					</div>
					<div class="modal-footer">
						<button id="btnActualizaTicket" type="button" class="btn btn-warning" data-dismiss="modal">Actualizar</button>

					</div>
				</div>
			</div>
		</div>

	</body>
	</html>

	<script type="text/javascript">
		function agregaDatosTicket(idticket){
			$.ajax({
				type:"POST",
				data:"idtic=" + idticket,
				url:"../procesos/tickets/obtenDatosTicket.php",
				success:function(r){
					
					dato=jQuery.parseJSON(r);
					$('#idTicket').val(dato['id_ticket']);
					$('#categoriaSelectU').val(dato['id_categoria']);
					$('#nombreU').val(dato['nombre']);
					$('#descripcionU').val(dato['descripcion']);
					$('#cantidadU').val(dato['cantidad']);
					$('#precioU').val(dato['precio']);

				}
			});
		}

		function eliminaTicket(idTicket){
			alertify.confirm('¿Desea eliminar este Ticket?', function(){ 
				$.ajax({
					type:"POST",
					data:"idticket=" + idTicket,
					url:"../procesos/tickets/eliminarTicket.php",
					success:function(r){
						if(r==1){
							$('#tablaTicketsLoad').load("tickets/tablaTickets.php");
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
			$('#btnActualizaTicket').click(function(){

				datos=$('#frmTicketsU').serialize();
				$.ajax({
					type:"POST",
					data:datos,
					url:"../procesos/tickets/actualizaTickets.php",
					success:function(r){
						if(r==1){
							$('#tablaTicketsLoad').load("tickets/tablaTickets.php");
							alertify.success("Actualizado con exito :D");
						}else{
							alertify.error("Error al actualizar :(");
						}
					}
				});
			});
		});
	</script>

	<script type="text/javascript">
		$(document).ready(function(){
			$('#tablaTicketsLoad').load("tickets/tablaTickets.php");

			$('#btnAgregaTicket').click(function(){

				vacios=validarFormVacio('frmTickets');

				if(vacios > 0){
					alertify.alert("Debes llenar todos los campos!!");
					return false;
				}

				var formData = new FormData(document.getElementById("frmTickets"));

				$.ajax({
					url: "../procesos/tickets/insertaTickets.php",
					type: "post",
					dataType: "html",
					data: formData,
					cache: false,
					contentType: false,
					processData: false,

					success:function(r){
						
						if(r == 1){
							$('#frmTickets')[0].reset();
							$('#tablaTicketsLoad').load("tickets/tablaTickets.php");
							alertify.success("Agregado con exito :D");
						}else{
							alertify.error("Fallo al subir el archivo :(");
						}
					}
				});
				
			});
		});
	</script>

	<?php 
}else{
	header("location:../index.php");
}
?>