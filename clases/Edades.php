<?php 

	class edades{

		public function agregaEdad($datos){
			$c= new conectar();
			$conexion=$c->conexion();

			$idusuario=$_SESSION['iduser'];

			$sql="INSERT into edad (id_usuario,
										nombre,
										edadMin,
										edadMax)
							values ('$idusuario',
									'$datos[0]',
									'$datos[1]',
									'$datos[2]')";
			return mysqli_query($conexion,$sql);	
		}

		public function obtenDatosEdad($idedad){
			$c= new conectar();
			$conexion=$c->conexion();

			$sql="SELECT id_edad, 
							nombre,
							edadMin,
							edadMax							
				from edad";
			$result=mysqli_query($conexion,$sql);
			$ver=mysqli_fetch_row($result);

			$datos=array(
					'id_edad' => $ver[0], 
					'nombre' => $ver[1],
					'edadMin' => $ver[2],
					'edadMax' => $ver[3]					
						);
			return $datos;
		}

		public function actualizaEdad($datos){
			$c= new conectar();
			$conexion=$c->conexion();
			$sql="UPDATE edad set nombre='$datos[1]',
										edadMin='$datos[2]',
										edadMax='$datos[3]'										
								where id_edad='$datos[0]'";
			return mysqli_query($conexion,$sql);
		}

		public function eliminaEdad($idedad){
			$c= new conectar();
			$conexion=$c->conexion();

			$sql="DELETE from edad where id_edad='$idedad'";

			return mysqli_query($conexion,$sql);
		}
	}

 ?>