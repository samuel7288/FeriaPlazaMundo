<?php 

class ventas{
	public function obtenDatosTicket($idticket){
		$c=new conectar();
		$conexion=$c->conexion();

		$sql = "SELECT 
				    tic.nombre,
				    tic.descripcion,
				    tic.cantidad,
				    img.ruta,
				    tic.precio
				FROM
				    tickets AS tic
				        INNER JOIN
				    imagenes AS img ON tic.id_imagen = img.id_imagen
				        AND tic.id_ticket = '$idticket'";
		$result=mysqli_query($conexion,$sql);

		$ver=mysqli_fetch_row($result);

		$d=explode('/', $ver[3]);

		$img=$d[1].'/'.$d[2].'/'.$d[3];

		$data=array(
			'nombre' => $ver[0],
			'descripcion' => $ver[1],
			'cantidad' => $ver[2],
			'ruta' => $img,
			'precio' => $ver[4]
		);		
		return $data;
	}

	public function crearVenta(){
		$c= new conectar();
		$conexion=$c->conexion();

		$fecha=date('Y-m-d');
		$idventa=self::creaFolio();
		$datos=$_SESSION['tablaComprasTemp'];
		$idusuario=$_SESSION['iduser'];
		$r=0;

		for ($i=0; $i < count($datos) ; $i++) { 
			$d=explode("||", $datos[$i]);

			$sql="INSERT into ventas (id_venta,
										id_edad,
										id_ticket,
										id_usuario,
										precio,
										fechaCompra)
							values ('$idventa',
									'$d[5]',
									'$d[0]',
									'$idusuario',
									'$d[3]',
									'$fecha')";
			$r=$r + $result=mysqli_query($conexion,$sql);
		}

		return $r;
	}

	public function creaFolio(){
		$c= new conectar();
		$conexion=$c->conexion();

		$sql="SELECT id_venta from ventas group by id_venta desc";

		$resul=mysqli_query($conexion,$sql);
		$id=mysqli_fetch_row($resul)[0];

		if($id=="" or $id==null or $id==0){
			return 1;
		}else{
			return $id + 1;
		}
	}
	public function nombreEdad($idEdad){
		$c= new conectar();
		$conexion=$c->conexion();

		 $sql="SELECT nombre, edadMin
			from edad
			where id_edad='$idEdad'";
		$result=mysqli_query($conexion,$sql);

		$ver=mysqli_fetch_row($result);

		return $ver[0]." ".$ver[1];
	}

	public function obtenerTotal($idVenta) {
		$c = new conectar();
		$conexion = $c->conexion();
		$sql = "SELECT SUM(precio) as total FROM ventas WHERE id_venta='$idVenta'";
		$result = mysqli_query($conexion, $sql);
		$total = mysqli_fetch_row($result)[0];
		return $total;
	}
}

?>