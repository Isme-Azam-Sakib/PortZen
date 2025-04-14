<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $portfolio->full_name }} - Portfolio</title>

    <!--Favicon-->
    <link rel="shortcut icon" href="{{ asset('templates/modern/images/favicon.ico') }}" title="Favicon"/>

    <!-- Main CSS Files -->
    <link rel="stylesheet" href="{{ asset('templates/modern/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('templates/modern/css/namari-color.css') }}">

    <!--Icon Fonts - Font Awesome Icons-->
    <link rel="stylesheet" href="{{ asset('templates/modern/css/font-awesome.min.css') }}">

    <!-- Animate CSS-->
    <link href="{{ asset('templates/modern/css/animate.css') }}" rel="stylesheet">

    <!--Google Webfonts-->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
</head>
<body>
    @yield('content')

    <!-- Include JavaScript resources -->
    <script src="{{ asset('templates/modern/js/jquery.1.8.3.min.js') }}"></script>
    <script src="{{ asset('templates/modern/js/wow.min.js') }}"></script>
    <script src="{{ asset('templates/modern/js/featherlight.min.js') }}"></script>
    <script src="{{ asset('templates/modern/js/featherlight.gallery.min.js') }}"></script>
    <script src="{{ asset('templates/modern/js/jquery.enllax.min.js') }}"></script>
    <script src="{{ asset('templates/modern/js/jquery.scrollUp.min.js') }}"></script>
    <script src="{{ asset('templates/modern/js/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('templates/modern/js/jquery.stickyNavbar.min.js') }}"></script>
    <script src="{{ asset('templates/modern/js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('templates/modern/js/images-loaded.min.js') }}"></script>
    <script src="{{ asset('templates/modern/js/lightbox.min.js') }}"></script>
    <script src="{{ asset('templates/modern/js/site.js') }}"></script>
</body>
</html>