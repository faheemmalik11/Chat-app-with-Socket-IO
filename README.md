# Chat-App-with-Socket-IO

* [Installation](#installation)
* [Server Side Setup](#server-side-setup)
* [Client Side Setup](#client-side-setup)
* [Emit Events](#emit-events)
* [Listen Events](#listen-events)
* [Broadcast Events](#broadcast-events)
* [Channel](#channel)
* [Redis Laravel](#redis-laravel)

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

## Channel

### Introduction
This project is a real-time chat room application built using Socket.io and Laravel. It allows users to join the chat room, see other online users, send messages, and reply to messages in real-time. The chat messages and user presence are broadcasted to all connected clients using Laravel broadcasting with the help of the Socket.io library.

### Features

User Authentication: Users can register and log in to participate in the chat room.
Real-Time Communication: Messages are sent and received in real-time without the need to refresh the page.
User Presence: The chat room displays a list of all online users.
Message Replies: Users can reply to messages, and replies are broadcasted to all users.

## Redis Laravel

### Install predis

```sh
composer require predis/predis
```

### Create Event

```sh
php artisan make:event SendMessage
```
app\Events\SendMessage.php

```php
<?php
  
namespace App\Events;
  
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
  
class SendMessage implements ShouldBroadcastNow
{
    use InteractsWithSockets, SerializesModels;
  
    public $data = ['asas'];
  
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
  
    }
  
    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('users');
    }
  
    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'UserEvent';
    }
    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastWith()
    {
        return ['title'=>'This notification from ItSolutionStuff.com'];
    }
}
```

### Updating env File

You need to set env file with BROADCAST_DRIVER as redis and database configuration and also database redis configuration.
```sh
BROADCAST_DRIVER=redis
  
DB_DATABASE=redis-laravel
DB_USERNAME=root
DB_PASSWORD=password
  
REDIS_HOST=localhost
REDIS_PASSWORD=null
REDIS_PORT=6379
   
LARAVEL_ECHO_PORT=6001
```

### Updating configuration

app/config/database.ph
```php
'redis' => [

        'client' => env('REDIS_CLIENT', 'predis'),

        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'redis'),
            'prefix' => ''
        ],

        'default' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),
        ],

        'cache' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_CACHE_DB', '1'),
        ],
]
```

### Migration
```sh
php artisan migrate
```

### Install laravel echo server
```sh
npm install -g laravel-echo-server
```
initialize it
```sh
npx laravel-echo-server init
```
It will create new file laravel-echo-server.json file

###  Install npm, laravel-echo, socket.io-client
Here, we will install npm and also install laravel-echo, socket.io-client. also you need to configuration. so let's run following command:
```sh
npm install
npm install laravel-echo
npm install socket.io-client
```
Remove `type:module` to disabble es6 from package.json. 
Now we need to create new file laravel-echo-setup.js file on resources/js directory.

resources/js/laravel-echo-setup.js:
```sh
var Echo = require('laravel-echo');
window.io = require('socket.io-client')

window.Echo = new Echo.default({
    broadcaster: 'socket.io',
    host: window.location.hostname + ":" + window.laravel_echo_port
});
```
Now you need to add on mix file as like bellow:
```sh
// webpack.mix.js

const mix = require('laravel-mix');

/*
|--------------------------------------------------------------------------
| Mix Asset Management
|--------------------------------------------------------------------------
|
| Mix provides a clean, fluent API for defining some Webpack build steps
| for your Laravel applications. By default, we are compiling the CSS
| file for the application as well as bundling up all the JS files.
|
*/

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/laravel-echo-setup.js', 'public/js') // add
    .postCss('resources/css/app.css', 'public/css', [
        //
    ]);
```

if there is no webpack.mix.js in your project, first install it and create file
```sh
npm install laravel-mix --save-dev
```
```sh
touch webpack.mix.js
```

After you have done it, run:
```sh
npx mix
```
then:
```sh
npm run dev
```

### Update views
app/resources/views/welcome.php
```sh
<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Laravel Broadcast Redis Socket io Tutorial - ItSolutionStuff.com</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <h1>Laravel Broadcast Redis Socket io Tutorial - ItSolutionStuff.com</h1>
            
            <div id="notification"></div>
        </div>
    </body>
  
    <script>
            window.laravel_echo_port='{{env("LARAVEL_ECHO_PORT")}}';
    </script>
    <script src="//{{ Request::getHost() }}:{{env('LARAVEL_ECHO_PORT')}}/socket.io/socket.io.js"></script>
    <script src="{{ url('/js/laravel-echo-setup.js') }}" type="text/javascript"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
      
    <script type="text/javascript">

        var i = 0;

        window.Echo.channel('users')
         .listen('.UserEvent', (data) => {
            i++;
            $("#notification").append('<div class="alert alert-success">'+i+'.'+data.title+'</div>');
        });
    </script>
</html>
```

### Call Event

routes/web.php
```sh
Route::get('/t', function () {
    event(new \App\Events\SendMessage());
    dd('Event Run Successfully.');
});
```

### Final steps
You must have to install redis server in your system or server. it not then you can install using following command:
```sh
sudo apt install redis-server
```
After that you can start laravel echo server as like bellow command:
```sh
npx laravel-echo-server start
```
Now you can run project using following command:
```sh
php artisan serve
```
