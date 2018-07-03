<?php

require('./conector.php');

$con = new ConectorBD();

$response['msg'] = $con->initConexion($con->database);

if ($response['msg']=='OK') {
  $resultado = $con->consultar(['eventos'],['*'], "WHERE fk_usuarios ='".$_SESSION['email']."'",'');

  $i = 0;


  while($fila = $resultado->fetch_assoc()){
    $response['eventos'][$i]['id']=$fila['id'];
    $response['eventos'][$i]['title']=$fila['titulo'];
    if ($fila['allday'] == 0){
      $allDay = false;

      $response['eventos'][$i]['start']=$fila['fecha_inicio'].'T'.$fila['hora_inicio'];

      $response['eventos'][$i]['end']=$fila['fecha_fin'].'T'.$fila['hora_fin'];
    }else{
      $allDay= true;

      $response['eventos'][$i]['start']=$fila['fecha_inicio'];

      $response['eventos'][$i]['end']="";
    }


    $response['eventos'][$i]['allDay']=$allDay;

    $i++;
  }

 $response['getData'] = "OK";
}

echo json_encode($response);


 ?>
