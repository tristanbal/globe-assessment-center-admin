<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<!--<link rel="icon" href="{{asset('atlantis/assets/img/icon.ico" type="image/x-icon')}}"/>-->

	<!-- Fonts and icons -->
	<script src="{{asset('atlantis/assets/js/plugin/webfont/webfont.min.js')}}"></script>
	<script>
		WebFont.load({
			google: {"families":["Lato:300,400,700,900"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ["{{asset('atlantis/assets/css/fonts.min.css')}}"]},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>

	<!-- CSS Files -->
	<link rel="stylesheet" href="{{asset('atlantis/assets/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{asset('atlantis/assets/css/atlantis.min.css')}}">
	<link rel="stylesheet" href="{{asset('atlantis/assets/css/demo.css')}}">

	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
	
	<!-- Amcharts script -->
	<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
	<script src="https://www.amcharts.com/lib/3/serial.js"></script>
	<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
	<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
	<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
	<script src="https://www.amcharts.com/lib/3/pie.js"></script>
	<script src="https://www.amcharts.com/lib/3/radar.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/responsive/1.0.5/responsive.min.js"></script>

	<!-- CDN for datatables export buttons -->
	<!-- <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script> -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>