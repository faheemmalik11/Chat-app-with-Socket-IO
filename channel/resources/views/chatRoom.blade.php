@component('components.chat')
    @section('content')
  
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />


<div class="p-3">
<div class="container ">
<div class="row clearfix ">
    <div class="col-lg-12 ">
        <div class="card chat-app ">
            <div id="plist" class="people-list">

                <ul id="userList" class="list-unstyled chat-list mt-2 mb-0">
                </ul>
            </div>
            <div class="chat">
                <div class="chat-header clearfix">
                    <div class="row">
                        <div class="col-lg-6">
                            <a href="javascript:void(0);" data-toggle="modal" data-target="#view_info">
                                <img src="{{auth()->user()->avatar_url}}" alt="avatar">
                            </a>
                            <div class="chat-about">
                                <h6 class="m-b-0">{{auth()->user()->name}}</h6>
                                <small><div class="status"> <i class="fa fa-circle online"></i> online </div></small>
                            </div>
                        </div>
                        
                    </div>
                    
                </div>
                <div class="chat-history ">
                    <ul id="messagesList" class="m-b-0 ">
                    <div id="notification" class="alert alert-success "></div>
                       

                            
                            
                                        
                        
                    </ul>
                </div>
                <div class="chat-message clearfix">
                    <div class="input-group mb-0">
                        <div class="input-group-prepend">
                            <button id="sendMessage" type="button"><span class="input-group-text"><i class="fa fa-send"></i></span></button>
                        </div>
                        <input id="message" type="text" class="form-control" placeholder="Enter text here..." />                                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<input id="name" type="hidden" value="{{auth()->user()->name}}" /> //name of the user
<input id="avatar" type="hidden" value="{{auth()->user()->avatar_url}}" /> //avatar of the user
<input id="group" type = "hidden" value="{{$group}}" /> //group 
<script>
    
        $(function(){
            
            const socket = io('http://127.0.0.1:3000');

                socket.emit('join', {group:$("#group").val(), user: $("#name").val(), avatar: $("#avatar").val()}); //join event emitted 


            socket.on('joinMessage', msg => {
                $("#userList").remove(); //removes joined users ul 
                $('#notification').remove(); //removes notification div
                $('<div id="notification" class="alert alert-success "></div>').appendTo($('#messagesList')); //adds notification div to parent div
                $('<ul id="userList" class="list-unstyled chat-list mt-2 mb-0"></ul>').appendTo($('#plist')); //add user list to parent div
                for (let i =0; i < msg.users.length; i++){  //loop on users array coming from server 
                    const userList ='<li class="clearfix active"> <img src="'+msg.avatars[i]+'" alt="avatar"><div class="about"> <div class="name">'+msg.users[i]+'</div><div class="status"> <i class="fa fa-circle online"></i> online </div> </div> </li>' //joined users
                    const li = document.createElement('li'); 
                    li.textContent = msg.users[i]+' Joined the chat'; // notification message
                    $('#notification').append(li);  
                    $("#userList").append(userList);
            }});

            $("#sendMessage").on('click', function(){ //send button click event
                socket.emit('sendMessage', {group:$("#group").val(),message: $("#message").val(), avatar: $("#avatar").val()}); //event emited
                $("#message").val(''); //input field made empty
            });
            $("#message").on('keydown',function(e) { //enter in message input event trigger
                if(e.which == 13) {
                    socket.emit('sendMessage', {group:$("#group").val(),message: $("#message").val(), avatar: $("#avatar").val()});
                    $("#message").val('');
                }
            });

            socket.on('newMessage', (msg) => { //message event listen for other users
                const time = new Date().toLocaleString([], { hour: 'numeric', minute: 'numeric' }); //date
                const component = '<li class="clearfix"><div class="message-data"> <span class="message-data-time">'+time+'</span> <img src="'+msg.avatar+'" alt="avatar"> </div> <div class="message my-message">'+msg.message+'</div> </li>     ';
                $("#messagesList").append(component);
                
        
            });
            socket.on('newMessageSender', (msg) => { //message event listen for sender

                const time = new Date().toLocaleString([], { hour: 'numeric', minute: 'numeric' });
                var component = '<li class="clearfix"> <div class="message-data text-right"> <span class="message-data-time">'+time+'</span> <img class="float-right" src="'+msg.avatar+'" alt="avatar"></div><div class="message other-message float-right">'+msg.message +' </div></li>';
               

                $("#messagesList").append(component);
                
        
            });
        });
    </script>

    @endsection
@endcomponent