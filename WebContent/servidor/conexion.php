<?php 

 /**
 * 
 */
 class conexion
 {
		private $servidor;
		private $usuario;
		private $contraseña;
		private $basedatos;
		public  $conexion;

 	function __construct()
 	{
			$this->servidor   = "192.168.1.14";
			$this->usuario	  = "root";
			$this->contraseña = "root";
			$this->basedatos  = "tuagro";
 	}
	
	function conectar(){
			$this->conexion= new mysqli($this->servidor,$this->usuario,$this->contraseña,$this->basedatos);

		if (!$this->conexion) {
			echo "No se pudo conectar";
			exit;
		}else{
			$sql = "SET NAMES 'utf8'";
			mysqli_query($this->conexion, $sql);
			return $this->conexion;
		}
	}

	function cerrar(){
			$this->conexion->close();
	} 	
 }


 ?>