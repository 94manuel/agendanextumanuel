<?php
	require('conector.php');
	$con = new conectorBD();

	$response['conexion'] = $con->initConexion($con->database);
	if ($response['conexion'] == 'OK'){
		$conexion = $con->getConexion();
		$insert = $conexion->prepare('INSERT INTO usuarios (email, nombre, password , fecha_nacimiento) VALUES (?,?,?,?)');
		$insert->bind_param("ssss", $email, $nombre, $password, $fecha_nacimiento);

		$d_password = "70693536";
		$email = "ialzateo@mail.com";
		$nombre = "ialzate";
		$password = password_hash($d_password, PASSWORD_DEFAULT);
		$fecha_nacimiento = "1990-04-15";

		$insert->execute();

    $d_password = "1077846777";
		$email = 'lcruz@mail.com';
		$nombre = 'lcruz';
		$password = password_hash($d_password, PASSWORD_DEFAULT);
		$fecha_nacimiento = '1986-10-26';

		$insert->execute();

		$d_password = "user";
		$email = 'user@mail.com';
		$nombre = 'user';
		$password = password_hash($d_password, PASSWORD_DEFAULT);
		$fecha_nacimiento = '1994-01-03';

		$insert->execute();
		$response['resultado'] = "1";
		$response['msg']= 'Informacio de inicio:';
		$getUsers = $con->consultar(['usuarios'],['*'],$condicion = "");
		while ($fila= $getUsers->fetch_assoc()) {
			$response['msg'].=$fila['email'];
		}
		$response['msg'].= 'contraenia: '.$d_password;
		}else{
			$response['resultado'] == "0";
			$response['msg'] = 'No se pudo conectar a la base de datos';
		}

		echo json_encode($response);

 ?>
