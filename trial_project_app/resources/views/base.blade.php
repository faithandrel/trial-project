<!DOCTYPE html>
<html>
    <head>
        <title>Contacts App - @yield('title')</title>

        <link href="{{ url('/') }}/styles/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="{{ url('/') }}/styles/trial-project-style.css" rel="stylesheet">
        <link href="{{ url('/') }}/styles/jquery-ui/jquery-ui.min.css" rel="stylesheet">

    </head>
    <body>
        <div class="container-fluid">
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                  <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                      <span class="sr-only">Toggle navigation</span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Contacts App</a>
                  </div>
                  <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                      <li><a href="{{ url('contact-page') }}">Contacts</a></li>
                      <li><a href="{{ url('follow-up-list') }}">Follow-ups</a></li>
                    </ul>
                    
                  </div><!--/.nav-collapse -->
                </div><!--/.container-fluid -->
            </nav>
        </div>
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
    <script src="{{ url('/') }}/js/all-follow-ups.js"></script>
    </body>
</html>
