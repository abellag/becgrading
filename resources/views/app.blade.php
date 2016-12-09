<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
        
        @if (Auth::guest())
        <title>Batangas Eastern Colleges</title>
        @else
	<title>{{ Auth::user()->fname }} {{ Auth::user()->lname }}</title>

	 <script>
            
         var explode = function(){
         //alert ("hello")
         $.get('/checksession',function(data){
             if(data=="false"){
                 document.location='/auth/logout';
             }
         })
         setTimeout(explode, 2000);
         }
            setTimeout(explode, 2000);
        </script>	

        @endif
        
	<link href="{{ asset('/css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/custom.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/fileinput.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/datepicker.css') }}" rel="stylesheet">
        
	<!-- Fonts 
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
           -->
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
       
<script src="{{asset('/script/jquery.js')}}"></script>
<script src="{{asset('/script/custom.js')}}"></script>
<script src="{{asset('/script/bootstrap.min.js')}}"></script>
<script src="{{asset('/script/fileinput.js')}}"></script>
<script src="{{asset('/script/bootstrap-datepicker.js')}}"></script>
</head>

<body> 
    @yield('scripts');
  <nav class="navbar navbar-default">      
    <div class= "container-fluid">  
        <div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
				<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				
	</div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        
        <ul class="nav navbar-nav">
            <li><a href="#" style="font-size:15pt">Batangas Eastern Colleges</a></li>
            <li><a href="{{ url('/') }}">Home</a></li>
       </ul>
                            <ul class="nav navbar-nav navbar-right">
					@if (Auth::guest())
						<li><a href="{{ url('/auth/login') }}">Login</a></li>
                                                <li><a href="{{ url('/auth/register') }}">Register</a></li>
					@else
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->fname }} {{ Auth::user()->lname }}<span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
                                                                <li><a href="{{ url('/auth/changepassword') }}">Change Password</a></li>
								<li><a href="{{ url('/auth/logout') }}">Logout</a></li>
							</ul>
						</li>
                                        @endif
                            </ul>
    </div>
     
   </div>
</nav>
       

	@yield('content')

	<!-- Scripts -->
	
<footer class="footer">
<div class="container_fluid">
<p class="text-muted">Powered by : <a href="http://nephilaweb.com.ph">Nephila Web Technology Inc</a></p>
</div>
</footer>
    
</body>
</html>
