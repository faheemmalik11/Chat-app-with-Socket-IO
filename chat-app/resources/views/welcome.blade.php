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
        <style> 
            ul {
                list-style: none
            }
         </style>
    </head>
    <body class="antialiased">
    <ul id="messageList">

    </ul>
    <input id="chatInput" placeholder="message" />
    <button id = "submit" class="btn btn-primary">send</button>
    
    
    <script>
        let typing = true;
        const socket = io('http://127.0.0.1:3000');
        document.getElementById('chatInput').addEventListener('input', function() {
            const inputValue = this.value.trim();
            if (typing){
                socket.emit('typing', {startedTyping: true});
                typing = false;
            }
            if (inputValue === '') {
                socket.emit('typing', {stoppedTyping: true});
                typing = true;
            } 
        });
        $(function(){

           

            $("#submit").click(function(){
                const message = $("#chatInput").val();
                socket.emit('message', message);
        });
        socket.on('message', msg => {
                const listItem = $("<li class = 'alert alert-primary col-md-4 col-md-offset-4'>").text(msg);
                $("#messageList").append(listItem);
            });
        socket.on('userMessage', msg => {
            const listItem = $("<li class = 'alert alert-success text-end col-md-4 col-md-offset-4'>").text(msg);
            $("#messageList").append(listItem);
        });
        });
    </script>
    </body>
</html>
