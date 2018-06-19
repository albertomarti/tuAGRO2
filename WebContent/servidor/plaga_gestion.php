<?php 

	/**
	* 
	*/
	include_once 'conexion.php';
		
	
	$resultado = false;
	$server = new conexion();
	$conexion = $server->conectar();
	

	if (isset($_POST["json"])){
		$plaga = json_decode($_POST["json"]);

#####################   TEST HONEY ALONSO ###########################################	

		if ($plaga->{"datos"}[0]->{"operacion"} == "obtenerPlagas") {
			$sql = "SELECT id_plaga, nombre, descripcion, prevencion FROM plaga";
			$stmts = $conexion->prepare($sql);

			if($stmts->execute()){
				$json = array();
				$stmts->store_result();

				$stmts->bind_result($id_plaga, $nombre, $descripcion, $prevencion);

				while ($stmts->fetch()) {
					$fila = array('id_plaga' => $id_plaga, 'nombre' => $nombre, 'descripcion' => $descripcion, 'prevencion' => $prevencion);
					$json[] = $fila;
				}
				$conexion->close();
				echo json_encode($json);

			}else{
					$conexion->close();
				echo $conexion->error;
			}
		}

		if ($plaga->{"datos"}[0]->{"operacion"} == "obtenerPlagasPorProducto") {
			$sql = "SELECT p.id_plaga as id_plaga, p.nombre as nombre, p.descripcion as descripcion, p.prevencion as prevencion FROM plaga p, producto_tiene_plaga pp where p.id_plaga=pp.id_plaga && pp.id_producto=".$plaga->{"datos"}[0]->{"idProducto"};
			$stmts = $conexion->prepare($sql);

			if($stmts->execute()){
				$json = array();
				$stmts->store_result();

				$stmts->bind_result($id_plaga, $nombre, $descripcion, $prevencion);

				while ($stmts->fetch()) {
					$fila = array('id_plaga' => $id_plaga, 'nombre' => $nombre, 'descripcion' => $descripcion, 'prevencion' => $prevencion);
					$json[] = $fila;
				}
				$conexion->close();
				echo json_encode($json);

			}else{
					$conexion->close();
				echo $conexion->error;
			}
		}	



		if ($plaga->{"datos"}[0]->{"operacion"} == "obtenerPlagasDeProductos") {
			  $sql = "SELECT pp.id_plaga as id_plaga, p.nombre as nombre FROM producto_tiene_plaga pp, plaga p WHERE p.id_plaga=pp.id_plaga && pp.id_producto=".$plaga->{"datos"}[0]->{"idProducto"};  
			$stmts = $conexion->prepare($sql);

			if($stmts->execute()){
				$json = array();
				$stmts->store_result();

				$stmts->bind_result($id_plaga, $nombre);

				while ($stmts->fetch()) {
					$fila = array('id_plaga' => $id_plaga, 'nombre' => $nombre);
					$json[] = $fila;
				}
				$conexion->close();
				echo json_encode($json);

			}else{
					$conexion->close();
				echo $conexion->error;
			}
		}	



		if ($plaga->{"datos"}[0]->{"operacion"} == "crearPlaga") {
			$prevencion = $plaga->{"datos"}[0]->{"prevencion"};
			$descripcion = $plaga->{"datos"}[0]->{"descripcion"};
			$plaga = $plaga->{"datos"}[0]->{"plaga"};
			
			
			$sql='INSERT INTO plaga(nombre, descripcion, prevencion) VALUES("'.$plaga.'","'.$descripcion.'","'.$prevencion.'")'; 
			$stmts = $conexion->prepare($sql);

			if ($stmts->execute()) {

				return $resultado = true;			

	        }else{
		    	return $resultado = false;     	
	        }

		}

		if ($plaga->{"datos"}[0]->{"operacion"} == "actualizarPlaga") {
			    	
$idPlaga = $plaga->{"datos"}[0]->{"id"};
			$descripcion = $plaga->{"datos"}[0]->{"descripcion"};
			$prevencion = $plaga->{"datos"}[0]->{"prevencion"};	
			$plaga = $plaga->{"datos"}[0]->{"plaga"};
			

		

			$sql="UPDATE plaga SET nombre='$plaga', descripcion='$descripcion', prevencion='$prevencion' WHERE id_plaga='$idPlaga'"; 
			if ($conexion->query($sql)) {
				 $respuesta = true;
	        }else{
		    	 $respuesta = false;     	
	        }

	        echo $respuesta;

		}

		if ($plaga->{"datos"}[0]->{"operacion"} == "eliminarPlaga") {

			$id= $plaga->{"datos"}[0]->{"id_plaga"};	

			$sql='DELETE FROM plaga WHERE id_plaga = '.$id.';'; 
			$stmts = $conexion->prepare($sql);
			if ($stmts->execute()) {
				

				return $resultado = true;
					
	            
	        }else{
		    	return $resultado = false;     	
	        }

		}	

		if ($plaga->{"datos"}[0]->{"operacion"} == "asignarPlaga") {
			$producto = $plaga->{"datos"}[0]->{"id_producto"};
			$plaga = $plaga->{"datos"}[0]->{"id_plaga"};
			
			$sql='INSERT INTO producto_tiene_plaga(id_producto, id_plaga) VALUES("'.$producto.'","'.$plaga.'")'; 
			$stmts = $conexion->prepare($sql);

			if ($stmts->execute()) {

				return $resultado = true;			

	        }else{
		    	return $resultado = false;     	
	        }

		}

		if ($plaga->{"datos"}[0]->{"operacion"} == "eliminarPlagaAsignada") {

			$id= $plaga->{"datos"}[0]->{"id_plaga"};
			$id_producto= $plaga->{"datos"}[0]->{"id_producto"};	

			$sql='DELETE FROM producto_tiene_plaga WHERE id_plaga = '.$id.' && id_producto='.$id_producto.';'; 
			$stmts = $conexion->prepare($sql);
			if ($stmts->execute()) {
				

				return $resultado = true;
					
	            
	        }else{
		    	return $resultado = false;     	
	        }

		}			


/*		if ($producto->{"datos"}[0]->{"operacion"} == "crearInstruccion") {

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




		if ($test->{"datos"}[0]->{"operacion"} == "habilitarTestHA") {
			    	

			$habilitado = $test->{"datos"}[0]->{"habilitado"};
			$id_test = $test->{"datos"}[0]->{"id_test"};

			$sql='UPDATE test_ha SET habilitado='.$habilitado.' WHERE id_test_ha='.$id_test.';'; 

			if ($habilitado == 1) {
				$sql2='UPDATE test_ha SET habilitado="0" WHERE id_test_ha !='.$id_test.';';
			}
			
			if ($conexion->query($sql) && $conexion->query($sql2)) {
				

				return $resultado = true;
					
	            
	        }else{
		    	return $resultado = false;     	
	        }

		}				

		if ($test->{"datos"}[0]->{"operacion"} == "crearItemHA") {
			    	

			$descripcion = $test->{"datos"}[0]->{"descripcion"};	
			$estilo = $test->{"datos"}[0]->{"estilo"};
			$id_test = $test->{"datos"}[0]->{"id_test"};

			$sql='INSERT INTO item(item, id_estilo, id_test_ha) VALUES("'.$descripcion.'","'.$estilo.'","'.$id_test.'")'; 
			
			if ($conexion->query($sql)) {
				

				return $resultado = true;
					
	            
	        }else{
		    	return $resultado = false;     	
	        }

		}

		if ($test->{"datos"}[0]->{"operacion"} == "eliminarItemHA") {

			$id= $test->{"datos"}[0]->{"id_item"};	

			$sql='DELETE FROM item WHERE id_item = '.$id.';'; 
			$stmts = $conexion->prepare($sql);
			if ($stmts->execute()) {
				

				return $resultado = true;
					
	            
	        }else{
		    	return $resultado = false;     	
	        }

		}

	


#####################   TEST VARK ###########################################		
		if ($test->{"datos"}[0]->{"operacion"} == "crearTestVark") {

			$id_administrador = $test->{"datos"}[0]->{"id_administrador"};

			$sql='INSERT INTO test_vark(id_administrador) VALUES("'.$id_administrador.'")'; 
			$stmts = $conexion->prepare($sql);
			
			if ($stmts->execute()) {

				return $resultado = true;			

	        }else{
		    	return $resultado = false;     	
	        }

		}

		if ($test->{"datos"}[0]->{"operacion"} == "eliminarTestVark") {

			$id= $test->{"datos"}[0]->{"id_test"};	

			$sql='DELETE FROM test_vark WHERE id_test_vark = '.$id.';'; 
			$stmts = $conexion->prepare($sql);
			if ($stmts->execute()) {
				

				return $resultado = true;
					
	            
	        }else{
		    	return $resultado = false;     	
	        }

		}

		if ($test->{"datos"}[0]->{"operacion"} == "habilitarTestVark") {
			    	

			$habilitado = $test->{"datos"}[0]->{"habilitado"};
			$id_test = $test->{"datos"}[0]->{"id_test"};

			$sql='UPDATE test_vark SET habilitado='.$habilitado.' WHERE id_test_vark='.$id_test.';'; 

			if ($habilitado == 1) {
				$sql2='UPDATE test_vark SET habilitado="0" WHERE id_test_vark !='.$id_test.';';
			}
			
			if ($conexion->query($sql) && $conexion->query($sql2)) {
				

				return $resultado = true;
					
	            
	        }else{
		    	return $resultado = false;     	
	        }

		}				

		if ($test->{"datos"}[0]->{"operacion"} == "crearPreguntaVark") {
			    	

			$descripcion = $test->{"datos"}[0]->{"descripcion"};	
			$estilo = $test->{"datos"}[0]->{"estilo"};
			$id_test = $test->{"datos"}[0]->{"id_test"};

			$sql='INSERT INTO pregunta(pregunta, id_test_vark) VALUES("'.$descripcion.'","'.$id_test.'")'; 
			
			if ($conexion->query($sql)) {
				

				return $resultado = true;
					
	            
	        }else{
		    	return $resultado = false;     	
	        }

		}

		if ($test->{"datos"}[0]->{"operacion"} == "eliminarPregunta") {

			$id = $test->{"datos"}[0]->{"id_pregunta"};	

			$sql='DELETE FROM respuesta WHERE id_pregunta = '.$id.';'; 
			$stmts = $conexion->prepare($sql);
			if ($stmts->execute()) {
				
				$sql='DELETE FROM pregunta WHERE id_pregunta = '.$id.';'; 
				$stmts = $conexion->prepare($sql);
				if ($stmts->execute()) {
					return $resultado = true;
				}else{
					return $resultado = false; 
				}	
					
	            
	        }else{
		    	return $resultado = false;     	
	        }

		}

		if ($test->{"datos"}[0]->{"operacion"} == "eliminarRespuesta") {

			$id = $test->{"datos"}[0]->{"id_respuesta"};	

			$sql='DELETE FROM respuesta WHERE id_respuesta = '.$id.';'; 
			$stmts = $conexion->prepare($sql);
			if ($stmts->execute()) {

				echo $resultado = true;					
	            
	        }else{
		    	echo $resultado = false;     	
	        }

		}		

		if ($test->{"datos"}[0]->{"operacion"} == "actualizarPregunta") {
			    	

			$pregunta = $test->{"datos"}[0]->{"descripcion"};
			$id_pregunta = $test->{"datos"}[0]->{"id_pregunta"};

			$sql='UPDATE pregunta SET pregunta="'.$pregunta.'" WHERE id_pregunta="'.$id_pregunta.'";'; 
			
			if ($conexion->query($sql)) {
				

				return $resultado = true;
					
	            
	        }else{
		    	return $resultado = false;     	
	        }

		}	

		if ($test->{"datos"}[0]->{"operacion"} == "crearRespuestaVark") {
			    	

			$respuesta = $test->{"datos"}[0]->{"respuesta"};	
			$id_tipo_persepcion = $test->{"datos"}[0]->{"estilo"};
			$id_pregunta = $test->{"datos"}[0]->{"id_pregunta"};

			$sql='INSERT INTO respuesta(respuesta, id_pregunta, id_tipo_persepcion) VALUES("'.$respuesta.'","'.$id_pregunta.'","'.$id_tipo_persepcion.'")'; 
			
			if ($conexion->query($sql)) {
				

				return $resultado = true;
					
	            
	        }else{
		    	return $resultado = false;     	
	        }

		}	*/
													



	}



 ?>