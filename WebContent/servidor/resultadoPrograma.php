<?php 

	/**
	* 
	*/
	include_once 'conexion.php';
		
	
	$resultado = false;
	$server = new conexion();
	$conexion = $server->conectar();
	

	if (isset($_POST["json"])){
		$usuario = json_decode($_POST["json"]);
		if ($usuario->{"datos"}[0]->{"operacion"} == "mostrarReporte") {

			$programa = $usuario->{"datos"}[0]->{"programa"};
			$cantidadItems=[];

			for ($i=1; $i <= 4; $i++) { 
			$sql='SELECT sum(r.resultado)/count(*) as resultado FROM resultado_ha r, usuario u, usuario_tiene_programa utp, programa p  WHERE p.id_programa='.$programa.' && r.id_estilo='.$i.' && u.id_usuario=r.id_usuario=utp.id_usuario'; 
			$itemsSeleccionados=$conexion->query($sql);
				for ($j=0; $j < 1; $j++) { 
					$cantidadItems[] = $itemsSeleccionados->fetch_object()->resultado;
				}
						
			}

			$items = array(
  				"activo" => $cantidadItems[0],
  				"reflexivo" => $cantidadItems[1],
  				"teorico" => $cantidadItems[2],
  				"pragmatico" => $cantidadItems[3]
			);
			
			
			echo json_encode($items);



		}

################### Vark #############################################3

		if ($usuario->{"datos"}[0]->{"operacion"} == "mostrarReporteVark") {

			$programa = $usuario->{"datos"}[0]->{"programa"};
			$cantidadItems=[];

			for ($i=1; $i <= 4; $i++) { 
			$sql='SELECT sum(r.resultado)/count(*) as resultado FROM resultado_vark r, usuario u, usuario_tiene_programa utp, programa p  WHERE p.id_programa='.$programa.' && r.id_tipo_persepcion='.$i.' && u.id_usuario=r.id_usuario=utp.id_usuario'; 
			$itemsSeleccionados=$conexion->query($sql);
				for ($j=0; $j < 1; $j++) { 
					$cantidadItems[] = $itemsSeleccionados->fetch_object()->resultado;
				}
						
			}

			$items1 = array(
  				"kinestesico" => $cantidadItems[0],
  				"auditivo" => $cantidadItems[1],
  				"lectoEscritor" => $cantidadItems[2],
  				"visual" => $cantidadItems[3]
			);
			
			
			echo json_encode($items1);



		}		
 		
		

		

	}



 ?>