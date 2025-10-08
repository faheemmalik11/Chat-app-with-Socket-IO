var Echo = require('laravel-echo');
window.io = require('socket.io-client')

window.Echo = new Echo.default({

    broadcaster: 'socket.io',
    host: window.location.hostname + ":" + window.laravel_echo_port
});