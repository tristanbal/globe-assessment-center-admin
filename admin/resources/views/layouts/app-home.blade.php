<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>ASSESSMENT PORTAL - Admin</title>
	@include('inc.templates')

</head>
<body>
	<div class="wrapper sidebar_minimize">
		
	@include('inc.navbar')
    @include('inc.leftmenu')
		<div class="main-panel" style="">
			<div class="content">
				@include('inc.messages')     
				@yield('content')
      		</div>
     		@include('inc.footer')
		</div>
  </div>
  @include('inc.scripts')
  @yield('scripts')
</body>
</html>