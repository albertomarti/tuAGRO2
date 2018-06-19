<?php 

	/**
	* 
	*/
	include_once 'conexion.php';
		
	
	$resultado = false;
	$server = new conexion();
	$conexion = $server->conectar();
	

	if (isset($_POST["json"])){
		$producto = json_decode($_POST["json"]);

#####################   TEST HONEY ALONSO ###########################################

		if ($producto->{"datos"}[0]->{"operacion"} == "obtenerProductos") {
			$sql = "SELECT p.id_producto, p.nombre, p.descripcion, a.nombre, a.apellido FROM producto p, administrador a";
			$stmts = $conexion->prepare($sql);

			if($stmts->execute()){
				$json = array();
				$stmts->store_result();

				$stmts->bind_result($id_producto, $nombre, $descripcion, $nombre_usu, $apellido_usu);

				while ($stmts->fetch()) {
					$fila = array('id_producto' => $id_producto, 'nombre' => $nombre, 'descripcion' => $descripcion, 'nombre_usu' => $nombre_usu, 'apellido_usu' => $apellido_usu);
					$json[] = $fila;
				}
				$conexion->close();
				echo json_encode($json);

			}else{
					$conexion->close();
				echo $conexion->error;
			}
		}


		if ($producto->{"datos"}[0]->{"operacion"} == "obtenerProductoSeleccionado") {
			$sql = "SELECT id_producto, nombre, descripcion FROM producto WHERE id_producto=".$producto->{"datos"}[0]->{"idProducto"};
			$stmts = $conexion->prepare($sql);

			if($stmts->execute()){
				$json = array();
				$stmts->store_result();

				$stmts->bind_result($id_producto, $nombre, $descripcion);

				while ($stmts->fetch()) {
					$fila = array('id_producto' => $id_producto, 'nombre' => $nombre, 'descripcion' => $descripcion);
					$json[] = $fila;
				}
				$conexion->close();
				echo json_encode($json);

			}else{
					$conexion->close();
				echo $conexion->error;
			}
		}	

		if ($producto->{"datos"}[0]->{"operacion"} == "obtenerPasos") {
			$sql = "SELECT id_paso, descripcion FROM paso WHERE id_producto=".$producto->{"datos"}[0]->{"idProducto"};
			$stmts = $conexion->prepare($sql);

			if($stmts->execute()){
				$json = array();
				$stmts->store_result();

				$stmts->bind_result($id_paso, $descripcion);

				while ($stmts->fetch()) {
					$fila = array('id_paso' => $id_paso, 'descripcion' => $descripcion);
					$json[] = $fila;
				}
				$conexion->close();
				echo json_encode($json);

			}else{
					$conexion->close();
				echo $conexion->error;
			}
		}			


		if ($producto->{"datos"}[0]->{"operacion"} == "crearProducto") {
			
			$descripcion = $producto->{"datos"}[0]->{"descripcion"};
			$id_administrador = $producto->{"datos"}[0]->{"id_administrador"};
			$producto = $producto->{"datos"}[0]->{"producto"};
			
		

			$sql='INSERT INTO producto(nombre, descripcion, id_administrador) VALUES("'.$producto.'","'.$descripcion.'","'.$id_administrador.'")'; 
				$stmts = $conexion->prepare($sql);
				
				if ($stmts->execute()) {

					return $resultado = true;			

		        }else{
			    	return $resultado = false;     	
		        }
		}else{
				return $resultado = false; 
		}
					

		if ($producto->{"datos"}[0]->{"operacion"} == "actualizarProducto") {
			    	
$idProducto = $producto->{"datos"}[0]->{"id"};
			$descripcion = $producto->{"datos"}[0]->{"descripcion"};	
			$producto = $producto->{"datos"}[0]->{"producto"};
			

			//echo $descripcion." ".$estilo." ".$id_item;

			$sql="UPDATE producto SET nombre='$producto', descripcion='$descripcion' WHERE id_producto='$idProducto'"; 
			if ($conexion->query($sql)) {
				 $respuesta = true;
	        }else{
		    	 $respuesta = false;     	
	        }

	        echo $respuesta;

		}

		if ($producto->{"datos"}[0]->{"operacion"} == "eliminarProducto") {

			$id= $producto->{"datos"}[0]->{"id_producto"};	

			$sql='DELETE FROM producto WHERE id_producto = '.$id.';'; 
			$stmts = $conexion->prepare($sql);
			if ($stmts->execute()) {
				

				return $resultado = true;
					
	            
	        }else{
		    	return $resultado = false;     	
	        }

		}

		if ($producto->{"datos"}[0]->{"operacion"} == "obtenerInstruccion") {
			$sql = "SELECT id_paso, descripcion FROM paso WHERE id_producto=".$producto->{"datos"}[0]->{"idProducto"};
			$stmts = $conexion->prepare($sql);

			if($stmts->execute()){
				$json = array();
				$stmts->store_result();

				$stmts->bind_result($id_paso, $descripcion);

				while ($stmts->fetch()) {
					$fila = array('id_paso' => $id_paso, 'descripcion' => $descripcion);
					$json[] = $fila;
				}
				$conexion->close();
				echo json_encode($json);

			}else{
					$conexion->close();
				echo $conexion->error;
			}
		}			


		if ($producto->{"datos"}[0]->{"operacion"} == "crearInstruccion") {

			$id_producto = $producto->{"datos"}[0]->{"id_producto"};
			$descripcion = $producto->{"datos"}[0]->{"descripcion"};

		

			$sql='INSERT INTO paso(descripcion, id_producto) VALUES("'.$descripcion.'","'.$id_producto.'")'; 
			$stmts = $conexion->prepare($sql);
			
			if ($stmts->execute()) {

				return $resultado = true;			

	        }else{
		    	return $resultado = false;     	
	        }

		}

		if ($producto->{"datos"}[0]->{"operacion"} == "actualizarPaso") {
			    	
			$idPaso = $producto->{"datos"}[0]->{"id_paso"};
			$descripcion = $producto->{"datos"}[0]->{"descripcion"};
			

			//echo $descripcion." ".$estilo." ".$id_item;

			$sql="UPDATE paso SET descripcion='$descripcion' WHERE id_paso='$idPaso'"; 
			if ($conexion->query($sql)) {
				 $respuesta = true;
	        }else{
		    	 $respuesta = false;     	
	        }

	        echo $respuesta;

		}		

		if ($producto->{"datos"}[0]->{"operacion"} == "eliminarPaso") {

			$id= $producto->{"datos"}[0]->{"id_paso"};	

			$sql='DELETE FROM paso WHERE id_paso = '.$id.';'; 
			$stmts = $conexion->prepare($sql);
			if ($stmts->execute()) {
				

				return $resultado = true;
					
	            
	        }else{
		    	return $resultado = false;     	
	        }

		}		
													



	}



 ?>