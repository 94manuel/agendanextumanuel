<?php
	require('conector.php');
	
	$con = new conectorBD();
	$response['conexion'] = $con->initConexion($con->database);
	if ($response['conexion'] == 'OK') {
		if ($con->eliminarRegistro('eventos', 'id='.$_POST['id'])) {
			$response['msg'] = 'OK';
		}else{
			$response['msg'] = 'No se a podido eliminar el registro';
		}
	}else{
			$response['msg'] = "error en la comunicacion con la base de datos";
		}
	echo json_encode($response)


 ?>
