<?php 

require_once "../../clases/Conexion.php";
$c= new conectar();
$conexion=$c->conexion();
?>


<h4>Vender un Ticket</h4>
<div class="row">
	<div class="col-sm-4">
		<form id="frmVentasTickets">
			<label>Seleciona Rango de Edad</label>
			<select class="form-control input-sm" id="edadVenta" name="edadVenta">
				<option value="A">Selecciona</option>
				<?php
				$sql="SELECT id_edad,nombre, edadMin
				from edad";
				$result=mysqli_query($conexion,$sql);
				while ($edad=mysqli_fetch_row($result)):
					?>
					<option value="<?php echo $edad[0] ?>"><?php echo $edad[2]." ".$edad[1] ?></option>
				<?php endwhile; ?>
			</select>
			<label>Ticket</label>
			<select class="form-control input-sm" id="ticketVenta" name="ticketVenta">
				<option value="A">Selecciona</option>
				<?php
				$sql="SELECT id_ticket,
				nombre
				from tickets";
				$result=mysqli_query($conexion,$sql);

				while ($ticket=mysqli_fetch_row($result)):
					?>
					<option value="<?php echo $ticket[0] ?>"><?php echo $ticket[1] ?></option>
				<?php endwhile; ?>
			</select>
			<label>Descripcion</label>
			<textarea readonly="" id="descripcionV" name="descripcionV" class="form-control input-sm"></textarea>
			<label>Cantidad</label>
			<input readonly="" type="text" class="form-control input-sm" id="cantidadV" name="cantidadV">
			<label>Precio</label>
			<input readonly="" type="text" class="form-control input-sm" id="precioV" name="precioV">
			<p></p>
			<span class="btn btn-primary" id="btnAgregaVenta">Agregar</span>
			<span class="btn btn-danger" id="btnVaciarVentas">Vaciar ventas</span>
		</form>
	</div>
	<div class="col-sm-3">
		<div id="imgTicket"></div>
	</div>
	<div class="col-sm-4">
		<div id="tablaVentasTempLoad"></div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){

		$('#tablaVentasTempLoad').load("ventas/tablaVentasTemp.php");

		$('#ticketVenta').change(function(){
			$.ajax({
				type:"POST",
				data:"idticket=" + $('#ticketVenta').val(),
				url:"../procesos/ventas/llenarFormTicket.php",
				success:function(r){
					dato=jQuery.parseJSON(r);

					$('#descripcionV').val(dato['descripcion']);
					$('#cantidadV').val(dato['cantidad']);
					$('#precioV').val(dato['precio']);

					$('#imgTicket').prepend('<img class="img-thumbnail" id="imgp" src="' + dato['ruta'] + '" />');
				}
			});
		});

		$('#btnAgregaVenta').click(function(){
			vacios=validarFormVacio('frmVentasTickets');

			if(vacios > 0){
				alertify.alert("Debes llenar todos los campos!!");
				return false;
			}

			datos=$('#frmVentasTickets').serialize();
			$.ajax({
				type:"POST",
				data:datos,
				url:"../procesos/ventas/agregaTicketTemp.php",
				success:function(r){
					$('#tablaVentasTempLoad').load("ventas/tablaVentasTemp.php");
				}
			});
		});

		$('#btnVaciarVentas').click(function(){

		$.ajax({
			url:"../procesos/ventas/vaciarTemp.php",
			success:function(r){
				$('#tablaVentasTempLoad').load("ventas/tablaVentasTemp.php");
			}
		});
	});

	});
</script>

<script type="text/javascript">
	function quitarP(index){
		$.ajax({
			type:"POST",
			data:"ind=" + index,
			url:"../procesos/ventas/quitarticket.php",
			success:function(r){
				$('#tablaVentasTempLoad').load("ventas/tablaVentasTemp.php");
				alertify.success("Ticket Eliminado");
			}
		});
	}

	function crearVenta(){
		$.ajax({
			url:"../procesos/ventas/crearVenta.php",
			success:function(r){
				if(r > 0){
					$('#tablaVentasTempLoad').load("ventas/tablaVentasTemp.php");
					$('#frmVentasTickets')[0].reset();
					alertify.alert("Venta creada con exito, consulte la informacion de esta en ventas hechas :D");
				}else if(r==0){
					alertify.alert("No hay lista de venta!!");
				}else{
					alertify.error("No se pudo crear la venta");
				}
			}
		});
	}
</script>

<script type="text/javascript">
	$(document).ready(function(){
		$('#edadVenta').select2();
		$('#ticketVenta').select2();

	});
</script>