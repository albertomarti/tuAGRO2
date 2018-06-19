<?php

session_start();


	include_once 'conexion.php';

  $server = new conexion();
  $conexion = $server->conectar();


	@session_start();
	session_destroy();
		

	if(!empty($_POST)){
		$usuario = $_POST["username"];
		$password = $_POST["password"];
		$rs = mysqli_query($conexion, "SELECT * FROM usuario WHERE usuario = '$usuario' and contrasena = '$password'");
		 

		if($rs->num_rows>0){
			while ($row = mysqli_fetch_array($rs)) {
				echo "Bienvenido ".$row['usuario'];
				@session_start();
				$_SESSION["tipo"] = "cliente";
				$_SESSION["usuario"] = $row["usuario"];
				$_SESSION["id"] = $row["id_usuario"];
				$_SESSION["nombre"] = $row["nombre"];
				$_SESSION["apellido"] = $row["apellido"];
				$_SESSION["email"] = $row["email"];
				$id = $row["id_usuario"];
				header("Location: ../usuario/inicio.html");
			}	
		}else{
			$usuario = $_POST["username"];
			$password = $_POST["password"];
			$rs = mysqli_query($conexion, "SELECT * FROM administrador WHERE usuario = '$usuario' and contrasena = '$password'");
			 

			if($rs->num_rows>0){
				while ($row = mysqli_fetch_array($rs)) {
					echo "Bienvenido ".$row['usuario'];
					@session_start();
					$_SESSION["tipo"] = "administrador";
					$_SESSION["usuario"] = $row["usuario"];
					$_SESSION["id"] = $row["id_administrador"];
					$_SESSION["nombre"] = $row["nombre"];
					$_SESSION["apellido"] = $row["apellido"];
					$_SESSION["email"] = $row["email"];					
					$id = $row["id_administrador"];
					header("Location: ../administrador/inicio.html");
				}	
			}else{
				@session_start();
				$_SESSION["mensaje"] = "Usuario o Contraseña Incorrectos";
				header("Location: ../../index.php");
			}
		}

	}else{
		echo "Error ";
	}



?>
