<?php


	include_once 'conexion.php';
	
	class cultivo {
		private $server;
		private $conexion;
		private $test;
		
		function __construct(){
			

			$this->server = new conexion();

			$this->conexion = $this->server->conectar();

		}


	

		function getCultivo($id){
			$datos = [];
			$sql = "SELECT c.id_cultivo, p.nombre, c.fecha FROM producto p, cultivo c WHERE c.id_producto=p.id_producto && c.id_usuario=".$id;
			$stmts = $this->conexion->prepare($sql);

			if($stmts->execute()){
				$json = array();
				$stmts->store_result();

				$stmts->bind_result($id_cultivo, $nombre, $fecha);

				while ($stmts->fetch()) {
					$fila = array('id_cultivo' => $id_cultivo, 'nombre' => $nombre, 'fecha' => $fecha);
					$json[] = $fila;
				}

				$this->conexion->close();
				return $json;

			}else{
					$this->conexion->close();
				return $this->conexion->error;
			}
		}

		function getFecha($id_usuario){
			$datos = [];
			$sql1 = "SELECT DISTINCT DATE(fecha) fecha FROM producto p, cultivo c WHERE c.id_producto=p.id_producto && c.id_usuario=".$id_usuario;
			$stmts = $this->conexion->prepare($sql1);

			if($stmts->execute()){
				$json = array();
				$stmts->store_result();

				$stmts->bind_result($fecha);

				while ($stmts->fetch()) {
					$fila = array('fecha' => $fecha);
					$json[] = $fila;
				}

				$this->conexion->close();
				return $json;

			}else{
					$this->conexion->close();
				return $this->conexion->error;
			}
		}		


	}
?>