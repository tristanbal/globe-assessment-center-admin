<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Assessment Portal Administrator</title>
  @include('inc.templates')
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  <!-- Main NAVBAR -->
  @include('inc.topbar')
  <!-- LEFT MENU -->
  @include('inc.leftmenu')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @yield('content')
  </div>

  <!-- FOOTER -->
  @include('inc.footer')
  
</div>
<!-- SCRIPTS-->

@include('inc.scripts')
</body>
</html>
