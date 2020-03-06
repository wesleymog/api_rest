const express = require("express");
const socketio = require("socket.io");
const bodyParser = require("body-parser");
const http = require("http");
const app = express();

server = http.createServer(app);
const io = socketio(server);

const clients = [];

app.use(
    express.urlencoded({
        extended: true
    })
);

/**
 * Initialize Server
 */
server.listen(8888, function() {
    console.log("Servidor Rodando na Porta 8888");
});

/**
 * Página de Teste
 */
app.get("/", function(req, res) {
  res.sendFile(__dirname+ "/index.html");
});

// Recebe requisição do Laravel
app.post("/notification", function(req, res) {
    console.log('Chegando dentro do like');
    var params = req.body;
    var clients = io.sockets.clients().sockets;
    console.log(req.body);
    console.log('Esses são os parametros\n');
    for (const key in clients) {
        if (key != params.id) clients[key].emit("notification", params);
    }

    res.send();
});

// Recebe conexão dos usuários no servidor
io.on("connection", function(client) {
    // Adicionado clientes
    client.emit("welcome", {
        id: client.id
    });
    console.log(client);

});
