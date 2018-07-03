var Usuario = require('./modelUsuarios.js')

module.exports.crearUsuarioDemo = function(callback){
  var arr = [{ email: 'lcruz@mail.com', user: "lcruz", password: "1077846777"}, { email: 'ialzate@mail.com', user: "ialzate", password: "70693536"}];
  Usuario.insertMany(arr, function(error, docs) {
    if (error){
      if (error.code == 11000){
        callback("Utilice los siguientes datos: </br>usuario: lcruz | password:1077846777 </br>usuario: ialzate | password:70693536")
      }else{
        callback(error.message)
      }
    }else{
      callback(null, "El usuario 'lcruz' y 'ialzate' se ha registrado correctamente. </br>usuario: lcruz | password:1077846777 </br >usuario: ialzate | password:70693536")
    }
  });
}
