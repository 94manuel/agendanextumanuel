const RouterEventos = require('express').Router();
const Usuario = require('./modelUsuarios.js')
const Evento = require('./modelEventos.js')
const Operaciones = require('./crud.js')
let ObjectId = require('mongoose').Types.ObjectId;


RouterEventos.get('/all', function(req, res) {
  req.session.reload(function(err) {
    if(req.session.user){
      if(err){
        res.send('logout');
        res.end()
      }else{
        Usuario.findOne({user:req.session.user}).exec({}, function(error, doc){
          if(error){
            res.send('logout');
          }else{
            Evento.find({user: doc._id}).exec(function(err, doc){
              if (err) {
                res.status(500)
                res.json(err)
              }
              res.json(doc)
            })
          }
        })
      }
    }else{
      res.send('logout');
      res.end()
    }
  })
})

RouterEventos.all('/', function(req, res) {
  res.send('Error al mostrar el recurso solicitado. Por favor verifique la dirección url a la cual desea ingresar' )
  res.end()
})


RouterEventos.post('/new', function(req, res) {
  req.session.reload(function(err) {
    if(err){
      console.log(err);
      res.json("logout");
    }else{
      Usuario.findOne({user:req.session.user}).exec({}, function(error, doc){
        Evento.nextCount(function(err, count) {
          newID = count
        });

        let title = req.body.title,
        start = req.body.start,
        end   = req.body.end,
        userId  = doc._id

        let evento = new Evento({
          title: title,
          start: start,
          end: end,
          user: userId
        })
        evento.save(function(error) {
          if (error) {
            console.log(error)
            res.json(error)
          }
          res.json(newID)
        })
      })
    }
  })
})

RouterEventos.post('/delete/:_id', function(req, res) {
  let id = req.params._id
  req.session.reload(function(err) {
    if(err){
      console.log(err)
      res.send("logout")
    }else{
      Evento.remove({_id: id}, function(error) {
        if(error) {
          console.log(error)
          res.status(500)
          res.json(error)
        }
        res.send("Registro eliminado")
      })
    }
  })
})


RouterEventos.post('/update/:_id&:start&:end', function(req, res) {
  req.session.reload(function(err) {
    if(err){
      console.log(err)
      res.send("logout")
    }else{
      Evento.findOne({_id:req.params._id}).exec((error, result) => {
        let id    = req.params._id,
        start = req.params.start,
        end   = req.params.end
        if (error){
          res.send(error)
        }else{
          Evento.update({_id: id}, {start:start, end:end}, (error, result) => {
            if (error){
              res.send(error )
            }else{
              res.send("Evento ha sido actualizado")
            }
          })
        }
      })
    }
  })
})

module.exports = RouterEventos
