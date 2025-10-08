<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>channel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">laravel</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
      <li class="nav-item active">
        <a class="nav-link" href="#">Chat <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{route('channel')}}">Channels</a>
      </li>

    </ul>
 
  </div>
</nav>


<main class="content mt-5">
    <div class="container p-0">

		<h1 class="h3 mb-3">Messages</h1>

		<div  class="card">
			<div class="row g-0">
				<div class="col-12 col-lg-5 col-xl-3 border-right">

					<div class="px-4 d-none d-md-block">
						<div class="d-flex align-items-center">
							<div class="flex-grow-1">
								<input type="text" class="form-control my-3" placeholder="Search...">
							</div>
						</div>
					</div>
					@foreach($users as $user)

					

					<a id="user-{{$user->id}}" href="#" class="list-group-item list-group-item-action border-0">
						<div class="d-flex align-items-start">
							<img src="{{$user->avatar}}" class="rounded-circle mr-1" alt="Vanessa Tucker" width="40" height="40">
							<div class="flex-grow-1 ml-3">
								{{$user->name}}
								<div class="small"><span class="fas fa-circle chat-online"></span> Online</div>
							</div>
						</div>
					</a>
					@endforeach

					

					<hr class="d-block d-lg-none mt-1 mb-0">
				</div>
				<div class="col-12 col-lg-7 col-xl-9">

				<div id="guideText"class="container h-100">
					<div  class="row align-items-center h-100">
						<div class="col-6 mx-auto">
							<div class="jumbotron">
								Click On user profile to start chatting
							</div>
						</div>
					</div>
				</div>

					<div class="py-2 px-4 border-bottom d-none d-lg-block">
						<div id="user-profile"class="d-flex align-items-center py-1">
							
						</div>
					</div>

					<div id="userChat" class="position-relative">
	
					</div>


					<div class="flex-grow-0 py-3 px-4 border-top">
						<form  method="POST" action="http://127.0.0.1:8000/chat/sendMessage" class="input-group" id="messageForm"   >
							
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

		var frm = $('#messageForm')
		var user_id = 0;


		$(document).ready(function() {
        @foreach($users as $user)
			$("#user-{{$user->id}}").click(function () {
				user_id = {{$user->id}};
				$("#user-profile").html('<div class="position-relative"> <img src="{{$user->avatar}}" class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40"></div><div class="flex-grow-1 pl-3"><strong>{{$user->name}}</strong><div class="text-muted small"><em>Typing...</em></div></div>');
				$("#userChat").html('<div id= "chat" class="chat-messages p-4"></div>')
				$('#guideText').html('');
				$('#guideText').remove();
				$('#messageForm').html('<input id="messageInput" name="message" type="text" class="form-control" placeholder="Type your message"><button type="submit"  id="send" class="btn btn-primary">Send</button> ');
				// console.log({{$user->id}});
				$.ajax({
					url: "http://127.0.0.1:8000/chat/getMessages/{{$user->id}}",
					type: 'GET',
					dataType: 'json', 
					success: function(res) {
						console.log(res.messages);
						jQuery.each(res.messages, function(index, message) {
							console.log(message);
								if(message.sender_id == {{auth()->user()->id}}) {
									var date = new Date(message.created_at);
									var formattedTime = date.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', second: 'numeric', hour12: true });
										$("#chat").append('<div id="sender" class="chat-message-right pb-4">'
												+'<div>'
												+'<img src="{{auth()->user()->avatar}}" class="rounded-circle mr-1" alt="{auth()->user()->name}}" width="40" height="40">'
												+'<div class="text-muted small text-nowrap mt-2">'+formattedTime+'</div>'
												+'</div>'
												+'<div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">'
												+'<div class="font-weight-bold mb-1">You</div>'
												+message.message
												+'</div>'
											+'</div>');
								}else{
									var date = new Date(message.created_at);
									var formattedTime = date.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', second: 'numeric', hour12: true });

										$("#chat").append('<div id="reciever" class="chat-message-left pb-4">'
										+'<div>'
										+'<img src="{{$user->avatar}}" class="rounded-circle mr-1" alt="{{$user->name}}" width="40" height="40">'
										+'<div class="text-muted small text-nowrap mt-2">'+formattedTime+'</div>'
										+'</div>'
										+'<div class="flex-shrink-1 bg-light rounded py-2 px-3 ml-3">'
										+'<div class="font-weight-bold mb-1">{{$user->name}}</div>'
										+message.message
										+'</div>'
										+'</div>' );

								}
						});			

					}
				});

				// console.log(user_id);
				
			});
			
			window.Echo.private('chat.{{$user->id}}.{{auth()->user()->id}}').listen('.message', (e) => {
					console.log(e);
					var date = new Date();
					var formattedTime = date.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', second: 'numeric', hour12: true });
					$("#chat").append('<div id="sender" class="chat-message-right pb-4">'
										+'<div>'
											+'<img src="{{auth()->user()->avatar}}" class="rounded-circle mr-1" alt="{auth()->user()->name}}" width="40" height="40">'
											+'<div class="text-muted small text-nowrap mt-2">'+formattedTime+'</div>'
										+'</div>'
										+'<div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">'
											+'<div class="font-weight-bold mb-1">You</div>'
												+$("#messageInput").val()
										+'</div>'
								+'</div>');
				
					

				});

				// console.log(user_id);
				window.Echo.private('chat.{{auth()->user()->id}}.{{$user->id}}').listen('.message', (e) => {
					var date = new Date();
					var formattedTime = date.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', second: 'numeric', hour12: true });
					console.log(e);

				

				$("#chat").append('<div id="reciever" class="chat-message-left pb-4">'
									+'<div>'
										+'<img src="{{$user->avatar}}" class="rounded-circle mr-1" alt="{{$user->name}}" width="40" height="40">'
										+'<div class="text-muted small text-nowrap mt-2">'+formattedTime+'</div>'
									+'</div>'
									+'<div class="flex-shrink-1 bg-light rounded py-2 px-3 ml-3">'
										+'<div class="font-weight-bold mb-1">{{$user->name}}</div>'
										+e.message
									+'</div>'
								+'</div>');
				});
		@endforeach



		frm.submit(function (e) {

			e.preventDefault();
			var formData = frm.serializeArray();
			formData.push({name: 'user_id', value: user_id});

			$.ajax({
				type: frm.attr('method'),
				url: frm.attr('action'),
				data: formData,
				success: function (data) {
						console.log(data);
				},
				error: function (data) {
					console.log('An error occurred.');
					console.log(data);
				},
			});

		});
		
	});
	
	
	
    </script>
</body>
</html>
