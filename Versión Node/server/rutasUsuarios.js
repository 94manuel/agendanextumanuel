const Router = require('express').Router();
const Usuarios = require('./modelUsuarios.js')
const Eventos = require('./modelEventos.js')
const Operaciones = require('./crud.js')

Router.get('/demo', function(req, res) {
  Usuarios.find({user: req.query.user}).count({}, function(err, count) {
    if(count>0){
        res.send("Utilice los siguientes datos: </br>usuario: lcruz | password:1077846777 </br>usuario: ialzate | password:70693536")
    }else{
      Eventos.find({}).count({}, function(err, count) {
        if(count>0){
          Eventos.remove({},function(err, doc){
          if(err){
            console.log(err)
          }else{
            console.log("Información de eventos reinicializada")
          }
        })
      }
    })
      Operaciones.crearUsuarioDemo((error, result) => {
        if(error){
          res.send(error)
        }else{
          res.send(result)
        }
      })
    }
  })
})


Router.post('/login', function(req, res) {
    let user = req.body.user
    let password = req.body.pass,
    sess = req.session;
    Usuarios.find({user: user}).count({}, function(err, count) {
        if (err) {
            res.status(500)
            res.json(err)
        }else{
          if(count == 1){
            Usuarios.find({user: user, password: password }).count({}, function(err, count) {
                if (err) {
                    res.status(500)
                    res.json(err)
                }else{
                  if(count == 1){
                    sess.user = req.body.user;
                    res.send("Validado")
                  }else{
                    res.send("Contraseña incorrecta")
                  }
                }
            })
          }else{
            res.send("Usuario no registrado")
          }
        }

    })
})


Router.post('/logout', function(req, res) {
  req.session.destroy(function(err) {
  if(err) {
    console.log(err);
    res.json(err)
  } else {
    req.session = null
    res.send('logout')
    res.end()
  }
  });
});

Router.all('*', function(req, res) {
  res.send('Error al mostrar el recurso solicitado. Por favor verifique la dirección url a la cual desea ingresar' )
  res.end()
})

module.exports = Router
