<html>
<head>
    <title>Symulacja apokalipsy zombie</title>
    <meta charset="UTF-8">
    <link href='{{asset('app.css')}}' type="text/css" rel="stylesheet"/>
</head>
<body>
<div class="main-layout-content">
    <h1>{{$title}}</h1>
    @if($showSettingsButton)
        <a class="settings-button" href="{{  asset ('/settings')}}">
            <button><img class="icon-img" src="{{asset('images/gear-solid.svg')}}"></button>
        </a>
    @endif
    {{ $slot }}
</div>
</body>
</html>
