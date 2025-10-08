import express from 'express';
import http from 'http';
import {Server} from 'socket.io';
import {createServer} from 'http';
const app = express(); 


const server = http.createServer(app); 
const io = new Server(server, {   
     cors: { origin: "*"} });  
     app.get('/', (req, res) => {     
          res.send('<h1>Hello world</h1>');   
});     
io.on('connection',(socket)=>{     
     console.log(socket.id);   
     
     socket.on('message',msg => {
        socket.emit('userMessage',msg);
        socket.broadcast.emit('message',msg);
        
     });
     socket.on('typing', (typing) => {
        socket.broadcast.emit('typing',typing);
     });
     socket.on('disconnect',(socket)=>{             
        console.log('Disconnect');     
}); 
})  
     
server.listen(3000, () => {   
     console.log('Server is running'); 
});