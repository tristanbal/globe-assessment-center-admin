<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>ASSESSMENT PORTAL - Admin</title>
	@include('inc.templates')

</head>
<body>
	<div class="wrapper ">
		
		  @include('inc-auth.navbar')
			<div class="content d-flex align-items-center justify-content-center	" style="height: 80vh;">
				@yield('content')
      </div>
      @include('inc.footer')
		</div>
  @include('inc.scripts')
</body>
</html>