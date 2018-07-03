<?php
  	require('./conector.php');

$con = new ConectorBD();

$response['conexion'] = $con->initConexion($con->database);
if($response['conexion'] == 'OK'){

    $data['titulo'] = '"'.$_POST['titulo'].'"';
    $data['fecha_inicio'] = '"'.$_POST['start_date'].'"';
    $data['hora_inicio'] = '"'.$_POST['start_hour'].':00"';
    $data['fecha_fin'] = '"'.$_POST['end_date'].'"';
    $data['hora_fin'] = '"'.$_POST['end_hour'].':00"';
    $data['allday'] = $_POST['allDay'];
    $data['fk_usuarios'] = '"'.$_SESSION['email'].'"';


    if($con->insertData('eventos', $data)){

        $resultado = $con->consultar(['eventos'],['MAX(id)']);
        while($fila = $resultado->fetch_assoc()){
          $response['id']=$fila['MAX(id)'];
        }
        $response['msg'] = 'OK';
    }else{

        $response['msg'] = "Ha ocurrido un error al guardar el evento";
    }
}else{

    $response['msg'] = "Error en la comunicacion con la base de datos";
}

echo json_encode($response);


 ?>
