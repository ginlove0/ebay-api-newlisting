const app = require('express');
const server = require('http').Server(app);
var cors = require('cors');
var io = require('socket.io')(server);
var redis = require('redis');

const https = require('https');



io.on('connection', function (socket) {

    console.log("new client connected");
    // var redisClient = redis.createClient();
    // redisClient.subscribe('message');
    //
    // redisClient.on("message", function(channel, message) {
    //     console.log("mew message in queue "+ message + "channel");
    //     socket.emit(channel, message);
    // });

    socket.on('get-all-data', () => {
        https.get('https://cat-fact.herokuapp.com/facts', (res) =>{

        })

    });

    socket.on('disconnect', function() {

    });

});


server.listen(8890, ()=>{
    console.log("Server Start")
});
