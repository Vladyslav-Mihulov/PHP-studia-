<!doctype html>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	<link rel="stylesheet" href="/project/assets/css/main.css" />	
        <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        -->>
</head>

<body>

<!-- Wrapper -->
    <div id="wrapper">

		<!-- Main -->
		<div id="main">
                    <div class="inner">

			<!-- Header -->
			@include('inc.header')

			<!-- Banner -->
			<section id="banner">
				<div class="content">
					<header>
					<h1>@yield('title')</h1>
                                        </header>
					
                                        <p>
                                        @yield('content')
                                        </p>
                                        
				</div>
				
			</section>

							
                    </div>
		</div>

		<!-- Sidebar -->
		@include('inc.side_bar')

    </div>

	<!-- Scripts -->
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/browser.min.js"></script>
	<script src="assets/js/breakpoints.min.js"></script>
	<script src="assets/js/util.js"></script>
	<script src="assets/js/main.js"></script>

</body>
</html>