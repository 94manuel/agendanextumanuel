<?php
require('conector.php');
$con = new ConectorBD();
$usuarios = new Usuarios();
$eventos = new Eventos();

$response['detalle'] = "Se han encontrado los siguientes errores:</br><ol>";
$resonse['usuarios'] = "";
$response['eventos']='';


$result = $con->crearTabla($usuarios->nombreTabla, $usuarios->data);
if( $result == "OK"){
  $response['msg'] = 'OK';
  $response['detalle'] = "OK";
  $response['usuarios'] = 'OK';
}else{
  $response['detalle'] .= "<li>Error al crear la tabla usuarios.</li>";
}
$result = $con->crearTabla($eventos->nombreTabla, $eventos->data);
if( $result == "OK"){
  $response['msg'] = 'OK';
  $response['detalle'] = "OK";
  $response['eventos'] = 'OK';
}else{
  $response['detalle'] .= "<li>Error al crear la tabla eventos.</li>";
}

if($response['eventos'] =='OK' AND $response['usuarios'] == 'OK' ){

  $result =  $con->nuevaRestriccion($eventos->nombreTabla, 'ADD KEY fk_usuarios (fk_usuarios)');
  if( $result == "OK"){
    $response['Index'] = 'OK';
    $response['detalle'] = 'OK';
  }

  $result =  $con->nuevaRelacion($eventos->nombreTabla, $usuarios->nombreTabla, 'fk_usuarioemail_evento', 'fk_usuarios', 'email'); //nombre de la tabla origen, nomvre tabla destino, nombre de la clave foranea, nombre de la columna origen, nombre de columna destino
  if( $result == "OK"){
    $response['Clave Foránea'] = 'OK';
    $response['detalle'] = 'OK';
  }
}else{
  $response['detalle'] .='</ul> </br>Verifique que los datos del usuario utilizado para realizar la conexión en el archivo <code>conector.php</code> cuentr con permisos administrativos en phpmyadmin';
  $response['msg'] = $response['detalle'];
}

echo json_encode($response);
?>
