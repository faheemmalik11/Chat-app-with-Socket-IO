# Redis Laravel

## Install Predis

```sh
composer require predis/predis
```

## Create Event

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

## Updating Env File

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

## Updating configuration

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

## Migration
```sh
php artisan migrate
```

## Install laravel echo server
```sh
npm install -g laravel-echo-server
```
initialize it
```sh
npx laravel-echo-server init
```
It will create new file laravel-echo-server.json file

##  Install npm, laravel-echo, socket.io-client
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

## Update views
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

## Call Event

routes/web.php
```sh
Route::get('/t', function () {
    event(new \App\Events\SendMessage());
    dd('Event Run Successfully.');
});
```

## Final steps
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
