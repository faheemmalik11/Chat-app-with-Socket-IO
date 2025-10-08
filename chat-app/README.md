
* [Installation](#installation)
* [Server Side Setup](#server-side-setup)
* [Client Side Setup](#client-side-setup)
* [Emit Events](#emit-events)
* [Listen Events](#listen-events)
* [Broadcast Events](#broadcast-events)


## Installation
Install all the necessary dependencies for the application.
```sh
npm install express
```
```sh
npm install socket.io
```
`also to use this project after clone install these packages`
## Server Side Setup
Create a server.js file in the app and setup the server.
```sh
import express from 'express';
import http from 'http';
import {Server} from 'socket.io';
import {createServer} from 'http';
const app = express(); 


const server = http.createServer(app); 
const io = new Server(server, {   
     cors: { origin: "*"} });

app.get('/', (req, res) => {     
          res.send('Hello world');   
});     
io.on('connection',(socket)=>{     
     console.log('Connected');   
     
     socket.on('disconnect',(socket)=>{             
        console.log('Disconnect');     
}); 
})  
     
server.listen(3000, () => {   
     console.log('Server is running'); 
});
```

## Client Side Setup
routes/web.php:
```sh
Route::get('/socket.io.js', function () {
    return response()->file(base_path('node_modules/socket.io/client-dist/socket.io.js'));
});
```

```sh
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Chat App</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

        <script src="{{ asset('socket.io.js') }}"></script>
        <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
        <!-- Styles -->
        <style>  </style>
    </head>
    <body class="antialiased">
    


    <script>
        $(function(){

            const socket = io('http://127.0.0.1:3000');

        });
    </script>
    </body>
</html>

```
## Emit Events
To emit an event using socket.io. .emit function is used. We emit an event from one side and it is listened one the other side.
```sh
io.on('connection', (socket) => {
    socket.emit('message',"HELLO WORLD!");
})
```
## Listen Events
To listen to an event .on function is used. 
```sh
io.on("connection", (socket) => {
  socket.on("message", (arg) => {
    console.log(arg); // "HELLO WORLD!"
  });
});
```
## Broadcast Events
Broadcast is sending event to all the connected clients. 
```sh
io.on("connection", (socket) => {
  socket.broadcast.emit("message", "HELLO WORLD!");
});
```