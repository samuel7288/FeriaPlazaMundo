

<?php 
	class tickets{
		public function agregaImagen($datos){
			$c=new conectar();
			$conexion=$c->conexion();

			$fecha=date('Y-m-d');

			$sql="INSERT into imagenes (id_categoria,
										nombre,
										ruta,
										fechaSubida)
							values ('$datos[0]',
									'$datos[1]',
									'$datos[2]',
									'$fecha')";
			$result=mysqli_query($conexion,$sql);

			return mysqli_insert_id($conexion);
		}
		public function insertaTicket($datos){
			$c=new conectar();
			$conexion=$c->conexion();

			$fecha=date('Y-m-d');

			$sql="INSERT into tickets (id_categoria,
										id_imagen,
										id_usuario,
										nombre,
										descripcion,
										cantidad,
										precio,
										fechaCaptura) 
							values ('$datos[0]',
									'$datos[1]',
									'$datos[2]',
									'$datos[3]',
									'$datos[4]',
									'$datos[5]',
									'$datos[6]',
									'$fecha')";
			return mysqli_query($conexion,$sql);
		}

		public function obtenDatosTicket($idticket){
			$c=new conectar();
			$conexion=$c->conexion();

			$sql="SELECT id_ticket, 
						id_categoria, 
						nombre,
						descripcion,
						cantidad,
						precio 
				from tickets 
				where id_ticket='$idticket'";
			$result=mysqli_query($conexion,$sql);

			$ver=mysqli_fetch_row($result);

			$datos=array(
					"id_ticket" => $ver[0],
					"id_categoria" => $ver[1],
					"nombre" => $ver[2],
					"descripcion" => $ver[3],
					"cantidad" => $ver[4],
					"precio" => $ver[5]
						);

			return $datos;
		}

		public function actualizaTicket($datos){
			$c=new conectar();
			$conexion=$c->conexion();

			$sql="UPDATE tickets set id_categoria='$datos[1]', 
										nombre='$datos[2]',
										descripcion='$datos[3]',
										cantidad='$datos[4]',
										precio='$datos[5]'
						where id_ticket='$datos[0]'";

			return mysqli_query($conexion,$sql);
		}

		public function eliminaTicket($idticket){
			$c=new conectar();
			$conexion=$c->conexion();

			$idimagen=self::obtenIdImg($idticket);

			$sql="DELETE from tickets 
					where id_ticket='$idticket'";
			$result=mysqli_query($conexion,$sql);

			if($result){
				$ruta=self::obtenRutaImagen($idimagen);

				$sql="DELETE from imagenes 
						where id_imagen='$idimagen'";
				$result=mysqli_query($conexion,$sql);
					if($result){
						if(unlink($ruta)){
							return 1;
						}
					}
			}
		}

		public function obtenIdImg($idTicket){
			$c= new conectar();
			$conexion=$c->conexion();

			$sql="SELECT id_imagen 
					from tickets 
					where id_ticket='$idTicket'";
			$result=mysqli_query($conexion,$sql);

			return mysqli_fetch_row($result)[0];
		}

		public function obtenRutaImagen($idImg){
			$c= new conectar();
			$conexion=$c->conexion();

			$sql="SELECT ruta 
					from imagenes 
					where id_imagen='$idImg'";

			$result=mysqli_query($conexion,$sql);

			return mysqli_fetch_row($result)[0];
		}

	}

 ?>