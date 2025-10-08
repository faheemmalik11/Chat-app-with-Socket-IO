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
        <div class ="container">
        <div class="d-flex align-items-center justify-content-center " style="height: 800px;">
            <form id="loginForm" method ="POST" action ="http://127.0.0.1:8000/auth/login">
            <!-- Email input -->
                <div class="form-outline ">
                    <input type="email" name="email" class="form-control" />
                    <label class="form-label" >Email address</label>
                </div>

                <!-- Password input -->
                <div class="form-outline ">
                    <input type="password" name="password"  class="form-control" />
                    <label class="form-label" >Password</label>
                </div>

               

                <!-- Submit button -->
                <button type="submit" class="btn btn-primary btn-block ">Sign in</button>

            
            </form>
        </div>
        </div>

        
    </body>
  
    <script>
            window.laravel_echo_port='{{env("LARAVEL_ECHO_PORT")}}';
    </script>
    <script src="//{{ Request::getHost() }}:{{env('LARAVEL_ECHO_PORT')}}/socket.io/socket.io.js"></script>
    <script src="{{ url('/js/laravel-echo-setup.js') }}" type="text/javascript"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js" integrity="sha512-3j3VU6WC5rPQB4Ld1jnLV7Kd5xr+cq9avvhwqzbH/taCRNURoeEpoPBK9pDyeukwSxwRPJ8fDgvYXd6SkaZ2TA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>



<script type="text/javascript">
    var frm = $('#loginForm');

    frm.submit(function (e) {

        e.preventDefault();

        $.ajax({
            type: frm.attr('method'),
            url: frm.attr('action'),
            data: frm.serialize(),
            success: function (data) {
                $.cookie("token", data.data.token, { expires: 2400, path: '/' });
                window.location.href = "http://127.0.0.1:8000/chat/"
            },
            error: function (data) {
                console.log('Unauthorized Attempt');
                console.log(data);
            },
        });
    });
</script>
</html>