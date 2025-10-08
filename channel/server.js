import express from 'express';
import http from 'http';
import {Server} from 'socket.io';
import {createServer} from 'http';
const app = express(); 


const server = http.createServer(app); 
var users = [];
var avatars = [];
users = new Set();
avatars = new Set();
const io = new Server(server, {   
     cors: { origin: "*"} });

app.get('/', (req, res) => {     
          res.send('Hello world');   
});     
io.on('connection',(socket)=>{     
     console.log('Connected');   
     
     socket.on('join', msg => {
        console.log(msg);
       socket.join(msg.group);
       users.add(msg.user);
       avatars.add(msg.avatar);
       console.log([...users]);
       io.to(msg.group).emit('joinMessage', {users: [...users], avatars: [...avatars]});
       
     });

     socket.on('sendMessage', msg => {
          socket.emit('newMessageSender', {message:msg.message, avatar: msg.avatar});
        socket.broadcast.to(msg.group).emit('newMessage', {message:msg.message, avatar: msg.avatar});
     })

     socket.on('disconnect',(socket)=>{             
        console.log('Disconnect');     
}); 
})  
     
server.listen(3000, () => {   
     console.log('Server is running'); 
});