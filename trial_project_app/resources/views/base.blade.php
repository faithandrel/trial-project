<!DOCTYPE html>
<html>
    <head>
        <title>Contacts App - @yield('title')</title>

        <link href="{{ url('/') }}/styles/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="{{ url('/') }}/styles/trial-project-style.css" rel="stylesheet">
        <link href="{{ url('/') }}/styles/jquery-ui/jquery-ui.min.css" rel="stylesheet">

    </head>
    <body>
        @yield('content')
    <script>
        var base_url="{{ url('/') }}/";
    </script>
    <script src="{{ url('/') }}/bower_components/jquery-2.2.4.min/index.js"></script>
    <script src="{{ url('/') }}/styles/jquery-ui/jquery-ui.min.js"></script>
    <script src="{{ url('/') }}/styles/bootstrap/js/bootstrap.min.js"></script>
    <script src="{{ url('/') }}/bower_components/angular/angular.min.js"></script>
    <script src="{{ url('/') }}/bower_components/angular-sanitize/angular-sanitize.min.js"></script>
    <script src="{{ url('/') }}/js/contacts-app.js"></script>
    <script src="{{ url('/') }}/js/contacts-page.js"></script>
    <script src="{{ url('/') }}/js/follow-up.js"></script>
    </body>
</html>
