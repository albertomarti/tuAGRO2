<?php


	include_once 'conexion.php';
	
	class plaga {
		private $server;
		private $conexion;
		private $test;
		
		function __construct(){
			

			$this->server = new conexion();

			$this->conexion = $this->server->conectar();

		}


	

		function getPlaga(){
			$sql = "SELECT id_plaga, nombre, descripcion, prevencion FROM plaga";
			$stmts = $this->conexion->prepare($sql);

			if($stmts->execute()){
				$json = array();
				$stmts->store_result();

				$stmts->bind_result($id_plaga, $nombre, $descripcion, $prevencion);

				while ($stmts->fetch()) {
					$fila = array('id_plaga' => $id_plaga, 'nombre' => $nombre, 'descripcion' => $descripcion, 'prevencion' => $prevencion);
					$json[] = $fila;
				}
				$this->conexion->close();
				return $json;

			}else{
					$this->conexion->close();
				return $this->conexion->error;
			}
		}

		function getPaso(){
			$sql = "SELECT id_paso, descripcion, FROM paso";
			$stmts = $this->conexion->prepare($sql);

			if($stmts->execute()){
				$json = array();
				$stmts->store_result();

				$stmts->bind_result($id_paso, $descripcion);

				while ($stmts->fetch()) {
					$fila = array('id_paso' => $id_paso, 'descripcion' => $descripcion);
					$json[] = $fila;
				}
				$this->conexion->close();
				return $json;

			}else{
					$this->conexion->close();
				return $this->conexion->error;
			}
		}		


/*		function getMisProductos(){
			$sql = "SELECT id_test_ha, fecha, habilitado, nombre, apellido FROM test_ha, administrador";
			$stmts = $this->conexion->prepare($sql);

			if($stmts->execute()){
				$json = array();
				$stmts->store_result();

				$stmts->bind_result($id_test_ha, $fecha, $habilitado, $nombre, $apellido);

				while ($stmts->fetch()) {
					$fila = array('id_test_ha' => $id_test_ha, 'fecha' => $fecha, 'nombre' => $nombre, 'apellido' => $apellido, 'habilitado' => $habilitado);
					$json[] = $fila;
				}
				$this->conexion->close();
				return $json;

			}else{
					$this->conexion->close();
				return $this->conexion->error;
			}
		}		

		function getItem($id_test){
			
			$sql = "SELECT * FROM item i, estilo_ha e WHERE i.id_test_ha='". $id_test ."' && i.id_estilo=e.id_estilo;";
			$stmts = $this->conexion->prepare($sql);

			if($stmts->execute()){
				$json = array();
				$stmts->store_result();

				$stmts->bind_result($id_item, $item, $id_estilo, $id_test_ha, $id_estilo, $nombre_estilo);

				while ($stmts->fetch()) {
					$fila = array('id_item' => $id_item, 'item' => $item, 'id_estilo' =>$id_estilo, 'id_test_ha' => $id_test_ha, 'id_estilo' => $id_estilo, 'nombre_estilo' => $nombre_estilo);
					$json[] = $fila;
				}
				$this->conexion->close();
				return $json;

			}
		}

		function getCriterios($id){
			
			$sql = "SELECT valor_minimo, valor_maximo FROM criterio WHERE id_test_ha='". $id;
			$stmts = $this->conexion->prepare($sql);

			if($stmts->execute()){
				$json = array();
				$stmts->store_result();

				$stmts->bind_result($valor_minimo, $valor_maximo);

				while ($stmts->fetch()) {
					$fila = array('valor_minimo' => $valor_minimo, 'valor_maximo' => $valor_maximo);
					$json[] = $fila;
				}
				$this->conexion->close();
				return $json;

			}

		}*/


	}
?>