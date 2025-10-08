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

<main class="content">
    <div class="container p-0">

		<h1 class="h3 mb-3">Messages</h1>

		<div class="card">
			<div class="row g-0">
				<div class="col-12 col-lg-5 col-xl-3 border-right">

                    @foreach($members as $member)
					<a href="#" class="list-group-item list-group-item-action border-0">

						<div class="d-flex align-items-start">
							<img src="{{$member->avatar}}" class="rounded-circle mr-1" alt="{{$member->name}}" width="40" height="40">
							<div class="flex-grow-1 ml-3">
                            {{$member->name}}
								<div id='user{{$member->id}}' class="small"><span  class="fas fa-circle chat-online"></span> Offline</div>
							</div>
						</div>
					</a>
                    @endforeach
					<hr class="d-block d-lg-none mt-1 mb-0">
				</div>

				<div class="col-12 col-lg-7 col-xl-9">
					<div class="py-2 px-4 border-bottom d-none d-lg-block">
						<div class="d-flex align-items-center py-1">
							<div class="position-relative">
								<img src="{{auth()->user()->avatar}}" class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40">
							</div>
							<div class="flex-grow-1 pl-3">
								<strong>{{auth()->user()->name}}</strong>
								<div id="userTyping" class="text-muted small"><em>Online</em></div>
							</div>
							
						</div>
					</div>

					<div class="position-relative">
						<div id="senderChat" class="chat-messages p-4">
                            @php
                                $lastDate = 0;
                            @endphp
                            @foreach($MessagesHistory as $Message)
                            @php
                                $messageDate = $Message->created_at->format('Y-m-d');
                            @endphp

                            @if ($lastDate !== $messageDate) 

                            <div class="row">
                                <div class="col-md-8 offset-md-4 text-right">
                                    <strong class="date">{{ $messageDate }}</strong>
                                </div>
                            </div>
                            @php
                                $lastDate = $messageDate;
                            @endphp
                        
                        @endif
                                <div class="chat-message pb-4">
                                    <div> 
                                        <img src="{{$Message->user->avatar}}" class="rounded-circle mr-1" alt="'+data.user.name+'" width="40" height="40">
                                        <div class="text-muted small text-nowrap mt-2">{{$Message->created_at->format('g:i A')}}</div>
                                    </div>
                                    <div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">
                                            <div class="font-weight-bold mb-1">{{$Message->user->name}}</div>
                                        {{$Message->message}}
                                    </div>
                                </div>
                                
                            @endforeach
                            
							

						</div>
					</div>

					<div class="flex-grow-0 py-3 px-4 border-top">
				
                            <form  class="input-group" id="messageForm" method = "POST" action="http://127.0.0.1:8000/room/sendMessage" >
                                <input id="messageInput" name="message" type="text" class="form-control" placeholder="Type your message">
                                <input type="hidden" name= "channel" value= "{{$channel->id}}"> 
                                <button type="submit" id="send" class="btn btn-primary">Send</button>
                            </form>
						
					</div>

				</div>
			</div>
		</div>
	</div>
</main>

    <script>
        window.laravel_echo_port = '{{ env("LARAVEL_ECHO_PORT") }}';
    </script>
    <script src="//{{ Request::getHost() }}:{{ env('LARAVEL_ECHO_PORT') }}/socket.io/socket.io.js"></script>
    <script src="{{ url('/js/laravel-echo-setup.js') }}" type="text/javascript"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>

    <script type="text/javascript">

       
         var frm = $('#messageForm');

        frm.submit(function (e) {

            e.preventDefault();

            $.ajax({
                type: frm.attr('method'),
                url: frm.attr('action'),
                data: frm.serialize(),
                success: function (data) {
                    console.log(data);
                    $.ajax({
                    url: "http://127.0.0.1:8000/room/typing",
                    type: "POST",
                    contentType: "application/json",
                    data: JSON.stringify({typing : false , channel: {{$channel->id}}}),
                    success: function(response) {
                        console.log(response);
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        console.error("Request failed with status:", xhr.status);
                    }
                    });
                    typing = true;
                },
                error: function (data) {
                    console.log('An error occurred.');
                    console.log(data);
                },
            });

        });


        

        let typing = true;
        document.getElementById('messageInput').addEventListener('input', function() {
            const inputValue = this.value.trim();
            if (typing){
                $.ajax({
                    url: "http://127.0.0.1:8000/room/typing",
                    type: "POST",
                    contentType: "application/json",
                    data: JSON.stringify({typing : true, channel:{{$channel->id}} }),
                    success: function(response) {
                        console.log(response);
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        console.error("Request failed with status:", xhr.status);
                    }
                });

                typing = false;
            }
            if (inputValue == '') {
                $.ajax({
                    url: "http://127.0.0.1:8000/room/typing",
                    type: "POST",
                    contentType: "application/json",
                    data: JSON.stringify({typing : false , channel: {{$channel->id}}}),
                    success: function(response) {
                        console.log(response);
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        console.error("Request failed with status:", xhr.status);
                    }
                });
                typing = true;
            } 
        });

        window.Echo.join('general.{{$channel->id}}')
    .here((users) => {
        users.forEach(user => {
            $("#user"+user.id).text('Online');
        });
        console.log(users); // List of users currently on the channel
    })
    .joining((user) => {

        console.log(user.name + ' has joined'); // User who joined
    })
    .leaving((user) => {
        console.log(user.name + ' has left'); // User who left
    })
    .listen('.typing', (data) => {
            console.log('typing listened');
            if(data.typing == true) {
                $("#user"+data.user.id).text('Typing...');
                $("#userTyping").text('Typing...');
            }else {
                $("#user"+data.user.id).text('Online');
                $("#userTyping").text('Online');
            }
            
        })
    .listen('.message', (data) => {          
        const time = new Date().toLocaleString([], { hour: 'numeric', minute: 'numeric' }); //date
        console.log(data);
        $("#senderChat").append('<div class="chat-message pb-4"><div> <img src="'+data.user.avatar+'" class="rounded-circle mr-1" alt="'+data.user.name+'" width="40" height="40"><div class="text-muted small text-nowrap mt-2">'+time+'</div></div><div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3"><div class="font-weight-bold mb-1">'+data.user.name+'</div>'+data.message+'</div></div>');
        $("#messageInput").val('');
        
    });


        

        


        
    </script>

</body>
</html>
