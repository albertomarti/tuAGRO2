<?php 

	/**
	* 
	*/
	include_once 'conexion.php';
		
	
	$resultado = false;
	$server = new conexion();
	$conexion = $server->conectar();
	

	if (isset($_POST["json"])){
		$cultivo = json_decode($_POST["json"]);

#####################   TEST HONEY ALONSO ###########################################	

		if ($cultivo->{"datos"}[0]->{"operacion"} == "obtenerCultivoSeleccionado") {
			$sql = "SELECT p.nombre FROM producto p, cultivo c WHERE p.id_producto=c.id_producto && c.id_cultivo=".$cultivo->{"datos"}[0]->{"id"};
			$stmts = $conexion->prepare($sql);

			if($stmts->execute()){
				$json = array();
				$stmts->store_result();

				$stmts->bind_result($nombre);

				while ($stmts->fetch()) {
					$fila = array('nombre' => $nombre);
					$json[] = $fila;
				}
				$conexion->close();
				echo json_encode($json);

			}else{
					$conexion->close();
				echo $conexion->error;
			}
		}	


		if ($cultivo->{"datos"}[0]->{"operacion"} == "obtenerRecursos") {
			$sql = "SELECT id_recurso, porcentaje_germinacion, terreno_hectareas, distancia_lineas, distancia_semillas, semillas_requeridas, plantas_esperadas, id_cultivo FROM recurso WHERE id_cultivo=".$cultivo->{"datos"}[0]->{"id"};
			$stmts = $conexion->prepare($sql);

			if($stmts->execute()){
				$json = array();
				$stmts->store_result();

				$stmts->bind_result($id_recurso, $porcentaje_germinacion, $terreno_hectareas, $distancia_lineas, $distancia_semillas, $semillas_requeridas, $plantas_esperadas, $id_cultivo);

				while ($stmts->fetch()) {
					$fila = array('id_recurso' => $id_recurso, 'porcentaje_germinacion' => $porcentaje_germinacion, 'terreno_hectareas' => $terreno_hectareas, 'distancia_lineas' => $distancia_lineas, 'distancia_semillas' => $distancia_semillas, 'semillas_requeridas' => $semillas_requeridas, 'plantas_esperadas' => $plantas_esperadas, 'id_cultivo' => $id_cultivo);
					$json[] = $fila;
				}
				$conexion->close();
				echo json_encode($json);

			}else{
					$conexion->close();
				echo $conexion->error;
			}
		}	

		if ($cultivo->{"datos"}[0]->{"operacion"} == "obtenerProduccion") {
			$sql = "SELECT id_produccion, semillas_germinadas, id_cultivo FROM produccion WHERE id_cultivo=".$cultivo->{"datos"}[0]->{"id"};
			$stmts = $conexion->prepare($sql);

			if($stmts->execute()){
				$json = array();
				$stmts->store_result();

				$stmts->bind_result($id_produccion, $semillas_germinadas, $id_cultivo);

				while ($stmts->fetch()) {
					$fila = array('id_produccion' => $id_produccion, 'semillas_germinadas' => $semillas_germinadas, 'id_cultivo' => $id_cultivo);
					$json[] = $fila;
				}
				$conexion->close();
				echo json_encode($json);

			}else{
					$conexion->close();
				echo $conexion->error;
			}
		}



		if ($cultivo->{"datos"}[0]->{"operacion"} == "obtenerCultivos") {
			$sql = "SELECT c.id_cultivo, p.nombre, c.fecha FROM producto p, cultivo c WHERE c.id_producto=p.id_producto && c.id_usuario=".$cultivo->{"datos"}[0]->{"id_usuario"};
			$stmts = $conexion->prepare($sql);

			if($stmts->execute()){
				$json = array();
				$stmts->store_result();

				$stmts->bind_result($id_cultivo, $nombre, $fecha);

				while ($stmts->fetch()) {
					$fila = array('id_cultivo' => $id_cultivo, 'nombre' => $nombre, 'fecha' => $fecha);
					$json[] = $fila;
				}
				$conexion->close();
				echo json_encode($json);

			}else{
					$conexion->close();
				echo $conexion->error;
			}
		}	


		if ($cultivo->{"datos"}[0]->{"operacion"} == "crearCultivo") {
			$usuario = $cultivo->{"datos"}[0]->{"id_usuario"};
			$producto = $cultivo->{"datos"}[0]->{"id_producto"};
			

		
			$sql='INSERT INTO cultivo(id_usuario, id_producto) VALUES("'.$usuario.'","'.$producto.'")'; 
			$stmts = $conexion->prepare($sql);
			
			if ($stmts->execute()) {

				return $resultado = true;			

	        }else{
		    	return $resultado = false;     	
	        }

		}

		if ($cultivo->{"datos"}[0]->{"operacion"} == "eliminarCultivo") {
			$id = $cultivo->{"datos"}[0]->{"id_cultivo"};
			
			$sql='DELETE FROM cultivo WHERE id_cultivo = '.$id.';';  
			$stmts = $conexion->prepare($sql);
			
			if ($stmts->execute()) {

				return $resultado = true;			

	        }else{
		    	return $resultado = false;     	
	        }

		}	

		if ($cultivo->{"datos"}[0]->{"operacion"} == "crearRecurso") {
			$germinacion = $cultivo->{"datos"}[0]->{"germinacion"};
			$semillas = $cultivo->{"datos"}[0]->{"semillas"};
			$produccion_esperada = $cultivo->{"datos"}[0]->{"produccion_esperada"};
			$hectareas_terreno = $cultivo->{"datos"}[0]->{"hectareas_terreno"};
			$distancia_lineas = $cultivo->{"datos"}[0]->{"distancia_lineas"};
			$distancia_semillas = $cultivo->{"datos"}[0]->{"distancia_semillas"};
			$id_cultivo = $cultivo->{"datos"}[0]->{"id_cultivo"};									

		
			$sql='INSERT INTO recurso(porcentaje_germinacion, terreno_hectareas, distancia_lineas, distancia_semillas, semillas_requeridas, plantas_esperadas, id_cultivo) VALUES("'.$germinacion.'","'.$hectareas_terreno.'","'.$distancia_lineas.'","'.$distancia_semillas.'","'.$semillas.'","'.$produccion_esperada.'","'.$id_cultivo.'")'; 
			$stmts = $conexion->prepare($sql);
			
			if ($stmts->execute()) {

				return $resultado = true;			

	        }else{
		    	return $resultado = false;     	
	        }

		}


		if ($cultivo->{"datos"}[0]->{"operacion"} == "modificarRecurso") {
			$germinacion = $cultivo->{"datos"}[0]->{"germinacion"};
			$semillas = $cultivo->{"datos"}[0]->{"semillas"};
			$produccion_esperada = $cultivo->{"datos"}[0]->{"produccion_esperada"};
			$hectareas_terreno = $cultivo->{"datos"}[0]->{"hectareas_terreno"};
			$distancia_lineas = $cultivo->{"datos"}[0]->{"distancia_lineas"};
			$distancia_semillas = $cultivo->{"datos"}[0]->{"distancia_semillas"};
			$id_recurso = $cultivo->{"datos"}[0]->{"id_recurso"};									

		
			$sql='UPDATE recurso SET porcentaje_germinacion="'.$germinacion.'", terreno_hectareas="'.$hectareas_terreno.'", distancia_lineas="'.$distancia_lineas.'", distancia_semillas="'.$distancia_semillas.'", semillas_requeridas="'.$semillas.'", plantas_esperadas="'.$produccion_esperada.'" WHERE id_recurso="'.$id_recurso.'"'; 
			$stmts = $conexion->prepare($sql);

			if ($stmts->execute()) {

				return $resultado = true;			

	        }else{
		    	return $resultado = false;     	
	        }

		}	

		if ($cultivo->{"datos"}[0]->{"operacion"} == "crearResultado") {
			$semillas_germinadas = $cultivo->{"datos"}[0]->{"semillas_germinadas"};
			$id_cultivo = $cultivo->{"datos"}[0]->{"id_cultivo"};
			

		
			$sql='INSERT INTO produccion(semillas_germinadas, id_cultivo) VALUES("'.$semillas_germinadas.'","'.$id_cultivo.'")'; 
			$stmts = $conexion->prepare($sql);
			
			if ($stmts->execute()) {

				return $resultado = true;			

	        }else{
		    	return $resultado = false;     	
	        }

		}

		if ($cultivo->{"datos"}[0]->{"operacion"} == "modificarResultado") {
			$semillas_germinadas = $cultivo->{"datos"}[0]->{"semillas_germinadas"};
			$id_produccion = $cultivo->{"datos"}[0]->{"id_produccion"};
			

		
			$sql='UPDATE produccion SET semillas_germinadas="'.$semillas_germinadas.'" WHERE id_produccion="'.$id_produccion.'"'; 
			$stmts = $conexion->prepare($sql);
			
			if ($stmts->execute()) {

				return $resultado = true;			

	        }else{
		    	return $resultado = false;     	
	        }

		}
		

	}



 ?>